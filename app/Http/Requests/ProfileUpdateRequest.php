<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'surname' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'phone' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string', 'max:255'],
            'delivery_point' => ['nullable', 'string', 'max:255'],
        ];
    }
}
