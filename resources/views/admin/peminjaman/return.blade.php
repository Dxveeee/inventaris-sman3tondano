<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pengembalian</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* Hilangkan scrollbar */
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
        }

        /* ─── SIDEBAR ─── */
        .sidebar { width: var(--sidebar-w); background: var(--sidebar-bg); min-height: 100vh; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-logo { padding: 20px 20px 16px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .sidebar-logo-img { width: 38px; height: 38px; border-radius: 50%; background: rgba(255,255,255,.12); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: #fff; overflow: hidden; flex-shrink: 0; }
        .sidebar-logo-img img { width: 85%; height: 85%; object-fit: contain; }
        .sidebar-logo-text { overflow: hidden; }
        .sidebar-logo-text span { display: block; color: #fff; font-size: 11.5px; font-weight: 700; line-height: 1.3; }
        .sidebar-logo-text small { display: block; color: rgba(255,255,255,.45); font-size: 10px; margin-top: 1px; }
        .sidebar-nav { flex: 1; padding: 16px 0; overflow-y: auto; }
        .nav-label { font-size: 10px; font-weight: 600; color: rgba(255,255,255,.3); letter-spacing: .08em; text-transform: uppercase; padding: 10px 20px 6px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: rgba(255,255,255,.6); font-size: 13.5px; font-weight: 500; text-decoration: none; border-left: 3px solid transparent; transition: all .18s; cursor: pointer; }
        .nav-item:hover { background: rgba(255,255,255,.06); color: #fff; }
        .nav-item.active { background: rgba(26,79,138,.35); color: #fff; border-left-color: var(--accent); }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; opacity: .7; }
        .nav-item.active svg, .nav-item:hover svg { opacity: 1; }
        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,.08); }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #fff; }
        .user-name { font-size: 12.5px; font-weight: 600; color: #fff; }
        .user-role { font-size: 11px; color: rgba(255,255,255,.4); }
        .btn-logout { width: 100%; display: flex; align-items: center; justify-content: center; gap: 7px; padding: 8px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12); border-radius: 8px; color: rgba(255,255,255,.6); font-family: inherit; font-size: 12.5px; cursor: pointer; transition: all .18s; text-decoration: none; }
        .btn-logout:hover { background: rgba(220,60,60,.2); color: #fff; border-color: rgba(220,60,60,.3); }

        .stats-wrapper { display: grid; grid-template-columns: repeat(6, 1fr); gap: 16px; margin-bottom: 20px; }
        .stat-card { background: var(--card); border-radius: 14px; border: 1px solid var(--border); box-shadow: 0 1px 8px rgba(26,79,138,.07); overflow: hidden; transition: transform .18s, box-shadow .18s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 18px rgba(26,79,138,.12); }
        .stat-card h3 { padding: 12px 18px 10px; border-bottom: 1px solid var(--border); font-size: 11px; text-transform: uppercase; letter-spacing: .06em; color: #fff; }

        .main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 28px 40px; min-height: 100vh; }
        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border); }
        .topbar-title h1 { font-size: 20px; font-weight: 700; color: var(--text); }
        .topbar-title p { font-size: 13px; color: var(--muted); margin-top: 2px; }
        .topbar-date { font-size: 12.5px; color: var(--muted); background: var(--card); padding: 7px 14px; border-radius: 8px; border: 1px solid var(--border); }

        .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .content-title h2 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .content-title p { font-size: 13px; color: var(--muted); }

        .card { background: var(--card); border-radius: 8px; border: 1px solid var(--border); padding: 20px; }
        .card-title { font-size: 16px; font-weight: 700; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }

        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: rgba(76,175,80,.1); color: var(--success); border-left: 4px solid var(--success); }
        .alert-error { background: rgba(244,67,54,.1); color: var(--danger); border-left: 4px solid var(--danger); }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 10px; color: var(--text); font-weight: 600; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px 14px; border: 1px solid #dfe5ea; border-radius: 12px; font-size: 13px; color: var(--text); }
        .form-group textarea { min-height: 68px; padding: 10px 12px; border-radius: 12px; }
        .form-inline { display: grid; gap: 8px; }
        .detail-list { list-style: none; display: grid; gap: 12px; margin-bottom: 24px; }
        .detail-list li { display: grid; gap: 6px; }
        .detail-label { color: var(--muted); font-size: 13px; }
        .detail-value { color: var(--text); font-size: 15px; font-weight: 600; }

        .btn { border: none; border-radius: 10px; padding: 9px 14px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: #1976d2; color: #fff; }
        .btn-secondary { background: #eef3f7; color: #37474f; }
        .btn-success { background: #4caf50; color: #fff; }
        .btn-danger { background: #f44336; color: #fff; }
        .btn-warning { background: #ff9800; color: #fff; }
        .note { display: block; color: var(--muted); font-size: 12px; margin-top: 6px; }
        a.btn-link { display: inline-flex; align-items: center; gap: 8px; color: var(--text); text-decoration: none; font-weight: 600; }
        a.btn-link:hover { text-decoration: underline; }

        /* Mobile topbar and responsive behavior (matches other views) */
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
            .topbar { flex-direction: row; align-items: flex-start; gap: 10px; margin-bottom: 16px; }
            .topbar-date { align-self: flex-end; width: 25%; text-align: center; }
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
                <h1>Proses Pengembalian</h1>
                <p>Catat kondisi barang dan tanggal kembali setelah peminjaman.</p>
            </div>
            <div class="topbar-date">{{ now()->translatedFormat('l, d F Y') }}</div>
        </div>

        <div class="content">
            @if($errors->any())
                <div class="alert alert-error">
                    <strong>Periksa kembali informasi:</strong>
                    <ul style="margin-top:10px; padding-left:18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <div class="content-title">
                <h2>Detail Peminjaman</h2>
            </div>

            <div class="card">
                <ul class="detail-list">
                    <li>
                        <span class="detail-label">Peminjam</span>
                        <span class="detail-value">{{ $peminjaman->peminjam->name ?? '-' }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Barang</span>
                        <span class="detail-value">{{ $peminjaman->nama_barang ?? ($peminjaman->barang->nama_barang ?? '-') }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Lokasi</span>
                        <span class="detail-value">{{ $peminjaman->lokasi->nama ?? '-' }}</span>
                    </li>
                    <li>
                        <span class="detail-label">
                            Unit yang Dipinjam ({{ $peminjaman->detail->count() }} unit)
                        </span>
                        @if($peminjaman->detail->isEmpty())
                            <span class="detail-value">-</span>
                        @else
                            <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:6px;">
                                @foreach($peminjaman->detail as $detail)
                                    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:8px 12px 8px 8px;">
                                        @if($detail->barang && $detail->barang->foto)
                                            <img src="{{ asset('storage/' . $detail->barang->foto) }}"
                                                 alt="Foto Unit"
                                                 style="width:40px;height:40px;object-fit:cover;border-radius:8px;">
                                        @else
                                            <div style="width:40px;height:40px;border-radius:8px;background:#eef3f7;display:flex;align-items:center;justify-content:center;color:var(--muted);">
                                                <i class="fas fa-image" style="font-size:14px;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-size:13px;font-weight:700;color:var(--text);">
                                                No. Reg: {{ $detail->nomor_register }}
                                            </div>
                                            @if($detail->barang)
                                                <div style="font-size:11.5px;color:var(--muted);">
                                                    {{ ucfirst(str_replace('_',' ',$detail->barang->kondisi)) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </li>
                    <li>
                        <span class="detail-label">Jumlah Pinjam</span>
                        <span class="detail-value">{{ $peminjaman->jumlah_pinjam }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Tanggal Pinjam</span>
                        <span class="detail-value">{{ optional($peminjaman->tanggal_pengajuan)->format('d/m/Y') ?? '-' }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Rencana Kembali</span>
                        <span class="detail-value">{{ optional($peminjaman->tanggal_kembali_rencana)->format('d/m/Y') ?? '-' }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Status</span>
                        <span class="detail-value">{{ $peminjaman->status }}</span>
                    </li>
                </ul>

                <form action="{{ route('admin.peminjaman.return.process', $peminjaman->id) }}" method="POST" class="form-grid">
                    @csrf
                    <div class="form-group">
                        <label for="tanggal_kembali_aktual">Tanggal Kembali</label>
                        <input type="date" id="tanggal_kembali_aktual" name="tanggal_kembali_aktual" value="{{ old('tanggal_kembali_aktual', $peminjaman->tanggal_kembali_rencana ? $peminjaman->tanggal_kembali_rencana->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kondisi_kembali">Kondisi Barang Saat Dikembalikan</label>
                        <select id="kondisi_kembali"
                            name="kondisi_kembali" required>
                            <option value="">Pilih kondisi</option>
                            <option value="Baik"
                                {{ old('kondisi_kembali') === 'Baik'
                                    ? 'selected' : '' }}>
                                Baik
                            </option>
                            <option value="Rusak Ringan"
                                {{ old('kondisi_kembali') === 'Rusak Ringan'
                                    ? 'selected' : '' }}>
                                Rusak Ringan
                            </option>
                            <option value="Rusak Berat"
                                {{ old('kondisi_kembali') === 'Rusak Berat'
                                    ? 'selected' : '' }}>
                                Rusak Berat
                            </option>
                            <option value="Hilang"
                                {{ old('kondisi_kembali') === 'Hilang'
                                    ? 'selected' : '' }}>
                                Hilang
                            </option>
                        </select>
                        <span class="note">Pilih kondisi terbaru dari barang setelah dikembalikan.</span>
                    </div>
                    <div style="display:flex; gap: 12px; flex-wrap: wrap; margin-top: 10px;">
                        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">Kembali ke daftar</a>
                        <button type="submit" class="btn btn-primary">Simpan Pengembalian</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
