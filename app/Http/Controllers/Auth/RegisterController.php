<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use Illuminate\Http\Request;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class RegisterController extends Controller implements HasMiddleware
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/dashboard';

    public function sendOtpRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah terdaftar atau format salah.'
            ]);
        }

        $otp = sprintf("%06d", mt_rand(1, 999999));
        session([
            'registration_otp' => $otp, 
            'registration_email' => $request->email,
            'registration_otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        try {
            \Illuminate\Support\Facades\Log::info('Sending OTP to: ' . $request->email . ' | OTP: ' . $otp);
            Mail::to($request->email)->send(new SendOtpMail($otp));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send OTP: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email. Silakan coba lagi.']);
        }
    }

    public function verifyOtpRegistration(Request $request)
    {
        $otp = $request->otp;
        $email = $request->email;
        $expiresAt = session('registration_otp_expires_at');

        if (!$expiresAt || Carbon::now()->gt($expiresAt)) {
            return response()->json(['success' => false, 'message' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang.']);
        }

        if ($otp === session('registration_otp') && $email === session('registration_email')) {
            session(['registration_email_verified' => $email]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Kode OTP salah.']);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['sendOtpRegistration', 'verifyOtpRegistration']),
        ];
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // Logout user after registration to force manual login
        \Illuminate\Support\Facades\Auth::logout();

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Akun Anda telah aktif. Silakan masuk menggunakan email dan kata sandi Anda.');
    }

    /**
     * Override register to send validation errors to a named bag so they
     * don't bleed into the login form which shares the same view.
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect('/login?tab=register')
                ->withErrors($validator, 'registerBag')
                ->withInput();
        }

        $user = $this->create($request->all());
        event(new \Illuminate\Auth\Events\Registered($user));
        $this->guard()->login($user);

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required', 
                'string', 
                'min:8', 
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
            ],
        ])->after(function($validator) use ($data) {
            if (session('registration_email_verified') !== $data['email']) {
                $validator->errors()->add('email', 'Email belum diverifikasi via OTP. Silakan klik tombol Verifikasi terlebih dahulu.');
            }
        });
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        $isVerified = session('registration_email_verified') === $data['email'];

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => $isVerified ? Carbon::now() : null,
            'role' => User::ROLE_USER,
        ]);

        if (!$isVerified) {
            $otp = sprintf("%06d", mt_rand(1, 999999));
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(15),
            ]);
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } else {
            // Clear session after success
            session()->forget(['registration_otp', 'registration_email', 'registration_email_verified']);
        }

        return $user;
    }
}
