<?php

namespace App\Http\Controllers\Auth;

use App\Actions\RegisterUserWithOtp;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\OtpManager;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(RegisterRequest $request, RegisterUserWithOtp $action, OtpManager $otp): RedirectResponse
    {
        $email = $request->string('email')->toString();
        $existing = User::where('email', $email)->first();

        if ($existing === null) {
            $action->handle($request->validated());
        } elseif (! $existing->hasVerifiedEmail()) {
            // Anti-enumeración: la respuesta es idéntica exista o no la cuenta.
            // Si está pendiente, se reemite respetando cooldown y tope horario.
            if (! $otp->hourlyLimitReached($existing) && $otp->canResend($existing)) {
                $otp->issue($existing);
            }
        }

        return redirect()->route('verification.notice')
            ->with('verify_email', $email)
            ->with('status', __('Te enviamos un código de 6 dígitos. Revisa tu correo.'));
    }
}
