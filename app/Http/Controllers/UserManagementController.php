<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    // ===========================
    // LIST USERS
    // ===========================
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // ===========================
    // FORM CREATE
    // ===========================
    public function create()
    {
        return view('admin.users.create');
    }

    // ===========================
    // STORE NEW USER
    // ===========================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => ['required', Rule::in(['admin', 'pegawai', 'mahasiswa'])],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User berhasil ditambahkan!');
    }

    // ===========================
    // FORM EDIT
    // ===========================
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // ===========================
    // UPDATE USER
    // ===========================
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required','email', Rule::unique('users')->ignore($user->id)],
            'role'     => ['required', Rule::in(['admin', 'pegawai', 'mahasiswa'])],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = $request->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User berhasil dihapus!');
    }
}
