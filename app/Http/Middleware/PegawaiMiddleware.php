<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PegawaiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isPegawai()) {
            abort(403, 'Akses hanya untuk pegawai.');
        }

        return $next($request);
    }
}
