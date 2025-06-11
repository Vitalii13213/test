<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate()
    {
        $credentials = $this->only('email', 'password');

        // Проверяем, зарегистрирован ли пользователь через Google
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if ($user && $user->provider === 'google' && is_null($user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Please use Google login for this account.'],
            ]);
        }

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }
    }
}
