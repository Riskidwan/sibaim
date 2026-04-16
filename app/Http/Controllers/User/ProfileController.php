<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Mail\SendOtpMail;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Show the user profile form.
     */
    public function index()
    {
        $user = Auth::user();
        return view('public.user.profile', compact('user'));
    }

    /**
     * Update the user profile (name).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Show the change email form.
     */
    public function showEmailForm()
    {
        $user = Auth::user();
        return view('public.user.change_email', compact('user'));
    }

    /**
     * Update the user email (Initiate OTP).
     */
    public function updateEmail(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($user->id)
            ],
        ]);

        // Generate OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));
        
        // Store technical details in session
        session([
            'account_update_type' => 'email',
            'pending_email' => $request->email,
            'account_update_otp' => $otp,
            'account_update_otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP to Current Email for security
        Mail::to($user->email)->send(new SendOtpMail($otp));

        return redirect()->route('user.account.verify-otp')->with('status', 'Kode OTP telah dikirim ke email lama Anda untuk konfirmasi pergantian email.');
    }

    /**
     * Show the change password form.
     */
    public function showPasswordForm()
    {
        return view('public.user.change_password');
    }

    /**
     * Update the user password (Initiate OTP).
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Generate OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));

        // Store technical details in session
        session([
            'account_update_type' => 'password',
            'pending_password' => Hash::make($request->password),
            'account_update_otp' => $otp,
            'account_update_otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP to Current Email
        Mail::to(Auth::user()->email)->send(new SendOtpMail($otp));

        return redirect()->route('user.account.verify-otp')->with('status', 'Kode OTP telah dikirim ke email Anda untuk konfirmasi perubahan kata sandi.');
    }

    /**
     * Show OTP Verification form for account updates.
     */
    public function showVerifyOtpForm()
    {
        if (!session()->has('account_update_type')) {
            return redirect()->route('user.profile');
        }
        return view('public.user.verify_otp');
    }

    /**
     * Verify OTP and apply account changes.
     */
    public function verifyAccountUpdate(Request $request)
    {
        $request->validate(['otp' => 'required|string|size:6']);

        $sessionOtp = session('account_update_otp');
        $expiresAt = session('account_update_otp_expires_at');

        if ($request->otp !== $sessionOtp || Carbon::now()->gt($expiresAt)) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
        }

        $user = Auth::user();
        $type = session('account_update_type');

        if ($type === 'email') {
            $user->update(['email' => session('pending_email')]);
            $msg = 'Email berhasil diperbarui.';
        } elseif ($type === 'password') {
            $user->update(['password' => session('pending_password')]);
            $msg = 'Kata sandi berhasil diperbarui.';
        }

        // Clear session
        session()->forget([
            'account_update_type', 'pending_email', 'pending_password', 
            'account_update_otp', 'account_update_otp_expires_at'
        ]);

        return redirect()->route('user.profile')->with('success', $msg);
    }
}
