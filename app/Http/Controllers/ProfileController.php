<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('profile.edit', [
            'user' => $request->user(),
            'categories' => $categories,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'surname' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string', 'max:255'],
            'delivery_point' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $rules = [
            'password' => ['required', Password::defaults(), 'confirmed'],
        ];

        // Якщо не Google-користувач, вимагаємо поточний пароль
        if ($user->provider !== 'google' || !is_null($user->password)) {
            $rules['current_password'] = ['required', 'current_password'];
        }

        $validated = $request->validate($rules);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        // Якщо Google-користувач без пароля, пропускаємо перевірку пароля
        if ($user->provider !== 'google' || !is_null($user->password)) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
