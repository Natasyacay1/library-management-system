<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FineMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasUnpaidFines()) {
            return redirect()
                ->route('mahasiswa.loans.history')
                ->with('error', 'Anda masih memiliki denda yang belum dibayar. Peminjaman baru diblokir.');
        }

        return $next($request);
    }
}