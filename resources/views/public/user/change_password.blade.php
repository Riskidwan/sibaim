@extends('public.layouts.app')
@section('title', 'Ubah Kata Sandi')

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
        background: #dc2626;
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
    .password-wrapper { position: relative; }
    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #94a3b8;
        z-index: 10;
        transition: color 0.2s;
    }
    .toggle-password:hover { color: #1e293b; }
</style>
@endpush

@section('content')
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="profile-card">
                <div class="text-center mb-4">
                    <div class="profile-icon"><i class="fas fa-lock"></i></div>
                    <h3 class="fw-bold">Ubah Kata Sandi</h3>
                    <p class="text-muted">Jaga keamanan akun Anda dengan kata sandi baru</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 mb-4">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('user.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label">Kata Sandi Baru</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
                        </div>
                        <div class="form-text mt-2"><i class="fas fa-shield-alt me-1"></i> Kode OTP akan dikirim ke email Anda untuk konfirmasi perubahan.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" id="password-confirm" class="form-control" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('password-confirm', this)"></i>
                        </div>
                    </div>

                    <div class="text-end mt-5">
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-shield-alt me-2"></i> Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
  function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }
</script>
@endpush
