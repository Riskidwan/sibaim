@extends('public.layouts.app')
@section('title', 'Ubah E-mail')

@push('styles')
<style>
    body { padding-top: 100px; background: #f8fafc; color: #1e293b; }
    .profile-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }
    .profile-icon {
        width: 100px; height: 100px;
        background: #0ea5e9;
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 40px; font-weight: 800;
        margin: 0 auto 20px;
    }
    .form-label { font-weight: 700; color: #475569; margin-bottom: 8px; }
    .form-control {
        border-radius: 12px;
        padding: 12px 18px;
        border: 1px solid #cbd5e1;
    }
    .btn-save {
        background: #ffff00;
        color: #000;
        border: none;
        border-radius: 12px;
        padding: 12px 30px;
        font-weight: 700;
        transition: all 0.2s;
    }
    .btn-save:hover { background: #e6e600; transform: translateY(-1px); }
</style>
@endpush

@section('content')
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="profile-card">
                <div class="text-center mb-4">
                    <div class="profile-icon"><i class="fas fa-envelope"></i></div>
                    <h3 class="fw-bold">Ubah Alamat E-mail</h3>
                    <p class="text-muted">Masukkan alamat email baru Anda</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 mb-4">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('user.email.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label">E-mail Saat Ini</label>
                        <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Alamat E-mail Baru</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        <div class="form-text mt-2"><i class="fas fa-shield-alt me-1"></i> Kode OTP akan dikirim ke email lama Anda untuk konfirmasi.</div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end mt-5">
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save me-2"></i> Ubah E-mail
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
