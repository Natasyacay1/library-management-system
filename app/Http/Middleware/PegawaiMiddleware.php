<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PegawaiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();
        if (!$user->isStaff() && !$user->isAdmin()) {
            return redirect()->route('homepage')->with('error', 'Akses ditolak. Hanya pegawai dan admin yang dapat mengakses.');
        }

        return $next($request);
    }
}