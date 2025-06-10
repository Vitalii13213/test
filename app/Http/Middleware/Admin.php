<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user() && Auth::user()->is_admin) {
            return $next($request);
        }

        if (Auth::check()) {
            \Log::info('Admin middleware failed', [
                'user_id' => Auth::id(),
                'is_admin' => Auth::user() ? Auth::user()->is_admin : null,
            ]);
        }

        return redirect()->route('home')->with('error', 'Доступ заборонено.');
    }
}
