<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peminjam</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* Hide scrollbar */
        ::-webkit-scrollbar { display: none; }
        html, body { -ms-overflow-style: none; scrollbar-width: none;
        }

        :root {
            --primary:    #37474f;
            --primary-d:  #263238;
            --primary-l:  #546e7a;
            --accent:     #ff9800;
            --sidebar-bg: #263238;
            --sidebar-w:  240px;
            --bg:         #f5f7fa;
            --card:       #ffffff;
            --text:       #263238;
            --muted:      #7b8a97;
            --border:     #e0e6ed;
            --success:    #4caf50;
            --danger:     #f44336;
            --warning:    #ff9800;
            --info:       #2196f3;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
        }

        /* ─── SIDEBAR ─── */
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

        .sidebar-logo-img img {
            width: 85%; height: 85%; object-fit: contain;
        }

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

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
            overflow-y: auto;
        }

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

        .nav-item:hover {
            background: rgba(255,255,255,.06);
            color: #fff;
        }

        .nav-item.active {
            background: rgba(26,79,138,.35);
            color: #fff;
            border-left-color: var(--accent);
        }

        .nav-item svg {
            width: 17px; height: 17px;
            flex-shrink: 0;
            opacity: .7;
        }
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

        .stats-wrapper {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
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
            font-size: 15px;
            margin-bottom: 6px;
        }

        .active-banner {
            background: linear-gradient(135deg, var(--primary-d) 0%, #000000 80%);
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 20px;
            color: #fff;
            box-shadow: 0 4px 20px rgba(26,79,138,.18);
            position: relative;
            overflow: hidden;
        }

        .active-banner::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
        }

        .active-banner h2 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .active-banner p {
            font-size: 13px;
            color: rgba(255,255,255,.75);
            line-height: 1.6;
            max-width: 740px;
        }

        .active-banner ul {
            margin-top: 16px;
            padding-left: 0;
            list-style: none;
            display: grid;
            gap: 10px;
        }

        .active-banner li {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.14);
            border-radius: 12px;
            padding: 14px 16px;
            line-height: 1.5;
        }

        .active-banner li .item-info {
            min-width: 0;
            flex: 1 1 auto;
        }

        .active-banner li strong {
            display: block;
            margin-bottom: 4px;
            font-size: 14px;
            line-height: 1.3;
        }

        .active-banner li .meta {
            font-size: 12px;
            color: rgba(255,255,255,.78);
        }

        .active-banner li .status-badge {
            background: rgba(255,255,255,.16);
            color: #fff;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* TABLE */
        .table-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 8px rgba(26,79,138,.07);
        }

        .table-card table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table-card th,
        .table-card td {
            padding: 14px 26px;
            text-align: left;
            border-bottom: 1px solid #f0f2f6;
            font-size: 13px;
        }

        .table-card thead {
            background: #263238;
        }

        .table-card thead th {
            color: white;
        }

        .table-card th:nth-child(4),
        .table-card td:nth-child(4),
        .table-card th:nth-child(5),
        .table-card td:nth-child(5),
        .table-card th:nth-child(6),
        .table-card td:nth-child(6) {
            white-space: nowrap;
        }

        .table-card tbody tr:hover {
            background: #f8fafc;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 14px;
            background: var(--accent);
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            transition: background .18s, transform .18s;
        }

        .btn:hover {
            background: #e68900;
            transform: translateY(-1px);
        }

        .btn-info { background: var(--info); color: #fff; }
        .btn-success { background: var(--success); color: #fff; }

        .btn-secondary {
            background: var(--primary-l);
        }

        .empty-state {
            padding: 22px 24px;
            color: var(--muted);
        }

        .badge { display: inline-flex; align-items: center; padding: 6px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; color: #fff; }
        .badge-menunggu { background: var(--warning); }
        .badge-disetujui { background: var(--success); }
        .badge-dipinjam { background: var(--info); }
        .badge-dikembalikan { background: #607d8b; }
        .badge-ditolak { background: var(--danger); }
        .badge-danger { background: var(--danger); }
        .badge-warning { background: var(--warning); }
        .badge-success { background: var(--success); }

        .mobile-topbar {
            display: none;
            align-items: center;
            gap: 14px;
            background: var(--sidebar-bg);
            padding: 14px 16px;
            position: sticky;
            top: 0;
            z-index: 150;
        }

        .hamburger-btn {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 8px;
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
        }

        .mobile-topbar-logo img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            border-radius: 50%;
        }

        .mobile-topbar-logo span {
            color: #fff;
            font-size: 13px;
            font-weight: 700;
        }

        .sidebar-close-btn {
            display: none;
            background: none;
            border: none;
            color: rgba(255,255,255,.6);
            cursor: pointer;
            margin-left: auto;
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

        @media (max-width: 768px) {
            body {
                display: block;
            }

            .mobile-topbar {
                display: flex;
                padding: 12px 14px;
                border-bottom: 1px solid rgba(255,255,255,.12);
                box-shadow: 0 4px 18px rgba(0,0,0,.15);
                position: sticky;
                top: 0;
            }

            .hamburger-btn {
                width: 42px;
                height: 42px;
                border-radius: 10px;
                background: rgba(255,255,255,.12);
                box-shadow: inset 0 0 0 1px rgba(255,255,255,.12);
            }

            .mobile-topbar-logo {
                min-width: 0;
                flex: 1;
            }

            .mobile-topbar-logo span {
                font-size: 12.5px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.28s ease;
                z-index: 200;
                width: min(82vw, 280px);
                box-shadow: 8px 0 30px rgba(0,0,0,.28);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-close-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 34px;
                height: 34px;
                border-radius: 8px;
                background: rgba(255,255,255,.06);
            }

            .sidebar-logo {
                align-items: center;
                padding: 16px 16px 14px;
            }

            .sidebar-nav {
                padding: 10px 0 14px;
            }

            .nav-item {
                padding: 11px 16px;
                font-size: 13px;
            }

            .main {
                margin-left: 0;
                padding: 16px 14px 32px;
            }

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

            .table-card {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            }

            .table-card table {
                min-width: 950px;
            }
        }
    </style>
</head>
<body>

<div class="mobile-topbar">
    <button type="button" class="hamburger-btn" id="hamburgerBtn" aria-label="Buka menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="mobile-topbar-logo">
        <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo">
        <span>Sistem Informasi Inventaris</span>
    </div>
</div>

@include('peminjam.layouts.sidebar')

<div class="main">
    <div class="topbar">
        <div class="topbar-title">
            <h1>Dashboard Peminjam</h1>
            <p>Selamat Datang, {{ auth()->user()->name }} — {{ auth()->user()->jabatan }}</p>
        </div>
        <div class="topbar-date">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

    <div class="stats-wrapper">
        <div class="stat-group">
            <div class="stat-group-header">
                <i class="fas fa-chart-simple"></i>
                Statistik Peminjaman
            </div>
            <div class="stat-group-body">
                <div class="stat-item">
                    <div class="stat-item-icon" style="color:#000">
                        <i class="fas fa-chart-simple"></i>
                    </div>
                    <div class="stat-item-value">{{ $total }}</div>
                    <div class="stat-item-label">Total Peminjaman</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-icon" style="color:#cd9300">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-item-value">{{ $totalMenunggu }}</div>
                    <div class="stat-item-label">Menunggu</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-icon" style="color:#38913c">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-item-value">{{ $totalDisetujui }}</div>
                    <div class="stat-item-label">Disetujui</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-icon" style="color:#125cca">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-item-value">{{ $totalDipinjam }}</div>
                    <div class="stat-item-label">Dipinjam</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-icon" style="color:#2a8130">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <div class="stat-item-value">{{ $totalDikembalikan }}</div>
                    <div class="stat-item-label">Dikembalikan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-icon" style="color:#bd2d22">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-item-value">{{ $totalDitolak }}</div>
                    <div class="stat-item-label">Ditolak</div>
                </div>
            </div>
        </div>
    </div>

    @if($active->count())
        <div class="active-banner">
            <h2>Aktifitas Peminjaman</h2>
            <p><strong>Anda memiliki barang yang sedang dipinjam.</strong> Pastikan dikembalikan sebelum tanggal jatuh tempo.</p>
            <ul>
                @foreach($active as $a)
                    <li>
                        <div class="item-info">
                            <strong>{{ $a->nama_barang ?? ($a->barang->nama_barang ?? '-') }}</strong>
                            <div class="meta">
                                {{ $a->jumlah_pinjam }} {{ $a->detail->first()->barang->satuan ?? '-' }}
                                <br> Lokasi : <strong>{{ $a->lokasi->nama ?? 'Lokasi tidak tersedia' }}</strong>
                                <br> Tanggal Rencana Pengembalian : <strong>{{ $a->tanggal_kembali_rencana->format('d-m-Y') }}</strong>
                            </div>
                        </div>
                        <span class="status-badge {{ $a->due_status === 'Terlambat' ? 'badge-danger' : ($a->due_status === 'Segera Kembali' ? 'badge-warning' : 'badge-success') }}">{{ $a->due_status }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 22%;">Nama Barang</th>
                    <th style="width: 7%;">Jumlah</th>
                    <th style="width: 12%;">Tgl Pengajuan</th>
                    <th style="width: 12%;">Tgl Rencana Pinjam</th>
                    <th style="width: 12%;">Tgl Rencana Kembali</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 21%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latest as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $p->nama_barang ?? ($p->barang->nama_barang ?? '-') }}</strong>
                            <div style="margin-top: 4px; color: var(--muted); font-size: 12px;">
                                {{ $p->lokasi->nama ?? 'Lokasi tidak tersedia' }}
                            </div>
                        </td>
                        <td>{{ $p->jumlah_pinjam }}</td>
                        <td><strong>{{ $p->tanggal_pengajuan->format('d-m-Y') }}</strong></td>
                        <td><strong>{{ optional($p->tanggal_pinjam_rencana)->format('d-m-Y') ?? '-' }}</strong></td>
                        <td><strong>{{ $p->tanggal_kembali_rencana->format('d-m-Y') }}</strong></td>
                        <td>
                            @php
                                $statusClass = 'badge-menunggu';
                                switch($p->status) {
                                    case 'Disetujui': $statusClass = 'badge-disetujui'; break;
                                    case 'Dipinjam': $statusClass = 'badge-dipinjam'; break;
                                    case 'Dikembalikan': $statusClass = 'badge-dikembalikan'; break;
                                    case 'Ditolak': $statusClass = 'badge-ditolak'; break;
                                }
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $p->status }}</span>
                        </td>
                        <td>
                            @if($p->status === 'Ditolak')
                                {{ $p->keterangan_penolakan }}
                            @elseif($p->status === 'Dikembalikan')
                                {{ $p->keterangan }}
                            @else
                                {{ $p->keterangan ?? '-' }}
                            @endif
                        </td>
                    </tr>
                                        @if($p->detail->isNotEmpty() && !in_array($p->status, ['Menunggu', 'Ditolak']))
                        <tr>
                            <td></td>
                            <td colspan="7" style="background: #f8fafc; padding: 14px 16px;">
                                <div style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                                    <i class="fas fa-boxes"></i>
                                    Unit yang dipinjam ({{ $p->detail->count() }} unit)
                                </div>
                                <div style="display:flex;flex-direction:column;gap:8px;">
                                    @foreach($p->detail as $i => $detail)
                                        <div class="unit-row-{{ $p->id }} {{ $i > 0 ? 'unit-row-extra' : '' }}" style="display:{{ $i > 0 ? 'none' : 'flex' }};align-items:center;gap:8px;background:#fff;border:1px solid var(--border);border-radius:8px;padding:10px;">
                                            @if($detail->barang && $detail->barang->foto)
                                                <img src="{{ asset('storage/' . $detail->barang->foto) }}"
                                                     alt="Foto Unit"
                                                     style="width:64px;height:64px;object-fit:cover;border-radius:6px;">
                                            @else
                                                <div style="width:64px;height:64px;border-radius:6px;background:#eef3f7;display:flex;align-items:center;justify-content:center;color:var(--muted);">
                                                    <i class="fas fa-image" style="font-size:20px;"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div style="font-size:12px;font-weight:600;color:var(--text);">
                                                    No. Reg: {{ $detail->nomor_register }}
                                                </div>
                                                @if($detail->barang)
                                                    <div style="font-size:11px;color:var(--muted);">
                                                        {{ ucfirst(str_replace('_',' ',$detail->barang->kondisi)) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($p->detail->count() > 1)
                                    <button type="button" onclick="toggleUnitList(this, '{{ $p->id }}')" style="margin-top:8px;background:none;border:none;color:var(--info);font-size:12px;font-weight:600;cursor:pointer;padding:4px 0;">
                                        Lihat {{ $p->detail->count() - 1 }} unit lainnya <i class="fas fa-chevron-down"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">Belum ada aktivitas peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="btn-group">
        <a href="{{ route('peminjam.barang.index') }}" class="btn">+ Ajukan Peminjaman</a>
    </div>
</div>

<script>
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar = document.querySelector('.sidebar');
    const closeBtn = document.getElementById('sidebarCloseBtn');
    const overlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar?.classList.add('active');
        overlay?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar?.classList.remove('active');
        overlay?.classList.remove('active');
        document.body.style.overflow = '';
    }

    function toggleUnitList(btn, id) {
        const extras = document.querySelectorAll('.unit-row-' + id + '.unit-row-extra');
        if (extras.length === 0) return;
        const isHidden = extras[0].style.display === 'none';
        extras.forEach(el => el.style.display = isHidden ? 'flex' : 'none');
        const count = extras.length;
        btn.innerHTML = isHidden
            ? 'Sembunyikan <i class="fas fa-chevron-up"></i>'
            : 'Lihat ' + count + ' unit lainnya <i class="fas fa-chevron-down"></i>';
    }

    hamburgerBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>
</body>
</html>
