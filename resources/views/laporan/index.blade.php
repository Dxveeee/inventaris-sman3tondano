<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventaris</title>
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
            --warning:    #ff9800;
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

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card);
            border-radius: 12px;
            padding: 18px 16px;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: all .3s ease;
        }

        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(0,0,0,.08); }

        .stat-icon {
            font-size: 24px;
            width: fit-content;
        }

        .stat-icon.blue { color: var(--info); }
        .stat-icon.green { color: var(--success); }
        .stat-icon.amber { color: var(--warning); }
        .stat-icon.red { color: var(--danger); }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
        }

        .filter-section {
            background: var(--card);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid var(--border);
            margin-bottom: 24px;
            align-items: flex-start;
        }

        .filter-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 0;
            justify-content: center;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
        }

        .filter-input, select {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text);
            font-size: 13px;
            font-family: inherit;
            min-width: 180px;
        }

        .filter-input:focus, select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255,152,0,.1);
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

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background: #f57c00;
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            background: var(--border);
        }

        .btn-danger {
            background: rgba(244,67,54,.1);
            color: #f44336;
        }

        .btn-danger:hover {
            background: rgba(244,67,54,.2);
        }

        .btn-success {
            background: rgba(76,175,80,.1);
            color: #4caf50;
        }

        .btn-success:hover {
            background: rgba(76,175,80,.2);
        }

        .export-buttons {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .active-filter-info {
            font-size: 12.5px;
            color: var(--muted);
            font-style: italic;
            padding: 10px 0;
        }

        .content-header {
            margin-bottom: 20px;
        }

        .content-header h2 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .content-header p {
            font-size: 12.5px;
            color: var(--muted);
        }

        .card {
            background: var(--card);
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th {
            background: var(--primary-d);
            color: #fff;
            padding: 14px 20px;
            text-align: left;
            font-weight: 600;
            border: none;
        }

        td {
            padding: 14px 23px;
            border-bottom: 1px solid var(--border);
        }

        tbody tr:hover {
            background: rgba(255,152,0,.04);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-baik { background: rgba(76,175,80,.1); color: #4caf50; }
        .badge-ringan { background: rgba(255,152,0,.1); color: #ff9800; }
        .badge-berat { background: rgba(244,67,54,.1); color: #f44336; }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 12px;
            opacity: .5;
        }

        .empty-state-text {
            font-size: 14px;
            margin-bottom: 16px;
        }

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
            .filter-section {
                padding: 16px;
            }

            .filter-row {
                flex-direction: row;
                flex-wrap: wrap;
                align-items: flex-end;
                gap: 12px;
            }

            .filter-group {
                flex: 1 1 calc(33.333% - 8px);
                min-width: 140px;
            }

            .filter-group select,
            .filter-group input {
                width: 100%;
                min-width: 0;
            }

            .stat-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            table {
                min-width: 760px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <main class="main">
        <div class="topbar">
            <div class="topbar-title">
                <h1>Laporan Inventaris</h1>
                <p>Laporan data inventaris barang SMA Negeri 3 Tondano</p>
            </div>
            <div class="topbar-date">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>

        <div class="filter-section">
            <form method="GET" action="{{ route('laporan.index') }}">
                <div class="filter-row">

                    <div class="filter-group">
                        <label class="filter-label">Lokasi</label>
                        <select name="lokasi">
                            <option value="">Semua Lokasi</option>
                            @foreach($lokasi as $lok)
                            <option value="{{ $lok->id }}"
                                {{ request('lokasi') == $lok->id ? 'selected' : '' }}>
                                {{ $lok->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Kategori</label>
                        <select name="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}"
                                    {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Kondisi</label>
                        <select name="kondisi">
                            <option value="">Semua Kondisi</option>
                            <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ request('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ request('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select name="status">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                            <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Tahun</label>
                        <select name="tahun">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}"
                                    {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display: flex; gap: 8px; align-items: flex-end;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i>
                            Terapkan Filter
                        </button>
                        <a href="{{ route('laporan.index') }}" class="btn btn-outline">
                            <i class="fas fa-rotate-left"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if(request()->anyFilled(['kategori', 'lokasi', 'kondisi', 'status', 'tahun']))
            <div class="active-filter-info">
                <i class="fas fa-info-circle"></i>
                Menampilkan data dengan filter: <strong>{{ $periode }}</strong>
            </div>
        @endif

        @if($totalFiltered > 0)
            <div class="export-buttons">
                <a href="{{ route('laporan.exportPdf') . '?' . http_build_query(request()->all()) }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i>
                    Cetak PDF
                </a>
                <a href="{{ route('laporan.exportExcel') . '?' . http_build_query(request()->all()) }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i>
                    Cetak Excel
                </a>
            </div>
        @endif

        <div class="content-header">
            <h2>Data Inventaris Barang</h2>
            <p>Menampilkan {{ $barang->count() }} dari {{ $totalFiltered }} barang</p>
        </div>

        <div class="card">
            @if($totalFiltered > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:4%">NO</th>
                                <th style="width:12%">KODE BARANG</th>
                                <th style="width:16%">NAMA BARANG</th>
                                <th style="width:10%">NOMOR REGISTER</th>
                                <th style="width:12%">MERK/TYPE</th>
                                <th style="width:10%">BAHAN</th>
                                <th style="width:8%">TAHUN</th>
                                <th style="width:10%">ASAL USUL</th>
                                <th style="width:10%">KONDISI</th>
                                <th style="width:12%">HARGA (Rp)</th>
                                <th style="width:15%">KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang as $index => $item)
                            <tr>
                                <td>{{ $barang->firstItem() + $index }}</td>
                                <td><strong>{{ $item->kode_barang }}</strong></td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->nomor_register ?? '-' }}</td>
                                <td>{{ $item->merk_type ?? '-' }}</td>
                                <td>{{ $item->bahan ?? '-' }}</td>
                                <td>{{ $item->tahun_pengadaan ?? '-' }}</td>
                                <td>{{ $item->asal_usul ?? '-' }}</td>
                                <td>
                                    @if($item->kondisi == 'baik')
                                        <span class="badge badge-baik">Baik</span>
                                    @elseif($item->kondisi == 'rusak_ringan')
                                        <span class="badge badge-ringan">Rusak Ringan</span>
                                    @else
                                        <span class="badge badge-berat">Rusak Berat</span>
                                    @endif
                                </td>
                                <td>{{ $item->harga ? 'Rp '.number_format($item->harga, 0, ',', '.') : '-' }}</td>
                                <td>{{ $item->deskripsi ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrapper" style="padding: 0 20px 20px;">
                    {{ $barang->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <div class="empty-state-text">
                        Tidak ada data barang dengan filter yang dipilih.
                    </div>
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline">
                        Reset Filter
                    </a>
                </div>
            @endif
        </div>
    </main>
</body>
</html>
