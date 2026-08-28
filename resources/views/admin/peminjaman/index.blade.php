<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Peminjaman</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        .user-name {
            font-size: 12.5px;
            font-weight: 600;
            color: #fff;
        }

        .user-role {
            font-size: 11px;
            color: rgba(255,255,255,.4);
        }

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

        .btn-logout:hover {
            background: rgba(220,60,60,.2);
            color: #fff;
            border-color: rgba(220,60,60,.3);
        }

        .stats-wrapper {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--card);
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 8px rgba(26,79,138,.07);
            overflow: hidden;
            transition: transform .18s, box-shadow .18s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 18px rgba(26,79,138,.12);
        }

        .stat-card h3 {
            padding: 12px 18px 10px;
            border-bottom: 1px solid var(--border);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #fff;
        }

        .stat-card.h3-total h3 { background: var(--primary); }
        .stat-card.h3-menunggu h3 { background: var(--warning); }
        .stat-card.h3-disetujui h3 { background: var(--success); }
        .stat-card.h3-dipinjam h3 { background: var(--info); }
        .stat-card.h3-dikembalikan h3 { background: #607d8b; }
        .stat-card.h3-ditolak h3 { background: var(--danger); }

        .stat-card p {
            padding: 18px;
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
        }

         /* ─── MAIN CONTENT ─── */

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

        /* ─── CONTENT HEADER ─── */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .content-title h2 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .content-title p  {
            font-size: 13px;
            color: var(--muted);
        }


        /* ─── CARD ─── */
        .card {
            background: var(--card);
            border-radius: 8px;
            border: 1px solid var(--border);
            padding: 20px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ─── ALERT ─── */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(76,175,80,.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background: rgba(244,67,54,.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        /* Stat cards */
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
            font-size: 18px;
            margin-bottom: 6px;
        }

        .stat-divider {
            width: 1px;
            background: var(--border);
            align-self: stretch;
            margin: 4px 0;
        }

        /* ─── TABLE ─── */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead {
            background: #263238;
            border-bottom: 2px solid var(--border);
        }

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
            padding: 14px 14px;
            border-bottom: 1px solid var(--border);
        }

        tbody tr:hover {
            background: #fafbfc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .badge-waiting { background: rgba(255,193,7,.14); color: #a67600; }
        .badge-approved { background: rgba(76,175,80,.14); color: #256028; }
        .badge-rejected { background: rgba(244,67,54,.14); color: #8a1f18; }
        .badge-borrowed { background: rgba(33,150,243,.14); color: #0d47a1; }
        .badge-returned { background: rgba(76,175,80,.14); color: #1b5e20; }
        .actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: flex-start;
        }
        .btn { border: none; border-radius: 10px; padding: 9px 14px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-primary { background: #1976d2; color: #fff; }
        .btn-secondary { background: #eef3f7; color: #37474f; }
        .btn-success { background: #4caf50; color: #fff; }
        .btn-danger { background: #f44336; color: #fff; }
        .btn-warning { background: #ff9800; color: #fff; }
        .input-inline { width: 180px; padding: 10px 12px; border: 1px solid #dfe5ea; border-radius: 12px; font-size: 13px; color: #263238; }
        .small-note { color: #6f7a86; font-size: 12px; margin-top: 4px; }
        .form-inline { display: grid; gap: 8px; }
        .form-inline textarea { min-height: 68px; padding: 10px 12px; border: 1px solid #dfe5ea; border-radius: 12px; font-family: inherit; resize: vertical; }
        .empty-state { padding: 28px; text-align: center; color: #7b8a97; }
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
            .main { padding: 16px 14px 32px; margin-left: 0; }
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
            .content-header { flex-direction: column; align-items: stretch; gap: 10px; }
            .stats-wrapper { grid-template-columns: 1fr; gap: 12px; }
            .table-wrapper { min-width: auto; overflow-x: auto; }
            table { min-width: 720px; font-size: 12px; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <main class="main">

        <div class="topbar">
            <div class="topbar-title">
                <h1>Manajemen Peminjaman</h1>
                <p>Kelola pengajuan dan pembaruan status peminjaman.</p>
            </div>
            <div class="topbar-date">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <div class="stats-wrapper">

                {{-- Informasi Barang --}}
                <div class="stat-group">

                    <div class="stat-group-header">
                        Statistik Peminjaman
                    </div>

                    <div class="stat-group-body">
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:#cd9300">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div class="stat-item-value">{{ $menunggu->count() }}</div>
                            <div class="stat-item-label">Status Menunggu</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:#38913c">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-item-value">{{ $disetujui->count() }}</div>
                            <div class="stat-item-label">Status Disetujui</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:#125cca">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            <div class="stat-item-value">{{ $dipinjam->count() }}</div>
                            <div class="stat-item-label">Status Dipinjam</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:#2a8130">
                                <i class="fas fa-undo-alt"></i>
                            </div>
                            <div class="stat-item-value">{{ $dikembalikan->count() }}</div>
                            <div class="stat-item-label">Status Dikembalikan</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="color:#bd2d22">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="stat-item-value">{{ $ditolak->count() }}</div>
                            <div class="stat-item-label">Status Ditolak</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-header">
                <div class="content-title">
                    <h2>Daftar Peminjaman</h2>
                    <p>Tinjau pengajuan, setujui, tolak, dan proses pengembalian.</p>
                </div>
            </div>

            <div class="card">

                <div class="card-title">
                    <i class="fas fa-users"></i>
                    Daftar Peminjam
                </div>

                <div class="table-wrapper">
                    @php
                        $allRecords = $menunggu->concat($disetujui)->concat($dipinjam)->concat($dikembalikan)->concat($ditolak);
                    @endphp

                    @if($allRecords->isEmpty())
                        <div class="empty-state">Belum ada data peminjaman tersedia.</div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Peran</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Rencana Pinjam</th>
                                    <th>Rencana Kembali</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allRecords as $index => $record)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $record->peminjam->name ?? '-' }}</strong></td>
                                        <td>{{ $record->peminjam->jabatan ?? '-' }}</td>
                                        <td>
                                            <strong>{{ $record->nama_barang ?? ($record->barang->nama_barang ?? '-') }}</strong>
                                            <div style="margin-top: 4px; color: var(--muted); font-size: 12px;">
                                                {{ $record->lokasi->nama ?? 'Lokasi tidak tersedia' }}
                                            </div>
                                        </td>
                                        <td>{{ $record->jumlah_pinjam }}</td>
                                        <td><strong>{{ optional($record->tanggal_pengajuan)->format('d/m/Y') ?? '-' }}</strong></td>
                                        <td><strong>{{ optional($record->tanggal_pinjam_rencana)->locale('id')->isoFormat('D MMMM Y') ?? '-' }}</strong></td>
                                        <td><strong>{{ optional($record->tanggal_kembali_rencana)->format('d/m/Y') ?? '-' }}</strong></td>
                                        <td>{{ $record->keterangan ?? '-' }}</td>
                                        <td>
                                            @php
                                                $status = $record->status;
                                                $badge = 'badge-waiting';
                                                if ($status === 'Disetujui') $badge = 'badge-approved';
                                                if ($status === 'Ditolak') $badge = 'badge-rejected';
                                                if ($status === 'Dipinjam') $badge = 'badge-borrowed';
                                                if ($status === 'Dikembalikan') $badge = 'badge-returned';
                                            @endphp
                                            <span class="badge {{ $badge }}">{{ $status }}</span>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                @if($record->status === 'Menunggu')
                                                    <a href="{{ route('admin.peminjaman.surat-permohonan', $record->id) }}" class="btn btn-primary"><i class="fas fa-eye"></i>Surat Permohonan</a>
                                                    <form action="{{ route('admin.peminjaman.approve', $record->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>Setujui</button>
                                                    </form>
                                                    <form action="{{ route('admin.peminjaman.reject', $record->id) }}" method="POST" class="form-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i>Tolak</button>
                                                        <textarea name="keterangan_penolakan" placeholder="Alasan penolakan (opsional)"></textarea>
                                                    </form>
                                                @elseif($record->status === 'Disetujui')
                                                    <a href="{{ route('admin.peminjaman.surat-permohonan', $record->id) }}" class="btn btn-secondary"><i class="fas fa-eye"></i>Lihat Surat Permohonan</a>
                                                    <a href="{{ route('admin.peminjaman.surat', $record->id) }}" class="btn" style="background:var(--info);color:#fff;font-size:13px;padding:6px; 12px;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;margin-right:6px;justify-content:center;">
                                                        <i class="fas fa-download" style="margin-left: 8px; margin-right: 3px;"></i>
                                                        Surat Persetujuan
                                                    </a>
                                                    @if(!$record->file_persetujuan_ttd)
                                                        <p class="small-note">Setelah Surat Persetujuan diunduh dan ditanda tangan, silahkan upload disini.</p>
                                                    @endif
                                                    <form action="{{ route('admin.peminjaman.surat-persetujuan-ttd.upload', $record->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="file" name="file_persetujuan_ttd" accept=".pdf,.jpg,.jpeg,.png" required>
                                                        <button type="submit" class="btn btn-secondary"><i class="fas fa-upload"></i>Upload TTD Surat Persetujuan</button>
                                                    </form>
                                                    @if($record->file_persetujuan_ttd)
                                                        <a href="{{ Storage::disk('public')->url($record->file_persetujuan_ttd) }}" target="_blank" class="btn btn-secondary"><i class="fas fa-eye"></i>Lihat TTD Surat Persetujuan</a>
                                                    @endif
                                                    <form action="{{ route('admin.peminjaman.dipinjam', $record->id) }}" method="POST" style="display:inline-block">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning"><i class="fas fa-check"></i>Proses Pinjam</button>
                                                    </form>
                                                @elseif($record->status === 'Dipinjam')
                                                    <a href="{{ route('admin.peminjaman.surat-permohonan', $record->id) }}" class="btn btn-secondary"><i class="fas fa-eye"></i>Lihat Surat Permohonan</a>
                                                    <a href="{{ route('admin.peminjaman.surat', $record->id) }}" class="btn btn-primary"><i class="fas fa-download"></i>Surat Persetujuan</a>
                                                    @if(!$record->file_persetujuan_ttd)
                                                        <p class="small-note">Setelah Surat Persetujuan diunduh dan ditanda tangan, silahkan upload disini.</p>
                                                    @endif
                                                    <form action="{{ route('admin.peminjaman.surat-persetujuan-ttd.upload', $record->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="file" name="file_persetujuan_ttd" accept=".pdf,.jpg,.jpeg,.png" required>
                                                        <button type="submit" class="btn btn-secondary"><i class="fas fa-upload"></i> Upload TTD Surat Persetujuan</button>
                                                    </form>
                                                    @if($record->file_persetujuan_ttd)
                                                        <a href="{{ Storage::disk('public')->url($record->file_persetujuan_ttd) }}" target="_blank" class="btn btn-secondary"><i class="fas fa-eye"></i>Lihat TTD Surat Persetujuan</a>
                                                    @endif
                                                    <a href="{{ route('admin.peminjaman.return.form', $record->id) }}" class="btn btn-primary"><i class="fas fa-undo"></i>Proses Kembali</a>
                                                @else
                                                    <span class="small-note">Tidak ada aksi</span>
                                                @endif
                                            </div>
                                            @if($record->status === 'Ditolak' && $record->keterangan_penolakan)
                                                <div class="small-note">Alasan: {{ $record->keterangan_penolakan }}</div>
                                            @endif
                                        </td>
                                    </tr>

                                    @if($record->detail->isNotEmpty() && $record->status !== 'Ditolak')
                                        <tr>
                                            <td></td>
                                            <td colspan="8" style="background: #f8fafc; padding: 14px 16px;">
                                                <div style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                                                    <i class="fas fa-boxes"></i>
                                                    Unit yang dipilih ({{ $record->detail->count() }} unit)
                                                </div>
                                                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                                                    @foreach($record->detail as $detail)
                                                        <div style="display:flex;align-items:center;gap:8px;background:#fff;border:1px solid var(--border);border-radius:8px;padding:6px 10px 6px 6px;">
                                                            @if($detail->barang && $detail->barang->foto)
                                                                <img src="{{ asset('storage/' . $detail->barang->foto) }}"
                                                                     alt="Foto Unit"
                                                                     style="width:32px;height:32px;object-fit:cover;border-radius:6px;">
                                                            @else
                                                                <div style="width:32px;height:32px;border-radius:6px;background:#eef3f7;display:flex;align-items:center;justify-content:center;color:var(--muted);">
                                                                    <i class="fas fa-image" style="font-size:11px;"></i>
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
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </main>
</body>
</html>
