<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Verifikasi OTP — SIBAIM</title>
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

        .card {
            background: var(--white);
            width: 100%;
            max-width: 450px;
            padding: 48px 40px;
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(18,81,197,0.12);
            text-align: center;
            animation: fadeUp 0.6s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes fadeUp {
            from { opacity:0; transform:translateY(20px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .icon-box {
            width: 80px; height: 80px;
            background: var(--off-white);
            color: var(--blue-main);
            border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
            font-size: 32px;
            border: 1px solid var(--border);
        }

        h2 { font-size: 24px; font-weight: 800; color: var(--text-dark); margin-bottom: 8px; }
        p { font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 32px; }
        .email-preview { font-weight: 700; color: var(--blue-main); }

        .otp-input-group {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-bottom: 32px;
        }

        .otp-input-group input {
            width: 100%;
            height: 56px;
            background: var(--off-white);
            border: 2px solid var(--border);
            border-radius: 12px;
            text-align: center;
            font-size: 18px;
            font-weight: 800;
            color: var(--blue-deep);
            outline: none;
            transition: all 0.2s;
        }

        .otp-input-group input:focus {
            border-color: var(--blue-main);
            background: white;
            box-shadow: 0 0 0 4px rgba(18,81,197,0.1);
        }

        .btn-verify {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, var(--blue-mid) 0%, var(--blue-light) 100%);
            border: none; border-radius: 14px; color: var(--white);
            font-family: inherit; font-weight: 700; font-size: 16px;
            cursor: pointer; box-shadow: 0 6px 20px rgba(18,81,197,0.3);
            transition: all 0.2s;
            margin-bottom: 16px;
        }

        .btn-verify:hover { transform: translateY(-1px); box-shadow: 0 10px 28px rgba(18,81,197,0.4); }

        .resend-text { font-size: 13px; color: var(--text-muted); }
        .resend-link {
            color: var(--blue-main);
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            font-family: inherit;
        }
        .resend-link:hover { text-decoration: underline; }
        .resend-link:disabled { opacity: 0.5; cursor: not-allowed; }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
        }
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* Hidden single input flow for simple handling */
        #hidden-otp { position: absolute; opacity: 0; pointer-events: none; }
    </style>
</head>
<body>

<div class="card">
    <div class="icon-box">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
            <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
        </svg>
    </div>

    <h2>Verifikasi Email Anda</h2>
    <p>Masukkan 6 digit kode OTP yang baru saja kami kirimkan ke <br><span class="email-preview">{{ Auth::user()->email }}</span></p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->has('otp'))
        <div class="alert alert-danger">{{ $errors->first('otp') }}</div>
    @endif

    <form method="POST" action="{{ route('auth.verify-otp.post') }}" id="otp-form">
        @csrf
        <input type="text" name="otp" id="hidden-otp" maxlength="6" autofocus required autocomplete="one-time-code">
        
        <div class="otp-input-group">
            <input type="text" maxlength="1" pattern="\d*" inputmode="numeric">
            <input type="text" maxlength="1" pattern="\d*" inputmode="numeric">
            <input type="text" maxlength="1" pattern="\d*" inputmode="numeric">
            <input type="text" maxlength="1" pattern="\d*" inputmode="numeric">
            <input type="text" maxlength="1" pattern="\d*" inputmode="numeric">
            <input type="text" maxlength="1" pattern="\d*" inputmode="numeric">
        </div>

        <button type="submit" class="btn-verify">Verifikasi Sekarang</button>
    </form>

    <div class="resend-text">
        Tidak menerima kode? 
        <form method="POST" action="{{ route('auth.resend-otp') }}" style="display:inline">
            @csrf
            <button type="submit" class="resend-link" id="resend-btn">Kirim Ulang</button>
        </form>
    </div>
</div>

<script>
    const inputs = document.querySelectorAll('.otp-input-group input');
    const hiddenInput = document.getElementById('hidden-otp');

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length > 1) {
                e.target.value = e.target.value.slice(0, 1);
            }
            
            updateHiddenValue();

            if (e.target.value !== '' && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    function updateHiddenValue() {
        let val = '';
        inputs.forEach(input => val += input.value);
        hiddenInput.value = val;
    }

    // Auto-focus first input
    window.addEventListener('load', () => inputs[0].focus());

    // Resend Timer logic
    let secondsLeft = 60;
    const resendBtn = document.getElementById('resend-btn');
    
    function startTimer() {
        resendBtn.disabled = true;
        const timer = setInterval(() => {
            secondsLeft--;
            resendBtn.innerText = `Kirim Ulang (${secondsLeft}s)`;
            if (secondsLeft <= 0) {
                clearInterval(timer);
                resendBtn.disabled = false;
                resendBtn.innerText = 'Kirim Ulang';
                secondsLeft = 60;
            }
        }, 1000);
    }
    
    // Auto start timer if just resent
    @if(session('status'))
        startTimer();
    @endif
</script>

</body>
</html>
