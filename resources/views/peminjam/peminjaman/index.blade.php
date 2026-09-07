<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman Saya</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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

        .main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 28px 40px; min-height: 100vh; }
        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border); }
        .topbar-title h1 { font-size: 20px; font-weight: 700; color: var(--text); }
        .topbar-title p { font-size: 13px; color: var(--muted); margin-top: 2px; }
        .topbar-date { font-size: 12.5px; color: var(--muted); background: var(--card); padding: 7px 14px; border-radius: 8px; border: 1px solid var(--border); }
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
            padding: 14px 16px;
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

        .table-card tbody tr:hover {
            background: #f8fafc;
        }

        .table-card th:last-child,
        .table-card td:last-child {
            padding-left: 32px;
        }

        td:nth-child(8) {
            max-width: 200px;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 9px 14px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary { background: #1976d2; color: #fff; }
        .btn-info {
            background: var(--info);
            color: #fff;
        }

        .btn-secondary { background: #eef3f7; color: #37474f; }

        .btn-success { background: var(--success); color: #fff; }
        .btn-danger { background: #f44336; color: #fff; }
        .btn.disabled { opacity: 0.5; cursor: not-allowed; pointer-events: none; }

        .btn-file-input { display: flex; flex-direction: column; gap: 8px; width: 100%; }
        .btn-file-input input[type="file"] { padding: 10px 12px; border: 1px solid #dfe5ea; border-radius: 8px; font-size: 13px; }
        .btn-file-input button { width: 100%; }

        .badge { display: inline-flex; align-items: center; padding: 6px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; color: #fff; }
        .badge-menunggu { background: var(--warning); }
        .badge-disetujui { background: var(--success); }
        .badge-dipinjam { background: var(--info); }
        .badge-dikembalikan { background: #607d8b; }
        .badge-ditolak { background: var(--danger); }
        .empty-state { padding: 22px 24px; color: var(--muted); }

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

        .small-note { color: #6f7a86; font-size: 12px; margin-top: 4px; }

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
            <h1>Riwayat Peminjaman Saya</h1>
            <p>Semua permintaan pinjaman Anda tercatat di sini.</p>
        </div>
        <div class="topbar-date">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

    @if(session('success'))
        <div style="margin-bottom:16px;padding:12px 16px;border-radius:8px;background:#e8f5e9;color:#256028;border-left:4px solid var(--success);font-size:13px;">{{ session('success') }}</div>
    @endif
    @if(session('error') || $errors->any())
        <div style="margin-bottom:16px;padding:12px 16px;border-radius:8px;background:#ffebee;color:#b71c1c;border-left:4px solid var(--danger);font-size:13px;">
            {{ session('error') ?? $errors->first() }}
        </div>
    @endif

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 15%;">Nama Barang</th>
                    <th style="width: 6%;">Jumlah</th>
                    <th style="width: 9%;">Tgl Pengajuan</th>
                    <th style="width: 11%;">Tgl Rencana Pinjam</th>
                    <th style="width: 10%;">Tgl Rencana Kembali</th>
                    <th style="width: 9%;">Status</th>
                    <th style="width: 15%;">Keterangan</th>
                    <th style="width: 22%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $i => $r)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $r->nama_barang ?? ($r->barang->nama_barang ?? '-') }}</strong>
                            <div style="margin-top: 4px; color: var(--muted); font-size: 12px;">
                                {{ $r->lokasi->nama ?? 'Lokasi tidak tersedia' }}
                            </div>
                        </td>
                        <td>{{ $r->jumlah_pinjam }}</td>
                        <td><strong>{{ optional($r->tanggal_pengajuan)->format('d/m/Y') }}</strong></td>
                        <td><strong>{{ optional($r->tanggal_pinjam_rencana)->locale('id')->isoFormat('D MMMM Y') ?? '-' }}</strong></td>
                        <td><strong>{{ optional($r->tanggal_kembali_rencana)->format('d/m/Y') }}</strong></td>
                        <td>
                            @php
                                $statusClass = 'badge-menunggu';
                                switch($r->status) {
                                    case 'Disetujui': $statusClass = 'badge-disetujui'; break;
                                    case 'Dipinjam': $statusClass = 'badge-dipinjam'; break;
                                    case 'Dikembalikan': $statusClass = 'badge-dikembalikan'; break;
                                    case 'Ditolak': $statusClass = 'badge-ditolak'; break;
                                }
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $r->status }}</span>
                        </td>
                        <td>
                            {{ $r->status === 'Ditolak' ? $r->keterangan_penolakan : ($r->keterangan ?? '-') }}
                        </td>
                        <td>
                            <div style="display:flex; flex-direction:column; gap:6px; ">
                                <a href="{{ route('peminjam.peminjaman.surat-permohonan', $r->id) }}" class="btn btn-info" style="width: 90%;">
                                    <i class="fas fa-download"></i> Surat Permohonan
                                </a>
                                @if($r->status === 'Menunggu' && !$r->file_permohonan_ttd)
                                    <p class="small-note">*Setelah Surat Permohonan diunduh dan ditanda tangan, silahkan upload disini.</p>
                                @endif
                                @if($r->file_permohonan_ttd)
                                    <a href="{{ Storage::disk('public')->url($r->file_permohonan_ttd) }}" target="_blank" class="btn btn-secondary" style="width: 90%;">
                                        <i class="fas fa-eye"></i>TTD Surat Permohonan
                                    </a>
                                @else
                                    <form action="{{ route('peminjam.peminjaman.surat-permohonan-ttd.upload', $r->id) }}" method="POST" enctype="multipart/form-data" class="btn-file-input" style="width: 90%;">
                                        @csrf
                                        <input type="file" name="file_permohonan_ttd" accept=".pdf,.jpg,.jpeg,.png" required>
                                        <button type="submit" class="btn btn-secondary" style="display: flex; justify-content: flex-start;"><i class="fas fa-upload"></i> Upload TTD Surat Permohonan</button>
                                    </form>
                                @endif
                            </div>
                            @if(in_array($r->status, ['Disetujui', 'Dipinjam']))
                                <div style="margin-top:6px; width: 90%;">
                                    @if($r->file_persetujuan_ttd)
                                        <a href="{{ route('peminjam.peminjaman.surat-persetujuan-ttd', $r->id) }}" target="_blank" class="btn btn-success" style="width: 100%;">
                                            <i class="fas fa-eye"></i> TTD Surat Persetujuan
                                        </a>
                                        <p class="small-note">
                                             *Sebagai bukti untuk melakukan <br> peminjaman barang
                                        </p>
                                    @else
                                        <a href="#" class="btn btn-secondary disabled">
                                            <i class="fas fa-eye"></i> Surat Persetujuan (menunggu TTD Admin)
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                    @if($r->detail->isNotEmpty() && !in_array($r->status, ['Menunggu', 'Ditolak']))
                        <tr>
                            <td></td>
                            <td colspan="8" style="background: #f8fafc; padding: 14px 16px;">
                                <div style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                                    <i class="fas fa-boxes"></i>
                                    Unit yang dipinjam ({{ $r->detail->count() }} unit)
                                </div>
                                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                                    @foreach($r->detail as $detail)
                                        <div style="display:flex;align-items:center;gap:8px;background:#fff;border:1px solid var(--border);border-radius:8px;padding:10px;">
                                            @if($detail->barang && $detail->barang->foto)
                                                <img src="{{ asset('storage/' . $detail->barang->foto) }}"
                                                     alt="Foto Unit"
                                                     style="width:42px;height:42px;object-fit:cover;border-radius:6px;">
                                            @else
                                                <div style="width:42px;height:42px;border-radius:6px;background:#eef3f7;display:flex;align-items:center;justify-content:center;color:var(--muted);">
                                                    <i class="fas fa-image" style="font-size:14px;"></i>
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
                @empty
                    <tr>
                        <td colspan="9" class="empty-state">Belum ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
