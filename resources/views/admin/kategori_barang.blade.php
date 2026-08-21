<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Barang</title>
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
            color: var(--text);
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


        /* ─── CONTENT ─── */
        .content {
            flex: 1;
            overflow-y: auto;
        }

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

        .btn-danger:hover {
            background: #e53935;
        }

        .btn-edit {
            background: var(--info);
            color: white;
            padding: 6px 12px;
            font-size: 11px;
        }

        .btn-edit:hover {
            background: #1976d2;
        }

        /* ─── CARD ─── */
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
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
        }

        tbody tr:hover {
            background: #fafbfc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .action-cell {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        /* ─── MODAL ─── */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 200;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--card);
            border-radius: 12px;
            padding: 28px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            font-size: 16px;
            font-weight: 700;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--muted);
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: var(--text);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text);
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 24px;
        }

        .btn-cancel {
            background: var(--border);
            color: var(--text);
        }

        .btn-cancel:hover {
            background: #d0d7e0;
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
            background: rgba(76, 175, 80, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        /* ─── EMPTY STATE ─── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            font-size: 48px;
            color: var(--border);
            margin-bottom: 16px;
        }

        .empty-state p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 16px;
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
                width: 24%;
                justify-content: center;
            }

            .btn-edit, .btn-danger {
                width: 35px;
                height: 27px;
                padding: 0;
                justify-content: center;
            }

            .modal-content { width: 95%; }
            table { font-size: 12px; display: block; overflow-x: auto; white-space: nowrap; }
            th, td { padding: 8px 12px; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
@include('layouts.sidebar')

    <!-- MAIN CONTENT -->
    <main class="main">
        <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-title">
            <h1>Kelola Kategori</h1>
            <p>Daftar Kategori inventaris SMA Negeri 3 Tondano</p>
        </div>
        <div class="topbar-date">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

        <!-- CONTENT -->
        <section class="content">
            <!-- ALERTS -->
            @if($message = session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ $message }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- HEADER -->
            <div class="content-header">
                <div class="content-title">
                    <h2>Daftar Kategori</h2>
                    <p>Total {{ count($kategori) }} kategori terdaftar</p>
                </div>
                <button type="button" class="btn btn-primary" onclick="openModal()">
                    <i class="fas fa-plus"></i> Tambah Kategori
                </button>
            </div>

            <!-- CARD -->
            <div class="card">
                <div class="card-title">
                    <i class="fas fa-folder"></i>
                    Daftar Kategori Barang
                </div>

                @if(count($kategori) > 0)
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 20%;">Nama Kategori</th>
                                    <th style="width: 20%;">Kode Prefix</th>
                                    <th style="width: 35%;">Deskripsi</th>
                                    <th style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategori as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $item->nama }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">
                                                {{ $item->kode_prefix ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $item->deskripsi ?? '-' }}
                                        </td>
                                        <td>
                                            <div class="action-cell">
                                                <button type="button" class="btn btn-edit"
                                                    onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->nama) }}', '{{ addslashes($item->kode_prefix ?? '') }}', '{{ addslashes($item->deskripsi ?? '') }}')">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>

                                                <form method="POST" action="{{ route('admin.kategori.destroy', $item->id) }}" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <p>Belum ada kategori barang yang terdaftar</p>
                        <button type="button" class="btn btn-primary" onclick="openModal()">
                            <i class="fas fa-plus"></i> Buat Kategori Pertama
                        </button>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <!-- MODAL TAMBAH KATEGORI -->
    <div class="modal" id="tambahKategoriModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Kategori Baru</h3>
                <button type="button" class="modal-close" onclick="closeModal()">×</button>
            </div>

            <form method="POST" action="{{ route('admin.kategori.store') }}">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Kategori <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="nama" name="nama" required placeholder="Contoh: Peralatan Tulis">
                </div>

                <div class="form-group">
                    <label for="kode_prefix">Kode Prefix <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="kode_prefix" name="kode_prefix" maxlength="5" placeholder="Contoh: LT" oninput="this.value = this.value.toUpperCase()">
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi kategori (opsional)"></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT KATEGORI -->
    <div class="modal" id="editKategoriModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-pencil-alt" style="color: var(--info); margin-right: 6px;"></i>Edit Kategori</h3>
                <button type="button" class="modal-close" onclick="closeEditModal()">×</button>
            </div>

            <form method="POST" id="editKategoriForm" action="">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="edit_nama">Nama Kategori <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="edit_nama" name="nama" required placeholder="Contoh: Peralatan Tulis">
                </div>

                <div class="form-group">
                    <label for="edit_kode_prefix">Kode Prefix <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="edit_kode_prefix" name="kode_prefix" maxlength="5" placeholder="Contoh: LT" oninput="this.value = this.value.toUpperCase()">
                </div>

                <div class="form-group">
                    <label for="edit_deskripsi">Deskripsi</label>
                    <textarea id="edit_deskripsi" name="deskripsi" placeholder="Masukkan deskripsi kategori (opsional)"></textarea>
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

    <script>
        function openModal() {
            document.getElementById('tambahKategoriModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('tambahKategoriModal').classList.remove('active');
        }

        function openEditModal(id, nama, kode_prefix, deskripsi) {
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_kode_prefix').value = kode_prefix;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('editKategoriForm').action = '/admin/kategori/' + id;
            document.getElementById('editKategoriModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editKategoriModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('tambahKategoriModal').addEventListener('click', (e) => {
            if (e.target.id === 'tambahKategoriModal') {
                closeModal();
            }
        });

        document.getElementById('editKategoriModal').addEventListener('click', (e) => {
            if (e.target.id === 'editKategoriModal') {
                closeEditModal();
            }
        });

        // Close alert after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.3s ease';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    </script>
</body>
</html>
