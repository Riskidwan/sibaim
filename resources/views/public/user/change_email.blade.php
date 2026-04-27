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
    .btn-save:disabled { background: #cbd5e1; color: #94a3b8; transform: none; cursor: not-allowed; }
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
                        <div class="input-group">
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="nama@baru.com">
                            <button class="btn btn-outline-primary" type="button" id="btn-send-otp">Kirim Kode OTP</button>
                        </div>
                        <div id="email-status" class="mt-1 small"></div>
                        <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i> Anda harus memverifikasi email baru sebelum menyimpannya.</div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- OTP Verification Section -->
                    <div id="otp-section" style="display: none;" class="mb-4">
                        <div class="p-3 border rounded-4 bg-light">
                            <label class="form-label fw-bold"><i class="fas fa-shield-alt me-1 text-primary"></i> Verifikasi Kode OTP</label>
                            <p class="small text-muted mb-2">Kode telah dikirim ke email baru Anda. Silakan masukkan kode tersebut.</p>
                            <div class="input-group">
                                <input type="text" id="otp_code" class="form-control text-center fw-bold" placeholder="6 Digit" maxlength="6" style="letter-spacing: 3px;">
                                <button class="btn btn-primary" type="button" id="btn-verify-otp">Konfirmasi</button>
                            </div>
                            <div id="otp-status" class="mt-1 small"></div>
                        </div>
                    </div>

                    <div class="text-end mt-5">
                        <button type="submit" class="btn btn-save" id="btn-submit" disabled>
                            <i class="fas fa-save me-2"></i> Perbarui Alamat E-mail
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
    document.addEventListener('DOMContentLoaded', function() {
        const btnSendOtp = document.getElementById('btn-send-otp');
        const btnVerifyOtp = document.getElementById('btn-verify-otp');
        const emailInput = document.getElementById('email');
        const otpInput = document.getElementById('otp_code');
        const otpSection = document.getElementById('otp-section');
        const submitBtn = document.getElementById('btn-submit');
        
        const emailStatus = document.getElementById('email-status');
        const otpStatus = document.getElementById('otp-status');

        btnSendOtp.addEventListener('click', async function() {
            const email = emailInput.value;
            if(!email || !email.includes('@')) {
                alert('Silakan masukkan email yang valid.');
                return;
            }

            btnSendOtp.disabled = true;
            btnSendOtp.innerText = 'Mengirim...';
            emailStatus.innerHTML = '<span class="text-muted small">Sedang mengirim kode OTP...</span>';

            try {
                const response = await fetch('{{ route("auth.send-otp-registration") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();
                if(data.success) {
                    otpSection.style.display = 'block';
                    emailStatus.innerHTML = '<span class="text-success small fw-bold"><i class="fas fa-check-circle"></i> OTP Terkirim ke email baru!</span>';
                    btnSendOtp.innerText = 'Kirim Ulang';
                    btnSendOtp.disabled = false;
                } else {
                    emailStatus.innerHTML = `<span class="text-danger small">${data.message || 'Gagal mengirim OTP.'}</span>`;
                    btnSendOtp.disabled = false;
                    btnSendOtp.innerText = 'Kirim Kode OTP';
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan koneksi.');
                btnSendOtp.disabled = false;
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
            btnVerifyOtp.innerText = '...';

            try {
                const response = await fetch('{{ route("auth.verify-otp-registration") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: email, otp: otp })
                });

                const data = await response.json();
                if(data.success) {
                    otpStatus.innerHTML = '<span class="text-success small fw-bold"><i class="fas fa-check-circle"></i> Berhasil diverifikasi!</span>';
                    
                    emailInput.readOnly = true;
                    otpInput.readOnly = true;
                    btnSendOtp.style.display = 'none';
                    btnVerifyOtp.disabled = true;
                    btnVerifyOtp.innerHTML = '<i class="fas fa-check"></i>';
                    
                    submitBtn.disabled = false;
                } else {
                    otpStatus.innerHTML = `<span class="text-danger small">${data.message || 'Kode OTP salah.'}</span>`;
                    btnVerifyOtp.disabled = false;
                    btnVerifyOtp.innerText = 'Konfirmasi';
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan koneksi.');
                btnVerifyOtp.disabled = false;
            }
        });
    });
</script>
@endpush
