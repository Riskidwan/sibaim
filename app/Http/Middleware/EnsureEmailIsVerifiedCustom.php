<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerifiedCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect('/login');
        }

        $user = \Illuminate\Support\Facades\Auth::user();

        // Bypass for admins - admins are trusted and shouldn't be blocked by email verification
        if ($user->is_admin) {
            return $next($request);
        }

        // Only redirect to login if email is not verified AND there is a pending OTP code
        // This allows existing/manually created accounts without an OTP code to skip verification
        if (!$user->email_verified_at && $user->otp_code && !$request->is('login', 'logout')) {
            \Illuminate\Support\Facades\Auth::logout();
            return redirect('/login')->with('error', 'Akun Anda belum terverifikasi. Silakan hubungi admin atau daftar ulang.');
        }

        return $next($request);
    }
}
