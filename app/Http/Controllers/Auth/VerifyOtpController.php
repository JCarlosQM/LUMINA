<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Models\User;
use App\Services\OtpManager;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class VerifyOtpController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Auth/Verify', [
            'email' => session('verify_email', ''),
        ]);
    }

    public function store(VerifyOtpRequest $request, OtpManager $otp): RedirectResponse
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();

        if ($user !== null && ! $user->hasVerifiedEmail() && $otp->verify($user, $validated['code'])) {
            return redirect()->intended(route('account'))
                ->with('status', __('Correo verificado. Ya puedes usar Lumina.'));
        }

        // Respuesta genérica: no distingue cuenta inexistente, expirada,
        // agotada o código inválido (anti-enumeración).
        return back()
            ->withInput($request->safe()->only(['email']))
            ->withErrors(['code' => __('El código no es válido o ha caducado. Solicita uno nuevo si lo necesitas.')]);
    }
}
