<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #000;
            padding: 30px 40px;
        }
        .kop-table { width: 100%; border-collapse: collapse; border: none; margin-bottom: 4px; }
        .kop-logo { width: 70px; vertical-align: middle; border: none; }
        .kop-text { vertical-align: middle; text-align: center; border: none; }
        .kop-text .instansi { font-size: 11px; font-weight: bold; line-height: 1.4; }
        .kop-text .sekolah { font-size: 14px; font-weight: bold; line-height: 1.6; }
        .kop-text .alamat { font-size: 10px; line-height: 1.4; }
        .kop-divider { border-top: 3px double #000; margin: 8px 0 16px; }

        .judul { text-align: center; font-size: 13px; font-weight: bold; text-decoration: underline; margin-bottom: 4px; }
        .nomor-surat { text-align: center; font-size: 11px; margin-bottom: 20px; }

        .pembuka { margin-bottom: 14px; line-height: 1.8; font-size: 12px; }
        .pembuka table { border: none; border-collapse: collapse; margin-bottom: 8px; }
        .pembuka td { border: none; padding: 1px 0; vertical-align: top; }
        .pembuka .label { width: 140px; }
        .pembuka .colon { width: 10px; }

        .tabel-barang { width: 100%; border-collapse: collapse; margin: 14px 0; font-size: 11px; }
        .tabel-barang th { background: #e0e0e0; border: 1px solid #000; padding: 6px 8px; text-align: center; font-weight: bold; }
        .tabel-barang td { border: 1px solid #000; padding: 5px 8px; vertical-align: top; }

        .info-tambahan { margin-bottom: 14px; line-height: 1.8; }
        .info-tambahan table { border: none; border-collapse: collapse; }
        .info-tambahan td { border: none; padding: 1px 0; vertical-align: top; }
        .info-tambahan .label { width: 140px; }
        .info-tambahan .colon { width: 10px; }

        .pernyataan { margin-bottom: 20px; line-height: 1.8; font-size: 12px; }

        .ttd-table { width: 100%; border-collapse: collapse; border: none; margin-top: 30px; }
        .ttd-table td { width: 50%; text-align: center; border: none; vertical-align: top; padding: 0 20px; }
        .ttd-space { height: 70px; }
        .ttd-name { font-weight: bold; border-top: 1px solid #000; padding-top: 4px; display: inline-block; min-width: 180px; }
        .ttd-nip { font-size: 10px; margin-top: 2px; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('images/logosulut.png') }}" width="60" height="60">
            </td>
            <td class="kop-text">
                <div class="instansi">
                    PEMERINTAH PROVINSI SULAWESI UTARA<br>
                    DINAS PENDIDIKAN DAERAH
                </div>
                <div class="sekolah">SMA NEGERI 3 TONDANO</div>
                <div class="alamat">
                    Jl. Parkir Timur Stadion Maesa Tondano Kembuan, Kec. Tondano Utara, Kab. Minahasa, Prov. Sulawesi Utara<br>
                    e-mail: sman3_tondano@yahoo.com 95615 Telp. 0431-322498
                </div>
            </td>
            <td class="kop-logo">
                <img src="{{ public_path('images/logo-sekolah.png') }}" width="60" height="60">
            </td>
        </tr>
    </table>
    <div class="kop-divider"></div>

    <div class="judul">SURAT PEMINJAMAN BARANG INVENTARIS</div>
    <div class="nomor-surat">Nomor: SPB/SMAN3TONDANO/</div>

    <div class="pembuka">
        Yang bertanda tangan di bawah ini:
        <table style="margin-top:8px;">
            <tr>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td><strong>{{ $peminjaman->peminjam->name ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td class="label">Peran</td>
                <td class="colon">:</td>
                <td>{{ $peminjaman->peminjam->jabatan ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="pernyataan">
        Dengan ini menyatakan meminjam barang inventaris milik SMA Negeri 3 Tondano sebagai berikut:
    </div>

    <table class="tabel-barang">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:25%">Nama Barang</th>
                <th style="width:15%">No. Register</th>
                <th style="width:15%">Merk/Type</th>
                <th style="width:15%">Kondisi</th>
                <th style="width:25%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman->detail as $i => $detail)
            <tr>
                <td style="text-align:center">{{ $i + 1 }}</td>
                <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                <td style="text-align:center">{{ $detail->nomor_register }}</td>
                <td>{{ $detail->barang->merk_type ?? '-' }}</td>
                <td style="text-align:center">{{ ucfirst(str_replace('_', ' ', $detail->barang->kondisi ?? '-')) }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="info-tambahan">
        <table>
            <tr>
                <td class="label">Lokasi Penyimpanan</td>
                <td class="colon">:</td>
                <td>{{ $peminjaman->lokasi->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Pinjam</td>
                <td class="colon">:</td>
                <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam_rencana ?? $peminjaman->tanggal_disetujui)->locale('id')->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Rencana Kembali</td>
                <td class="colon">:</td>
                <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->locale('id')->isoFormat('D MMMM Y') }}</td>
            </tr>
            @if($peminjaman->keterangan)
            <tr>
                <td class="label">Keterangan</td>
                <td class="colon">:</td>
                <td>{{ $peminjaman->keterangan }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="pernyataan">
        Peminjam bertanggung jawab penuh atas keselamatan dan kondisi barang yang dipinjam, serta bersedia mengembalikan tepat waktu sesuai tanggal yang telah ditentukan.
    </div>

    <table class="ttd-table">
        <tr>
            <td>
                <div>Tondano, {{ $tanggalCetak }}</div>
                <div style="margin-top:4px;font-weight:bold;">Peminjam,</div>
                <div class="ttd-space"></div>
                <div class="ttd-name">{{ $peminjaman->peminjam->name ?? '...' }}</div>
                <div class="ttd-nip">{{ $peminjaman->peminjam->jabatan ?? '' }}</div>
            </td>
            <td>
                <div>&nbsp;</div>
                <div style="margin-top:4px;font-weight:bold;">Pengurus Barang,</div>
                <div class="ttd-space"></div>
                <div class="ttd-name">.................................</div>
                <div class="ttd-nip">NIP. .........................</div>
            </td>
        </tr>
    </table>

</body>
</html>
