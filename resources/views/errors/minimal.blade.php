<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - SIG Jalan Pemalang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            max-width: 500px;
            padding: 40px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.1);
        }
        .icon-box {
            font-size: 80px;
            margin-bottom: 20px;
            color: #2563eb;
        }
        .code {
            font-size: 120px;
            font-weight: 800;
            margin: 0;
            line-height: 1;
            letter-spacing: -4px;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 10px 0 20px;
        }
        p {
            color: #64748b;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: #2563eb;
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-box">
            @yield('icon')
        </div>
        <div class="code">@yield('code')</div>
        <h1>@yield('message')</h1>
        <p>@yield('description')</p>
        <a href="@yield('link', '/')" class="btn-back">
            <i class="fas fa-arrow-left"></i> @yield('button_text', 'Kembali ke Beranda')
        </a>
    </div>
</body>
</html>
