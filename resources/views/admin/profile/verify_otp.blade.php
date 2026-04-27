@extends('admin.layouts.app')
@section('title', 'Verifikasi Keamanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                    <i class="bi bi-shield-lock-fill text-primary" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold">Verifikasi OTP</h4>
                <p class="text-muted">
                    @if(session('status'))
                        {{ session('status') }}
                    @else
                        Silakan masukkan kode OTP yang telah dikirim ke email Anda.
                    @endif
                </p>

                <form action="{{ route('admin.profile.verify-otp.post') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="form-group mb-4">
                        <input type="text" name="otp" class="form-control form-control-lg text-center fw-bold @error('otp') is-invalid @enderror" 
                               placeholder="123456" maxlength="6" autofocus required style="letter-spacing: 0.5rem; font-size: 1.5rem;">
                        @error('otp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Verifikasi & Terapkan Perubahan</button>
                        <a href="{{ route('admin.profile') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>

                <div class="mt-4">
                    <p class="small text-muted">Tidak menerima kode? Periksa folder Spam atau coba lagi beberapa saat lagi.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
