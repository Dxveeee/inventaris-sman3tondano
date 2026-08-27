<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; color: #000; padding: 30px 40px; }
        .sekolah { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 28px; }
        .judul { text-align: center; font-size: 13px; font-weight: bold; text-decoration: underline; margin-bottom: 22px; }
        .pembuka, .pernyataan, .info-tambahan { line-height: 1.8; margin-bottom: 14px; }
        .pembuka table, .info-tambahan table { border-collapse: collapse; }
        .pembuka td, .info-tambahan td { border: none; padding: 1px 0; vertical-align: top; }
        .label { width: 170px; }
        .colon { width: 10px; }
        .tabel-barang { width: 100%; border-collapse: collapse; margin: 14px 0; font-size: 11px; }
        .tabel-barang th, .tabel-barang td { border: 1px solid #000; padding: 6px 8px; vertical-align: top; }
        .tabel-barang th { background: #e0e0e0; text-align: center; font-weight: bold; }
        .ttd-table { width: 100%; border-collapse: collapse; border: none; margin-top: 38px; }
        .ttd-table td { text-align: center; border: none; vertical-align: top; }
        .ttd-space { height: 70px; }
        .ttd-name { font-weight: bold; border-top: 1px solid #000; padding-top: 4px; display: inline-block; min-width: 180px; }
        .ttd-jabatan { font-size: 10px; margin-top: 2px; }
    </style>
</head>
<body>
    <div class="sekolah">SMA NEGERI 3 TONDANO</div>
    <div class="judul">SURAT PERMOHONAN PEMINJAMAN BARANG INVENTARIS</div>

    <div class="pembuka">
        Yang bertanda tangan di bawah ini:
        <table style="margin-top:8px;">
            <tr><td class="label">Nama Peminjam</td><td class="colon">:</td><td><strong>{{ $peminjaman->peminjam->name ?? '-' }}</strong></td></tr>
            <tr><td class="label">Peran</td><td class="colon">:</td><td>{{ $peminjaman->peminjam->jabatan ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="pernyataan">Mengajukan permohonan peminjaman barang inventaris sebagai berikut:</div>

    <table class="tabel-barang">
        <thead><tr><th style="width:8%">No</th><th>Nama Barang</th><th style="width:30%">No. Register</th></tr></thead>
        <tbody>
            @foreach($peminjaman->detail as $i => $detail)
                <tr>
                    <td style="text-align:center">{{ $i + 1 }}</td>
                    <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                    <td style="text-align:center">{{ $detail->nomor_register }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="info-tambahan">
        <table>
            <tr><td class="label">Lokasi Penyimpanan</td><td class="colon">:</td><td>{{ $peminjaman->lokasi->nama ?? '-' }}</td></tr>
            <tr><td class="label">Tanggal Pinjam</td><td class="colon">:</td><td>{{ $peminjaman->tanggal_pinjam_rencana ? $peminjaman->tanggal_pinjam_rencana->locale('id')->isoFormat('D MMMM Y') : '-' }}</td></tr>
            <tr><td class="label">Tanggal Rencana Pengembalian</td><td class="colon">:</td><td>{{ $peminjaman->tanggal_kembali_rencana ? $peminjaman->tanggal_kembali_rencana->locale('id')->isoFormat('D MMMM Y') : '-' }}</td></tr>
            @if($peminjaman->keterangan)
                <tr><td class="label">Keterangan</td><td class="colon">:</td><td>{{ $peminjaman->keterangan }}</td></tr>
            @endif
        </table>
    </div>

    <div class="pernyataan">Demikian permohonan ini dibuat untuk dipergunakan sebagaimana mestinya.</div>

    <table class="ttd-table">
        <tr><td>
            <div>Tondano, {{ now()->locale('id')->isoFormat('D MMMM Y') }}</div>
            <div style="margin-top:4px;font-weight:bold;">Peminjam,</div>
            <div class="ttd-space"></div>
            <div class="ttd-name">{{ $peminjaman->peminjam->name ?? '...' }}</div>
            <div class="ttd-jabatan">{{ $peminjaman->peminjam->jabatan ?? '' }}</div>
        </td></tr>
    </table>
</body>
</html>
