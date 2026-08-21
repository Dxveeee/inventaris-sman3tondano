<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Unit Spesifik</title>
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
            --warning:    #ff9800;
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
        .content-card { background: var(--card); border-radius: 14px; border: 1px solid var(--border); box-shadow: 0 1px 8px rgba(26,79,138,.07); padding: 24px; }
        .section-title { font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 10px; }
        .section-text { color: var(--muted); font-size: 13px; margin-bottom: 22px; line-height: 1.7; }
        .breadcrumb { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; font-size: 13px; margin-bottom: 20px; }
        .breadcrumb a { color: var(--accent); text-decoration: none; }
        .breadcrumb span { color: var(--muted); }
        .back-button { display: inline-flex; align-items: center; gap: 8px; padding: 8px 10px; background: var(--primary-l); border-radius: 12px; color: #fff; text-decoration: none; font-size: 14px; margin-bottom: 18px; }
        .unit-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(auto-fill, 283px);
            justify-content: start;
        }
        .unit-card { position: relative; background: #fff; border: 1px solid var(--border); border-radius: 18px; padding: 18px; cursor: pointer; display: flex; flex-direction: column; gap: 16px; transition: transform .18s, box-shadow .18s; }
        .unit-card:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(0,0,0,.08); }
        .unit-card input { position: absolute; top: 18px; right: 18px; width: 18px; height: 18px; }
        .unit-photo { width: 100%; height: 180px; border-radius: 16px; background: #f1f5f8; overflow: hidden; display: grid; place-items: center; }
        .unit-photo img { width: 100%; height: 100%; object-fit: cover; }
        .no-photo { width: 100%; height: 100%; display: grid; place-items: center; color: var(--muted); font-size: 24px; }
        .unit-info { display: grid; gap: 8px; }
        .unit-info strong { font-size: 15px; }
        .unit-info strong span { font-size: 13px; color: var(--muted); }
        .unit-info span { font-size: 13px; color: var(--muted); }
        .unit-info .badge { display: inline-flex; align-items: center; justify-content: center; padding: 5px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; color: #fff; }
        .unit-info .badge-baik { background: var(--success); }
        .unit-info .badge-rusak_ringan { background: var(--warning); }
        .unit-info .badge-rusak_berat { background: var(--danger); }
        .unit-info .badge-info { background: var(--info); }
        .badge { display: inline-flex; align-items: center; justify-content: center; padding: 7px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; color: #fff; }
        .badge-baik { background: var(--success); }
        .badge-rusak_ringan { background: var(--warning); }
        .badge-rusak_berat { background: var(--danger); }
        .badge-info { background: var(--info); }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; color: var(--text); }
        .form-control { width: 100%; border: 1px solid var(--border); border-radius: 12px; padding: 12px 14px; font-size: 14px; color: var(--text); background: #fff; }
        .form-control:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(255,152,0,.12); }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 10px 10px; background: var(--accent); color: #fff; border-radius: 12px; text-decoration: none; font-size: 14px; font-weight: 700; border: none; cursor: pointer; }
        .btn-secondary { background: var(--primary-l); }
        .btn-submit { min-width: 190px; }
        .empty-state { padding: 22px; background: #f8fafc; border: 1px solid var(--border); border-radius: 14px; color: var(--muted); }
        .item-meta { display: column; flex-wrap: wrap; gap: 12px; font-size: 13px; color: var(--muted); }
        .item-meta span { display: flex; align-items: center; gap: 4px;  margin-bottom: 6px;}
        .item-meta .badge { font-size: 12px; padding: 4px 8px; }

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

            .unit-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 10x;
            }

            .unit-card {
                width: calc(50% - 10px)/* Desktop: 4 card per baris (contoh) */
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
            <h1>Pilih Unit</h1>
            <p>Pilih unit yang akan dipinjam.</p>
        </div>
        <div class="topbar-date">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

    <div class="content-card">
        <div class="breadcrumb">
            <a href="{{ route('peminjam.barang.index') }}">Pilih Lokasi</a>
            <span>/</span>
            <a href="{{ route('peminjam.barang.pilihBarang', $lokasi->id) }}">{{ $lokasi->nama }}</a>
            <span>/</span>
            <span>{{ $namaBarangDecoded }}</span>
        </div>

        <a href="{{ route('peminjam.barang.pilihBarang', $lokasi->id) }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

        @if(session('error'))
            <div class="empty-state" style="border-color: var(--danger); color: var(--danger); background: #fff1f0; margin-bottom: 18px;">{{ session('error') }}</div>
        @endif

        @if($units->isEmpty())
            <div class="empty-state">Tidak ada unit tersedia untuk barang ini di lokasi terpilih.</div>
        @else
            <form method="POST" action="{{ route('peminjam.peminjaman.create') }}">
                @csrf
                <div class="unit-grid">
                    @foreach($units as $unit)
                        <label class="unit-card">
                            <input type="checkbox" name="unit_ids[]" value="{{ $unit->id }}" class="unit-checkbox">
                            <div class="unit-photo">
                                @if($unit->foto)
                                    <img src="{{ asset('storage/' . $unit->foto) }}" alt="Foto {{ $unit->nomor_register }}">
                                @else
                                    <div class="no-photo"><i class="fas fa-image"></i></div>
                                @endif
                            </div>
                            <div class="unit-info">
                                <strong>{{ $namaBarangDecoded }} <span>- {{ $unit->nomor_register }} </span></strong>
                                <div class="item-meta">
                                    <span>
                                        <strong>Kondisi:</strong>
                                        <span class="badge badge-{{ $unit->kondisi }}">
                                            {{ ucfirst(str_replace('_', ' ', $unit->kondisi)) }}
                                        </span>
                                    </span>
                                    <span>
                                        <strong>Status:</strong>
                                        <span class="badge badge-info">
                                            {{ ucfirst($unit->status) }}
                                        </span>
                                    </span>
                                    @if($unit->merk_type)
                                        <span>
                                            <strong>Merk / Tipe:</strong>
                                            {{ $unit->merk_type }}
                                        </span>
                                    @endif
                                    @if($unit->bahan)
                                        <span>
                                            <strong>Bahan:</strong>
                                            {{ $unit->bahan }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-top:22px; align-items:center;">
                    <button type="submit" class="btn btn-submit" id="submitButton" disabled>Lanjutkan (0 unit dipilih)</button>
                </div>
            </form>
        @endif
    </div>
</div>

<script>
    const checkboxes = document.querySelectorAll('.unit-checkbox');
    const submitButton = document.getElementById('submitButton');
    function updateSelection() {
        const selected = Array.from(checkboxes).filter(ch => ch.checked).length;
        submitButton.textContent = selected > 0 ? `Lanjutkan (${selected} unit dipilih)` : 'Lanjutkan (0 unit dipilih)';
        submitButton.disabled = selected === 0;
    }
    checkboxes.forEach(ch => ch.addEventListener('change', updateSelection));
    updateSelection();

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
