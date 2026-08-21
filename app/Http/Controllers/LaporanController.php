<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Exports\BarangExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    private function getFilteredBarang(Request $request)
    {
        $query = Barang::with(['kategori', 'lokasi']);

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('lokasi')) {
            $query->where('id_lokasi', $request->lokasi);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_pengadaan', $request->tahun);
        }

        return $query;
    }

    private function buildPeriode(Request $request)
    {
        $periode = 'Semua Data';
        $parts = [];

        if ($request->filled('kategori')) {
            $kat = Kategori::find($request->kategori);
            if ($kat) $parts[] = 'Kategori: ' . $kat->nama;
        }

        if ($request->filled('lokasi')) {
            $lok = Lokasi::find($request->lokasi);
            if ($lok) $parts[] = 'Lokasi: ' . $lok->nama;
        }

        if ($request->filled('kondisi')) {
            $parts[] = 'Kondisi: ' . ucfirst(str_replace('_', ' ', $request->kondisi));
        }

        if ($request->filled('status')) {
            $parts[] = 'Status: ' . ucfirst(str_replace('_', ' ', $request->status));
        }

        if ($request->filled('tahun')) {
            $parts[] = 'Tahun: ' . $request->tahun;
        }

        if (!empty($parts)) {
            $periode = implode(' | ', $parts);
        }

        return $periode;
    }

    public function index(Request $request)
    {
        $barangQuery = $this->getFilteredBarang($request);
        $totalFiltered = $barangQuery->count();
        $barang = $barangQuery
            ->orderBy('tahun_pengadaan', 'desc')
            ->orderBy('nomor_register', 'asc')
            ->paginate(10)
            ->withQueryString();

        // Get all stat cards (always from full data, not filtered)
        $totalBarang      = Barang::count();
        $totalBaik        = Barang::where('kondisi', 'baik')->count();
        $totalRusakRingan = Barang::where('kondisi', 'rusak_ringan')->count();
        $totalRusakBerat  = Barang::where('kondisi', 'rusak_berat')->count();
        $totalTersedia    = Barang::where('status', 'tersedia')->count();
        $totalDipinjam    = Barang::where('status', 'dipinjam')->count();
        $totalHilang      = Barang::where('status', 'hilang')->count();

        // Load filter options
        $kategori = Kategori::all();
        $lokasi   = Lokasi::all();
        $tahunList = Barang::select('tahun_pengadaan')
                    ->whereNotNull('tahun_pengadaan')
                    ->distinct()
                    ->orderBy('tahun_pengadaan', 'desc')
                    ->pluck('tahun_pengadaan');

        // Build periode string
        $periode = $this->buildPeriode($request);

        return view('laporan.index', compact(
            'barang', 'kategori', 'lokasi', 'tahunList',
            'totalBarang', 'totalBaik', 'totalRusakRingan', 'totalRusakBerat',
            'totalTersedia', 'totalDipinjam', 'totalHilang',
            'periode', 'totalFiltered'
        ));
    }

    public function exportPdf(Request $request)
    {
        $barang = $this->getFilteredBarang($request)->get();
        $periode = $this->buildPeriode($request);
        $tanggalCetak = now()->locale('id')->isoFormat('D MMMM Y');

        $pdf = Pdf::loadView('laporan.pdf', compact('barang', 'periode', 'tanggalCetak'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Inventaris-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $barang = $this->getFilteredBarang($request)->get();

        $filters = [
            'kategori' => '',
            'lokasi'   => '',
            'kondisi'  => $request->kondisi ?? '',
            'status'   => $request->status ?? '',
            'tahun'    => $request->tahun ?? '',
        ];

        if ($request->filled('kategori')) {
            $kat = Kategori::find($request->kategori);
            if ($kat) {
                $filters['kategori'] = $kat->nama_kategori;
            }
        }

        if ($request->filled('lokasi')) {
            $lok = Lokasi::find($request->lokasi);
            if ($lok) {
                $filters['lokasi'] = $lok->nama_lokasi;
            }
        }

        return Excel::download(
            new BarangExport($barang, $filters),
            'Laporan-Inventaris-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
