<?php

namespace Tests\Feature\Auth;

use App\Mail\OtpCodeMail;
use App\Models\OtpCode;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OtpRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private const PASSWORD = 'Secret123';

    private function registerPayload(string $email = 'nuevo@lumina.local'): array
    {
        return [
            'name' => 'Explorador',
            'email' => $email,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ];
    }

    /** @return array{user: User, code: string} */
    private function registerPendingUser(string $email = 'nuevo@lumina.local'): array
    {
        Mail::fake();

        $this->post('/registro', $this->registerPayload($email))
            ->assertRedirect(route('verification.notice'));

        $code = '';
        Mail::assertSent(OtpCodeMail::class, function (OtpCodeMail $mail) use (&$code, $email) {
            $code = $mail->code;

            return $mail->hasTo($email);
        });

        $this->assertMatchesRegularExpression('/^\d{6}$/', $code);

        return ['user' => User::where('email', $email)->firstOrFail(), 'code' => $code];
    }

    public function test_home_publica_responde(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_registro_crea_usuario_pendiente_y_envia_otp(): void
    {
        Mail::fake();

        $response = $this->post('/registro', $this->registerPayload());

        $response->assertRedirect(route('verification.notice'));
        $this->assertGuest();

        $user = User::where('email', 'nuevo@lumina.local')->firstOrFail();
        $this->assertNull($user->email_verified_at);
        $this->assertTrue(Hash::check(self::PASSWORD, $user->password));

        Mail::assertSent(OtpCodeMail::class, 1);

        $otp = OtpCode::where('user_id', $user->id)->firstOrFail();
        $this->assertNull($otp->used_at);
        $this->assertNotEmpty($otp->code_hash);
    }

    public function test_otp_se_almacena_con_hash_y_no_en_claro(): void
    {
        ['user' => $user, 'code' => $code] = $this->registerPendingUser();

        $otp = OtpCode::where('user_id', $user->id)->firstOrFail();
        $this->assertNotSame($code, $otp->code_hash);
        $this->assertTrue(Hash::check($code, $otp->code_hash));
        $this->assertArrayNotHasKey('code_hash', $otp->toArray());
    }

    public function test_verificacion_correcta_activa_cuenta_y_login_no_pide_otp(): void
    {
        ['user' => $user, 'code' => $code] = $this->registerPendingUser();

        $this->post('/verificar', ['email' => $user->email, 'code' => $code])
            ->assertRedirect(route('account'));

        $this->assertNotNull($user->fresh()->email_verified_at);

        // El login posterior no emite ningún OTP nuevo.
        $this->post('/entrar', ['email' => $user->email, 'password' => self::PASSWORD])
            ->assertRedirect(route('account'));
        $this->get('/cuenta')->assertOk();

        Mail::assertSent(OtpCodeMail::class, 1);
    }

    public function test_codigo_incorrecto_falla_y_cuenta_intentos(): void
    {
        ['user' => $user, 'code' => $code] = $this->registerPendingUser();

        $wrong = $code === '000000' ? '000001' : '000000';

        $this->post('/verificar', ['email' => $user->email, 'code' => $wrong])
            ->assertRedirect();

        $this->assertNull($user->fresh()->email_verified_at);
        $this->assertSame(1, (int) OtpCode::where('user_id', $user->id)->firstOrFail()->attempts);
    }

    public function test_codigo_expirado_es_rechazado(): void
    {
        ['user' => $user, 'code' => $code] = $this->registerPendingUser();

        $this->travel(11)->minutes();

        $this->post('/verificar', ['email' => $user->email, 'code' => $code])
            ->assertRedirect();

        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_agotamiento_de_intentos_invalida_el_codigo(): void
    {
        ['user' => $user, 'code' => $code] = $this->registerPendingUser();

        $wrong = $code === '000000' ? '000001' : '000000';

        for ($i = 0; $i < 5; $i++) {
            $this->post('/verificar', ['email' => $user->email, 'code' => $wrong]);
        }

        // Ni siquiera el código correcto funciona tras agotar intentos.
        $this->post('/verificar', ['email' => $user->email, 'code' => $code])
            ->assertRedirect();

        $this->assertNull($user->fresh()->email_verified_at);
        $this->assertNotNull(OtpCode::where('user_id', $user->id)->firstOrFail()->used_at);
    }

    public function test_reenvio_antes_del_cooldown_no_emite_nuevo(): void
    {
        ['user' => $user, 'code' => $code] = $this->registerPendingUser();

        $this->post('/reenviar-codigo', ['email' => $user->email])
            ->assertRedirect();

        Mail::assertSent(OtpCodeMail::class, 1);

        // El código original sigue válido tras el reenvío en cooldown.
        $this->post('/verificar', ['email' => $user->email, 'code' => $code])
            ->assertRedirect(route('account'));
    }

    public function test_reenvio_despues_del_cooldown_invalida_el_anterior(): void
    {
        ['user' => $user, 'code' => $oldCode] = $this->registerPendingUser();

        $newCode = $oldCode;

        // Reintento limitado por si el generador repitiera el código.
        for ($i = 0; $i < 3 && $newCode === $oldCode; $i++) {
            $this->travel(61)->seconds();
            $this->post('/reenviar-codigo', ['email' => $user->email])->assertRedirect();

            $sent = Mail::sent(OtpCodeMail::class);
            $newCode = $sent->last()->code;
        }

        $this->assertNotSame($oldCode, $newCode);

        // El anterior queda invalidado…
        $this->post('/verificar', ['email' => $user->email, 'code' => $oldCode])
            ->assertRedirect();
        $this->assertNull($user->fresh()->email_verified_at);

        // …y el nuevo funciona.
        $this->post('/verificar', ['email' => $user->email, 'code' => $newCode])
            ->assertRedirect(route('account'));
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_reutilizacion_de_codigo_falla(): void
    {
        ['user' => $user, 'code' => $code] = $this->registerPendingUser();

        $this->post('/verificar', ['email' => $user->email, 'code' => $code])
            ->assertRedirect(route('account'));

        $this->post('/verificar', ['email' => $user->email, 'code' => $code])
            ->assertRedirect();
    }

    public function test_pendiente_no_accede_a_rutas_protegidas(): void
    {
        ['user' => $user] = $this->registerPendingUser();

        $this->actingAs($user)->get('/cuenta')
            ->assertRedirect(route('verification.notice'));
    }

    public function test_pendiente_no_entra_al_panel(): void
    {
        ['user' => $user] = $this->registerPendingUser();

        $this->assertFalse($user->canAccessPanel(Filament::getDefaultPanel()));
        // Autenticado pero sin acceso al panel: denegado (403), sin entrar.
        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_verificado_si_entra_al_panel(): void
    {
        $user = User::factory()->create(['email' => 'ok@lumina.local']);

        $this->assertTrue($user->canAccessPanel(Filament::getDefaultPanel()));
        $this->actingAs($user)->get('/admin')->assertOk();
    }

    public function test_login_pendiente_redirige_a_verificar_sin_sesion(): void
    {
        ['user' => $user] = $this->registerPendingUser();

        $this->post('/entrar', ['email' => $user->email, 'password' => self::PASSWORD])
            ->assertRedirect(route('verification.notice'));

        $this->assertGuest();
    }

    public function test_registro_con_email_existente_no_revela_nada(): void
    {
        $existing = User::factory()->create(['email' => 'existe@lumina.local']);

        Mail::fake();

        $first = $this->post('/registro', $this->registerPayload('existe@lumina.local'));

        Mail::assertNothingSent();

        // Misma respuesta que un registro nuevo (comparada abajo).
        Mail::fake();
        $second = $this->post('/registro', $this->registerPayload('nuevo2@lumina.local'));

        $this->assertSame($second->getStatusCode(), $first->getStatusCode());
        $this->assertSame(
            $second->headers->get('Location'),
            $first->headers->get('Location')
        );
        $this->assertSame(1, User::where('email', 'existe@lumina.local')->count());
        $this->assertTrue($existing->fresh()->hasVerifiedEmail());
    }

    public function test_verificar_cuenta_inexistente_responde_igual(): void
    {
        Mail::fake();

        $response = $this->post('/verificar', ['email' => 'nadie@lumina.local', 'code' => '123456']);

        $response->assertRedirect();
        $response->assertSessionHasErrors('code');
    }
}
