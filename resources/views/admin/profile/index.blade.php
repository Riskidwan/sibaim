@extends('admin.layouts.app')
@section('title', 'Profil Saya')

@push('styles')
<style>
    .password-wrapper { position: relative; }
    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #94a3b8;
        z-index: 10;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Informasi Dasar</h4>
                <p class="text-muted small">Perbarui nama tampilan Anda.</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Ubah Alamat Email</h4>
                <p class="text-muted small">Gunakan email aktif. OTP akan dikirim ke email lama untuk verifikasi.</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.email.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label class="form-label">Email Saat Ini</label>
                        <input type="text" class="form-control" value="{{ $user->email }}" readonly disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Email Baru</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required placeholder="nama@email.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">Ganti Email (Minta OTP)</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Ubah Kata Sandi</h4>
                <p class="text-muted small">Jaga keamanan akun Anda dengan memperbarui kata sandi secara berkala.</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label class="form-label">Kata Sandi Baru</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Minimal 8 karakter">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
                        </div>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Konfirmasi Kata Sandi</label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Ulangi kata sandi">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirmation', this)"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger">Perbarui Kata Sandi</button>
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
