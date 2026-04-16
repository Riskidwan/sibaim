<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Masuk — SIBAIM</title>
  <link rel="icon" href="{{ asset('img/logoKab.Pemalang.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
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

    .terms { font-size: 12px; color: var(--text-muted); margin-top: 12px; line-height: 1.65; }
    .terms a { color: var(--blue-main); text-decoration:none; font-weight:600; }

    .alert-err { background: #fff1f2; border: 1.5px solid #fecdd3; color: #9f1239; border-radius: 10px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }

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

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group">
          <label>Alamat Email</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus/>
          @error('email')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
        </div>

        <div class="input-group">
          <label>Kata Sandi</label>
          <input type="password" name="password" placeholder="Masukkan kata sandi" required/>
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

      <div class="sep">atau</div>

    <a href="{{ route('redirect.google') }}" class="btn-google">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
          <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
          <path d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9 18z" fill="#34A853"/>
          <path d="M3.964 10.71C3.784 10.17 3.68 9.593 3.68 9c0-.593.104-1.17.284-1.71V4.958H.957C.347 6.173 0 7.548 0 9s.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
          <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 4.958L3.964 6.29C4.672 4.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
        </svg>
        Masuk dengan Akun Google
      </a>
    </div>

    <!-- ══ FORM REGISTER ══ -->
    <div class="form-view" id="register-view">
      <div class="form-title">Buat Akun Baru</div>
      <div class="form-subtitle">Daftarkan akun untuk mengajukan PSU Anda</div>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="input-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" required/>
          @error('name')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
        </div>

        <div class="input-group">
          <label>Alamat Email</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required/>
          @error('email')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
        </div>

        <div class="input-row">
          <div class="input-group">
            <label>Kata Sandi</label>
            <input type="password" name="password" placeholder="Min. 8 karakter" required/>
            @error('password')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
          </div>
          <div class="input-group">
            <label>Konfirmasi Sandi</label>
            <input type="password" name="password_confirmation" placeholder="Ulangi sandi" required/>
          </div>
        </div>

        <button type="submit" class="btn-submit" style="margin-top:6px;">Daftarkan Akun</button>
      </form>

      <div class="sep">atau</div>

      <a href="{{ route('redirect.google') }}" class="btn-google">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
          <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
          <path d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9 18z" fill="#34A853"/>
          <path d="M3.964 10.71C3.784 10.17 3.68 9.593 3.68 9c0-.593.104-1.17.284-1.71V4.958H.957C.347 6.173 0 7.548 0 9s.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
          <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 4.958L3.964 6.29C4.672 4.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
        </svg>
        Daftar dengan Akun Google
      </a>

      <p class="terms">
        Dengan mendaftar, Anda menyetujui Syarat & Ketentuan serta Kebijakan Privasi sistem.
      </p>
    </div>

  </div>
</div>

<script>
  // Baca URL param ?tab=register untuk auto-switch ke tab Daftar (dari link redirect)
  (function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('tab') === 'register') switchTab('register');
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
</script>

</body>
</html>
