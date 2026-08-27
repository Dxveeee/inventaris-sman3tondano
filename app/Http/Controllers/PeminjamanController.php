<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Lokasi;
use App\Models\PeminjamanDetail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();

        $total = Peminjaman::where('id_pengguna', $userId)->count();
        $totalMenunggu = Peminjaman::where('id_pengguna', $userId)->where('status', 'Menunggu')->count();
        $totalDisetujui = Peminjaman::where('id_pengguna', $userId)->where('status', 'Disetujui')->count();
        $totalDipinjam = Peminjaman::where('id_pengguna', $userId)->where('status', 'Dipinjam')->count();
        $totalDikembalikan = Peminjaman::where('id_pengguna', $userId)->where('status', 'Dikembalikan')->count();
        $totalDitolak = Peminjaman::where('id_pengguna', $userId)->where('status', 'Ditolak')->count();

        $latest = Peminjaman::where('id_pengguna', $userId)
            ->whereIn('status', ['Menunggu', 'Disetujui', 'Dipinjam'])
            ->with([
                'lokasi',
                'barang',
                'detail.barang'
            ])
            ->latest()
            ->take(5)
            ->get();

        $active = Peminjaman::where('id_pengguna', $userId)
                    ->whereIn('status', ['Disetujui', 'Dipinjam'])
                    ->with(['lokasi', 'detail'])
                    ->get()
                    ->map(function ($item) {
                        $today = Carbon::today();
                        $dueDate = Carbon::parse($item->tanggal_kembali_rencana);

                        if ($dueDate->isPast() && !$dueDate->isToday()) {
                            $item->due_status = 'Terlambat';
                            $item->hari_terlambat = $dueDate->diffInDays($today);
                        } elseif ($dueDate->isToday()) {
                            $item->due_status = 'Segera Kembali';
                        } else {
                            $item->due_status = 'Tepat Waktu';
                            $item->sisa_hari = $today->diffInDays($dueDate);
                        }

                        return $item;
                    });

        return view('peminjam.dashboard', compact(
            'total', 'totalMenunggu', 'totalDisetujui', 'totalDipinjam', 'totalDikembalikan', 'totalDitolak', 'latest', 'active'
        ));
    }

    public function barangTersedia(Request $request)
    {
        $lokasi = Lokasi::all()->map(function ($lok) {
            $lok->jumlah_tersedia = Barang::where('id_lokasi', $lok->id)
                ->where('status', 'tersedia')
                ->where('kondisi', 'baik')
                ->count();
            return $lok;
        });

        return view('peminjam.barang.index', compact('lokasi'));
    }

    public function pilihBarang(Request $request, $idLokasi)
    {
        $lokasi = Lokasi::findOrFail($idLokasi);

        $barangList = Barang::select(
                'nama_barang',
                DB::raw('COUNT(*) as jumlah_tersedia')
            )
            ->where('id_lokasi', $idLokasi)
            ->where('status', 'tersedia')
            ->where('kondisi', 'baik')
            ->groupBy('nama_barang')
            ->having('jumlah_tersedia', '>', 0)
            ->orderBy('nama_barang', 'asc')
            ->get();

        return view('peminjam.barang.pilih-barang',
            compact('lokasi', 'barangList'));
    }

    public function pilihUnit(Request $request, $idLokasi, $namaBarang)
    {
        $lokasi = Lokasi::findOrFail($idLokasi);
        $namaBarangDecoded = urldecode($namaBarang);

        $units = Barang::where('id_lokasi', $idLokasi)
            ->where('nama_barang', $namaBarangDecoded)
            ->where('status', 'tersedia')
            ->where('kondisi', 'baik')
            ->orderBy('nomor_register', 'asc')
            ->get();

        return view('peminjam.barang.pilih-unit', compact('lokasi', 'namaBarangDecoded', 'units'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'unit_ids' => 'required|array|min:1',
            'unit_ids.*' => 'exists:barang,id',
        ]);

        $units = Barang::whereIn('id', $request->unit_ids)
            ->where('status', 'tersedia')
            ->get();

        if ($units->count() !== count($request->unit_ids)) {
            return redirect()->back()
                ->with('error', 'Beberapa unit yang dipilih sudah tidak tersedia. Silakan pilih ulang.');
        }

        $firstUnit = $units->first();
        $namaBarang = $firstUnit->nama_barang;
        $id_lokasi = $firstUnit->id_lokasi;
        $barangInfo = $firstUnit;
        $jumlahTersedia = $units->count();

        return view('peminjam.peminjaman.create', compact('units', 'namaBarang', 'id_lokasi', 'barangInfo', 'jumlahTersedia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_ids' => 'required|array|min:1',
            'unit_ids.*' => 'exists:barang,id',
            'tanggal_pinjam_rencana' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam_rencana',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $units = Barang::whereIn('id', $request->unit_ids)
            ->where('status', 'tersedia')
            ->get();

        if ($units->count() !== count($request->unit_ids)) {
            return redirect()->back()
                ->with('error', 'Beberapa unit yang dipilih sudah tidak tersedia. Silakan pilih ulang.')
                ->withInput();
        }

        $firstUnit = $units->first();

        DB::transaction(function () use ($request, $units, $firstUnit) {
            $peminjaman = Peminjaman::create([
                'id_pengguna' => auth()->id(),
                'nama_barang' => $firstUnit->nama_barang,
                'id_lokasi' => $firstUnit->id_lokasi,
                'jumlah_pinjam' => $units->count(),
                'tanggal_pengajuan' => Carbon::today()->toDateString(),
                'tanggal_pinjam_rencana' => $request->tanggal_pinjam_rencana,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'keterangan' => $request->keterangan,
                'status' => 'Menunggu',
            ]);

            foreach ($units as $unit) {
                PeminjamanDetail::create([
                    'id_peminjaman' => $peminjaman->id,
                    'id_barang' => $unit->id,
                    'nomor_register' => $unit->nomor_register,
                    'status_unit' => 'dipinjam',
                ]);
            }
        });

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan Admin.');
    }

    public function riwayat()
    {
        $userId = auth()->id();

        $peminjaman = Peminjaman::where('id_pengguna', $userId)
                    ->with(['lokasi', 'detail.barang'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('peminjam.peminjaman.index', compact('peminjaman'));
    }

    public function profil()
    {
        $user = auth()->user();
        return view('peminjam.profil', compact('user'));
    }

    public function editPassword()
    {
        $user = auth()->user();
        return view('peminjam.ubah-password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('peminjam.profil')
            ->with('success', 'Password berhasil diperbarui.');
    }

    public function downloadSurat(string $id)
    {
        $peminjaman = Peminjaman::with([
            'peminjam',
            'lokasi',
            'detail.barang',
        ])->findOrFail($id);

        if ($peminjaman->id_pengguna !== auth()->id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        if (!in_array($peminjaman->status, ['Disetujui', 'Dipinjam'])) {
            return back()->with('error', 'Surat belum tersedia. Peminjaman belum disetujui.');
        }

        $tanggalCetak = now()->locale('id')->isoFormat('D MMMM Y');

        $pdf = Pdf::loadView('peminjaman.surat', compact('peminjaman', 'tanggalCetak'))
            ->setPaper('a4', 'portrait');

        $namaPeminjam = Str::slug($peminjaman->peminjam->name ?? 'peminjam');
        $filename = 'SPB-SMAN3TONDANO-' . $namaPeminjam . '.pdf';

        return $pdf->download($filename);
    }

    public function downloadSuratPermohonan(string $id)
    {
        $peminjaman = Peminjaman::with(['peminjam', 'lokasi', 'detail.barang'])->findOrFail($id);

        if ($peminjaman->id_pengguna !== auth()->id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $pdf = Pdf::loadView('peminjaman.permohonan', compact('peminjaman'))
            ->setPaper('a4', 'portrait');

        $namaPeminjam = Str::slug($peminjaman->peminjam->name ?? 'peminjam');

        return $pdf->download('Permohonan-Peminjaman-' . $namaPeminjam . '.pdf');
    }

    public function uploadSuratPermohonanTtd(Request $request, string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->id_pengguna !== auth()->id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $request->validate([
            'file_permohonan_ttd' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('file_permohonan_ttd')->store('surat_permohonan_ttd', 'public');
        $peminjaman->update(['file_permohonan_ttd' => $path]);

        return back()->with('success', 'Surat permohonan bertanda tangan berhasil diupload.');
    }

    public function downloadSuratPersetujuanTtd(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->id_pengguna !== auth()->id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        abort_unless($peminjaman->file_persetujuan_ttd, 404);

        return redirect(Storage::disk('public')->url($peminjaman->file_persetujuan_ttd));
    }
}
