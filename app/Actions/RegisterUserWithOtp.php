<?php

namespace App\Actions;

use App\Models\User;
use App\Services\OtpManager;
use Illuminate\Support\Facades\DB;

class RegisterUserWithOtp
{
    public function __construct(private readonly OtpManager $otp) {}

    /**
     * Crea la cuenta en estado pendiente (sin email_verified_at) y emite
     * el primer código OTP. No inicia sesión: el acceso espera verificación.
     */
    public function handle(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $this->otp->issue($user);

            return $user;
        });
    }
}
