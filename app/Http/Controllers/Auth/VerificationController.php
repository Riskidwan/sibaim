<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class VerificationController extends Controller
{
    public function showOtpForm()
    {
        // Require user to be logged in but not yet verified
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->email_verified_at) {
            return redirect('/dashboard');
        }

        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = User::find(Auth::id());

        if ($user->otp_code === $request->otp && Carbon::now()->lt($user->otp_expires_at)) {
            $user->email_verified_at = Carbon::now();
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();

            // Redirect based on role
            if ($user->role === User::ROLE_SUPERADMIN || $user->role === User::ROLE_KEPALA) {
                return redirect('/admin/dashboard')->with('success', 'Email berhasil diverifikasi.');
            }
            
            return redirect('/user/dashboard')->with('success', 'Email berhasil diverifikasi.');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
    }

    public function resendOtp()
    {
        $user = User::find(Auth::id());
        
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(15);
        $user->save();

        Mail::to($user->email)->send(new SendOtpMail($otp));

        return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
