<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        ::-webkit-scrollbar { display: none; }
        html, body { -ms-overflow-style: none; scrollbar-width: none; min-height: 100%; }
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
            --warning:     #ff9800;
            --info:       #2196f3;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); min-height: 100vh; display: flex; }
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
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 28px 40px; min-height: 100vh; }
        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border); }
        .topbar-title h1 { font-size: 20px; font-weight: 700; color: var(--text); }
        .topbar-title p { font-size: 13px; color: var(--muted); margin-top: 2px; }
        .topbar-date { font-size: 12.5px; color: var(--muted); background: var(--card); padding: 7px 14px; border-radius: 8px; border: 1px solid var(--border); }
        .content-card { background: var(--card); border-radius: 14px; border: 1px solid var(--border); box-shadow: 0 1px 8px rgba(26,79,138,.07); padding: 24px; max-width: 100%; margin-bottom: 20px; }
        .section-title { font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 10px; }
        .section-text { color: var(--muted); font-size: 13px; margin-bottom: 22px; line-height: 1.7; }
        .info-grid { display: grid; grid-template-columns: repeat(5, minmax(0,1fr)); gap: 16px; margin-bottom: 26px; }
        .info-card { background: #f8fafc; border: 1px solid var(--border); border-radius: 14px; padding: 18px 20px; }
        .info-card h4 { font-size: 14px; font-weight: 500; color: var(--text); margin-bottom: 8px; }
        .info-card p { font-size: 13px; color: #000000; line-height: 1.6; margin-bottom: 6px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; color: var(--text); }
        .form-control { width: 100%; border: 1px solid var(--border); border-radius: 12px; padding: 12px 14px; font-size: 14px; color: var(--text); background: #fff; }
        .form-control:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(255,152,0,.12); }
        .error-text { margin-top: 6px; font-size: 12px; color: var(--danger); }
        .btn-submit { display: inline-flex; align-items: center; justify-content: center; padding: 12px 18px; background: var(--accent); color: #fff; border-radius: 12px; text-decoration: none; font-size: 14px; font-weight: 700; border: none; cursor: pointer; }
        .btn-secondary { background: var(--primary-l); color: #fff; text-decoration: none; justify-content: center; display: inline-flex; align-items: center; padding: 12px 18px; border-radius: 12px; font-size: 14px; font-weight: 700; border: none; cursor: pointer; }
        .form-note { color: var(--muted); font-size: 12px; margin-top: 8px; }
        .button-group { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 18px; }
        .kondisi-badge { display: inline-block; padding: 4px 10px; border-radius: 15px; font-size: 12px; font-weight: 600; color: #fff; }
        .kondisi-badge.baik { background: var(--success); }
        .kondisi-badge.rusak_ringan { background: var(--warning); }
        .kondisi-badge.rusak_berat { background: var(--danger); }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 15px; font-size: 12px; font-weight: 600; color: #fff; }
        .status-badge.tersedia { background: var(--info); }
        .status-badge.dipinjam { background: var(--warning); }

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
                flex-direction: row
                align-items: flex-start;
                gap: 10px;
                margin-bottom: 16px;
            }

            .topbar-date {
                align-self: flex-end;
                width: 25%;
                text-align: center;
            }

            .info-grid {
                grid-template-columns: repeat(2, minmax(0,1fr));
                gap: 12px;
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
            <h1>Ajukan Peminjaman</h1>
            <p>Pilih unit yang sudah Anda pilih dan lengkapi detail peminjaman.</p>
        </div>
        <div class="topbar-date">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>
    <div class="content-card">
        <div class="section-title">Ringkasan Unit Terpilih</div>
        <div class="section-text">Pastikan unit yang dipilih sudah benar sebelum mengajukan peminjaman.</div>
        <div class="info-card" style="margin-bottom:24px;">
            <h3>Detail Pilihan</h3>
            <table style="width:100%; border-collapse: collapse; margin-top: 16px;">
                <tr>
                    <td style="padding: 10px 12px; width: 180px; color: var(--muted);">Nama Barang</td>
                    <td style="padding: 10px 12px;">: <strong>{{ $namaBarang ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 10px 12px; color: var(--muted);">Lokasi</td>
                    <td style="padding: 10px 12px;">: <strong>{{ optional($barangInfo)->lokasi->nama ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 10px 12px; color: var(--muted);">Jumlah Unit</td>
                    <td style="padding: 10px 12px;">: <strong>{{ $units->count() }} unit</strong></td>
                </tr>
            </table>
        </div>
        <div class="info-grid">
                    @foreach($units as $unit)
                        <div class="info-card">
                            <h4><strong>{{ $unit->nama_barang }}</strong></h4>
                            @if($unit->foto)
                        <img src="{{ asset('storage/' . $unit->foto) }}"
                            alt="Foto {{ $unit->nama_barang }}"
                            style="width:170px;
                                   height:170px;
                                   object-fit:cover;
                                   border-radius:8px;
                                   margin-bottom:12px;
                                   border:1px solid var(--border);">
                    @else
                        <div style="width:170px;
                                    height:170px;
                                    border-radius:8px;
                                    background:#f0f2f8;
                                    display:flex;
                                    flex-direction:column;
                                    align-items:center;
                                    justify-content:center;
                                    margin-bottom:12px;
                                    border:1px solid var(--border);
                                    color:var(--muted);">
                            <i class="fas fa-image"
                                style="font-size:28px;
                                       margin-bottom:6px;
                                       opacity:.4;"></i>
                            <span style="font-size:11px;">
                                Tidak ada foto
                            </span>
                        </div>
                    @endif
                    <p><strong>Nomor Register:</strong> {{ $unit->nomor_register }}</p>
                    <p><strong>Status:</strong> <span class="status-badge {{ str_replace('_', '-', $unit->status) }}">{{ ucfirst(str_replace('_', ' ', $unit->status)) }}</span></p>
                    <p><strong>Kondisi:</strong> <span class="kondisi-badge {{ str_replace('_', '-', $unit->kondisi) }}">{{ ucfirst(str_replace('_', ' ', $unit->kondisi)) }}</span></p>
                </div>
            @endforeach
        </div>
        <form method="POST" action="{{ route('peminjam.peminjaman.store') }}">
            @csrf
            @foreach($units as $unit)
                <input type="hidden" name="unit_ids[]" value="{{ $unit->id }}">
            @endforeach
            <input type="hidden" name="nama_barang" value="{{ $namaBarang }}">
            <input type="hidden" name="id_lokasi" value="{{ $id_lokasi }}">
            <div class="form-group">
                <label class="form-label" for="tanggal_kembali_rencana">Tanggal Rencana Kembali *</label>
                <input class="form-control" type="date" name="tanggal_kembali_rencana" id="tanggal_kembali_rencana" min="{{ now()->addDay()->toDateString() }}" value="{{ old('tanggal_kembali_rencana') }}" required>
                @error('tanggal_kembali_rencana')<p class="error-text">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="keterangan">Keterangan / Keperluan</label>
                <textarea class="form-control" name="keterangan" id="keterangan" rows="4" placeholder="Opsional...">{{ old('keterangan') }}</textarea>
                @error('keterangan')<p class="error-text">{{ $message }}</p>@enderror
            </div>
            <div class="button-group">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn-submit">Ajukan Peminjaman</button>
            </div>
        </form>
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

    hamburgerBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>
</body>
</html>
