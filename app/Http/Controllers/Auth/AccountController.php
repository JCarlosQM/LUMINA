<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Auth/Account', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'verified' => $user->hasVerifiedEmail(),
            ],
        ]);
    }
}
