<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUniversityEmail
{
    private $universityDomains = [
        'ac.id',
        'edu',
        'sch.id',
        // Tambahkan domain universitas lainnya sesuai kebutuhan
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Hanya berlaku untuk route register mahasiswa
        if ($request->routeIs('register') && $request->has('email')) {
            $email = $request->email;
            $isValidUniversityEmail = false;

            foreach ($this->universityDomains as $domain) {
                if (str_contains($email, '@') && str_ends_with(explode('@', $email)[1], $domain)) {
                    $isValidUniversityEmail = true;
                    break;
                }
            }

            if (!$isValidUniversityEmail) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'email' => 'Email harus menggunakan domain universitas yang valid (.ac.id, .edu, dll)'
                    ]);
            }
        }

        return $next($request);
    }
}