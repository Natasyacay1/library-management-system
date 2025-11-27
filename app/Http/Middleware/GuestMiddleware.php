<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isStaff()) {
                return redirect()->route('staff.dashboard');
            } elseif ($user->isStudent()) {
                return redirect()->route('student.dashboard');
            }
        }

        return $next($request);
    }
}