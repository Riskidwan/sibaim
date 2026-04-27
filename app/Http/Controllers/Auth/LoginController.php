<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controllers\HasMiddleware; // Tambahkan ini
use Illuminate\Routing\Controllers\Middleware;    // Tambahkan ini

class LoginController extends Controller implements HasMiddleware
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Redirect admin ke /admin/dashboard, user biasa ke /user/dashboard.
     */
    protected function redirectTo(): string
    {
        return auth()->user()->is_admin
            ? '/admin/dashboard'
            : '/user/dashboard';
    }

    /**
     * Get the needed authorization credentials from the request.
     */
    protected function credentials(\Illuminate\Http\Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        
        // HANYA perbolehkan user dengan role 'user' (Pemohon)
        // Pejabat (Admin/Kepala) HARUS login via halaman admin menggunakan NIP
        $credentials['role'] = 'user';
        
        return $credentials;
    }

    /**
     * Auto-verify user after successful login if not verified.
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        // Double check role security
        if ($user->role !== 'user') {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun pejabat harus login melalui Panel Admin menggunakan NIP.',
            ]);
        }

        if (!$user->email_verified_at) {
            $user->update([
                'email_verified_at' => now(),
                'otp_code' => null,
                'otp_expires_at' => null
            ]);
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   public static function middleware(): array
    {
        return [
            // Middleware 'guest' kecuali untuk logout
            new Middleware('guest', except: ['logout']),
            
            // Middleware 'auth' hanya untuk logout
            new Middleware('auth', only: ['logout']),
        ];
    }
}
