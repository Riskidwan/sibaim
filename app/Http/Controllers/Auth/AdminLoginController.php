<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => ['required', 'string', 'digits:18'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['nip' => $credentials['nip'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            
            if ($user->is_admin || in_array($user->role, [User::ROLE_SUPERADMIN, User::ROLE_KEPALA])) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            Auth::logout();
            return back()->withErrors([
                'nip' => 'Akses ditolak. Anda bukan administrator.',
            ])->onlyInput('nip');
        }

        return back()->withErrors([
            'nip' => 'NIP atau password yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('nip');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
