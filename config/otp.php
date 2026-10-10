<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Verificación OTP de registro — LUMINA (P-04)
    |--------------------------------------------------------------------------
    |
    | Código numérico de 6 dígitos enviado por correo SOLO durante el registro.
    | La cuenta queda pendiente (email_verified_at = null) hasta validar.
    | No es 2FA por inicio de sesión. Valores propuestos en docs/analisis/16.
    |
    */

    'digits' => (int) env('OTP_DIGITS', 6),

    // Segundos de validez de cada código.
    'expires_in' => (int) env('OTP_EXPIRES_IN', 600),

    // Intentos de verificación por código antes de invalidarlo.
    'max_attempts' => (int) env('OTP_MAX_ATTEMPTS', 5),

    // Segundos mínimos entre envíos a la misma cuenta.
    'resend_cooldown' => (int) env('OTP_RESEND_COOLDOWN', 60),

    // Máximo de códigos emitidos por cuenta en una hora (anti-abuso).
    'max_per_hour' => (int) env('OTP_MAX_PER_HOUR', 10),

];
