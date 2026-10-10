<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (! Auth::attempt(
            ['email' => $validated['email'], 'password' => $validated['password']],
            $validated['remember'] ?? false
        )) {
            return back()
                ->withInput($request->safe()->only(['email']))
                ->withErrors(['email' => __('Estas credenciales no coinciden con nuestros registros.')]);
        }

        /** @var User $user */
        $user = Auth::user();

        if (! $user->hasVerifiedEmail()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('verification.notice')
                ->with('verify_email', $validated['email'])
                ->withErrors(['email' => __('Tu cuenta está pendiente de verificación. Revisa tu correo.')]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('account'));
    }
}
