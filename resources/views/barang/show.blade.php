<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang - {{ $barang->nama_barang }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        ::-webkit-scrollbar { display: none; }
        html, body { -ms-overflow-style: none; scrollbar-width: none; }

        :root {
            --primary:    #37474f;
            --primary-d:  #263238;
            --primary-l:  #546e7a;
            --accent:     #ff9800;
            --sidebar-bg: #263238;
            --sidebar-w:  220px;
            --bg:         #f5f7fa;
            --card:       #ffffff;
            --text:       #263238;
            --muted:      #7b8a97;
            --border:     #e0e6ed;
            --success:    #4caf50;
            --danger:     #f44336;
            --warning:     #ff9800;
            --info:       #2196f3;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            color: var(--text);
        }

        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            transform: translateX(0);
            transition: transform 0.28s ease;
        }

        .mobile-topbar {
            display: none;
            align-items: center;
            gap: 14px;
            background: var(--sidebar-bg);
            padding: 12px 14px;
            position: sticky;
            top: 0;
            z-index: 150;
            box-shadow: 0 4px 18px rgba(0,0,0,.15);
        }

        .hamburger-btn {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            color: #fff;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
        }

        .mobile-topbar-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            flex: 1;
        }

        .mobile-topbar-logo img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            border-radius: 50%;
        }

        .mobile-topbar-logo span {
            color: #fff;
            font-size: 12.5px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-close-btn {
            display: none;
            background: none;
            border: none;
            color: rgba(255,255,255,.6);
            cursor: pointer;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: rgba(255,255,255,.06);
            align-items: center;
            justify-content: center;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,.5);
            z-index: 99;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        .sidebar-logo {
            padding: 20px 20px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-logo-img {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: rgba(255,255,255,.12);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff;
            overflow: hidden; flex-shrink: 0;
        }

        .sidebar-logo-img img { width: 85%; height: 85%; object-fit: contain; }

        .sidebar-logo-text { overflow: hidden; }
        .sidebar-logo-text span {
            display: block;
            color: #fff;
            font-size: 11.5px;
            font-weight: 700;
            line-height: 1.3;
        }

        .sidebar-logo-text small {
            display: block;
            color: rgba(255,255,255,.45);
            font-size: 10px;
            margin-top: 1px;
        }

        .sidebar-nav { flex: 1; padding: 16px 0; overflow-y: auto; }

        .nav-label {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255,255,255,.3);
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 10px 20px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: rgba(255,255,255,.6);
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all .18s;
            cursor: pointer;
        }

        .nav-item:hover { background: rgba(255,255,255,.06); color: #fff; }

        .nav-item.active {
            background: rgba(26,79,138,.35);
            color: #fff;
            border-left-color: var(--accent);
        }

        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; opacity: .7; }
        .nav-item.active svg, .nav-item:hover svg { opacity: 1; }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff;
        }

        .user-name { font-size: 12.5px; font-weight: 600; color: #fff; }
        .user-role { font-size: 11px; color: rgba(255,255,255,.4); }

        .btn-logout {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 8px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 8px;
            color: rgba(255,255,255,.6);
            font-family: inherit;
            font-size: 12.5px;
            cursor: pointer;
            transition: all .18s;
            text-decoration: none;
        }

        .btn-logout:hover { background: rgba(220,60,60,.2); color: #fff; border-color: rgba(220,60,60,.3); }

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            padding: 28px 28px 40px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .topbar-title h1 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
        }

        .topbar-title p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 2px;
        }

        .topbar-date {
            font-size: 12.5px;
            color: var(--muted);
            background: var(--card);
            padding: 7px 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 12.5px;
            color: var(--muted);
        }

        .breadcrumb a {
            color: var(--muted);
            text-decoration: none;
        }

        .breadcrumb a:hover { color: var(--text); }

        .breadcrumb-separator {
            margin: 0 4px;
            color: var(--muted);
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-outline {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            background: var(--border);
            transform: translateY(-1px);
        }

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            border: 1px solid rgba(76, 175, 80, 0.18);
            background: rgba(76, 175, 80, 0.1);
            color: #2e7d32;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .field-error {
            margin-top: 8px;
            color: var(--danger);
            font-size: 13px;
        }

        .kondisi-form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .kondisi-select {
            min-width: 180px;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text);
            font-size: 14px;
        }

        .btn-small {
            padding: 10px 16px;
            font-size: 13px;
        }

        .btn-accent {
            background: var(--accent);
            color: white;
        }

        .btn-accent:hover {
            background: #f57c00;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1.3fr minmax(320px, 420px);
            gap: 26px;
            align-items: start;
        }

        .card {
            background: var(--card);
            border-radius: 18px;
            border: 1px solid var(--border);
            padding: 28px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06);
        }

        .card + .card {
            margin-top: 22px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 12px;
        }

        .badge-info {
            background: rgba(33, 150, 243, .1);
            color: #2196f3;
        }

        .badge-danger {
            background: rgba(244, 67, 54, .1);
            color: #f44336;
        }

        .spec-row-image .spec-icon {
            align-self: start;
        }

        .spec-image-box {
            width: 100%;
            max-width: 360px;
            aspect-ratio: 1 / 1;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--border);
            background: #fff;
        }

        .btn-block {
            width: 100%;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-baik { background: rgba(76,175,80,.1); color: #4caf50; }
        .badge-rusak_ringan { background: rgba(255,152,0,.1); color: #ff9800; }
        .badge-rusak_berat { background: rgba(244,67,54,.1); color: #f44336; }

        .spec-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }

        .spec-row:last-child { border-bottom: none; }

        .spec-icon {
            width: 38px; height: 38px;
            border-radius: 8px;
            background: rgba(255,152,0,.08);
            color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .spec-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .spec-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .spec-value {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
        }

        .spec-value.mono {
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }

        .stock-progress {
            margin-top: 8px;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: var(--border);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 6px;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .progress-fill.green { background: var(--success); }
        .progress-fill.blue { background: #2196f3; }
        .progress-fill.red { background: var(--danger); }

        .progress-text {
            font-size: 11px;
            color: var(--muted);
            text-align: center;
        }

        .qr-container {
            text-align: center;
            margin-bottom: 16px;
        }

        .qr-image {
            width: 180px; height: 180px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: white;
            padding: 8px;
            margin: 0 auto 12px;
        }

        .qr-caption {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.4;
        }

        .usage-steps {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .usage-step {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .spec-image {
            width: 100%;
            margin-top: 10px;
        }

        .spec-image-box {
            width: 100%;
            max-width: 380px;
            aspect-ratio: 1 / 1;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border);
            background: #fff;
        }

        .spec-image-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-block {
            width: 43%;
            justify-content: center;
            align-items: center;
        }

        .usage-step {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .step-number {
            width: 20px; height: 20px;
            border-radius: 50%;
            background: var(--accent);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .step-text {
            font-size: 13px;
            color: var(--text);
            line-height: 1.4;
        }

        @media (max-width: 1024px) {
            .content-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 1024px) {
            .content-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            body { display: block; overflow-x: hidden; }
            .mobile-topbar { display: flex; }
            .sidebar { transform: translateX(-100%); width: min(82vw, 280px); box-shadow: 8px 0 30px rgba(0,0,0,.28); }
            .sidebar.active { transform: translateX(0); }
            .sidebar-close-btn { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 32px; }
            .topbar { flex-direction: row; align-items: flex-start; gap: 10px; margin-bottom: 16px; }
            .topbar-date {
                align-self: flex-end;
                width: 25%;
                text-align: center;
            }
            .action-buttons { flex-direction: column; }
            .btn { width: 30%; justify-content: center; }
        }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <main class="main">
        <div class="topbar">
            <div class="topbar-title">
                <h1>Detail Barang</h1>
                <p>Informasi lengkap dan QR Code barang inventaris</p>
            </div>
            <div class="topbar-date">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>

        <div class="breadcrumb">
            <i class="fas fa-home"></i>
            <a href="{{ route('barang.index') }}">Data Barang</a>
            <span class="breadcrumb-separator">›</span>
            <span>{{ $barang->nama_barang }}</span>
        </div>

        <div class="action-buttons">
            <a href="{{ route('barang.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="content-grid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-cube"></i>
                        Spesifikasi Barang
                    </div>
                    <div class="badge badge-{{ $barang->kondisi }}">
                        {{ $barang->kondisi === 'baik' ? 'Baik' : ($barang->kondisi === 'rusak_ringan' ? 'Rusak Ringan' : 'Rusak Berat') }}
                    </div>
                </div>

                @if($barang->foto)
                    <div class="spec-row spec-row-image">
                        <div class="spec-icon"><i class="fas fa-tag"></i></div>
                        <div class="spec-content">
                            <div class="spec-label">Foto Barang</div>
                            <div class="spec-image">
                                <div class="spec-image-box">
                                    <img src="{{ asset('storage/' . $barang->foto) }}"
                                         alt="Foto {{ $barang->nama_barang }}"
                                         class="spec-image-img">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-tag"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Nama Barang</div>
                        <div class="spec-value">{{ $barang->nama_barang }}</div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-folder"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Kategori</div>
                        <div class="spec-value">{{ $barang->kategori->nama ?? 'Tidak tersedia' }}</div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-list-ol"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Nomor Register</div>
                        <div class="spec-value">{{ $barang->nomor_register ?? 'Tidak tersedia' }}</div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-industry"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Merk/Type</div>
                        <div class="spec-value">{{ $barang->merk_type ?? 'Tidak tersedia' }}</div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-box"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Bahan</div>
                        <div class="spec-value">{{ $barang->bahan ?? 'Tidak tersedia' }}</div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-truck-loading"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Asal Usul</div>
                        <div class="spec-value">{{ $barang->asal_usul ?? 'Tidak tersedia' }}</div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Lokasi</div>
                        <div class="spec-value">{{ $barang->lokasi->nama ?? 'Tidak tersedia' }}</div>
                    </div>
                </div>

                @php
                    $statusLabel = match ($barang->status) {
                        'tersedia' => 'Tersedia',
                        'dipinjam' => 'Dipinjam',
                        'hilang' => 'Hilang',
                        default => 'Tidak Diketahui',
                    };

                    $statusProgressClass = match ($barang->status) {
                        'tersedia' => 'green',
                        'dipinjam' => 'blue',
                        'hilang' => 'red',
                        default => 'red',
                    };

                    $statusProgressWidth = match ($barang->status) {
                        'tersedia' => 100,
                        'dipinjam' => 60,
                        'hilang' => 100,
                        default => 0,
                    };

                    $statusProgressText = match ($barang->status) {
                        'tersedia' => 'Unit tersedia untuk dipinjam',
                        'dipinjam' => 'Unit sedang dipinjam',
                        'hilang' => 'Unit dinyatakan hilang',
                        default => 'Status belum tersedia',
                    };
                @endphp

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-cubes"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Ketersediaan</div>
                        <div class="spec-value">{{ $statusLabel }}</div>
                        <div class="stock-progress">
                            <div class="progress-bar">
                                <div class="progress-fill {{ $statusProgressClass }}" style="width: {{ $statusProgressWidth }}%"></div>
                            </div>
                            <div class="progress-text">{{ $statusProgressText }}</div>
                        </div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-shield-alt"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Kondisi</div>
                        @if(auth()->user()->role === 'admin')
                            <form action="{{ route('admin.barang.updateKondisi', $barang->id) }}" method="POST" class="kondisi-form">
                                @csrf
                                @method('PATCH')
                                <select name="kondisi" class="kondisi-select" required>
                                    <option value="baik" {{ $barang->kondisi === 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="rusak_ringan" {{ $barang->kondisi === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="rusak_berat" {{ $barang->kondisi === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                <button type="submit" class="btn btn-accent btn-small">Simpan</button>
                            </form>
                            @error('kondisi')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        @else
                            <div class="spec-value">{{ $barang->kondisi === 'baik' ? 'Baik' : ($barang->kondisi === 'rusak_ringan' ? 'Rusak Ringan' : 'Rusak Berat') }}</div>
                        @endif
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-info-circle"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Status</div>
                        <div class="spec-value">
                            @if($barang->status === 'tersedia')
                                <span class="badge badge-baik">
                                    Tersedia
                                </span>
                            @elseif($barang->status === 'dipinjam')
                                <span class="badge" style="background: rgba(33,150,243,.1); color: #2196f3;">
                                    Dipinjam
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    Hilang
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-barcode"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Kode Barang</div>
                        <div class="spec-value mono">{{ $barang->kode_barang }}</div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-align-left"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Keterangan</div>
                        <div class="spec-value">{{ $barang->deskripsi ?? 'Tidak ada keterangan.' }}</div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-clock"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Ditambahkan</div>
                        <div class="spec-value">{{ $barang->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</div>
                    </div>
                </div>

                <div class="spec-row">
                    <div class="spec-icon"><i class="fas fa-sync"></i></div>
                    <div class="spec-content">
                        <div class="spec-label">Terakhir Diperbarui</div>
                        <div class="spec-value">{{ $barang->updated_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</div>
                    </div>
                </div>
            </div>

            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-qrcode"></i>
                            QR Code Barang
                        </div>
                    </div>

                    <div class="qr-container">
                        <img src="/admin/barang/qrcode/generate?code={{ urlencode($barang->kode_barang) }}" alt="QR Code" class="qr-image">
                        <div class="qr-caption">
                            Scan QR Code ini untuk melihat detail barang secara langsung
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Cara Penggunaan
                        </div>
                    </div>

                    <div class="usage-steps">
                        <div class="usage-step">
                            <div class="step-number">1</div>
                            <div class="step-text">Cetak label QR Code dan tempelkan pada barang fisik</div>
                        </div>
                        <div class="usage-step">
                            <div class="step-number">2</div>
                            <div class="step-text">Buka halaman Scan Barcode di menu sidebar</div>
                        </div>
                        <div class="usage-step">
                            <div class="step-number">3</div>
                            <div class="step-text">Arahkan kamera ke QR Code untuk melihat detail barang</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</body>
</html>
