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
