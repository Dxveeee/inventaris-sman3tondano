<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:   #1a4f8a;
            --primary-d: #123a6a;
            --primary-l: #2261a8;
            --accent:    #e8a020;
            --bg:        #eef2f7;
            --card:      #ffffff;
            --text:      #1c2b3a;
            --muted:     #6b7f94;
            --border:    #d0dae6;
            --input-bg:  #f4f7fb;
            --shadow:    0 20px 60px rgba(26,79,138,.18), 0 4px 16px rgba(26,79,138,.10);
        }

        body {
            min-height: 100vh;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(26,79,138,.10) 0%, transparent 70%),
                radial-gradient(ellipse 60% 50% at 80% 90%, rgba(232,160,32,.08) 0%, transparent 70%);
        }

        /* Decorative background shapes */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            z-index: 0;
        }
        body::before {
            width: 500px; height: 500px;
            top: -180px; left: -150px;
            background: radial-gradient(circle, rgba(26,79,138,.12), transparent 70%);
        }
        body::after {
            width: 400px; height: 400px;
            bottom: -140px; right: -120px;
            background: radial-gradient(circle, rgba(232,160,32,.10), transparent 70%);
        }

        .wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 420px;
            padding: 0 20px;
        }

        /* Logo circle */
        .logo-ring {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            background: var(--card);
            box-shadow: 0 8px 30px rgba(26,79,138,.20), 0 0 0 6px rgba(26,79,138,.10);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: -48px;
            z-index: 2;
            position: relative;
            overflow: hidden;
            animation: popIn .5s cubic-bezier(.34,1.56,.64,1) both;
        }

        .logo-ring img {
            width: 72px;
            height: 72px;
            object-fit: contain;
        }

        .logo-placeholder {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-l) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #fff;
            font-weight: 700;
            letter-spacing: -1px;
        }

        /* Card */
        .card {
            width: 100%;
            background: var(--card);
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 72px 36px 36px;
            animation: slideUp .5s cubic-bezier(.22,1,.36,1) .1s both;
        }

        .card-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .card-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.3;
        }

        .card-header p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 6px;
        }

        .divider {
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 2px;
            margin: 10px auto 0;
        }

        /* Form */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 7px;
            letter-spacing: .02em;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            width: 16px;
            height: 16px;
            pointer-events: none;
        }

        .form-group input {
            width: 100%;
            height: 46px;
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 0 14px 0 40px;
            font-family: inherit;
            font-size: 14px;
            color: var(--text);
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        .form-group input::placeholder { color: #aab8c8; }

        .form-group input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,79,138,.10);
        }

        /* Error messages (Laravel) */
        .error-msg {
            font-size: 12px;
            color: #d94f4f;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Session error */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fcd4d4;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            color: #b91c1c;
            margin-bottom: 18px;
        }

        /* Submit button */
        .btn-login {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-l) 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
            letter-spacing: .02em;
            box-shadow: 0 4px 16px rgba(26,79,138,.30);
            transition: transform .15s, box-shadow .15s, filter .15s;
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.15), transparent);
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(26,79,138,.40);
            filter: brightness(1.05);
        }

        .btn-login:active { transform: translateY(0); }

        /* Footer */
        .card-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .card-footer p {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.6;
        }

        .card-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }

        .card-footer strong {
            color: var(--primary);
            font-weight: 600;
        }

        /* Animations */
        @keyframes popIn {
            from { opacity: 0; transform: scale(.7) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- Logo sekolah -->
    <div class="logo-ring">
        <img src="{{ asset('images/logo-sekolah.png') }}">
    </div>

    <!-- Card login -->
    <div class="card">
        <div class="card-header">
            <h1>Sistem Informasi Inventaris</h1>
            <p>SMA Negeri 3 Tondano</p>
            <div class="divider"></div>
        </div>

        {{-- Tampilkan error jika login gagal --}}
        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                        autofocus
                    >
                </div>
                @error('email')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                </div>
                @error('password')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="card-footer">
            <p>
                Mau melakukan peminjaman?
                <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
            <p style="margin-top:10px">
                <strong>Sistem Informasi Inventaris</strong>
                <br>SMA Negeri 3 Tondano &copy; {{ date('Y') }}
            </p>
        </div>
    </div>

        <!-- Tombol Kembali -->
    <a href="{{ route('landing') }}" style="
        align-self: flex-start;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: var(--muted);
        text-decoration: none;
        margin-top: 16px;
        padding: 8px 14px;
        border-radius: 8px;
        background: rgba(255,255,255,.6);
        transition: all 0.2s ease;
        z-index: 2;
        position: relative;
    " onmouseover="this.style.color='var(--primary)'; this.style.background='#fff';"
       onmouseout="this.style.color='var(--muted)'; this.style.background='rgba(255,255,255,.6)';">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Beranda
    </a>

</div>

</body>
</html>
