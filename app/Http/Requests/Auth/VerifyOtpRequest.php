<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $digits = (int) config('otp.digits', 6);

        return [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'code' => ['required', 'string', 'digits:'.$digits],
        ];
    }
}
