<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FineMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Cek jika user adalah mahasiswa dan memiliki denda tertunggak
        if ($user->isStudent() && $user->hasOverdueFines()) {
            return redirect()->route('student.dashboard')
                ->with('error', 
                    'Anda tidak dapat meminjam buku karena memiliki denda tertunggak sebesar Rp ' . 
                    number_format($user->fines_balance, 0, ',', '.') . 
                    '. Silakan lunasi denda terlebih dahulu.'
                );
        }

        // Cek jika user diblokir
        if ($user->is_blocked) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Akun Anda sedang diblokir. Silakan hubungi admin perpustakaan.');
        }

        return $next($request);
    }
}