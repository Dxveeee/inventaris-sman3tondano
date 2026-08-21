<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\PeminjamanDetail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPeminjamanController extends Controller
{
    public function index()
    {
        $menunggu = Peminjaman::where('status', 'Menunggu')
            ->with(['peminjam', 'lokasi'])
            ->orderBy('created_at', 'asc')
            ->get();

        $disetujui = Peminjaman::where('status', 'Disetujui')
            ->with(['peminjam', 'lokasi', 'detail.barang'])
            ->orderBy('tanggal_disetujui', 'desc')
            ->get();

        $dipinjam = Peminjaman::where('status', 'Dipinjam')
            ->with(['peminjam', 'lokasi', 'detail.barang'])
            ->orderBy('tanggal_disetujui', 'desc')
            ->get();

        $dikembalikan = Peminjaman::where('status', 'Dikembalikan')
            ->with(['peminjam', 'lokasi', 'detail.barang'])
            ->orderBy('tanggal_kembali_aktual', 'desc')
            ->get();

        $ditolak = Peminjaman::where('status', 'Ditolak')
            ->with(['peminjam', 'lokasi'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $countMenunggu = $menunggu->count();

        return view('admin.peminjaman.index', compact(
            'menunggu', 'disetujui', 'dipinjam', 'dikembalikan', 'ditolak', 'countMenunggu'
        ));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::with('detail.barang')->findOrFail($id);

        if ($peminjaman->status !== 'Menunggu') {
            return back()->with('error', 'Status peminjaman tidak valid.');
        }

        $unavailable = $peminjaman->detail->filter(function ($detail) {
            return $detail->barang->status !== 'tersedia';
        });

        if ($unavailable->count() > 0) {
            $list = $unavailable->pluck('nomor_register')->implode(', ');
            return back()->with('error', "Unit dengan No. Register: $list sudah tidak tersedia. Tidak bisa disetujui.");
        }

        DB::transaction(function () use ($peminjaman) {
            foreach ($peminjaman->detail as $detail) {
                $detail->barang->update(['status' => 'dipinjam']);
            }

            // Auto-generate nomor_surat
            $bulan = (int) Carbon::now()->format('m');
            $tahun = Carbon::now()->format('Y');

            $count = Peminjaman::whereNotNull('nomor_surat')
                ->whereMonth('tanggal_disetujui', $bulan)
                ->whereYear('tanggal_disetujui', $tahun)
                ->count();

            $nomorSurat = "SPB/SMAN3TONDANO/";

            $peminjaman->update([
                'status' => 'Disetujui',
                'tanggal_disetujui' => Carbon::today()->toDateString(),
                'nomor_surat' => $nomorSurat,
            ]);
        });

        return back()->with('success', 'Peminjaman disetujui. ' . $peminjaman->detail->count() . ' unit telah dikonfirmasi.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'keterangan_penolakan' => 'nullable|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Menunggu') {
            return back()->with('error', 'Status peminjaman tidak valid.');
        }

        $peminjaman->update([
            'status' => 'Ditolak',
            'keterangan_penolakan' => $request->keterangan_penolakan,
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function dipinjam(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Cek status harus 'Disetujui' dulu
        if ($peminjaman->status !== 'Disetujui') {
            return redirect()->back()
                ->with('error',
                    'Status peminjaman harus
                    Disetujui terlebih dahulu.');
        }

        // Update status peminjaman saja
        // Unit sudah di-assign saat Approve
        $peminjaman->update([
            'status' => 'Dipinjam',
        ]);

        return redirect()->back()
            ->with('success',
                'Status peminjaman diubah
                menjadi Dipinjam.');
    }

    public function returnForm($id)
    {
        $peminjaman = Peminjaman::with(['detail.barang', 'peminjam', 'lokasi'])->findOrFail($id);

        return view('admin.peminjaman.return', compact('peminjaman'));
    }

    public function returnProcess(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali_aktual' => 'required|date',
            'kondisi_kembali' => [
                'required',
                'in:Baik,Rusak Ringan,Rusak Berat,Hilang'
            ],
            'keterangan' => 'nullable|string|max:255',
        ]);

        $peminjaman = Peminjaman::with('detail.barang')->findOrFail($id);

        if ($peminjaman->status !== 'Dipinjam') {
            return back()->with('error', 'Status peminjaman tidak valid.');
        }

        $kondisiMap = [
            'Baik'        => 'baik',
            'Rusak Ringan' => 'rusak_ringan',
            'Rusak Berat'  => 'rusak_berat',
            'Hilang'       => 'hilang',
        ];

        $kondisiDb = $kondisiMap[$request->kondisi_kembali]
            ?? 'baik';

        DB::transaction(function () use (
            $request, $peminjaman, $kondisiDb
        ) {
            foreach ($peminjaman->detail as $detail) {
                if ($detail->barang) {
                    if ($kondisiDb === 'hilang') {
                        $detail->barang->update([
                            'status' => 'hilang',
                        ]);
                    } else {
                        $detail->barang->update([
                            'status'  => 'tersedia',
                            'kondisi' => $kondisiDb,
                        ]);
                    }
                }

                // Tetap update status_unit
                $detail->update([
                    'status_unit' => 'dikembalikan',
                ]);
            }

            $peminjaman->update([
                'status'                 => 'Dikembalikan',
                'tanggal_kembali_aktual' => $request
                    ->tanggal_kembali_aktual,
                'kondisi_kembali'        => $request
                    ->kondisi_kembali,
                'keterangan'             => $request
                    ->keterangan,
            ]);
        });

        return redirect()->route('admin.peminjaman.index')->with('success', 'Pengembalian berhasil diproses.');
    }

    public function cetakSurat(string $id)
    {
        $peminjaman = Peminjaman::with([
            'peminjam',
            'lokasi',
            'detail.barang',
        ])->findOrFail($id);

        if (!in_array($peminjaman->status, ['Disetujui', 'Dipinjam'])) {
            return back()->with('error', 'Surat hanya tersedia untuk peminjaman yang sudah disetujui.');
        }

        $tanggalCetak = now()->locale('id')->isoFormat('D MMMM Y');

        $pdf = Pdf::loadView('peminjaman.surat', compact('peminjaman', 'tanggalCetak'))
            ->setPaper('a4', 'portrait');

        $namaPeminjam = Str::slug($peminjaman->peminjam->name ?? 'peminjam');
        $filename = 'SPB-SMAN3TONDANO-' . $namaPeminjam . '.pdf';

        return $pdf->download($filename);
    }
}
