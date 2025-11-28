<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateUniversityEmail
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('email')) {
            $email = $request->input('email');

            if (!str_ends_with($email, '.ac.id') && !str_ends_with($email, '.edu')) {
                return back()
                    ->withInput()
                    ->withErrors(['email' => 'Email harus menggunakan domain kampus (.ac.id / .edu).']);
            }
        }

        return $next($request);
    }
}
