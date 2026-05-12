<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Masuk — SIBAIM</title>
  <link rel="icon" href="{{ asset('img/logoKab.Pemalang.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --blue-deep:  #07194a;
      --blue-mid:   #0c2d80;
      --blue-main:  #1251c5;
      --blue-light: #2e6ff5;
      --accent:     #f0c040;
      --white:      #ffffff;
      --off-white:  #f2f6ff;
      --text-dark:  #0d1b3e;
      --text-muted: #7a8bb5;
      --border:     #dce5f7;
      --input-bg:   #f7f9ff;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--off-white);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .card-wrap {
      display: flex;
      width: 1000px;
      min-height: 640px;
      border-radius: 28px;
      overflow: hidden;
      box-shadow: 0 30px 80px rgba(18,81,197,0.18), 0 4px 20px rgba(0,0,0,0.08);
      animation: fadeUp 0.65s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes fadeUp {
      from { opacity:0; transform:translateY(30px); }
      to   { opacity:1; transform:translateY(0); }
    }

    /* ══ KIRI — LOGO PANEL ══ */
    .logo-panel {
      width: 400px;
      background: linear-gradient(170deg, var(--blue-deep) 0%, var(--blue-mid) 50%, var(--blue-main) 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 56px 44px;
      position: relative;
      overflow: hidden;
      text-align: center;
    }

    .logo-panel .ring { position: absolute; border-radius: 50%; pointer-events: none; }
    .ring.r1 { width:460px; height:460px; border:1px solid rgba(255,255,255,0.05); top:-170px; right:-160px; }
    .ring.r2 { width:300px; height:300px; border:1px solid rgba(255,255,255,0.04); bottom:-120px; left:-80px; }
    .ring.r3 { width:200px; height:200px; border:1px dashed rgba(240,192,64,0.12); bottom:60px; right:-60px; }

    .logo-panel::after {
      content:''; position:absolute;
      width:320px; height:320px; border-radius:50%;
      background:radial-gradient(circle, rgba(46,111,245,0.22) 0%, transparent 70%);
      top:50%; left:50%; transform:translate(-50%,-50%); pointer-events:none;
    }

    .logo-wrap { position:relative; z-index:2; }

    .logo-img-wrap {
      width: 148px; height: 148px;
      background: white;
      border-radius: 36px;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 30px;
      box-shadow: 0 24px 64px rgba(0,0,0,0.3), 0 0 0 10px rgba(255,255,255,0.06);
    }

    .logo-img-wrap img { width: 100px; height: 100px; object-fit: contain; }

    .logo-kab { font-size: 10.5px; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; color: var(--accent); margin-bottom: 6px; }
    .logo-nama-sistem { font-size: 26px; font-weight: 800; color: var(--white); line-height: 1.2; margin-bottom: 4px; letter-spacing: -0.01em; }
    .divider-logo { width: 44px; height: 2px; background: var(--accent); border-radius: 2px; margin: 16px auto 16px; opacity: 0.75; }
    .logo-instansi-nama { font-size: 15px; font-weight: 700; color: rgba(255,255,255,0.92); margin-bottom: 6px; line-height: 1.4; }
    .logo-instansi-dinas { font-size: 13px; font-weight: 400; color: rgba(255,255,255,0.5); line-height: 1.65; }
    .logo-desc { margin-top: 22px; font-size: 12px; color: rgba(255,255,255,0.35); line-height: 1.7; }

    /* ══ KANAN — FORM PANEL ══ */
    .form-panel {
      flex: 1;
      background: var(--white);
      padding: 48px 52px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      overflow-y: auto;
    }

    .tab-switcher {
      display: inline-flex;
      background: var(--off-white);
      border-radius: 12px;
      padding: 4px;
      margin-bottom: 28px;
      border: 1px solid var(--border);
    }

    .tab-btn {
      border: none; background: transparent;
      color: var(--text-muted); font-family: inherit;
      font-size: 13.5px; font-weight: 600;
      padding: 9px 28px; border-radius: 9px;
      cursor: pointer; transition: all 0.22s;
    }
    .tab-btn.active { background: var(--blue-main); color: var(--white); box-shadow: 0 4px 14px rgba(18,81,197,0.35); }

    .form-title { font-size: 24px; font-weight: 800; color: var(--text-dark); margin-bottom: 4px; }
    .form-subtitle { font-size: 14px; color: var(--text-muted); margin-bottom: 24px; }

    .form-view { display: none; }
    .form-view.active { display: block; }

    .input-group { margin-bottom: 15px; }

    label {
      display: block; font-size: 11px; font-weight: 700;
      letter-spacing: 0.07em; text-transform: uppercase;
      color: var(--text-muted); margin-bottom: 6px;
    }

    input[type="text"], input[type="email"], input[type="password"] {
      width: 100%; background: var(--input-bg);
      border: 1.5px solid var(--border); border-radius: 10px;
      padding: 11px 14px; color: var(--text-dark);
      font-family: inherit; font-size: 14px; outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    input:focus { border-color: var(--blue-light); box-shadow: 0 0 0 3px rgba(46,111,245,0.12); background: white; }
    input::placeholder { color: #c2cde8; }

    .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .forgot { text-align: right; margin-top: -6px; margin-bottom: 18px; }
    .forgot a { font-size: 12px; color: var(--blue-main); text-decoration: none; font-weight: 600; }
    .forgot a:hover { text-decoration: underline; }

    .btn-submit {
      width: 100%; padding: 13px;
      background: linear-gradient(135deg, var(--blue-mid) 0%, var(--blue-light) 100%);
      border: none; border-radius: 12px; color: var(--white);
      font-family: inherit; font-weight: 700; font-size: 15px;
      letter-spacing: 0.03em; cursor: pointer;
      box-shadow: 0 6px 20px rgba(18,81,197,0.3);
      transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
    }
    .btn-submit:hover { opacity: 0.92; transform: translateY(-1px); box-shadow: 0 10px 28px rgba(18,81,197,0.4); }
    .btn-submit:active { transform: translateY(0); }
    .btn-submit:disabled { background: #cbd5e1; cursor: not-allowed; box-shadow: none; }

    .sep { display:flex; align-items:center; gap:12px; margin: 16px 0; color: var(--text-muted); font-size: 12px; }
    .sep::before,.sep::after { content:''; flex:1; height:1px; background: var(--border); }

    .btn-google {
      width: 100%; padding: 11px; background: white;
      border: 1.5px solid var(--border); border-radius: 12px;
      color: var(--text-dark); font-family: inherit; font-size: 14px; font-weight: 600;
      cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;
      transition: border-color 0.2s, box-shadow 0.2s; text-decoration: none;
    }
    .btn-google:hover { border-color: var(--blue-light); box-shadow: 0 2px 12px rgba(46,111,245,0.1); }

    .alert-err { background: #fff1f2; border: 1.5px solid #fecdd3; color: #9f1239; border-radius: 10px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }
    .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; border-radius: 10px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }

    .btn-inline-verify {
      background: var(--blue-main);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 0 15px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      height: 42px;
      white-space: nowrap;
      transition: all 0.2s;
    }
    .btn-inline-verify:hover { background: var(--blue-light); }
    .btn-inline-verify:disabled { background: #cbd5e1; cursor: not-allowed; }

    #otp-section {
      background: #f8fafc;
      border: 1px dashed var(--border);
      border-radius: 12px;
      padding: 15px;
      margin-top: 10px;
      display: none;
      animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    .verify-status { font-size: 11px; font-weight: 700; margin-top: 5px; display: none; }
    .verify-status.success { color: #059669; }
    .verify-status.error { color: #dc2626; }
    
    .password-wrapper { position: relative; width: 100%; }
    .toggle-password {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--text-muted);
      z-index: 10;
      font-size: 14px;
      transition: color 0.2s;
    }
    .toggle-password:hover { color: var(--blue-main); }
    
    .back-link { text-align: center; margin-top: 24px; }
    .back-link a { color: var(--text-muted); text-decoration: none; font-size: 13px; transition: color 0.2s; }
    .back-link a:hover { color: var(--blue-main); }
    
    @media (max-width: 740px) {
      .card-wrap { flex-direction: column-reverse; width:95vw; min-height:unset; }
      .logo-panel { width:100%; padding:36px 24px; }
      .form-panel { padding:32px 24px; }
      .input-row { grid-template-columns:1fr; }
    }
  </style>
</head>
<body>

<div class="card-wrap">

  <!-- KIRI: LOGO -->
  <div class="logo-panel">
    <div class="ring r1"></div>
    <div class="ring r2"></div>
    <div class="ring r3"></div>

    <div class="logo-wrap">
      <div class="logo-img-wrap">
        <img src="{{ asset('img/logoKab.Pemalang.png') }}" alt="Logo Kabupaten Pemalang"/>
      </div>

      <div class="logo-kab">Pemerintah Kabupaten</div>
      <div class="logo-nama-sistem">SIBAIM</div>
      <div class="divider-logo"></div>

      <div class="logo-instansi-nama">Kabupaten Pemalang</div>
      <div class="logo-instansi-dinas">
        Dinas Perhubungan, Perumahan, dan <br/>Kawasan Permukiman 
      </div>

      <div class="logo-desc">
        Sistem Informasi Basis Data <br/>Kawasan Permukiman
      </div>
    </div>
  </div>

  <!-- KANAN: FORM -->
  <div class="form-panel">

    <div class="tab-switcher">
      <button class="tab-btn active" onclick="switchTab('login')">Masuk</button>
      <button class="tab-btn" onclick="switchTab('register')">Daftar</button>
    </div>

    <!-- ══ FORM LOGIN ══ -->
    <div class="form-view active" id="login-view">
      <div class="form-title">Selamat Datang 👋</div>
      <div class="form-subtitle">Masuk untuk mengajukan atau memantau status PSU Anda</div>

      @if (session('error'))
        <div class="alert-err">{{ session('error') }}</div>
      @endif

      @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group">
          <label>ALAMAT EMAIL</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@gmail.com" required autofocus/>
          @if(!$errors->hasBag('registerBag'))
            @error('email')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
          @endif
        </div>

        <div class="input-group">
          <label>KATA SANDI</label>
          <div class="password-wrapper">
            <input type="password" name="password" id="login-password" placeholder="••••••••" required/>
            <i class="fas fa-eye toggle-password" onclick="togglePassword('login-password', this)"></i>
          </div>
          @error('password')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
        </div>

        <div class="forgot">
          <label style="display:none"></label>
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
            <label style="display:flex;align-items:center;gap:6px;text-transform:none;font-size:13px;color:var(--text-muted);letter-spacing:0;cursor:pointer">
              <input type="checkbox" name="remember" style="width:auto;border:none;background:none;box-shadow:none;padding:0"> Ingat saya
            </label>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}">Lupa kata sandi?</a>
            @endif
          </div>
        </div>

        <button type="submit" class="btn-submit">Masuk ke Portal PSU</button>
      </form>
    </div>

    <!-- ══ FORM REGISTER ══ -->
    <div class="form-view" id="register-view">
      <div class="form-title">Buat Akun Baru</div>
      <div class="form-subtitle">Daftarkan akun untuk mengajukan PSU Anda</div>

      <!-- Step Indicator -->
      <div id="reg-step-indicator" style="display:flex;gap:6px;align-items:center;margin-bottom:18px;">
        <div id="step-1" style="display:flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:var(--blue-main)">
          <span style="width:20px;height:20px;border-radius:50%;background:var(--blue-main);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:10px;">1</span>
          Masukkan Email
        </div>
        <span style="flex:1;height:1px;background:#dce5f7;"></span>
        <div id="step-2" style="display:flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:#94a3b8">
          <span id="step-2-circle" style="width:20px;height:20px;border-radius:50%;background:#e2e8f0;color:#94a3b8;display:inline-flex;align-items:center;justify-content:center;font-size:10px;">2</span>
          Verifikasi OTP
        </div>
        <span style="flex:1;height:1px;background:#dce5f7;"></span>
        <div id="step-3" style="display:flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:#94a3b8">
          <span id="step-3-circle" style="width:20px;height:20px;border-radius:50%;background:#e2e8f0;color:#94a3b8;display:inline-flex;align-items:center;justify-content:center;font-size:10px;">3</span>
          Lengkapi Data
        </div>
      </div>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="input-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" required/>
          @error('name', 'registerBag')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
        </div>

        <div class="input-group">
          <label>Alamat Email</label>
          <div style="display: flex; gap: 8px;">
            <div style="flex: 1;">
              <input type="email" id="reg-email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required/>
            </div>
            <button type="button" id="btn-send-otp" class="btn-inline-verify">Verifikasi</button>
          </div>
          <div id="verify-email-status" class="verify-status"></div>
          @error('email', 'registerBag')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
        </div>

        <!-- OTP SECTION (HIDDEN BY DEFAULT) -->
        <div id="otp-section">
          <label>② Masukkan Kode OTP</label>
          <p style="font-size: 11px; color: #64748b; margin-bottom: 10px;">Kode 6 digit telah dikirim ke email Anda. Periksa kotak masuk atau folder Spam.</p>
          <div style="display: flex; gap: 8px;">
            <input type="text" id="reg-otp" maxlength="6" placeholder="000000" style="text-align: center; font-weight: 800; letter-spacing: 4px;"/>
            <button type="button" id="btn-check-otp" class="btn-inline-verify">Cek Kode</button>
          </div>
          <div id="verify-otp-status" class="verify-status"></div>
        </div>

        <div class="input-row">
          <div class="input-group">
            <label>Kata Sandi</label>
            <div class="password-wrapper">
              <input type="password" name="password" id="reg-password" placeholder="Min. 8 karakter" required/>
              <i class="fas fa-eye toggle-password" onclick="togglePassword('reg-password', this)"></i>
            </div>
            <div id="password-strength" style="font-size: 11px; margin-top: 4px; display: none;"></div>
            @error('password', 'registerBag')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
          </div>
          <div class="input-group">
            <label>Konfirmasi Sandi</label>
            <div class="password-wrapper">
              <input type="password" name="password_confirmation" id="reg-password-confirm" placeholder="Ulangi sandi" required/>
              <i class="fas fa-eye toggle-password" onclick="togglePassword('reg-password-confirm', this)"></i>
            </div>
          </div>
        </div>

        <button type="submit" id="btn-register-submit" class="btn-submit" style="margin-top:6px;" disabled>Daftarkan Akun</button>
        <p id="reg-submit-hint" style="text-align:center;font-size:11px;color:#94a3b8;margin-top:8px;transition:opacity 0.3s;">
          🔒 Verifikasi email Anda terlebih dahulu untuk mengaktifkan tombol ini
        </p>
      </form>
      <p class="terms" style="margin-top: 10px; font-size: 11px; color: var(--text-muted); text-align: center;">
        Dengan mendaftar, Anda menyetujui Syarat &amp; Ketentuan serta Kebijakan Privasi sistem.
      </p>
    </div>

    <div class="back-link">
      <a href="/">← Kembali ke Beranda</a>
    </div>

  </div>
</div>

<script>
  // Baca URL param ?tab=register atau jika ada error dari form registrasi
  (function() {
    const params = new URLSearchParams(window.location.search);
    const hasRegisterErrors = {{ $errors->hasBag('registerBag') ? 'true' : 'false' }};
    if (params.get('tab') === 'register' || hasRegisterErrors) switchTab('register');
  })();

  function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.form-view').forEach(v => v.classList.remove('active'));
    const labels = { login: 'Masuk', register: 'Daftar' };
    [...document.querySelectorAll('.tab-btn')]
      .find(b => b.textContent.trim() === labels[tab])
      ?.classList.add('active');
    document.getElementById(tab + '-view').classList.add('active');
  }

  // INLINE OTP LOGIC
  document.addEventListener('DOMContentLoaded', function() {
    const btnSendOtp = document.getElementById('btn-send-otp');
    const btnCheckOtp = document.getElementById('btn-check-otp');
    const emailInput = document.getElementById('reg-email');
    const otpInput = document.getElementById('reg-otp');
    const otpSection = document.getElementById('otp-section');
    const submitBtn = document.getElementById('btn-register-submit');
    
    const emailStatus = document.getElementById('verify-email-status');
    const otpStatus = document.getElementById('verify-otp-status');

    let isEmailVerified = false;

    btnSendOtp.addEventListener('click', async function() {
      const email = emailInput.value;
      if(!email || !email.includes('@')) {
        alert('Silakan masukkan email yang valid.');
        return;
      }

      btnSendOtp.disabled = true;
      btnSendOtp.innerText = 'Mengirim...';
      emailStatus.style.display = 'none';

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
          emailStatus.innerText = '✓ Kode OTP terkirim! Cek inbox/spam email Anda.';
          emailStatus.className = 'verify-status success';
          emailStatus.style.display = 'block';
          btnSendOtp.innerText = 'Kirim Ulang';
          btnSendOtp.disabled = false;
          // Advance step indicator to step 2
          const s2 = document.getElementById('step-2');
          const s2c = document.getElementById('step-2-circle');
          if(s2) s2.style.color = 'var(--blue-main)';
          if(s2c) { s2c.style.background = 'var(--blue-main)'; s2c.style.color = '#fff'; }
        } else {
          emailStatus.innerText = data.message || 'Gagal mengirim OTP.';
          emailStatus.className = 'verify-status error';
          emailStatus.style.display = 'block';
          btnSendOtp.disabled = false;
          btnSendOtp.innerText = 'Verifikasi';
        }
      } catch (error) {
        alert('Terjadi kesalahan koneksi.');
        btnSendOtp.disabled = false;
        btnSendOtp.innerText = 'Verifikasi';
      }
    });

    btnCheckOtp.addEventListener('click', async function() {
      const otp = otpInput.value;
      const email = emailInput.value;
      if(!otp || otp.length < 6) {
        alert('Masukkan 6 digit kode OTP.');
        return;
      }

      btnCheckOtp.disabled = true;
      btnCheckOtp.innerText = 'Memeriksa...';

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
          otpStatus.innerText = 'Email berhasil diverifikasi!';
          otpStatus.className = 'verify-status success';
          otpStatus.style.display = 'block';
          
          // Disable email and otp inputs
          emailInput.readOnly = true;
          otpInput.readOnly = true;
          btnSendOtp.style.display = 'none';
          btnCheckOtp.disabled = true;
          btnCheckOtp.innerText = 'Selesai';
          
          // Enable register button
          submitBtn.disabled = false;
          isEmailVerified = true;
          // Advance step indicator to step 3
          const s3 = document.getElementById('step-3');
          const s3c = document.getElementById('step-3-circle');
          if(s3) s3.style.color = 'var(--blue-main)';
          if(s3c) { s3c.style.background = 'var(--blue-main)'; s3c.style.color = '#fff'; }
          // Hide submit hint
          const hint = document.getElementById('reg-submit-hint');
          if(hint) hint.style.display = 'none';
        } else {
          otpStatus.innerText = data.message || 'Kode OTP salah.';
          otpStatus.className = 'verify-status error';
          otpStatus.style.display = 'block';
          btnCheckOtp.disabled = false;
          btnCheckOtp.innerText = 'Cek Kode';
        }
      } catch (error) {
        alert('Terjadi kesalahan koneksi.');
        btnCheckOtp.disabled = false;
        btnCheckOtp.innerText = 'Cek Kode';
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

  // Password Strength Indicator
  const pwInput = document.getElementById('reg-password');
  const strengthDiv = document.getElementById('password-strength');
  if(pwInput && strengthDiv) {
    pwInput.addEventListener('input', function() {
      const val = pwInput.value;
      if(!val) { strengthDiv.style.display = 'none'; return; }
      strengthDiv.style.display = 'block';
      let strength = 0;
      if(val.length >= 8) strength++;
      if(/[a-z]/.test(val) && /[A-Z]/.test(val)) strength++;
      if(/\d/.test(val)) strength++;
      if(/[^a-zA-Z\d]/.test(val)) strength++;
      
      let color = '#ef4444'; let text = 'Lemah';
      if(strength === 2) { color = '#f59e0b'; text = 'Sedang'; }
      if(strength >= 3) { color = '#10b981'; text = 'Kuat'; }
      
      strengthDiv.innerHTML = `<span style="color: ${color}; font-weight: 600;">Kekuatan sandi: ${text}</span> <br><span style="color: var(--text-muted);">(Min. 8 karakter, huruf besar & kecil, angka, simbol)</span>`;
    });
  }
</script>

</body>
</html>
