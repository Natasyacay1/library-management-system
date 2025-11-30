<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:15'],
            'role' => ['required', 'string', 'in:mahasiswa,staff'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nim' => ['required_if:role,mahasiswa', 'nullable', 'string', 'max:20', 'unique:'.User::class],
            'faculty' => ['required_if:role,mahasiswa', 'nullable', 'string', 'max:100'],
        ], [
            'nim.required_if' => 'NIM wajib diisi untuk mahasiswa.',
            'faculty.required_if' => 'Fakultas wajib diisi untuk mahasiswa.',
            'nim.unique' => 'NIM sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nim' => $validated['nim'] ?? null,
            'faculty' => $validated['faculty'] ?? null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}