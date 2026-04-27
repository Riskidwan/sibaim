<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'pejabat');
        return view('admin.users.create', compact('type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nip' => [Rule::requiredIf(in_array($request->role, ['superadmin', 'kepala'])), 'nullable', 'string', 'unique:users', 'digits:18'],
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:superadmin,kepala,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_admin' => in_array($request->role, ['superadmin', 'kepala']) ? 1 : 0,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nip' => [Rule::requiredIf(in_array($request->role, ['superadmin', 'kepala'])), 'nullable', 'string', Rule::unique('users')->ignore($user->id), 'digits:18'],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:superadmin,kepala,user',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->is_admin = in_array($request->role, ['superadmin', 'kepala']) ? 1 : 0;
        
        // Auto verify if not already verified when updated by admin
        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
