<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Kata Sandi — Portal PSU Kabupaten Pemalang</title>
  <link rel="icon" href="{{ asset('img/logoKab.Pemalang.png') }}" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --blue-deep: #07194a; --blue-mid: #0c2d80; --blue-main: #1251c5;
      --blue-light: #2e6ff5; --accent: #f0c040; --white: #ffffff;
      --off-white: #f2f6ff; --text-dark: #0d1b3e; --text-muted: #7a8bb5;
      --border: #dce5f7; --input-bg: #f7f9ff;
    }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--off-white); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .card-wrap { display: flex; width: 1000px; min-height: 620px; border-radius: 28px; overflow: hidden; box-shadow: 0 30px 80px rgba(18,81,197,0.18), 0 4px 20px rgba(0,0,0,0.08); animation: fadeUp 0.65s cubic-bezier(0.22,1,0.36,1) both; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
    .logo-panel { width: 400px; background: linear-gradient(170deg, var(--blue-deep) 0%, var(--blue-mid) 50%, var(--blue-main) 100%); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 56px 44px; position: relative; overflow: hidden; text-align: center; }
    .ring { position: absolute; border-radius: 50%; pointer-events: none; }
    .r1 { width:460px; height:460px; border:1px solid rgba(255,255,255,0.05); top:-170px; right:-160px; }
    .r2 { width:300px; height:300px; border:1px solid rgba(255,255,255,0.04); bottom:-120px; left:-80px; }
    .r3 { width:200px; height:200px; border:1px dashed rgba(240,192,64,0.12); bottom:60px; right:-60px; }
    .logo-panel::after { content:''; position:absolute; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle, rgba(46,111,245,0.22) 0%, transparent 70%); top:50%; left:50%; transform:translate(-50%,-50%); pointer-events:none; }
    .logo-wrap { position:relative; z-index:2; }
    .logo-img-wrap { width:148px; height:148px; background:white; border-radius:36px; display:flex; align-items:center; justify-content:center; margin:0 auto 30px; box-shadow:0 24px 64px rgba(0,0,0,0.3), 0 0 0 10px rgba(255,255,255,0.06); }
    .logo-img-wrap img { width:100px; height:100px; object-fit:contain; }
    .logo-kab { font-size:10.5px; font-weight:700; letter-spacing:0.2em; text-transform:uppercase; color:var(--accent); margin-bottom:6px; }
    .logo-nama { font-size:26px; font-weight:800; color:var(--white); line-height:1.2; margin-bottom:4px; }
    .divider-logo { width:44px; height:2px; background:var(--accent); border-radius:2px; margin:16px auto; opacity:0.75; }
    .logo-instansi { font-size:15px; font-weight:700; color:rgba(255,255,255,0.92); margin-bottom:6px; line-height:1.4; }
    .logo-dinas { font-size:13px; color:rgba(255,255,255,0.5); line-height:1.65; }
    .form-panel { flex:1; background:var(--white); padding:52px 52px; display:flex; flex-direction:column; justify-content:center; overflow-y:auto; }
    .icon-circle { width:56px; height:56px; background:#eff6ff; border-radius:16px; display:flex; align-items:center; justify-content:center; margin-bottom:20px; }
    .form-title { font-size:24px; font-weight:800; color:var(--text-dark); margin-bottom:6px; }
    .form-subtitle { font-size:14px; color:var(--text-muted); margin-bottom:28px; line-height:1.6; }
    .input-group { margin-bottom:16px; }
    label { display:block; font-size:11px; font-weight:700; letter-spacing:0.07em; text-transform:uppercase; color:var(--text-muted); margin-bottom:7px; }
    input[type="email"], input[type="password"] { width:100%; background:var(--input-bg); border:1.5px solid var(--border); border-radius:10px; padding:12px 15px; color:var(--text-dark); font-family:inherit; font-size:14px; outline:none; transition:border-color 0.2s, box-shadow 0.2s; }
    input:focus { border-color:var(--blue-light); box-shadow:0 0 0 3px rgba(46,111,245,0.12); background:white; }
    input::placeholder { color:#c2cde8; }
    .input-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .btn-submit { width:100%; padding:13px; background:linear-gradient(135deg, var(--blue-mid) 0%, var(--blue-light) 100%); border:none; border-radius:12px; color:var(--white); font-family:inherit; font-weight:700; font-size:15px; cursor:pointer; box-shadow:0 6px 20px rgba(18,81,197,0.3); transition:opacity 0.2s, transform 0.15s; margin-top:6px; }
    .btn-submit:hover { opacity:0.92; transform:translateY(-1px); }
    .alert-err { background:#fff1f2; border:1.5px solid #fecdd3; color:#9f1239; border-radius:10px; padding:10px 14px; font-size:13px; margin-bottom:16px; }
    
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
    
    @media (max-width: 740px) { .card-wrap { flex-direction:column-reverse; width:95vw; } .logo-panel { width:100%; padding:36px 24px; } .form-panel { padding:36px 24px; } .input-row { grid-template-columns:1fr; } }
  </style>
</head>
<body>
<div class="card-wrap">
  <div class="logo-panel">
    <div class="ring r1"></div><div class="ring r2"></div><div class="ring r3"></div>
    <div class="logo-wrap">
      <div class="logo-img-wrap">
        <img src="{{ asset('img/logoKab.Pemalang.png') }}" alt="Logo Kabupaten Pemalang"/>
      </div>
      <div class="logo-kab">Pemerintah Kabupaten</div>
      <div class="logo-nama">Portal PSU</div>
      <div class="divider-logo"></div>
      <div class="logo-instansi">Kabupaten Pemalang</div>
      <div class="logo-dinas">Dinas Perhubungan, Perumahan dan <br/>Kawasan Permukiman</div>
    </div>
  </div>

  <div class="form-panel">
    <div class="icon-circle">
      <svg width="26" height="26" fill="none" stroke="#1251c5" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
    </div>

    <div class="form-title">Buat Kata Sandi Baru</div>
    <div class="form-subtitle">Masukkan kata sandi baru Anda di bawah ini. Pastikan kata sandi cukup kuat dan mudah Anda ingat.</div>

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}"/>

      <div class="input-group">
        <label>Alamat Email</label>
        <input type="email" name="email" value="{{ $email ?? old('email') }}" placeholder="nama@email.com" required autofocus/>
        @error('email')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
      </div>

      <div class="input-row">
        <div class="input-group">
          <label>Kata Sandi Baru</label>
          <div class="password-wrapper">
            <input type="password" name="password" id="password" placeholder="Min. 8 karakter" required/>
            <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
          </div>
          @error('password')<span style="color:#e11d48;font-size:12px;margin-top:4px;display:block">{{ $message }}</span>@enderror
        </div>
        <div class="input-group">
          <label>Konfirmasi Sandi</label>
          <div class="password-wrapper">
            <input type="password" name="password_confirmation" id="password-confirm" placeholder="Ulangi sandi baru" required/>
            <i class="fas fa-eye toggle-password" onclick="togglePassword('password-confirm', this)"></i>
          </div>
        </div>
      </div>

      <button type="submit" class="btn-submit">Simpan Kata Sandi Baru</button>
    </form>
  </div>
</div>

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

</body>
</html>
