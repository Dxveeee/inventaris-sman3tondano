<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BarangExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithEvents,
    WithColumnWidths
{
    protected $barang;
    protected $filters;
    protected $tanggalCetak;

    public function __construct($barang, $filters = [])
    {
        $this->barang = $barang;
        $this->filters = $filters;
        $this->tanggalCetak = now()->locale('id')->isoFormat('D MMMM Y');
    }

    public function collection()
    {
        return $this->barang->map(function ($item, $index) {
            $kondisi = match ($item->kondisi) {
                'baik' => 'Baik',
                'rusak_ringan' => 'Rusak Ringan',
                'rusak_berat' => 'Rusak Berat',
                default => '-'
            };

            $jumlah = trim(($item->jumlah_total ? $item->jumlah_total : 0) . ($item->satuan ? ' ' . $item->satuan : ''));

            return [
                'no' => $index + 1,
                'kode_barang' => $item->kode_barang ?? '-',
                'nama_barang' => $item->nama_barang ?? '-',
                'nomor_register' => $item->nomor_register ?? '-',
                'merk_type' => $item->merk_type ?? '-',
                'bahan' => $item->bahan ?? '-',
                'tahun_pengadaan' => $item->tahun_pengadaan ?? '-',
                'asal_usul' => $item->asal_usul ?? '-',
                'kondisi' => $kondisi,
                'jumlah' => $jumlah ?: '-',
                'harga' => $item->harga ?: '-',
                'keterangan' => $item->deskripsi ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Nama Barang',
            'Nomor Register',
            'Merk/Type',
            'Bahan',
            'Tahun',
            'Asal Usul',
            'Kondisi',
            'Jumlah',
            'Harga (Rp)',
            'Keterangan',
        ];
    }

    public function title(): string
    {
        return 'Laporan Inventaris';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 24,
            'D' => 14,
            'E' => 16,
            'F' => 12,
            'G' => 8,
            'H' => 14,
            'I' => 14,
            'J' => 12,
            'K' => 16,
            'L' => 28,
        ];
    }

    public function registerEvents(): array
    {
        $filters = $this->filters;
        $tanggal = $this->tanggalCetak;
        $dataCount = $this->barang->count();
        $headerRows = 15;

        $periode = 'Semua Data';
        $parts = [];
        if (!empty($filters['kategori'])) $parts[] = 'Kategori: ' . $filters['kategori'];
        if (!empty($filters['lokasi'])) $parts[] = 'Lokasi: ' . $filters['lokasi'];
        if (!empty($filters['kondisi'])) $parts[] = 'Kondisi: ' . ucfirst(str_replace('_', ' ', $filters['kondisi']));
        if (!empty($filters['status'])) $parts[] = 'Status: ' . ucfirst(str_replace('_', ' ', $filters['status']));
        if (!empty($filters['tahun'])) $parts[] = 'Tahun: ' . $filters['tahun'];
        if (!empty($parts)) $periode = implode(' | ', $parts);

        return [
            AfterSheet::class => function (AfterSheet $event) use ($periode, $tanggal, $dataCount, $headerRows) {
                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1, $headerRows);

                $sheet->setCellValue('A1', 'PEMERINTAH PROVINSI SULAWESI UTARA');
                $sheet->setCellValue('A2', 'SMA NEGERI 3 TONDANO');
                $sheet->setCellValue('A3', 'REKAPITULASI KARTU INVENTARIS BARANG (KIB) B');
                $sheet->setCellValue('A4', 'PERALATAN DAN MESIN');

                $sheet->setCellValue('A6', 'Provinsi');
                $sheet->setCellValue('B6', ': PROVINSI SULAWESI UTARA');
                $sheet->setCellValue('A7', 'Kab. Kota');
                $sheet->setCellValue('B7', ': PEMERINTAH PROVINSI SULAWESI UTARA');
                $sheet->setCellValue('A8', 'Bidang');
                $sheet->setCellValue('B8', ': Bidang Pendidikan dan Kebudayaan');
                $sheet->setCellValue('A9', 'Unit Organisasi');
                $sheet->setCellValue('B9', ': Dinas Pendidikan');
                $sheet->setCellValue('A10', 'Sub Unit Organisasi');
                $sheet->setCellValue('B10', ': SMA Negeri 3 Tondano');
                $sheet->setCellValue('A11', 'No. Kode Lokasi');
                $sheet->setCellValue('B11', ': 11.01.19.00.08.01.045.01.2011');
                $sheet->setCellValue('A12', 'Total Data');
                $sheet->setCellValue('B12', ': ' . $dataCount . ' barang');
                $sheet->setCellValue('A13', 'Periode');
                $sheet->setCellValue('B13', ': ' . $periode);
                $sheet->setCellValue('A14', 'Tanggal Cetak');
                $sheet->setCellValue('B14', ': ' . $tanggal);

                foreach (range(1, 4) as $row) {
                    $sheet->mergeCells("A{$row}:L{$row}");
                }

                $sheet->getStyle('A1:A4')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('A6:B14')->applyFromArray([
                    'font' => ['size' => 10],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                ]);

                $tableHeaderRow = 16;
                $sheet->getStyle("A{$tableHeaderRow}:L{$tableHeaderRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '37474F']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                $lastRow = $tableHeaderRow + $dataCount;
                if ($dataCount > 0) {
                    $sheet->getStyle("A" . ($tableHeaderRow + 1) . ":L{$lastRow}")->applyFromArray([
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                }

                $sheet->getRowDimension(1)->setRowHeight(20);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(20);
                $sheet->getRowDimension(4)->setRowHeight(20);
            },
        ];
    }
}
