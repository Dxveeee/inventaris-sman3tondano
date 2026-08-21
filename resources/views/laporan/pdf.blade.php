<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #263238;
            padding: 20px;
        }
        .header { text-align: center; margin-bottom: 20px; }
        .header .school-name {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 13px;
            font-weight: bold;
            line-height: 1.4;
            text-align: left;
        }
        .header .school-name img {
            width: 56px;
            height: auto;
            object-fit: contain;
            display: block;
        }
        .header .report-title {
            font-size: 10px;
            font-weight: bold;
            margin-top: 10px;
            text-align: left;
            line-height: 1.6;
        }
        .header .report-title .label {
            display: inline-block;
            width: 130px;
        }
        .report-info {
            font-size: 10px;
            margin-top: 10px;
            line-height: 1.6;
        }
        .divider {
            border-top: 2px solid #263238;
            margin: 12px 0;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-top: 10px;
        }
        table.data-table thead {
            background-color: #37474f;
            color: #ffffff;
            display: table-header-group;
        }
        table.data-table th {
            padding: 7px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #546e7a;
        }
        table.data-table td {
            padding: 6px;
            border: 1px solid #e0e6ed;
            vertical-align: top;
        }
        table.data-table tbody tr {
            page-break-inside: avoid;
        }
        table.data-table tbody tr:nth-child(even) {
            background-color: #f5f7fa;
        }
        .signature-section {
            page-break-inside: avoid;
            margin-top: 40px;
        }
        .footer {
            margin-top: 16px;
            font-size: 9px;
            color: #7b8a97;
            text-align: right;
        }
        .summary {
            margin-top: 10px;
            font-size: 10px;
            color: #263238;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="width:100%; border-collapse:collapse; border:none; margin-bottom:10px;">
            <tr>
                <td style="width:70px; vertical-align:middle; border:none;">
                    <img src="{{ public_path('images/logosulut.png') }}"
                         alt="Logo Sulut"
                         style="width:70px; height:70px; object-fit:contain;">
                </td>

                <td style="text-align:center; vertical-align:middle; border:none;">
                    <div style="font-size:13px; font-weight:bold; line-height:1.6;">
                        PEMERINTAH PROVINSI SULAWESI UTARA
                    </div>
                    <div style="font-size:13px; font-weight:bold; line-height:1.6;">
                        SMA NEGERI 3 TONDANO
                    </div>
                    <div style="font-size:11px; font-weight:bold; line-height:1.6;">
                        REKAPITULASI KARTU INVENTARIS BARANG (KIB) B
                    </div>
                    <div style="font-size:11px; font-weight:bold; line-height:1.6;">
                        PERALATAN DAN MESIN
                    </div>
                </td>

                <td style="width:70px; vertical-align:middle; border:none;">
                    <img src="{{ public_path('images/logo-sekolah.png') }}"
                         alt="Logo SMART"
                         style="width:60px; height:70px; object-fit:contain;">
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="report-title">
            <div>
                <span class="label">Provinsi</span>
                : PROVINSI SULAWESI UTARA
            </div>
            <div>
                <span class="label">Kab. Kota</span>
                : PEMERINTAH PROVINSI SULAWESI UTARA
            </div>
            <div>
                <span class="label">Bidang</span>
                : Bidang Pendidikan dan Kebudayaan
            </div>
            <div>
                <span class="label">Unit Organisasi</span>
                : Dinas Pendidikan
            </div>
            <div>
                <span class="label">Sub Unit Organisasi</span>
                : SMA Negeri 3 Tondano
            </div>
            <div>
                <span class="label">No. Kode Lokasi</span>
                : 11.01.19.00.08.01.045.01.2011
            </div>
        </div>
    </div>

    <div class="summary">
        Total Data: <strong>{{ $barang->count() }} barang</strong>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:4%">No</th>
                <th style="width:10%">Kode Barang</th>
                <th style="width:16%">Nama Barang</th>
                <th style="width:10%">Nomor Register</th>
                <th style="width:11%">Merk/Type</th>
                <th style="width:10%">Bahan</th>
                <th style="width:6%">Tahun</th>
                <th style="width:10%">Asal Usul</th>
                <th style="width:9%">Kondisi</th>
                <th style="width:8%">Jumlah</th>
                <th style="width:10%">Harga (Rp)</th>
                <th style="width:14%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barang as $index => $item)
            <tr>
                <td style="text-align:center">{{ $index + 1 }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->nomor_register ?? '-' }}</td>
                <td>{{ $item->merk_type ?? '-' }}</td>
                <td>{{ $item->bahan ?? '-' }}</td>
                <td style="text-align:center">{{ $item->tahun_pengadaan ?? '-' }}</td>
                <td>{{ $item->asal_usul ?? '-' }}</td>
                <td>
                    @if($item->kondisi == 'baik')
                        Baik
                    @elseif($item->kondisi == 'rusak_ringan')
                        Rusak Ringan
                    @else
                        Rusak Berat
                    @endif
                </td>
                <td>{{ $item->jumlah_total }} {{ $item->satuan }}</td>
                <td>{{ $item->harga ? number_format($item->harga, 0, ',', '.') : '-' }}</td>
                <td>{{ $item->deskripsi ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="12" style="text-align:center;padding:20px;color:#7b8a97">
                    Tidak ada data barang.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-section">
        <table style="width:100%; border-collapse:collapse; border:none;">
            <tr>
                <td style="width:50%; text-align:center; border:none; vertical-align:top; padding-left:30px;">
                    <div style="font-size:10px; margin-bottom:4px;">
                        Tondano, {{ $tanggalCetak }}
                    </div>
                    <div style="font-size:10px; font-weight:bold; margin-bottom:80px;">
                        Kepala Sekolah
                    </div>
                    <div style="font-size:10px; font-weight:bold;
                                border-top:1px solid #263238;
                                display:inline-block;
                                padding-top:4px;
                                min-width:200px;">
                        Naomi Sulistyorini, S.Pd, M.Pd
                    </div>
                    <div style="font-size:9px; margin-top:2px;">
                        NIP. 19710101 199412 2 004
                    </div>
                </td>

                <td style="width:50%; text-align:center; border:none; vertical-align:top; padding-right:30px;">
                    <div style="font-size:10px; margin-bottom:4px;">
                        &nbsp;
                    </div>
                    <div style="font-size:10px; font-weight:bold; margin-bottom:80px;">
                        Penanggung Jawab
                    </div>
                    <div style="font-size:10px; font-weight:bold;
                                border-top:1px solid #263238;
                                display:inline-block;
                                padding-top:4px;
                                min-width:200px;">
                        Djemmy R. Mongi, S.Pd
                    </div>
                    <div style="font-size:9px; margin-top:2px;">
                        NIP. 19710528 200312 1 004
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="report-info">
        Periode &nbsp;&nbsp;&nbsp;: {{ $periode }}<br>
        Tanggal Cetak: {{ $tanggalCetak }}
    </div>

    <div class="footer">
        Dicetak pada: {{ $tanggalCetak }} &bull;
        Sistem Informasi Inventaris SMA Negeri 3 Tondano
    </div>
</body>
</html>
