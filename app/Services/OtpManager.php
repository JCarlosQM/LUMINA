<?php

namespace App\Services;

use App\Mail\OtpCodeMail;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpManager
{
    public function digits(): int
    {
        return (int) config('otp.digits', 6);
    }

    public function expiresIn(): int
    {
        return (int) config('otp.expires_in', 600);
    }

    public function maxAttempts(): int
    {
        return (int) config('otp.max_attempts', 5);
    }

    public function resendCooldown(): int
    {
        return (int) config('otp.resend_cooldown', 60);
    }

    public function maxPerHour(): int
    {
        return (int) config('otp.max_per_hour', 10);
    }

    public function latestActive(User $user): ?OtpCode
    {
        return $user->otpCodes()
            ->whereNull('used_at')
            ->orderByDesc('id')
            ->first();
    }

    public function canResend(User $user): bool
    {
        return $this->resendWaitSeconds($user) === 0;
    }

    public function resendWaitSeconds(User $user): int
    {
        $latest = $user->otpCodes()->orderByDesc('id')->first();

        if ($latest === null) {
            return 0;
        }

        return max(0, $this->resendCooldown() - $latest->created_at->diffInSeconds(now()));
    }

    public function hourlyLimitReached(User $user): bool
    {
        return $user->otpCodes()
            ->where('created_at', '>=', now()->subHour())
            ->count() >= $this->maxPerHour();
    }

    /**
     * Emite un código nuevo e invalida el anterior. Serializa reenvíos
     * concurrentes bloqueando la fila del usuario dentro de la transacción.
     *
     * @return string Código en claro (solo para el correo; nunca se persiste).
     */
    public function issue(User $user): string
    {
        return DB::transaction(function () use ($user) {
            User::whereKey($user->getKey())->lockForUpdate()->firstOrFail();

            OtpCode::where('user_id', $user->getKey())
                ->whereNull('used_at')
                ->update(['used_at' => now()]);

            $code = $this->generateCode();

            $user->otpCodes()->create([
                'code_hash' => Hash::make($code),
                'expires_at' => now()->addSeconds($this->expiresIn()),
            ]);

            // Envío síncrono: sin worker de colas en esta fase, el registro
            // debe conocer el resultado del envío de inmediato.
            Mail::to($user->email)->send(new OtpCodeMail($user, $code, $this->expiresIn()));

            return $code;
        });
    }

    /**
     * Verifica un código con bloqueo de fila para que dos peticiones
     * simultáneas no consuman el código ni dupliquen intentos.
     */
    public function verify(User $user, string $code): bool
    {
        return DB::transaction(function () use ($user, $code) {
            $otp = OtpCode::where('user_id', $user->getKey())
                ->whereNull('used_at')
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if ($otp === null || $otp->isExpired() || $otp->attemptsExhausted()) {
                return false;
            }

            if (! Hash::check($code, $otp->code_hash)) {
                $attempts = $otp->attempts + 1;

                $otp->update([
                    'attempts' => $attempts,
                    'used_at' => $attempts >= $this->maxAttempts() ? now() : null,
                ]);

                return false;
            }

            $otp->update(['used_at' => now()]);
            $user->markEmailAsVerified();

            return true;
        });
    }

    private function generateCode(): string
    {
        $digits = $this->digits();
        $min = (int) (10 ** ($digits - 1));
        $max = (int) (10 ** $digits) - 1;

        return (string) random_int($min, $max);
    }
}
