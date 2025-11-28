<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Kalau sudah login, jangan boleh akses halaman guest tertentu (misal /register)
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
