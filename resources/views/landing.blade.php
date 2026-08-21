<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Inventaris SMA Negeri 3 Tondano</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #37474f;
            --primary-d: #263238;
            --accent: #ff9800;
            --text: #263238;
            --muted: #7b8a97;
            --border: #e0e6ed;
            --card: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f5f7fa;
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 64px;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(38, 50, 56, 0.95);
            backdrop-filter: blur(10px);
            z-index: 100;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
        }

        .brand img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: contain;
            display: block;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-text .brand-title {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
        }

        .brand-text .brand-subtitle {
            font-size: 10px;
            color: rgba(255,255,255,.6);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-links {
            display: flex;
            gap: 28px;
            align-items: center;
        }

        .nav-link {
            color: rgba(255,255,255,.7);
            font-size: 13.5px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--accent);
        }

        .login-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--accent);
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            transition: background 0.2s ease, transform 0.2s ease;
            margin-left: 12px;
        }

        .login-button:hover {
            background: #f57c00;
            transform: translateY(-1px);
        }

        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 40px;
            color: #ffffff;
            background: linear-gradient(135deg, #263238 0%, #37474f 50%, #263238 100%);
            background-image: url("{{ asset('images/bgsekolah.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,.6);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 820px;
            text-align: center;
            padding: 80px 0;
        }

        .hero-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid var(--accent);
            object-fit: contain;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255,152,0,.15);
            color: var(--accent);
            border: 1px solid rgba(255,152,0,.3);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            margin: 0 0 12px;
        }

        .hero-subtitle {
            font-size: 16px;
            color: rgba(255,255,255,.75);
            max-width: 600px;
            line-height: 1.6;
            margin: 0 auto 32px;
        }

        .hero-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            padding: 12px 28px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--accent);
            color: #ffffff;
            box-shadow: 0 4px 16px rgba(255,152,0,.4);
        }

        .btn-primary:hover {
            background: #f57c00;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid rgba(255,255,255,.5);
            color: #ffffff;
            font-weight: 600;
        }

        .btn-secondary:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .scroll-indicator {
            margin: 48px auto 0;
            width: 40px;
            height: 40px;
            border: 1px solid rgba(255,255,255,.5);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.08);
            cursor: pointer;
            color: rgba(255,255,255,.8);
            transition: transform 0.2s ease, background 0.2s ease;
            animation: bounce 1.5s infinite;
        }

        .scroll-indicator:hover {
            transform: translateY(-3px);
            background: rgba(255,255,255,.14);
        }

        .scroll-arrow {
            display: block;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-top: 12px solid currentColor;
        }

        .section {
            padding: 80px 40px;
        }

        .section:nth-of-type(even) {
            background: #f5f7fa;
        }

        .section-header {
            max-width: 720px;
            margin: 0 auto 48px;
            text-align: center;
        }

        .section-label {
            display: inline-block;
            color: var(--accent);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 16px;
            color: var(--primary-d);
        }

        .section-description {
            font-size: 14px;
            color: var(--muted);
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            max-width: 960px;
            margin: 0 auto;
        }

        .feature-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px 24px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin: 0 auto 16px;
        }

        .feature-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--primary-d);
            margin-bottom: 8px;
        }

        .feature-text {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            max-width: 980px;
            margin: 0 auto;
        }

        .inventory-stat-group {
            max-width: 980px;
            margin: 0 auto 28px;
        }

        .inventory-stat-group .group-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 700;
            color: var(--primary-d);
            text-transform: uppercase;
            letter-spacing: .05em;
            padding-left: 4px;
        }

        .inventory-stat-group .group-title i {
            color: var(--accent);
            font-size: 13px;
        }

        .inventory-stat-grid {
            display: grid;
            gap: 16px;
        }

        .inventory-stat-grid.three-col {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .inventory-stat-grid.two-col {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .inventory-stat-grid.single-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .stat-card {
            background: linear-gradient(180deg, #ffffff 0%, #f9fbfd 100%);
            border: 1px solid rgba(224, 230, 237, 0.9);
            border-radius: 16px;
            padding: 24px 18px;
            text-align: center;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.04);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
        }

        .stat-card.featured {
            width: min(260px, 100%);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin: 0 auto 12px;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.12);
        }

        .stat-value {
            font-size: clamp(1.7rem, 2vw, 2.2rem);
            font-weight: 800;
            color: var(--primary-d);
            margin-bottom: 6px;
            line-height: 1.1;
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 600;
        }

        .stats-note {
            font-size: 12px;
            color: #7b8a97;
            text-align: center;
            margin-top: 24px;
        }

        .timeline {
            max-width: 640px;
            margin: 0 auto;
        }

        .step {
            display: flex;
            gap: 20px;
            margin-bottom: 32px;
            align-items: flex-start;
        }

        .step-number {
            position: relative;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--accent);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .step-number::after {
            content: '';
            position: absolute;
            top: 48px;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 32px;
            background: var(--border);
        }

        .step:last-child .step-number::after {
            display: none;
        }

        .step-body {
            flex: 1;
        }

        .step-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255,152,0,.1);
            color: var(--accent);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .step-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--primary-d);
            margin: 0 0 6px;
        }

        .step-text {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
            margin: 0;
        }

        .cta-block {
            text-align: center;
            margin-top: 48px;
        }

        .cta-text {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--primary-d);
        }

        .footer {
            background: var(--primary-d);
            padding: 32px 40px;
            color: rgba(255,255,255,.8);
            text-align: center;
        }

        .footer .brand {
            justify-content: center;
            gap: 10px;
        }

        .footer .brand-text .brand-title,
        .footer .brand-text .brand-subtitle {
            color: rgba(255,255,255,.9);
        }

        .footer-divider {
            border-top: 1px solid rgba(255,255,255,.1);
            margin: 16px auto;
            max-width: 720px;
        }

        .footer-text {
            font-size: 12px;
            color: rgba(255,255,255,.4);
            margin: 0;
        }

        .active {
            color: var(--accent) !important;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(8px); }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
            }

            .nav-links {
                display: none;
            }

            .hero {
                padding: 0 20px;
            }

            .hero-content {
                padding: 60px 0;
            }

            .hero-title {
                font-size: 28px;
            }

            .section {
                padding: 60px 20px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .timeline {
                max-width: 100%;
            }

            .step {
                flex-direction: column;
            }

            .step-number {
                margin-bottom: 8px;
            }

            .footer {
                padding: 24px 20px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ route('landing') }}" class="brand">
                <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo Sekolah">
                <div class="brand-text">
                    <span class="brand-title">SMA Negeri 3 Tondano</span>
                    <span class="brand-subtitle">Sistem Informasi Inventaris</span>
                </div>
            </a>
        </div>

        <div class="nav-right">
            <div class="nav-links">
                <a href="#home" class="nav-link">Home</a>
                <a href="#info" class="nav-link">Info</a>
                <a href="#info-barang" class="nav-link">Info Barang</a>
                <a href="#info-peminjaman" class="nav-link">Info Peminjaman</a>
            </div>
            <a href="{{ route('login') }}" class="login-button">Login</a>
        </div>
    </nav>

    <main>
        <section id="home" class="hero">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <img class="hero-logo" src="{{ asset('images/logo-sekolah.png') }}" alt="Logo Sekolah">
                <div class="hero-badge">Sistem Informasi Inventaris</div>
                <h1 class="hero-title">SMA Negeri 3 Tondano</h1>
                <p class="hero-subtitle">Platform digital untuk mengelola inventaris barang SMA Negeri 3 Tondano secara terpusat, akurat, dan efisien.</p>
                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary">Masuk ke Sistem</a>
                    <a href="#info" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
                </div>
                <button type="button" class="scroll-indicator" onclick="document.querySelector('#info').scrollIntoView({ behavior: 'smooth' })" aria-label="Scroll ke Info">
                    <span class="scroll-arrow"></span>
                </button>
            </div>
        </section>

        <section id="info" class="section">
            <div class="section-header">
                <div class="section-label">Tentang Sistem</div>
                <h2 class="section-title">Sistem Informasi Inventaris</h2>
                <p class="section-description">Sistem Informasi Inventaris SMA Negeri 3 Tondano adalah platform digital yang dirancang untuk memudahkan pengelolaan aset dan inventaris barang sekolah secara terpusat, akurat, dan real-time. Sistem ini dibangun menggunakan teknologi berbasis web sehingga dapat diakses kapan saja dan di mana saja melalui browser tanpa perlu instalasi khusus pada setiap perangkat.</p>
                <br>
                <br>
                <p class="section-description">Dengan fitur pencatatan barang, peminjaman, pengembalian, hingga pembuatan laporan dalam format PDF dan Excel, sistem ini hadir sebagai solusi modern untuk menggantikan proses pencatatan manual yang rentan terhadap kesalahan dan kehilangan data. Setiap barang dilengkapi dengan QR Code unik yang memudahkan identifikasi dan pemantauan kondisi barang secara langsung hanya dengan melakukan scan menggunakan kamera perangkat.</p>
            </div>

        </section>

        <section id="info-barang" class="section" style="background: #ffffff;">
            <div class="section-header">
                <div class="section-label">Inventaris</div>
                <h2 class="section-title">Informasi Barang</h2>
                <p class="section-description">Statistik data inventaris barang SMA Negeri 3 Tondano</p>
            </div>

            <div class="inventory-stat-group">
                <div class="group-title"><i class="fas fa-cube"></i> Total Barang</div>
                <div class="inventory-stat-grid single-center" style="display:flex;justify-content:center;">
                    <div class="stat-card featured" style="margin:0 auto;">
                        <div class="stat-icon" style="background:rgba(33,150,243,.1);color:#2196f3;">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="stat-value">{{ $stats['total'] }}</div>
                        <div class="stat-label">Total Barang</div>
                    </div>
                </div>
            </div>

            <div class="inventory-stat-group">
                <div class="group-title"><i class="fas fa-shield-alt"></i> Kondisi Barang</div>
                <div class="inventory-stat-grid three-col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:rgba(76,175,80,.1);color:#4caf50">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-value">{{ $stats['baik'] }}</div>
                        <div class="stat-label">Baik</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:rgba(255,193,7,.1);color:#ffb300">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="stat-value">{{ $stats['rusak_ringan'] }}</div>
                        <div class="stat-label">Rusak Ringan</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:rgba(244,67,54,.1);color:#f44336">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-value">{{ $stats['rusak_berat'] }}</div>
                        <div class="stat-label">Rusak Berat</div>
                    </div>
                </div>
            </div>

            <div class="inventory-stat-group">
                <div class="group-title"><i class="fas fa-boxes"></i> Ketersediaan</div>
                <div class="inventory-stat-grid three-col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:rgba(33,150,243,.1);color:#2196f3">
                            <i class="fas fa-check-square"></i>
                        </div>
                        <div class="stat-value">{{ $stats['tersedia'] }}</div>
                        <div class="stat-label">Tersedia</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:rgba(33,150,243,.1);color:#2196f3">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="stat-value">{{ $stats['dipinjam'] }}</div>
                        <div class="stat-label">Dipinjam</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:rgba(244,67,54,.1);color:#f44336">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div class="stat-value">{{ $stats['hilang'] }}</div>
                        <div class="stat-label">Hilang</div>
                    </div>
                </div>
            </div>

            <div class="inventory-stat-group">
                <div class="group-title"><i class="fas fa-info-circle"></i> Lainnya</div>
                <div class="inventory-stat-grid two-col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:rgba(156,39,176,.1);color:#9c27b0">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-value">{{ $stats['kategori'] }}</div>
                        <div class="stat-label">Kategori Barang</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:rgba(0,150,136,.1);color:#009688">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="stat-value">{{ $stats['lokasi'] }}</div>
                        <div class="stat-label">Lokasi Penyimpanan</div>
                    </div>
                </div>
            </div>

            <p class="stats-note">* Data diperbarui secara real-time dari sistem</p>
        </section>

        <section id="info-peminjaman" class="section">
            <div class="section-header">
                <div class="section-label">Peminjaman</div>
                <h2 class="section-title">Cara Melakukan Peminjaman</h2>
                <p class="section-description">Ikuti langkah-langkah berikut untuk meminjam barang inventaris sekolah</p>
            </div>

            <div class="timeline">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-body">
                        <div class="step-icon"><i class="fas fa-right-to-bracket"></i></div>
                        <h3 class="step-title">Login Sebagai Peminjam</h3>
                        <p class="step-text">Peminjam masuk ke sistem menggunakan akun yang sudah terdaftar untuk mengakses fitur peminjaman.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-body">
                        <div class="step-icon"><i class="fas fa-box-open"></i></div>
                        <h3 class="step-title">Buka Menu Peminjaman dan Pilih Barang</h3>
                        <p class="step-text">Setelah login, peminjam masuk ke menu peminjaman dan memilih barang yang tersedia di lokasi tertentu.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-body">
                        <div class="step-icon"><i class="fas fa-file-signature"></i></div>
                        <h3 class="step-title">Ajukan Pengajuan Peminjaman</h3>
                        <p class="step-text">Peminjam memilih unit barang, menentukan tanggal kembali rencana, dan mengirim pengajuan ke admin.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-body">
                        <div class="step-icon"><i class="fas fa-clock"></i></div>
                        <h3 class="step-title">Tunggu Persetujuan Admin</h3>
                        <p class="step-text">Pengajuan akan berstatus Menunggu sampai admin memeriksa dan menyetujui permintaan peminjaman.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">5</div>
                    <div class="step-body">
                        <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                        <h3 class="step-title">Barang Dipinjam dan Dikembalikan</h3>
                        <p class="step-text">Setelah disetujui, admin mengubah status menjadi Dipinjam. Setelah digunakan, barang harus dikembalikan agar status menjadi Dikembalikan.</p>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <footer class="footer">
        <a href="{{ route('landing') }}" class="brand">
            <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo Sekolah">
            <div class="brand-text">
                <span class="brand-title">SMA Negeri 3 Tondano</span>
                <span class="brand-subtitle">Sistem Informasi Inventaris</span>
            </div>
        </a>
        <div class="footer-divider"></div>
        <p class="footer-text">© {{ date('Y') }} Sistem Informasi Inventaris SMA Negeri 3 Tondano. Hak cipta dilindungi.</p>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href && href.startsWith('#')) {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });

        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(link => link.classList.remove('active'));
                    const activeLink = document.querySelector('.nav-link[href="#' + entry.target.id + '"]');
                    if (activeLink) activeLink.classList.add('active');
                }
            });
        }, { threshold: 0.5 });

        sections.forEach(section => observer.observe(section));

        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(38, 50, 56, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,.2)';
            } else {
                navbar.style.background = 'rgba(38, 50, 56, 0.95)';
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>
