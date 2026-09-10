<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
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
            z-index: 100;
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

        .content { flex: 1; overflow-y: auto; }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .content-title h2 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .content-title p {
            font-size: 13px;
            color: var(--muted);
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background: #f57c00;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
            padding: 6px 12px;
            font-size: 11px;
        }

        .btn-danger:hover { background: #e53935; }

        .btn-edit {
            background: #2196f3;
            color: #fff;
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .btn-edit:hover { background: #1976d2; }

        .card {
            background: var(--card);
            border-radius: 8px;
            border: 1px solid var(--border);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Stat cards */
        .stats-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-group {
            background: var(--card);
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 8px rgba(26,79,138,.07);
            overflow: hidden;
            transition: transform .18s, box-shadow .18s;
        }

        .stat-group:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 18px rgba(26,79,138,.12);
        }

        .stat-group-header {
            padding: 12px 18px 10px;
            border-bottom: 1px solid var(--border);
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .06em;
            display: flex;
            align-items: center;
            gap: 7px;
            text-align: center;
            justify-content: center;
        }

        .stat-group-header i {
            color: var(--accent);
            font-size: 12px;
        }

        .stat-group-body {
            padding: 14px 18px 16px;
            display: flex;
            gap: 16px;
        }

        .stat-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .stat-item-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-item-label {
            font-size: 11.5px;
            color: var(--muted);
            font-weight: 500;
        }

        .stat-item-icon {
            font-size: 18px;
            margin-bottom: 6px;
        }

        .stat-divider {
            width: 1px;
            background: var(--border);
            align-self: stretch;
            margin: 4px 0;
        }

        .table-wrapper { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead { background: #263238; border-bottom: 2px solid var(--border); }

        th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #fff;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
        }

        tbody tr:hover { background: #fafbfc; }

        tbody tr:last-child td { border-bottom: none; }

        .action-cell { display: flex; gap: 8px; align-items: center; }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-success { background: rgba(76, 175, 80, 0.1); color: var(--success); }
        .badge-warning { background: rgba(255, 152, 0, 0.1); color: var(--warning); }
        .badge-danger { background: rgba(244, 67, 54, 0.1); color: var(--danger); }
        .badge-info { background: rgba(33, 150, 243, 0.1); color: var(--info); }

        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 200; align-items: flex-start; justify-content: center; overflow-y: auto; padding-top: 24px; padding-bottom: 24px; }
        .modal.active { display: flex; }

        .modal-content {
            background: var(--card);
            border-radius: 12px;
            padding: 28px;
            max-width: 600px;
            width: 90%;
            max-height: calc(100vh - 48px);
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 { font-size: 16px; font-weight: 700; }
        .modal-close { background: none; border: none; font-size: 24px; cursor: pointer; color: var(--muted); transition: color 0.3s ease; }
        .modal-close:hover { color: var(--text); }

        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text);
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
        }

        .form-group textarea { resize: vertical; min-height: 80px; }

        .form-actions { display: flex; flex-direction: row; gap: 10px; justify-content: flex-end; margin-top: 10px; }
        .btn-cancel { background: var(--border); color: var(--text); }
        .btn-cancel:hover { background: #d0d7e0; }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success { background: rgba(76, 175, 80, 0.1); color: var(--success); border-left: 4px solid var(--success); }
        .alert-error { background: rgba(244, 67, 54, 0.1); color: var(--danger); border-left: 4px solid var(--danger); }

        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state-icon { font-size: 48px; color: var(--border); margin-bottom: 16px; }
        .empty-state p { color: var(--muted); font-size: 14px; margin-bottom: 16px; }

        .pagination-wrapper {
            margin-top: 18px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 0;
            margin: 0;
            list-style: none;
            justify-content: center;
        }

        .pagination li {
            display: inline-flex;
        }

        .pagination a,
        .pagination span,
        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            min-height: 38px;
            padding: 0 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text);
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s ease;
        }

        .pagination a:hover,
        .pagination .page-link:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .pagination .active span,
        .pagination .active a {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        .pagination .disabled span,
        .pagination .disabled a {
            color: var(--muted);
            border-color: var(--border);
            background: #f9fafb;
            cursor: default;
        }

        @media (max-width: 1024px) {
            .status-grid { grid-template-columns: repeat(2, minmax(150px, 1fr)); }
        }

        .mobile-topbar { display: none; align-items: center; gap: 14px; background: var(--sidebar-bg); padding: 12px 14px; position: sticky; top: 0; z-index: 150; box-shadow: 0 4px 18px rgba(0,0,0,.15); }
        .hamburger-btn { background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); color: #fff; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }
        .mobile-topbar-logo { display: flex; align-items: center; gap: 8px; min-width: 0; flex: 1; }
        .mobile-topbar-logo img { width: 28px; height: 28px; object-fit: contain; border-radius: 50%; }
        .mobile-topbar-logo span { color: #fff; font-size: 12.5px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-close-btn { display: none; background: none; border: none; color: rgba(255,255,255,.6); cursor: pointer; width: 34px; height: 34px; border-radius: 8px; background: rgba(255,255,255,.06); align-items: center; justify-content: center; }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.5); z-index: 99; opacity: 0; transition: opacity 0.25s ease; }
        .sidebar-overlay.active { display: block; opacity: 1; }

        @media (max-width: 768px) {
            body { display: block; overflow-x: hidden; }
            .mobile-topbar { display: flex; }
            .sidebar { transform: translateX(-100%); transition: transform 0.28s ease; z-index: 200; width: min(82vw, 280px); box-shadow: 8px 0 30px rgba(0,0,0,.28); }
            .sidebar.active { transform: translateX(0); }
            .sidebar-close-btn { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 32px; }
            .topbar {
                flex-direction: row;
                align-items: flex-start;
                gap: 10px;
                margin-bottom: 16px;
            }
            .topbar-date {
                align-self: flex-end;
                width: 25%;
                text-align: center;
            }
            .content-header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .btn {
                width: 100%;
                justify-content: center;
            }

            .btn-cancel, .btn-primary {
                width: auto;
                justify-content: start;
            }

            .stats-wrapper {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            /* Card ke-3 (Ketersediaan) full width */
            .stats-wrapper .stat-group:nth-child(3) {
                grid-column: 1 / -1;
            }

            .stat-group-body {
                flex-wrap: wrap;
                gap: 12px;
            }

            .stat-item {
                flex: 1 1 30%;
                min-width: 80px;
            }

            .stat-divider {
                display: none;
            }
            .modal-content { width: 95%; }
            .table-wrapper { overflow-x: auto; }
            table { min-width: 640px; font-size: 12px; }
            th, td { padding: 8px 10px; }
        }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <main class="main">
        <div class="topbar">
            <div class="topbar-title">
                <h1>Data Barang</h1>
                <p>Kelola semua inventaris barang SMA Negeri 3 Tondano</p>
            </div>
            <div class="topbar-date">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>

        <section class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="stats-wrapper">

                {{-- Informasi Barang --}}
                <div class="stat-group">
                    <div class="stat-group-header">
                        Informasi Barang
                    </div>
                    <div class="stat-group-body">
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:var(--info)">
                                <i class="fas fa-cube"></i>
                            </div>
                            <div class="stat-item-value">{{ $totalBarang }}</div>
                            <div class="stat-item-label">Total Barang</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:#9c27b0">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="stat-item-value">{{ $totalKategori }}</div>
                            <div class="stat-item-label">Kategori Barang</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:#009688">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="stat-item-value">{{ $totalLokasi }}</div>
                            <div class="stat-item-label">Lokasi Barang</div>
                        </div>
                    </div>
                </div>

                {{-- Kondisi Barang --}}
                <div class="stat-group">
                    <div class="stat-group-header">
                        Kondisi Barang
                    </div>
                    <div class="stat-group-body">
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:var(--success)">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-item-value">{{ $totalBaik }}</div>
                            <div class="stat-item-label">Baik</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:var(--warning)">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="stat-item-value">{{ $totalRusakRingan }}</div>
                            <div class="stat-item-label">Rusak Ringan</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:var(--danger)">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="stat-item-value">{{ $totalRusakBerat }}</div>
                            <div class="stat-item-label">Rusak Berat</div>
                        </div>
                    </div>
                </div>

                {{-- Ketersediaan --}}
                <div class="stat-group">
                    <div class="stat-group-header">
                        Ketersediaan
                    </div>
                    <div class="stat-group-body">
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:var(--info)">
                                <i class="fas fa-check-square"></i>
                            </div>
                            <div class="stat-item-value">{{ $totalTersedia }}</div>
                            <div class="stat-item-label">Tersedia</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:var(--info)">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="stat-item-value">{{ $totalDipinjam }}</div>
                            <div class="stat-item-label">Dipinjam</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:var(--danger)">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div class="stat-item-value">{{ $totalHilang }}</div>
                            <div class="stat-item-label">Hilang</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="content-header">
                <div class="content-title">
                    <h2>Daftar Barang</h2>
                    <p>Berikut adalah daftar inventaris barang :</p>
                </div>
                @if(auth()->user()->role === 'admin')
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                        <button type="button" class="btn btn-primary" onclick="openTambahModal()">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </button>
                    </div>
                @endif
            </div>


            <div class="card">
                <div class="card-title">
                    <i class="fas fa-boxes"></i>
                    Data Inventaris Barang
                </div>

                <form method="GET" action="{{ route('barang.index') }}" style="margin-bottom: 18px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 12px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="search">Cari Nama Barang</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama barang...">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="lokasi">Lokasi</label>
                            <select id="lokasi" name="lokasi">
                                <option value="">Semua Lokasi</option>
                                @foreach($lokasi as $item)
                                    <option value="{{ $item->id }}" {{ request('lokasi') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="kategori">Kategori</label>
                            <select id="kategori" name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach($kategori as $item)
                                    <option value="{{ $item->id }}" {{ request('kategori') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="kondisi">Kondisi</label>
                            <select id="kondisi" name="kondisi">
                                <option value="">Semua Kondisi</option>
                                <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak_ringan" {{ request('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak_berat" {{ request('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="status">Status</label>
                            <select id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <a href="{{ route('barang.index') }}" class="btn btn-cancel">
                            <i class="fas fa-rotate-left"></i> Reset
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Terapkan Filter
                        </button>
                    </div>
                </form>

                @if($barang->count() > 0)
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 4%;">No</th>
                                    <th style="width: 12%;">Kode Barang</th>
                                    <th style="width: 16%;">Nama Barang</th>
                                    <th style="width: 16%;">Foto Barang</th>
                                    <th style="width: 10%;">Nomor Register</th>
                                    <th style="width: 12%;">Merk/Type</th>
                                    <th style="width: 10%;">Bahan</th>
                                    <th style="width: 8%;">Tahun</th>
                                    <th style="width: 10%;">Asal Usul</th>
                                    <th style="width: 10%;">Kondisi</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 12%;">Harga (Rp)</th>
                                    <th style="width: 15%;">Keterangan</th>
                                    @if(auth()->user()->role === 'admin')
                                        <th style="width: 10%;">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($barang as $index => $item)
                                    <tr>
                                        <td>{{ $barang->firstItem() + $index }}</td>
                                        <td><strong>{{ $item->kode_barang }}</strong></td>
                                        <td><strong>{{ $item->nama_barang }}</strong></td>
                                        <td>
                                            @if($item->foto)
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Barang" style="max-width: 100px; max-height: 100px;">
                                            @else
                                                <span class="text-muted">Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->nomor_register ?? '-' }}</td>
                                        <td>{{ $item->merk_type ?? '-' }}</td>
                                        <td>{{ $item->bahan ?? '-' }}</td>
                                        <td>{{ $item->tahun_pengadaan ?? '-' }}</td>
                                        <td>{{ $item->asal_usul ?? '-' }}</td>
                                        <td>
                                            @if($item->kondisi === 'baik')
                                                <span class="badge badge-success">Baik</span>
                                            @elseif($item->kondisi === 'rusak_ringan')
                                                <span class="badge badge-warning">Rusak Ringan</span>
                                            @else
                                                <span class="badge badge-danger">Rusak Berat</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status === 'tersedia')
                                                <span class="badge" style="background:rgba(76,175,80,.1);color: var(--success);">Tersedia</span>
                                            @elseif($item->status === 'dipinjam')
                                                <span class="badge" style="background:rgba(33,150,243,.1);color:var(--info);">Dipinjam</span>
                                            @else
                                                <span class="badge" style="background:rgba(244,67,54,.1);color: var(--danger);">Hilang</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->harga ? 'Rp '.number_format($item->harga, 0, ',', '.') : '-' }}</td>
                                        <td>{{ $item->deskripsi ?? '-' }}</td>
                                        @if(auth()->user()->role === 'admin')
                                            <td>
                                                <div class="action-cell">
                                                    <button type="button" class="btn btn-edit" data-foto="{{ $item->foto ?? '' }}" onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->nama_barang) }}', '{{ addslashes($item->kode_barang) }}', '{{ $item->id_kategori }}', '{{ $item->id_lokasi }}', '{{ $item->harga ?? '' }}', '{{ $item->tahun_pengadaan ?? '' }}', '{{ $item->satuan ?? 'unit' }}', '{{ $item->kondisi }}', '{{ $item->status }}', '{{ addslashes($item->deskripsi ?? '') }}', '{{ $item->foto ?? '' }}', '{{ addslashes($item->nomor_register ?? '') }}', '{{ addslashes($item->merk_type ?? '') }}', '{{ addslashes($item->bahan ?? '') }}', '{{ $item->asal_usul ?? '' }}')">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-info" style="background:rgba(33,150,243,.1);color:var(--info);padding:7px 10px;font-size:11px;" onclick="openQRCodeModal('{{ addslashes($item->kode_barcode) }}', '{{ addslashes($item->nama_barang) }}', '{{ addslashes($item->kode_barang) }}')">
                                                        <i class="fas fa-qrcode"></i>
                                                    </button>
                                                    @if($item->status === 'dipinjam')
                                                        <button type="button" class="btn btn-danger" disabled title="Barang sedang dipinjam, tidak bisa dihapus" style="opacity:0.4;cursor:not-allowed;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <form method="POST" action="{{ route('barang.destroy', $item->id) }}" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus unit barang No. Register {{ $item->nomor_register }}?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-wrapper">
                        {{ $barang->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-boxes"></i></div>
                        <p>Belum ada data inventaris barang yang terdaftar.</p>
                        @if(auth()->user()->role === 'admin')
                            <button type="button" class="btn btn-primary" onclick="openTambahModal()">
                                <i class="fas fa-plus"></i> Tambah Barang Pertama
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    </main>

    @if(auth()->user()->role === 'admin')
        <div class="modal" id="tambahBarangModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="fas fa-boxes" style="color: var(--accent); margin-right: 6px;"></i>Tambah Barang Baru</h3>
                    <button type="button" class="modal-close" onclick="closeTambahModal()">×</button>
                </div>

                <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="nama_barang">Nama Barang <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="nama_barang" name="nama_barang" required placeholder="Contoh: Laptop" value="{{ old('nama_barang') }}">
                    </div>

                    <div class="form-group">
                        <label for="id_kategori">Kategori <span style="color: var(--danger);">*</span></label>
                        <select id="id_kategori" name="id_kategori" required onchange="updateKodePreview()">
                            <option value="">Pilih kategori</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->id }}" data-prefix="{{ strtoupper($item->kode_prefix ?? 'XX') }}" {{ old('id_kategori') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        <p id="kodeBarangPreview" style="margin-top:0.5rem;font-size:0.95rem;color:var(--muted);">
                            Pilih kategori untuk melihat contoh kode barang.
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="id_lokasi">Lokasi <span style="color: var(--danger);">*</span></label>
                        <select id="id_lokasi" name="id_lokasi" required>
                            <option value="">Pilih lokasi</option>
                            @foreach($lokasi as $item)
                                <option value="{{ $item->id }}" {{ old('id_lokasi') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah_total">
                            Jumlah/Qty <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="number" id="jumlah_total" name="jumlah_total" min="1" max="999" required placeholder="Contoh: 10" value="{{ old('jumlah_total') }}">
                        <small style="color:var(--muted);font-size:11px;">
                            Setiap unit akan mendapat nomor register tersendiri secara otomatis.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="satuan">Satuan <span style="color: var(--danger);">*</span></label>
                        <select id="satuan" name="satuan" required>
                            <option value="unit" {{ old('satuan', 'unit') == 'unit' ? 'selected' : '' }}>unit</option>
                            <option value="set" {{ old('satuan') == 'set' ? 'selected' : '' }}>set</option>
                            <option value="lusin" {{ old('satuan') == 'lusin' ? 'selected' : '' }}>lusin</option>
                            <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>box</option>
                            <option value="rim" {{ old('satuan') == 'rim' ? 'selected' : '' }}>rim</option>
                            <option value="pak" {{ old('satuan') == 'pak' ? 'selected' : '' }}>pak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga Barang</label>
                        <input type="number" id="harga" name="harga" step="0.01" min="0" placeholder="Contoh: 1500000" value="{{ old('harga') }}">
                    </div>

                    <div class="form-group">
                        <label for="tahun_pengadaan">Tahun Pengadaan</label>
                        <input type="number" id="tahun_pengadaan" name="tahun_pengadaan" min="1900" max="{{ date('Y') }}" placeholder="Contoh: 2011" value="{{ old('tahun_pengadaan') }}">
                    </div>

                    <div class="form-group">
                        <label for="kondisi">Kondisi <span style="color: var(--danger);">*</span></label>
                        <select id="kondisi" name="kondisi" required>
                            <option value="">Pilih kondisi</option>
                            <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="merk_type">Merk / Type</label>
                        <input type="text" id="merk_type" name="merk_type" placeholder="Contoh: Intra" value="{{ old('merk_type') }}">
                    </div>

                    <div class="form-group">
                        <label for="bahan">Bahan</label>
                        <input type="text" id="bahan" name="bahan" placeholder="Contoh: Kayu" value="{{ old('bahan') }}">
                    </div>

                    <div class="form-group">
                        <label for="asal_usul">Asal Usul</label>
                        <select id="asal_usul" name="asal_usul">
                            <option value="">Pilih asal usul</option>
                            <option value="Pembelian" {{ old('asal_usul') == 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
                            <option value="Hibah" {{ old('asal_usul') == 'Hibah' ? 'selected' : '' }}>Hibah</option>
                            <option value="Dropping" {{ old('asal_usul') == 'Dropping' ? 'selected' : '' }}>Dropping</option>
                            <option value="Lainnya" {{ old('asal_usul') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status <span style="color:var(--danger)">*</span></label>
                        <select name="status" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi tambahan (opsional)">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="foto-input">Foto Barang</label>
                        <div id="camera-container" style="display:flex;flex-direction:column;gap:10px;">
                            <video id="camera-preview" style="width:100%;border-radius:8px;background:#000;display:none;"></video>
                            <canvas id="camera-canvas" style="display:none;"></canvas>
                            <img id="foto-preview" style="width:100%;border-radius:8px;object-fit:cover;max-height:200px;display:none;" alt="Preview Foto Barang">
                            <button type="button" id="btn-buka-kamera" style="width:100%;background:rgba(33,150,243,.1);color:#2196f3;border:1px solid rgba(33,150,243,.2);border-radius:6px;font-size:13px;font-weight:600;padding:10px;cursor:pointer;">📷 Buka Kamera</button>
                            <button type="button" id="btn-ambil-foto" style="width:100%;background:var(--accent);color:#fff;border-radius:6px;font-size:13px;font-weight:600;padding:10px;cursor:pointer;display:none;">📸 Ambil Foto</button>
                            <button type="button" id="btn-ulangi-foto" style="width:100%;background:rgba(244,67,54,.1);color:#f44336;border:1px solid rgba(244,67,54,.2);border-radius:6px;font-size:13px;font-weight:600;padding:10px;cursor:pointer;display:none;">🔄 Ulangi Foto</button>
                            <input type="file" id="foto-input" name="foto" accept="image/*" style="display:none;">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-cancel" onclick="closeTambahModal()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal" id="editBarangModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="fas fa-pencil-alt" style="color: var(--info); margin-right: 6px;"></i>Edit Barang</h3>
                    <button type="button" class="modal-close" onclick="closeEditModal()">×</button>
                </div>

                <form method="POST" id="editBarangForm" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="edit_kode_barang">Kode Barang <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="edit_kode_barang" name="kode_barang" readonly style="background:#f5f7fa;cursor:not-allowed;color:var(--muted);" placeholder="Contoh: BRG-001">
                        <small style="color:var(--muted);font-size:11px;">Kode barang tidak dapat diubah.</small>
                    </div>

                    <div class="form-group">
                        <label for="edit_nama_barang">Nama Barang <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="edit_nama_barang" name="nama_barang" required placeholder="Contoh: Laptop">
                    </div>

                    <div class="form-group">
                        <label for="edit_nomor_register">Nomor Register</label>
                        <input type="text" id="edit_nomor_register" name="nomor_register" readonly style="background:#f5f7fa;cursor:not-allowed;color:var(--muted);" placeholder="Contoh: 000257">
                        <small style="color:var(--muted);font-size:11px;">Nomor register tidak dapat diubah.</small>
                    </div>

                    <div class="form-group">
                        <label for="edit_id_kategori">Kategori <span style="color: var(--danger);">*</span></label>
                        <select id="edit_id_kategori" name="id_kategori" required>
                            <option value="">Pilih kategori</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->id }}" data-prefix="{{ strtoupper($item->kode_prefix ?? 'XX') }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_id_lokasi">Lokasi <span style="color: var(--danger);">*</span></label>
                        <select id="edit_id_lokasi" name="id_lokasi" required>
                            <option value="">Pilih lokasi</option>
                            @foreach($lokasi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_satuan">Satuan <span style="color: var(--danger);">*</span></label>
                        <select id="edit_satuan" name="satuan" required>
                            <option value="unit">unit</option>
                            <option value="set">set</option>
                            <option value="lusin">lusin</option>
                            <option value="box">box</option>
                            <option value="rim">rim</option>
                            <option value="pak">pak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_harga">Harga Barang</label>
                        <input type="number" id="edit_harga" name="harga" step="0.01" min="0" placeholder="Contoh: 1500000">
                    </div>

                    <div class="form-group">
                        <label for="edit_tahun_pengadaan">Tahun Pengadaan</label>
                        <input type="number" id="edit_tahun_pengadaan" name="tahun_pengadaan" min="1900" max="{{ date('Y') }}" placeholder="Contoh: 2011">
                    </div>

                    <div class="form-group">
                        <label for="edit_kondisi">Kondisi <span style="color: var(--danger);">*</span></label>
                        <select id="edit_kondisi" name="kondisi" required>
                            <option value="">Pilih kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_merk_type">Merk / Type</label>
                        <input type="text" id="edit_merk_type" name="merk_type" placeholder="Contoh: Intra">
                    </div>

                    <div class="form-group">
                        <label for="edit_bahan">Bahan</label>
                        <input type="text" id="edit_bahan" name="bahan" placeholder="Contoh: Kayu">
                    </div>

                    <div class="form-group">
                        <label for="edit_asal_usul">Asal Usul</label>
                        <select id="edit_asal_usul" name="asal_usul">
                            <option value="">Pilih asal usul</option>
                            <option value="Pembelian">Pembelian</option>
                            <option value="Hibah">Hibah</option>
                            <option value="Dropping">Dropping</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status <span style="color:var(--danger);">*</span></label>
                        <select name="status" id="edit_status" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_deskripsi">Deskripsi</label>
                        <textarea id="edit_deskripsi" name="deskripsi" placeholder="Masukkan deskripsi tambahan (opsional)"></textarea>
                    </div>

                    <div class="form-group" id="current-foto-container" style="display:none;margin-bottom:16px;">
                        <label>Foto saat ini</label>
                        <img id="current-foto-preview" src="" alt="Foto saat ini" style="width:100%;border-radius:8px;max-height:100%;object-fit:cover;">
                        <p style="font-size:11px;color:var(--muted);margin-top:4px;">Foto saat ini. Buka kamera untuk mengganti.</p>
                    </div>

                    <div class="form-group">
                        <label for="foto-input-edit">Foto Barang</label>
                        <div id="camera-container-edit" style="display:flex;flex-direction:column;gap:10px;">
                            <video id="camera-preview-edit" style="width:100%;border-radius:8px;background:#000;display:none;"></video>
                            <canvas id="camera-canvas-edit" style="display:none;"></canvas>
                            <img id="foto-preview-edit" style="width:100%;border-radius:8px;object-fit:cover;max-height:200px;display:none;" alt="Preview Foto Barang">
                            <button type="button" id="btn-buka-kamera-edit" style="width:100%;background:rgba(33,150,243,.1);color:#2196f3;border:1px solid rgba(33,150,243,.2);border-radius:6px;font-size:13px;font-weight:600;padding:10px;cursor:pointer;">📷 Buka Kamera</button>
                            <button type="button" id="btn-ambil-foto-edit" style="width:100%;background:var(--accent);color:#fff;border-radius:6px;font-size:13px;font-weight:600;padding:10px;cursor:pointer;display:none;">📸 Ambil Foto</button>
                            <button type="button" id="btn-ulangi-foto-edit" style="width:100%;background:rgba(244,67,54,.1);color:#f44336;border:1px solid rgba(244,67,54,.2);border-radius:6px;font-size:13px;font-weight:600;padding:10px;cursor:pointer;display:none;">🔄 Ulangi Foto</button>
                            <input type="file" id="foto-input-edit" name="foto" accept="image/*" style="display:none;">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-cancel" onclick="closeEditModal()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal" id="qrcodeModal">
            <div class="modal-content" style="max-width: 500px;">
                <div class="modal-header">
                    <h3><i class="fas fa-qrcode" style="color: var(--info); margin-right: 6px;"></i>QR Code Barang</h3>
                    <button type="button" class="modal-close" onclick="closeQRCodeModal()">×</button>
                </div>
                <div style="text-align: center; padding: 20px;">
                    <p id="qrcodeBarangNama" style="font-weight: 600; margin-bottom: 16px; color: var(--text);"></p>
                    <div id="qrcodeContainer" style="background: white; padding: 20px; border: 1px solid var(--border); border-radius: 8px; display: inline-block;">
                        <img id="qrcodeImage" src="" alt="QR Code" style="width: 300px; height: 300px; max-width: 100%;">
                    </div>
                    <p style="font-size: 12px; color: var(--muted); margin-top: 16px;">
                        Scan QR code ini untuk melihat detail barang
                    </p>
                </div>
                <div class="form-actions">
                    <button id="printQRBtn" class="btn btn-success" style="margin-top:5px; width: 31%;" onclick="printQRCode()">
                        <i class="fas fa-print"></i> Cetak QR Code
                    </button>
                </div>
            </div>
        </div>
    @endif

    <script>
        function openTambahModal() {
            document.getElementById('tambahBarangModal').classList.add('active');
            updateKodePreview();
        }

        function updateKodePreview() {
            const kategoriSelect = document.getElementById('id_kategori');
            const preview = document.getElementById('kodeBarangPreview');
            if (!kategoriSelect || !preview) {
                return;
            }

            const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];
            const prefix = selectedOption?.dataset?.prefix || 'XX';
            if (!kategoriSelect.value) {
                preview.innerHTML = 'Pilih kategori untuk melihat contoh kode barang.';
                return;
            }

            const sample = prefix + '001';
            preview.innerHTML = 'Contoh kode: <strong>' + sample + '</strong>';
        }

        function closeTambahModal() {
            document.getElementById('tambahBarangModal').classList.remove('active');
            stopCamera();
        }

        function openEditModal(
            id, nama, kode, kategoriId, lokasiId,
            harga, tahunPengadaan, satuan, kondisi,
            status, deskripsi, foto, nomorRegister,
            merkType, bahan, asalUsul
        ) {
            document.getElementById('edit_kode_barang').value = kode;
            document.getElementById('edit_nama_barang').value = nama;
            document.getElementById('edit_id_kategori').value = kategoriId;
            document.getElementById('edit_id_lokasi').value = lokasiId;
            document.getElementById('edit_satuan').value = satuan || 'unit';
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_tahun_pengadaan').value = tahunPengadaan ?? '';
            document.getElementById('edit_kondisi').value = kondisi;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_nomor_register').value = nomorRegister ?? '';
            document.getElementById('edit_merk_type').value = merkType ?? '';
            document.getElementById('edit_bahan').value = bahan ?? '';
            document.getElementById('edit_asal_usul').value = asalUsul ?? '';
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('editBarangForm').action = '/barang/' + id;

            const currentFotoContainer = document.getElementById('current-foto-container');
            const currentFotoPreview = document.getElementById('current-foto-preview');
            if (foto) {
                currentFotoPreview.src = '{{ asset("storage") }}' + '/' + foto;
                currentFotoContainer.style.display = 'block';
            } else {
                currentFotoPreview.src = '';
                currentFotoContainer.style.display = 'none';
            }

            document.getElementById('foto-preview-edit').style.display = 'none';
            document.getElementById('camera-preview-edit').style.display = 'none';
            document.getElementById('btn-buka-kamera-edit').style.display = 'block';
            document.getElementById('btn-ambil-foto-edit').style.display = 'none';
            document.getElementById('btn-ulangi-foto-edit').style.display = 'none';
            document.getElementById('foto-input-edit').value = '';

            document.getElementById('editBarangModal').classList.add('active');
        }

        let cameraStream = null;
        let editCameraStream = null;

        function closeEditModal() {
            document.getElementById('editBarangModal').classList.remove('active');
            stopCameraEdit();
        }

        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function(stream) {
                cameraStream = stream;
                const video = document.getElementById('camera-preview');
                video.srcObject = stream;
                video.play();
                video.style.display = 'block';
                document.getElementById('foto-preview').style.display = 'none';
                document.getElementById('btn-buka-kamera').style.display = 'none';
                document.getElementById('btn-ambil-foto').style.display = 'block';
                document.getElementById('btn-ulangi-foto').style.display = 'none';
            })
            .catch(function(err) {
                alert('Tidak dapat mengakses kamera: ' + err.message);
            });
        }

        function stopCamera() {
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }
        }

        function ambilFoto() {
            const video = document.getElementById('camera-preview');
            const canvas = document.getElementById('camera-canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            stopCamera();
            video.style.display = 'none';

            const imgPreview = document.getElementById('foto-preview');
            imgPreview.src = canvas.toDataURL('image/jpeg');
            imgPreview.style.display = 'block';

            canvas.toBlob(function(blob) {
                const file = new File([blob], 'foto-barang.jpg', { type: 'image/jpeg' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('foto-input').files = dataTransfer.files;
            }, 'image/jpeg', 0.85);

            document.getElementById('btn-ambil-foto').style.display = 'none';
            document.getElementById('btn-ulangi-foto').style.display = 'block';
            document.getElementById('btn-buka-kamera').style.display = 'none';
        }

        function ulangiFoto() {
            document.getElementById('foto-preview').style.display = 'none';
            document.getElementById('foto-input').value = '';
            document.getElementById('btn-ulangi-foto').style.display = 'none';
            document.getElementById('btn-buka-kamera').style.display = 'block';
            startCamera();
        }

        function startCameraEdit() {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function(stream) {
                editCameraStream = stream;
                const video = document.getElementById('camera-preview-edit');
                video.srcObject = stream;
                video.play();
                video.style.display = 'block';
                document.getElementById('current-foto-container').style.display = 'none';
                document.getElementById('foto-preview-edit').style.display = 'none';
                document.getElementById('btn-buka-kamera-edit').style.display = 'none';
                document.getElementById('btn-ambil-foto-edit').style.display = 'block';
                document.getElementById('btn-ulangi-foto-edit').style.display = 'none';
            })
            .catch(function(err) {
                alert('Tidak dapat mengakses kamera: ' + err.message);
            });
        }

        function stopCameraEdit() {
            if (editCameraStream) {
                editCameraStream.getTracks().forEach(track => track.stop());
                editCameraStream = null;
            }
        }

        function ambilFotoEdit() {
            const video = document.getElementById('camera-preview-edit');
            const canvas = document.getElementById('camera-canvas-edit');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            stopCameraEdit();
            video.style.display = 'none';

            const imgPreview = document.getElementById('foto-preview-edit');
            imgPreview.src = canvas.toDataURL('image/jpeg');
            imgPreview.style.display = 'block';

            canvas.toBlob(function(blob) {
                const file = new File([blob], 'foto-barang.jpg', { type: 'image/jpeg' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('foto-input-edit').files = dataTransfer.files;
            }, 'image/jpeg', 0.85);

            document.getElementById('btn-ambil-foto-edit').style.display = 'none';
            document.getElementById('btn-ulangi-foto-edit').style.display = 'block';
            document.getElementById('btn-buka-kamera-edit').style.display = 'none';
        }

        function ulangiFotoEdit() {
            document.getElementById('foto-preview-edit').style.display = 'none';
            document.getElementById('foto-input-edit').value = '';
            document.getElementById('btn-ulangi-foto-edit').style.display = 'none';
            document.getElementById('btn-buka-kamera-edit').style.display = 'block';
            startCameraEdit();
        }

        function openQRCodeModal(kodeBarcode, namaBarang, kodeBarang) {
            document.getElementById('qrcodeBarangNama').textContent = namaBarang;
            const qrcodeImage = document.getElementById('qrcodeImage');
            const qrcodeUrl = '/admin/barang/qrcode/generate?code=' + encodeURIComponent(kodeBarcode);

            qrcodeImage.src = qrcodeUrl;
            qrcodeImage.onerror = function() {
                alert('Gagal memuat QR Code');
            };

            const printBtn = document.getElementById('printQRBtn');
            printBtn.onclick = function () {
                // Sekarang pakai kodeBarang (dari kode_barang)
                // bukan kodeBarcode (dari kode_barcode)
                printQRCode(qrcodeUrl, namaBarang, kodeBarang);
            };

            document.getElementById('qrcodeModal').classList.add('active');
        }

        function closeQRCodeModal() {
            document.getElementById('qrcodeModal').classList.remove('active');
        }

        function printQRCode(qrUrl, namaBarang, kodeBarang) {

        const win = window.open('', '_blank');

        win.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>QR Code - ${namaBarang}</title>
                <style>
                    * {
                        box-sizing: border-box;
                        margin: 0;
                        padding: 0;
                    }

                    body {
                        font-family: Arial, sans-serif;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        background: #f5f5f5;
                    }

                    .label-card {
                        background: #fff;
                        border: 2px solid #263238;
                        border-radius: 8px;
                        padding: 16px 20px;
                        text-align: center;
                        width: 200px;
                        box-shadow: 0 2px 8px rgba(0,0,0,.1);
                    }

                    .label-header {
                        border-bottom: 1px solid #263238;
                        padding-bottom: 8px;
                        margin-bottom: 12px;
                    }

                    .label-brand {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 7px;
                    }

                    .label-logo {
                        width: 30px;
                        height: 30px;
                        object-fit: contain;
                        flex-shrink: 0;
                    }

                    .label-brand-text {
                        text-align: left;
                    }

                    h1 {
                        font-size: 9px;
                        font-weight: 700;
                        color: #263238;
                        margin-bottom: 2px;
                    }

                    h2 {
                        font-size: 8px;
                        font-weight: 400;
                        color: #546e7a;
                    }

                    .qr-wrapper {
                        border: 1px solid #e0e0e0;
                        border-radius: 6px;
                        padding: 8px;
                        display: inline-block;
                        margin-bottom: 10px;
                        background: #fff;
                    }

                    img {
                        width: 100px;
                        height: 100px;
                        display: block;
                    }

                    .label-footer {
                        border-top: 1px solid #263238;
                        padding-top: 8px;
                        margin-top: 4px;
                    }

                    h3 {
                        font-size: 11px;
                        font-weight: 700;
                        color: #263238;
                        margin-bottom: 4px;
                    }

                    p {
                        font-size: 9px;
                        color: #546e7a;
                        letter-spacing: .04em;
                    }

                    @media print {
                        body {
                            background: #fff;
                            min-height: auto;
                        }
                        .label-card {
                            box-shadow: none;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="label-card">
                    <div class="label-header">
                        <div class="label-brand">
                            <img class="label-logo" src="{{ asset('images/logo-sekolah.png') }}" alt="Logo sekolah">
                            <div class="label-brand-text">
                                <h1>SMA NEGERI 3 TONDANO</h1>
                                <h2>Sistem Informasi Inventaris</h2>
                            </div>
                        </div>
                    </div>

                    <div class="qr-wrapper">
                        <img src="${qrUrl}"
                            alt="QR Code ${namaBarang}">
                    </div>

                    <div class="label-footer">
                        <h3>${namaBarang}</h3>
                        <p>${kodeBarang}</p>
                    </div>
                </div>
            </body>
            </html>
        `);

        win.document.close();

        win.onload = function () {
            win.focus();
            win.print();
            win.close();
        };
    }

        document.getElementById('qrcodeModal').addEventListener('click', function(e) {
            if (e.target.id === 'qrcodeModal') closeQRCodeModal();
        });

        document.getElementById('tambahBarangModal').addEventListener('click', function(e) {
            if (e.target.id === 'tambahBarangModal') {
                stopCamera();
                closeTambahModal();
            }
        });

        document.getElementById('editBarangModal').addEventListener('click', function(e) {
            if (e.target.id === 'editBarangModal') closeEditModal();
        });

        document.getElementById('btn-buka-kamera')?.addEventListener('click', startCamera);
        document.getElementById('btn-ambil-foto')?.addEventListener('click', ambilFoto);
        document.getElementById('btn-ulangi-foto')?.addEventListener('click', ulangiFoto);
        document.getElementById('btn-buka-kamera-edit')?.addEventListener('click', startCameraEdit);
        document.getElementById('btn-ambil-foto-edit')?.addEventListener('click', ambilFotoEdit);
        document.getElementById('btn-ulangi-foto-edit')?.addEventListener('click', ulangiFotoEdit);

        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                // Setelah fade selesai, hilangkan space
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500); // 500ms = durasi transition
            }, 5000);
        });
    </script>
</body>
</html>
