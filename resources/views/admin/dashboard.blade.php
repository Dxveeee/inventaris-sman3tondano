<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* Hilangkan scrollbar */
        ::-webkit-scrollbar {
            display: none;
        }
        html, body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

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
            --warning:    #ff9800;
            --info:       #2196f3;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
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

        /* ─── MAIN ─── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            padding: 28px 28px 40px;
            min-height: 100vh;
        }

        /* Topbar */
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

        /* Welcome banner */
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary) 0%, #000000 60%, #000000 100%);
            border-radius: 14px;
            padding: 20px 28px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(26,79,138,.25);
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -30px; right: 120px;
            width: 120px; height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }

        .welcome-text h2 {
            font-size: 17px;
            font-weight: 700;
            color: #fff;
        }

        .welcome-text p {
            font-size: 13px;
            color: rgba(255,255,255,.7);
            margin-top: 4px;
        }

        .welcome-badge {
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 8px;
            padding: 8px 16px;
            color: #fff;
            font-size: 12.5px;
            font-weight: 600;
            z-index: 1;
            white-space: nowrap;
        }

        /* Charts row */
        .charts-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(240px, 1fr));
            gap: 18px;
            align-items: start;
        }

        @media (max-width: 1200px) {
            .charts-row {
                grid-template-columns: repeat(2, minmax(240px, 1fr));
            }
        }

        @media (max-width: 900px) {
            .charts-row {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            background: var(--card);
            border-radius: 14px;
            padding: 20px 22px;
            box-shadow: 0 1px 8px rgba(26,79,138,.07);
            border: 1px solid var(--border);
        }

        .chart-card--hero {
            grid-column: span 2;
            border-left: 3px solid var(--accent);
        }

        .chart-card--popular {
            display: flex;
            flex-direction: column;
            align-self: stretch;
        }

        .chart-card--popular .chart-wrap {
            flex: 1;
            min-height: 320px;
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .chart-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .chart-sub {
            font-size: 11.5px;
            color: var(--muted);
            margin-top: 2px;
        }

        .chart-badge {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--primary);
            background: #e6f0fb;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .chart-wrap {
            position: relative;
        }

        .donut-center {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }

        .donut-center .dc-val {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            line-height: 1;
        }

        .donut-center .dc-lbl {
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px;
        }

        .donut-legend {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 16px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12.5px;
        }

        .legend-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-right: 8px;
        }

        .legend-label {
            display: flex;
            align-items: center;
            color: var(--muted);
            flex: 1;
        }

        .legend-val {
            font-weight: 700;
            color: var(--text);
        }

        /* ─── MOBILE TOPBAR (Hamburger) ─── */
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

        /* Tombol close di dalam sidebar (hanya tampil mobile) */
        .sidebar-close-btn {
            display: none;
            background: none;
            border: none;
            color: rgba(255,255,255,.6);
            cursor: pointer;
            margin-left: auto;
        }

        /* Overlay gelap di belakang sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
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
                overflow-x: hidden;
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

            .topbar-title h1 {
                font-size: 18px;
            }

            .topbar-title p {
                font-size: 12px;
            }

            .topbar-date {
                align-self: flex-end;
                width: 25%;
                text-align: center;
            }

            .welcome-banner {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 18px 18px;
                flex-wrap: wrap;
            }

            .welcome-text {
                flex: 1;
                min-width: 0;
            }

            .welcome-text h2 {
                font-size: 16px;
            }

            .welcome-text p {
                font-size: 12px;
            }

            .welcome-badge {
                flex-shrink: 0;
                align-self: center;
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

            .stat-item-value {
                font-size: 22px;
            }

            .charts-row {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }

            /* Bar Chart - urutan 1, full width di bawah */
            .charts-row .chart-card:nth-child(2) {
                order: 1;
                grid-column: 1 / -1;
            }

            /* Pie Chart - urutan 2, kolom kiri */
            .charts-row .chart-card:nth-child(1) {
                order: 2;
            }

            /* Donut Chart - urutan 3, kolom kanan */
            .charts-row .chart-card:nth-child(3) {
                order: 3;
            }

            .chart-card {
                padding: 16px 18px;
            }

            .chart-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .chart-wrap {
                height: auto !important;
            }

            #barangPerKategoriChart {
                max-height: 280px;
            }

            .chart-wrap[style*="335px"] {
                max-width: 100% !important;
            }

            #pieChartJenis {
                width: 220px !important;
                height: 220px !important;
            }
        }

        @media (max-width: 480px) {
            .stat-item {
                flex: 1 1 100%;
            }

            .stat-group-body {
                flex-direction: column;
            }
        }


    </style>
</head>
<body>

<!-- ─── SIDEBAR ─── -->
@include('layouts.sidebar')

<!-- ─── MAIN CONTENT ─── -->
<main class="main">

    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-title">
            <h1>Dashboard</h1>
            <p>Ringkasan data inventaris SMA Negeri 3 Tondano</p>
        </div>
        <div class="topbar-date">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-text">
            <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
            <p>
                {{ auth()->user()->role === 'kepala_sekolah' ? 'Panel Kepala Sekolah' : 'Panel Admin' }}
            </p>
        </div>
        <div class="welcome-badge">
            {{ auth()->user()->role === 'kepala_sekolah' ? 'Kepala Sekolah' : 'Administrator' }}
        </div>
    </div>

    <div class="stats-wrapper">

    {{-- Informasi Barang --}}
    <div class="stat-group">
        <div class="stat-group-header">
            <i class="fas fa-boxes"></i>
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
            <i class="fas fa-shield-alt"></i>
            Kondisi Barang
        </div>
        <div class="stat-group-body">
            <div class="stat-item">
                <div class="stat-item-icon" style="color:var(--success)">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-item-value">{{ $kondisiBaik }}</div>
                <div class="stat-item-label">Baik</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-item-icon" style="color:var(--warning)">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="stat-item-value">{{ $rusakRingan }}</div>
                <div class="stat-item-label">Rusak Ringan</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-item-icon" style="color:var(--danger)">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-item-value">{{ $rusakBerat }}</div>
                <div class="stat-item-label">Rusak Berat</div>
            </div>
        </div>
    </div>

    {{-- Ketersediaan --}}
    <div class="stat-group">
        <div class="stat-group-header">
            <i class="fas fa-clipboard-list"></i>
            Ketersediaan
        </div>
        <div class="stat-group-body">
            <div class="stat-item">
                <div class="stat-item-icon" style="color:var(--info)">
                    <i class="fas fa-check-square"></i>
                </div>
                <div class="stat-item-value">{{ $tersedia }}</div>
                <div class="stat-item-label">Tersedia</div>
            </div>
            <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-item-icon" style="color:var(--info)">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div class="stat-item-value">{{ $dipinjam }}</div>
                    <div class="stat-item-label">Dipinjam</div>
                </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-item-icon" style="color:var(--danger)">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="stat-item-value">{{ $hilang }}</div>
                <div class="stat-item-label">Hilang</div>
            </div>
        </div>
    </div>
</div>


    <!-- Charts -->
    <div class="charts-row">

        <!-- Bar Chart -->
        <div class="chart-card chart-card--hero">
            <div class="chart-header">
                <div>
                    <div class="chart-title">Barang per Kategori</div>
                    <div class="chart-sub">Distribusi jumlah barang berdasarkan kategori</div>
                </div>
                <span class="chart-badge">Tahun ini</span>
            </div>
            <div class="chart-wrap" style="height:413px">
                @if($barangPerKategori->isEmpty())
                    <div style="text-align:center;padding:60px 20px">
                        <div style="font-size:40px;margin-bottom:12px"></div>
                        <div style="color:var(--muted);font-size:13px">
                            Belum ada data barang per kategori
                        </div>
                    </div>
                @else
                    <canvas id="barangPerKategoriChart"></canvas>
                @endif
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <div class="chart-title">Kondisi Barang</div>
                    <div class="chart-sub">Persentase kondisi seluruh barang</div>
                </div>
            </div>
            <div class="chart-wrap" style="position:relative;max-width:335px;margin:0 auto;">
                <canvas id="donutChart" height="220"></canvas>
                <div class="donut-center">
                    <div class="dc-val">{{ $totalBarang }}</div>
                    <div class="dc-lbl">Total</div>
                </div>
            </div>
            <div class="donut-legend">
                <div class="legend-item">
                    <div class="legend-label"><div class="legend-dot" style="background:#22a06b"></div> Baik</div>
                    <div class="legend-val">{{ $kondisiBaik }}</div>
                </div>
                <div class="legend-item">
                    <div class="legend-label"><div class="legend-dot" style="background:#e8a020"></div> Rusak Ringan</div>
                    <div class="legend-val">{{ $rusakRingan }}</div>
                </div>
                <div class="legend-item">
                    <div class="legend-label"><div class="legend-dot" style="background:#e05252"></div> Rusak Berat</div>
                    <div class="legend-val">{{ $rusakBerat }}</div>
                </div>
            </div>
        </div>

        {{-- Pie Chart Per Jenis Barang --}}
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <div class="chart-title">
                        Distribusi Jenis Barang
                    </div>
                    <div class="chart-sub">
                        Persentase jumlah unit per jenis barang
                    </div>
                </div>
                <span class="chart-badge">
                    Total: {{ $barangPerJenis->sum('total') }} unit
                </span>
            </div>

            @if($barangPerJenis->isEmpty())
                <div style="text-align:center;padding:40px 20px;">
                    <div style="font-size:40px;margin-bottom:12px;">
                        📦
                    </div>
                    <div style="color:var(--muted);font-size:13px;">
                        Belum ada data barang
                    </div>
                </div>
            @else
                <div style="display:flex;align-items:center;
                            gap:24px;flex-wrap:wrap;
                            padding:12px 0;">

                    {{-- Pie Chart --}}
                    <div style="width:220px;height:220px;
                                flex-shrink:0;margin:0 auto;">
                        <canvas id="pieChartJenis"
                            width="220" height="220">
                        </canvas>
                    </div>

                    {{-- Legend --}}
                    <div style="flex:1;min-width:200px;">
                        @php
                            $colors = [
                                '#2196f3','#4caf50','#ff9800',
                                '#e91e63','#9c27b0','#00bcd4',
                                '#ff5722','#607d8b','#795548',
                                '#009688',
                            ];
                            $totalUnit = $barangPerJenis->sum('total');
                        @endphp

                        @foreach($barangPerJenis as $i => $item)
                            @php
                                $color = $colors[$i % count($colors)];
                                $pct = $totalUnit > 0
                                    ? round(($item->total / $totalUnit) * 100)
                                    : 0;
                            @endphp
                            <div style="display:flex;
                                        align-items:center;
                                        justify-content:space-between;
                                        margin-bottom:10px;">
                                <div style="display:flex;
                                            align-items:center;
                                            gap:8px;">
                                    <div style="width:10px;height:10px;
                                                border-radius:50%;
                                                background:{{ $color }};
                                                flex-shrink:0;">
                                    </div>
                                    <span style="font-size:12.5px;">
                                        {{ $item->nama_barang }}
                                    </span>
                                </div>
                                <div style="text-align:right;
                                            margin-left:12px;">
                                    <span style="font-weight:700;
                                                font-size:13px;">
                                        {{ $item->total }}
                                    </span>
                                    <span style="font-size:11px;
                                                color:var(--muted);
                                                margin-left:4px;">
                                        ({{ $pct }}%)
                                    </span>
                                </div>
                            </div>
                        @endforeach

                        {{-- Total --}}
                        <div style="border-top:1px solid var(--border);
                                    padding-top:10px;margin-top:6px;
                                    display:flex;
                                    justify-content:space-between;">
                            <span style="font-size:12px;
                                        color:var(--muted);">
                                Total
                            </span>
                            <span style="font-weight:700;font-size:13px;">
                                {{ $totalUnit }} unit
                            </span>
                        </div>
                    </div>

                </div>
            @endif
        </div>

        <div class="chart-card chart-card--popular">
            <div class="chart-header">
                <div>
                    <div class="chart-title">Barang Paling Sering Dipinjam</div>
                    <div class="chart-sub">Top 5 unit barang berdasarkan jumlah peminjaman</div>
                </div>
            </div>
            <div class="chart-wrap">
                @if($barangTerpopuler->isEmpty())
                    <div style="text-align:center;padding:60px 20px">
                        <div style="color:var(--muted);font-size:13px">
                            Belum ada data peminjaman
                        </div>
                    </div>
                @else
                    <canvas id="barangTerpopulerChart"></canvas>
                @endif
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <div class="chart-title">Peminjam Berdasarkan Peran</div>
                    <div class="chart-sub">Persentase peminjaman: Guru vs Siswa</div>
                </div>
            </div>
            <div class="chart-wrap" style="position:relative;max-width:335px;margin:0 auto;">
                <canvas id="donutPeranChart" height="220"></canvas>
                <div class="donut-center">
                    <div class="dc-val">{{ $totalPeminjamRole }}</div>
                    <div class="dc-lbl">Total</div>
                </div>
            </div>
            <div class="donut-legend">
                <div class="legend-item">
                    <div class="legend-label"><div class="legend-dot" style="background:#3b6dc9"></div> Guru</div>
                    <div class="legend-val">{{ $persenGuru }}%</div>
                </div>
                <div class="legend-item">
                    <div class="legend-label"><div class="legend-dot" style="background:#f0a942"></div> Siswa</div>
                    <div class="legend-val">{{ $persenSiswa }}%</div>
                </div>
            </div>
        </div>

    </div>

</main>

<script>

    // Pie Chart - Per Jenis Barang
    @if(!$barangPerJenis->isEmpty())
    const pieColors = [
        '#2196f3','#4caf50','#ff9800',
        '#e91e63','#9c27b0','#00bcd4',
        '#ff5722','#607d8b','#795548',
        '#009688',
    ];

    const pieCtx = document.getElementById(
        'pieChartJenis'
    );

    if (pieCtx) {
        new Chart(pieCtx.getContext('2d'), {
            type: 'pie',
            data: {
                labels: {!! json_encode(
                    $barangPerJenis->pluck('nama_barang')
                ) !!},
                datasets: [{
                    data: {!! json_encode(
                        $barangPerJenis->pluck('total')
                    ) !!},
                    backgroundColor: pieColors.slice(
                        0, {{ $barangPerJenis->count() }}
                    ),
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context
                                    .dataset.data
                                    .reduce((a,b) => a+b, 0);
                                const value = context.parsed;
                                const pct = total > 0
                                    ? Math.round(
                                        (value/total)*100
                                      )
                                    : 0;
                                return context.label +
                                    ': ' + value +
                                    ' unit (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });
    }
    @endif

    // Bar Chart
    @if(!$barangPerKategori->isEmpty())
    const barCtx = document.getElementById('barangPerKategoriChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($barangPerKategori->pluck('nama')) !!},
            datasets: [{
                label: 'Jumlah Barang',
                data: {!! json_encode($barangPerKategori->pluck('jumlah')) !!},
                backgroundColor: 'rgba(33,150,243,0.8)',
                borderColor: '#2196f3',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' barang';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        font: { family: 'Plus Jakarta Sans', size: 11 },
                        color: '#6b7f94'
                    },
                    grid: { color: 'rgba(0,0,0,.05)' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#6b7f94' }
                }
            }
        }
    });
    @endif

    @if(!$barangTerpopuler->isEmpty())
    const barTerpopulerCtx = document.getElementById('barangTerpopulerChart').getContext('2d');
    new Chart(barTerpopulerCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($barangTerpopuler->pluck('nama')) !!},
            datasets: [{
                label: 'Jumlah Dipinjam',
                data: {!! json_encode($barangTerpopuler->pluck('jumlah')) !!},
                backgroundColor: 'rgba(33,150,243,0.8)',
                borderColor: '#2196f3',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' unit';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        font: { family: 'Plus Jakarta Sans', size: 11 },
                        color: '#6b7f94'
                    },
                    grid: { color: 'rgba(0,0,0,.05)' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#6b7f94' }
                }
            }
        }
    });
    @endif

    // Donut Chart
    const donutCtx = document.getElementById('donutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Tidak Diketahui'],
            datasets: [{
                data: @json($kondisiData),
                backgroundColor: ['#22a06b','#e8a020','#e05252','#dce5f0'],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            cutout: '68%',
            responsive: true,
            plugins: {
                legend: { display: false },
            }
        }
    });

    const donutPeranCtx = document.getElementById('donutPeranChart').getContext('2d');
    new Chart(donutPeranCtx, {
        type: 'doughnut',
        data: {
            labels: ['Guru', 'Siswa'],
            datasets: [{
                data: [{{ $peminjamGuru }}, {{ $peminjamSiswa }}],
                backgroundColor: ['#3b6dc9', '#f0a942'],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            cutout: '68%',
            responsive: true,
            plugins: {
                legend: { display: false },
            }
        }
    });
</script>

</body>
</html>
