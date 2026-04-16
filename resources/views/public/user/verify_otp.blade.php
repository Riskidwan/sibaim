@extends('public.layouts.app')
@section('title', 'Verifikasi Akun')

@push('styles')
<style>
    body { padding-top: 100px; background: #f8fafc; color: #1e293b; }
    .otp-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }
    .profile-icon {
        width: 100px; height: 100px;
        background: #115e59;
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 40px; font-weight: 800;
        margin: 0 auto 20px;
    }
    .form-label { font-weight: 700; color: #475569; margin-bottom: 8px; }
    .otp-input {
        border-radius: 12px;
        padding: 15px;
        border: 2px solid #cbd5e1;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: 5px;
        text-align: center;
        width: 100%;
    }
    .otp-input:focus {
        border-color: #ffff00;
        box-shadow: 0 0 0 4px rgba(255, 255, 0, 0.2);
    }
    .btn-verify {
        background: #ffff00;
        color: #000;
        border: none;
        border-radius: 12px;
        padding: 12px 30px;
        font-weight: 700;
        transition: all 0.2s;
        width: 100%;
        font-size: 1.1rem;
    }
    .btn-verify:hover { background: #e6e600; transform: translateY(-1px); }
</style>
@endpush

@section('content')
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="otp-card text-center">
                <div class="profile-icon"><i class="fas fa-key"></i></div>
                <h3 class="fw-bold">Verifikasi OTP</h3>
                <p class="text-muted">
                    @if(session('account_update_type') === 'email')
                        Konfirmasi perubahan alamat email Anda.
                    @else
                        Konfirmasi perubahan kata sandi Anda.
                    @endif
                </p>

                @if(session('status'))
                    <div class="alert alert-info border-0 rounded-4 mb-4 text-start">
                        <i class="fas fa-info-circle me-2"></i> {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('user.account.verify-otp.post') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4 text-start">
                        <label class="form-label text-center d-block">Masukkan 6 Digit Kode OTP</label>
                        <input type="text" name="otp" class="otp-input @error('otp') is-invalid @enderror" maxlength="6" placeholder="000000" autocomplete="off" required autofocus>
                        @error('otp')
                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-verify mt-3">
                        <i class="fas fa-check-circle me-2"></i> Verifikasi & Simpan
                    </button>
                    
                    <p class="mt-4 text-muted small">
                        Tidak menerima kode? Silakan periksa folder spam atau pastikan email Anda benar.
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
