<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendOtpRequest;
use App\Models\User;
use App\Services\OtpManager;
use Illuminate\Http\RedirectResponse;

class ResendOtpController extends Controller
{
    public function __invoke(ResendOtpRequest $request, OtpManager $otp): RedirectResponse
    {
        $user = User::where('email', $request->validated()['email'])->first();

        if ($user !== null && ! $user->hasVerifiedEmail()
            && ! $otp->hourlyLimitReached($user) && $otp->canResend($user)) {
            $otp->issue($user);
        }

        // Respuesta idéntica en todos los casos: no revela si la cuenta
        // existe, si está verificada o si el reenvío quedó en cooldown.
        return back()->with('status', __('Si la cuenta está pendiente, te enviamos un código nuevo.'));
    }
}
