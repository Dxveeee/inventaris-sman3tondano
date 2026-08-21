<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            padding: 40px 20px;
        }

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
        }

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

        .form-group input,
        .form-group select {
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

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,79,138,.10);
        }

        .error-msg {
            font-size: 12px;
            color: #d94f4f;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fcd4d4;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            color: #b91c1c;
            margin-bottom: 18px;
        }

        .btn-register {
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

        .btn-register::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.15), transparent);
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(26,79,138,.40);
            filter: brightness(1.05);
        }

        .btn-register:active { transform: translateY(0); }

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

    <div class="logo-ring">
        <img src="{{ asset('images/logo-sekolah.png') }}">
    </div>

    <div class="card">
        <div class="card-header">
            <h1>Buat Akun Baru</h1>
            <p>SMA Negeri 3 Tondano</p>
            <div class="divider"></div>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama --}}
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <div class="input-wrap">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        required
                        autofocus
                    >
                </div>
                @error('name')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
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
                    >
                </div>
                @error('email')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jabatan --}}
            <div class="form-group">
                <label for="jabatan">Peran</label>
                <div class="input-wrap">
                    <select id="jabatan" name="jabatan" required>
                        <option value="">Pilih peran</option>
                        <option value="Guru" {{ old('jabatan') == 'Guru' ? 'selected' : '' }}>Guru</option>
                        <option value="Siswa" {{ old('jabatan') == 'Siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                </div>
                @error('jabatan')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
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

            {{-- Konfirmasi Password --}}
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrap">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        required
                    >
                </div>
                @error('password_confirmation')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-register">Daftar</button>
        </form>

        <div class="card-footer">
            <p>
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </p>
            <p style="margin-top:10px">
                <strong>Sistem Informasi Inventaris</strong><br>
                SMA Negeri 3 Tondano &copy; {{ date('Y') }}
            </p>
        </div>
    </div>

</div>

</body>
</html>
