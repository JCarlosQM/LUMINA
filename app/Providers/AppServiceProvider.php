<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Clave cuenta+IP: ni la IP sola agrupa usuarios tras una NAT ni la
        // cuenta sola permite DoS dirigida (regla security.md).
        RateLimiter::for('auth', function (Request $request) {
            $key = Str::transliterate(Str::lower($request->string('email')).'|'.$request->ip());

            return Limit::perMinute(10)->by($key);
        });

        RateLimiter::for('otp', function (Request $request) {
            $key = Str::transliterate(Str::lower($request->string('email', '')).'|'.$request->ip());

            return Limit::perMinute(10)->by($key);
        });
    }
}
