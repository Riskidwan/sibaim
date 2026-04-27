<?php

namespace App\Http\Controllers\Admin;

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
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate(['name' => 'required|string|max:255']);
        $user->update(['name' => $request->name]);
        return back()->with('success', 'Nama profil berhasil diperbarui.');
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $otp = sprintf("%06d", mt_rand(1, 999999));
        session([
            'admin_update_type' => 'email',
            'admin_pending_email' => $request->email,
            'admin_update_otp' => $otp,
            'admin_update_otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new SendOtpMail($otp));
        return redirect()->route('admin.profile.verify-otp')->with('status', 'OTP dikirim ke email lama Anda.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

    public function showVerifyOtpForm()
    {
        if (!session()->has('admin_update_type')) return redirect()->route('admin.profile');
        return view('admin.profile.verify_otp');
    }

    public function verifyUpdate(Request $request)
    {
        $request->validate(['otp' => 'required|string|size:6']);
        if ($request->otp !== session('admin_update_otp') || Carbon::now()->gt(session('admin_update_otp_expires_at'))) {
            return back()->withErrors(['otp' => 'OTP salah atau kadaluarsa.']);
        }

        $user = Auth::user();
        if (session('admin_update_type') === 'email') {
            $user->update(['email' => session('admin_pending_email')]);
            $msg = 'Email berhasil diperbarui.';
        } else {
            $user->update(['password' => session('admin_pending_password')]);
            $msg = 'Password berhasil diperbarui.';
        }

        session()->forget(['admin_update_type', 'admin_pending_email', 'admin_pending_password', 'admin_update_otp', 'admin_update_otp_expires_at']);
        return redirect()->route('admin.profile')->with('success', $msg);
    }
}
