@extends('admin.layouts.app')
@section('title', 'Tambah Akun')

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
        transition: color 0.2s;
    }
    .toggle-password:hover { color: #435ebe; }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title">Tambah Akun {{ $type === 'pejabat' ? 'Pejabat/Admin' : 'Pemohon/User' }}</h4>
                    <p class="text-subtitle text-muted">Buat akses {{ $type === 'pejabat' ? 'administrator' : 'pengguna' }} baru</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <div class="input-group">
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="budi@example.com" required>
                                    <button class="btn btn-outline-primary" type="button" id="btn-send-otp">Verifikasi Email</button>
                                </div>
                                <div id="email-status" class="mt-1 small"></div>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- OTP Verification Section -->
                        <div class="col-md-12" id="otp-section" style="display: none;">
                            <div class="form-group mb-3 p-3 border rounded bg-light">
                                <label class="form-label text-primary fw-bold"><i class="bi bi-shield-lock me-1"></i> Verifikasi Kode OTP</label>
                                <p class="small text-muted mb-2">Kode telah dikirim ke email di atas. Silakan masukkan kode tersebut.</p>
                                <div class="input-group">
                                    <input type="text" id="otp_code" class="form-control" placeholder="6 Digit Kode" maxlength="6">
                                    <button class="btn btn-primary" type="button" id="btn-verify-otp">Konfirmasi</button>
                                </div>
                                <div id="otp-status" class="mt-1 small"></div>
                            </div>
                        </div>

                        @if($type === 'pejabat')
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="nip" class="form-label">NIP (18 Digit)</label>
                                <input type="text" id="nip" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" placeholder="Contoh: 198001012005011001" maxlength="18" minlength="18" pattern="\d{18}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18)">
                                <small class="text-muted">Wajib 18 digit angka untuk Pejabat.</small>
                                @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="role" class="form-label">Role / Peran</label>
                                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin (Akses Penuh)</option>
                                    <option value="kepala" {{ old('role') == 'kepala' ? 'selected' : '' }}>Kepala (Lihat Data Saja)</option>
                                </select>
                                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        @else
                        <input type="hidden" name="role" value="user">
                        @endif

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="password-wrapper">
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                                    <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
                                </div>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="password-wrapper">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                                    <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirmation', this)"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-light-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnSendOtp = document.getElementById('btn-send-otp');
        const btnVerifyOtp = document.getElementById('btn-verify-otp');
        const emailInput = document.getElementById('email');
        const otpInput = document.getElementById('otp_code');
        const otpSection = document.getElementById('otp-section');
        const submitBtn = document.querySelector('button[type="submit"]');
        
        const emailStatus = document.getElementById('email-status');
        const otpStatus = document.getElementById('otp-status');

        let isEmailVerified = false;

        // Disable submit until verified
        submitBtn.disabled = true;

        btnSendOtp.addEventListener('click', async function() {
            const email = emailInput.value;
            if(!email || !email.includes('@')) {
                alert('Silakan masukkan email yang valid.');
                return;
            }

            btnSendOtp.disabled = true;
            btnSendOtp.innerText = 'Mengirim...';
            emailStatus.innerHTML = '<span class="text-muted">Sedang mengirim kode OTP...</span>';

            try {
                const response = await fetch('{{ route("auth.send-otp-registration") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();
                if(data.success) {
                    otpSection.style.display = 'block';
                    emailStatus.innerHTML = '<span class="text-success fw-bold">Kode OTP berhasil dikirim!</span>';
                    btnSendOtp.innerText = 'Kirim Ulang';
                    btnSendOtp.disabled = false;
                } else {
                    emailStatus.innerHTML = `<span class="text-danger">${data.message || 'Gagal mengirim OTP.'}</span>`;
                    btnSendOtp.disabled = false;
                    btnSendOtp.innerText = 'Verifikasi Email';
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan koneksi.');
                btnSendOtp.disabled = false;
                btnSendOtp.innerText = 'Verifikasi Email';
            }
        });

        btnVerifyOtp.addEventListener('click', async function() {
            const otp = otpInput.value;
            const email = emailInput.value;
            if(!otp || otp.length < 6) {
                alert('Masukkan 6 digit kode OTP.');
                return;
            }

            btnVerifyOtp.disabled = true;
            btnVerifyOtp.innerText = 'Mengecek...';

            try {
                const response = await fetch('{{ route("auth.verify-otp-registration") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email: email, otp: otp })
                });

                const data = await response.json();
                if(data.success) {
                    otpStatus.innerHTML = '<span class="text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Email berhasil diverifikasi!</span>';
                    
                    // Lock inputs
                    emailInput.readOnly = true;
                    otpInput.readOnly = true;
                    btnSendOtp.style.display = 'none';
                    btnVerifyOtp.disabled = true;
                    btnVerifyOtp.innerHTML = '<i class="bi bi-check-lg"></i>';
                    
                    // Enable submit
                    submitBtn.disabled = false;
                    isEmailVerified = true;
                } else {
                    otpStatus.innerHTML = `<span class="text-danger">${data.message || 'Kode OTP salah.'}</span>`;
                    btnVerifyOtp.disabled = false;
                    btnVerifyOtp.innerText = 'Konfirmasi';
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan koneksi.');
                btnVerifyOtp.disabled = false;
                btnVerifyOtp.innerText = 'Konfirmasi';
            }
        });
    });

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
