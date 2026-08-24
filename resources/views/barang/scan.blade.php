<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js untuk modal -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Library scan QR dari kamera -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f5f7fa; min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
        }
        .scan-wrap { width: 100%; max-width: 700px; }
        .scan-card {
            background: #fff; border-radius: 20px;
            border: 1px solid #dee3ea; padding: 24px;
            box-shadow: 0 14px 45px rgba(15, 23, 42, 0.06);
        }
        .scan-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            gap: 16px; margin-bottom: 24px;
        }
        .scan-meta { display: grid; gap: 6px; }
        .scan-title { font-size: 24px; font-weight: 800; color: #111827; }
        .scan-sub { font-size: 14px; color: #6b7280; }
        .scan-note { font-size: 13px; color: #9ca3af; }
        #reader { border-radius: 20px; overflow: hidden; min-height: 280px; background: #000; }
        .btn-rescan {
            display: inline-flex; align-items: center; justify-content: center;
            width: 100%; text-align: center; padding: 14px;
            background: #f3f4f6; color: #111827;
            border-radius: 14px; font-weight: 700; font-size: 14px;
            border: 1px solid #d1d5db; cursor: pointer;
            transition: background .2s ease;
        }
        .btn-rescan:hover { background: #e5e7eb; }
        .error-toast {
            display: none; background: rgba(244,67,54,.1);
            border-left: 4px solid #f44336; border-radius: 8px;
            padding: 12px 16px; color: #f44336; font-size: 14px;
            margin-top: 16px; position: relative;
        }
        .error-toast.show { display: block; }

        /* Modal Styles */
        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5); display: flex;
            align-items: center; justify-content: center;
            z-index: 999; padding: 20px;
        }
        .modal-content {
            background: #ffffff; border-radius: 16px;
            max-width: 420px; width: 90%; max-height: 90vh;
            overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,.2);
            position: relative;
        }
        .modal-header {
            padding: 24px 24px 16px 24px;
            text-align: center;
        }
        .modal-title {
            font-size: 24px; font-weight: 700; color: #111827;
            margin-bottom: 8px;
        }
        .modal-badge {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 6px 12px; border-radius: 9999px;
            font-size: 12px; font-weight: 700;
        }
        .badge-baik { background: rgba(76,175,80,.1); color: #4caf50; }
        .badge-rusak_ringan { background: rgba(255,152,0,.1); color: #ff9800; }
        .badge-rusak_berat { background: rgba(244,67,54,.1); color: #f44336; }
        .badge-dipinjam { background: rgba(33,150,243,.1); color: #2196f3; }
        .modal-body { padding: 0 24px 24px 24px; }
        .detail-row {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 0; border-bottom: 1px solid #f3f4f6;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-icon {
            width: 20px; text-align: center; color: #6b7280;
        }
        .detail-content {
            flex: 1; display: flex; justify-content: space-between;
            align-items: center;
        }
        .detail-label {
            font-size: 14px; font-weight: 600; color: #6b7280;
        }
        .detail-value {
            font-size: 14px; font-weight: 700; color: #111827;
        }
        .stock-progress {
            margin: 16px 0;
        }
        .progress-bar {
            width: 100%; height: 8px; background: #e5e7eb;
            border-radius: 4px; overflow: hidden;
        }
        .progress-fill {
            height: 100%; border-radius: 4px; transition: width 0.3s ease;
        }
        .progress-fill.green { background: #4caf50; }
        .progress-fill.blue { background: #2196f3; }
        .progress-fill.red { background: #f44336; }
        .stock-text {
            font-size: 12px; color: #6b7280; text-align: center;
            margin-top: 4px;
        }
        .modal-actions {
            display: flex; gap: 12px; margin-top: 24px;
        }
        .btn-kembali {
            flex: 1; display: inline-flex; align-items: center; justify-content: center;
            padding: 12px 16px; background: #e0e6ed; color: #263238;
            border-radius: 8px; font-weight: 700; border: none;
            cursor: pointer; transition: background .2s;
        }
        .btn-kembali:hover { background: #d0d7de; }
        .btn-detail {
            flex: 1; display: inline-flex; align-items: center; justify-content: center;
            padding: 12px 16px; background: #ff9800; color: #fff;
            border-radius: 8px; font-weight: 700; text-decoration: none;
            transition: background .2s;
        }
        .btn-detail:hover { background: #e68900; }

        /* Modal Animation */
        .modal-overlay[x-show="true"] .modal-content {
            animation: modalFadeIn 0.3s ease-out;
        }
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 768px) {
            body {
                display: block;
                padding: 12px;
            }
            .scan-wrap {
                max-width: 100%;
            }
            .scan-card {
                padding: 16px;
                border-radius: 16px;
            }
            .scan-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .scan-title {
                font-size: 20px;
            }
            .scan-sub, .scan-note {
                font-size: 13px;
            }
            .btn-rescan {
                width: 100%;
            }
            .modal-overlay {
                padding: 10px;
                align-items: center;
                justify-content: center;
            }
            .modal-content {
                width: min(92vw, 340px);
                max-width: 340px;
                max-height: 78vh;
                border-radius: 16px;
                margin: 0 auto;
            }
            .modal-body {
                padding: 0 14px 14px;
            }
            .modal-header {
                padding: 16px 14px 10px;
            }
            .modal-title {
                font-size: 18px;
                line-height: 1.3;
            }
            .detail-row {
                align-items: center;
                gap: 8px;
                padding: 9px 0;
            }
            .detail-content {
                width: 100%;
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
            }
            .detail-label,
            .detail-value {
                font-size: 12.5px;
            }
            .detail-value {
                line-height: 1.4;
                word-break: break-word;
                text-align: right;
                flex: 1;
                max-width: 58%;
            }
            .detail-label {
                flex-shrink: 0;
                max-width: 42%;
            }
            .modal-actions {
                flex-direction: column;
                gap: 10px;
                margin-top: 16px;
            }
            .btn-kembali,
            .btn-detail {
                width: 100%;
                min-height: 44px;
                font-size: 13px;
            }
        }

        @media (max-width: 420px) {
            body {
                padding: 8px;
            }
            .scan-card {
                padding: 14px;
            }
            .scan-title {
                font-size: 18px;
            }
            .scan-sub,
            .scan-note {
                font-size: 12px;
            }
            .modal-content {
                width: min(90vw, 300px);
                max-width: 300px;
            }
            .modal-header {
                padding: 14px 12px 8px;
            }
            .modal-title {
                font-size: 17px;
            }
            .modal-body {
                padding: 0 12px 12px;
            }
            .detail-icon {
                width: 18px;
            }
        }
    </style>
</head>
<body>
<div class="scan-wrap">
    <div class="scan-card">
        <div class="scan-header">
            <div class="scan-meta">
                <div class="scan-title"><i class="fas fa-qrcode" style="color:#ff9800;margin-right:8px"></i>Scan QR Barang</div>
                <div class="scan-sub">Arahkan kamera ke QR Code yang tertempel di barang untuk melihat spesifikasi lengkap.</div>
                <div class="scan-note">Hasil scan akan muncul dalam popup setelah QR Code terbaca.</div>
            </div>
            <div class="scan-action">
                <button class="btn-rescan" onclick="rescan()"><i class="fas fa-redo" style="margin-right:8px"></i>Mulai Ulang Scan</button>
            </div>
        </div>

        <div id="reader"></div>
        <div class="error-toast" id="errorToast">
            <span id="errorMsg">Barang tidak ditemukan</span>
        </div>
    </div>
</div>

<!-- Modal Detail Barang -->
<div x-data="modalData()" x-show="open" x-cloak class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title" x-text="barang.nama_barang || 'Detail Barang'"></div>
            <div class="modal-badge" :class="getStatusBadgeClass(barang.status)" x-text="getStatusText(barang.status)"></div>
        </div>

        <div class="modal-body">
            <div class="detail-row">
                <div class="detail-icon"><i class="fas fa-folder"></i></div>
                <div class="detail-content">
                    <span class="detail-label">Kategori</span>
                    <span class="detail-value" x-text="barang.kategori || '-'"></span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-icon"><i class="fas fa-list-ol"></i></div>
                <div class="detail-content">
                    <span class="detail-label">Nomor Register</span>
                    <span class="detail-value" x-text="barang.nomor_register || '-'"></span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-icon"><i class="fas fa-industry"></i></div>
                <div class="detail-content">
                    <span class="detail-label">Merk/Type</span>
                    <span class="detail-value" x-text="barang.merk_type || '-'"></span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-icon"><i class="fas fa-box"></i></div>
                <div class="detail-content">
                    <span class="detail-label">Bahan</span>
                    <span class="detail-value" x-text="barang.bahan || '-'"></span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-icon"><i class="fas fa-truck-loading"></i></div>
                <div class="detail-content">
                    <span class="detail-label">Asal Usul</span>
                    <span class="detail-value" x-text="barang.asal_usul || '-'"></span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="detail-content">
                    <span class="detail-label">Lokasi</span>
                    <span class="detail-value" x-text="barang.lokasi || '-'"></span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="detail-content">
                    <span class="detail-label">Kondisi</span>
                    <span class="detail-value" x-text="getKondisiText(barang.kondisi)"></span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-icon"><i class="fas fa-info-circle"></i></div>
                <div class="detail-content">
                    <span class="detail-label">Status</span>
                    <span class="detail-value" x-text="getStatusText(barang.status)"></span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-icon"><i class="fas fa-align-left"></i></div>
                <div class="detail-content">
                    <span class="detail-label">Keterangan</span>
                    <span class="detail-value" x-text="barang.deskripsi || '-'"></span>
                </div>
            </div>

            <div class="stock-progress">
                <div class="progress-bar">
                    <div class="progress-fill" :class="getStatusProgressColor(barang.status)" :style="'width: ' + getStatusProgressWidth(barang.status) + '%'"></div>
                </div>
                <div class="stock-text" x-text="getStatusProgressText(barang.status)"></div>
            </div>

            <div class="modal-actions">
                <button class="btn-kembali" @click="closeModal()">
                    Kembali
                </button>
                <a :href="barang.detail_url || '#'" class="btn-detail">
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let scanner = null;
let modalInstance = null;

// Alpine.js data untuk modal
function modalData() {
    return {
        open: false,
        barang: {},

        init() {
            modalInstance = this;
        },

        getKondisiBadgeClass(kondisi) {
            const classes = {
                'baik': 'badge-baik',
                'rusak_ringan': 'badge-rusak_ringan',
                'rusak_berat': 'badge-rusak_berat'
            };
            return classes[kondisi] || 'badge-baik';
        },

        getKondisiText(kondisi) {
            const texts = {
                'baik': 'Baik',
                'rusak_ringan': 'Rusak Ringan',
                'rusak_berat': 'Rusak Berat'
            };
            return texts[kondisi] || kondisi;
        },

        getStatusText(status) {
            const texts = {
                'tersedia': 'Tersedia',
                'dipinjam': 'Dipinjam',
                'hilang': 'Hilang'
            };
            return texts[status] || 'Tidak Diketahui';
        },

        getStatusBadgeClass(status) {
            const classes = {
                'tersedia': 'badge-baik',
                'dipinjam': 'badge-dipinjam',
                'hilang': 'badge-rusak_berat'
            };
            return classes[status] || 'badge-baik';
        },

        getStatusProgressWidth(status) {
            if (status === 'tersedia') return 100;
            if (status === 'dipinjam') return 60;
            return 100;
        },

        getStatusProgressColor(status) {
            if (status === 'tersedia') return 'green';
            if (status === 'dipinjam') return 'blue';
            return 'red';
        },

        getStatusProgressText(status) {
            const texts = {
                'tersedia': 'Status Barang: Tersedia',
                'dipinjam': 'Status Barang: Sedang dipinjam',
                'hilang': 'Status Barang: Barang hilang'
            };
            return texts[status] || 'Status Barang: Tidak diketahui';
        },

        closeModal() {
            this.open = false;
            this.barang = {};
            // Restart scanner when modal is closed
            startScanner();
        }
    }
}

function startScanner() {
    document.getElementById('errorToast').classList.remove('show');

    scanner = new Html5Qrcode("reader");
    scanner.start(
        { facingMode: "environment" },   // kamera belakang
        { fps: 10, qrbox: { width: 250, height: 250 } },
        function(decodedText) {
            scanner.stop();
            handleScanResult(decodedText);
        },
        function(error) { /* abaikan error scan */ }
    );
}

function handleScanResult(scannedText) {
    // Cek apakah hasil scan adalah URL detail barang
    // Jika ya, langsung redirect
    if (scannedText.includes('/admin/barang/')) {
        window.location.href = scannedText;
        return;
    }

    // Jika hasil scan adalah kode_barcode mentah, cari via API
    fetch('{{ route("admin.barang.scan.result") }}?kode=' + encodeURIComponent(scannedText))
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                document.getElementById('errorMsg').textContent = data.error;
                document.getElementById('errorToast').classList.add('show');
                setTimeout(() => {
                    document.getElementById('errorToast').classList.remove('show');
                    startScanner();
                }, 3000);
                return;
            }

            // Update modal data dan buka modal
            if (modalInstance) {
                modalInstance.barang = data;
                modalInstance.open = true;
            }
        })
        .catch(() => {
            document.getElementById('errorMsg').textContent = 'Gagal terhubung ke server';
            document.getElementById('errorToast').classList.add('show');
            setTimeout(() => {
                document.getElementById('errorToast').classList.remove('show');
                startScanner();
            }, 3000);
        });
}

function rescan() {
    document.getElementById('errorToast').classList.remove('show');
    // Tutup modal jika terbuka
    if (modalInstance) {
        modalInstance.open = false;
        modalInstance.barang = {};
    }
    startScanner();
}

// Mulai scanner saat halaman dibuka
startScanner();
</script>
</body>
</html>
