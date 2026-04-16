<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Jika user ada tapi belum ada google_id (pernah daftar via email), tautkan akunnya
                $updateData = ['avatar' => $googleUser->avatar];
                if (!$user->google_id) {
                    $updateData['google_id'] = $googleUser->id;
                }
                
                // Google users are pre-verified, so we set this to bypass OTP
                if (!$user->email_verified_at) {
                    $updateData['email_verified_at'] = now();
                }

                $user->update($updateData);
                Auth::login($user);
            } else {
                // Buat user baru jika belum terdaftar
                $newUser = User::create([
                    'name'              => $googleUser->name,
                    'email'             => $googleUser->email,
                    'google_id'         => $googleUser->id,
                    'avatar'            => $googleUser->avatar,
                    'email_verified_at' => now(), // Mark as verified automatically
                    'password'          => bcrypt(Str::random(16)),
                    'role'              => User::ROLE_USER,
                ]);

                Auth::login($newUser);
            }

            // Redirect berdasarkan role (admin/user)
            return Auth::user()->is_admin 
                ? redirect('/admin/dashboard') 
                : redirect('/user/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login via Google. Silakan coba lagi.');
        }
    }
}