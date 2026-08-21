<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangController extends Controller
{
    protected function normalizePhotoPath(?string $photoPath): ?string
    {
        if (empty($photoPath)) {
            return null;
        }

        return ltrim(str_replace(['public/', 'storage/'], '', $photoPath), '/');
    }

    protected function photoIsStillUsed(?string $photoPath, ?int $exceptBarangId = null): bool
    {
        $normalizedPath = $this->normalizePhotoPath($photoPath);

        if (empty($normalizedPath)) {
            return false;
        }

        $query = Barang::query()->where('foto', $normalizedPath);

        if (!is_null($exceptBarangId)) {
            $query->where('id', '!=', $exceptBarangId);
        }

        return $query->exists();
    }

    protected function deletePhotoIfUnused(?string $photoPath, ?int $exceptBarangId = null): void
    {
        $normalizedPath = $this->normalizePhotoPath($photoPath);

        if (empty($normalizedPath) || $this->photoIsStillUsed($normalizedPath, $exceptBarangId)) {
            return;
        }

        Storage::disk('public')->delete($normalizedPath);
    }

    public function index(Request $request)
    {
        $query = Barang::with(['kategori', 'lokasi']);

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('lokasi')) {
            $query->where('id_lokasi', $request->lokasi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // $barang = $query->paginate(10)->appends(request()->query());
        $barang = $query
            ->orderBy('tahun_pengadaan', 'desc')
            ->orderBy('nomor_register', 'asc')
            ->paginate(10)
            ->appends(request()->query());

        $kategori  = Kategori::all();
        $lokasi    = Lokasi::all();

        $totalBarang      = Barang::count();
        $totalKategori    = Kategori::count();
        $totalLokasi      = Lokasi::count();
        $totalBaik        = Barang::where('kondisi', 'baik')->count();
        $totalRusakRingan = Barang::where('kondisi', 'rusak_ringan')->count();
        $totalRusakBerat  = Barang::where('kondisi', 'rusak_berat')->count();
        $totalTersedia    = Barang::where('status', 'tersedia')->count();
        $totalDipinjam    = Barang::where('status', 'dipinjam')->count();
        $totalHilang      = Barang::where('status', 'hilang')->count();

        return view('barang.index', compact(
            'barang', 'kategori', 'lokasi',
            'totalBarang', 'totalKategori', 'totalLokasi', 'totalBaik', 'totalRusakRingan', 'totalRusakBerat', 'totalTersedia', 'totalDipinjam', 'totalHilang'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'        => 'required|string|max:255',
            'id_kategori'        => 'required|exists:kategori,id',
            'id_lokasi'          => 'required|exists:lokasi,id',
            'jumlah_total'       => 'required|integer|min:1|max:999',
            'satuan'             => 'required|string',
            'harga'              => 'nullable|numeric|min:0',
            'tahun_pengadaan'    => [
                'nullable',
                'digits:4',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],
            'kondisi'            => 'required|in:baik,rusak_ringan,rusak_berat',
            'status'             => 'required|in:tersedia,hilang',
            'nomor_register'     => 'nullable',
            'merk_type'          => 'nullable|string|max:100',
            'bahan'              => 'nullable|string|max:100',
            'asal_usul'          => 'nullable|in:Pembelian,Hibah,Dropping,Lainnya',
            'deskripsi'          => 'nullable|string',
            'foto'               => 'nullable|image|max:2048',
        ]);

        $kategori = Kategori::findOrFail($request->id_kategori);

        $namaBarangTrimmed = trim($request->nama_barang);

        $existingBarang = Barang::where('nama_barang', $namaBarangTrimmed)
            ->where('id_kategori', $request->id_kategori)
            ->first();

        $kodeBarang = $existingBarang
            ? $existingBarang->kode_barang
            : Barang::generateKode($kategori);

        $lastNomorRegister = Barang::where('nama_barang', $namaBarangTrimmed)
            ->max('nomor_register');

        $nextNumber = $lastNomorRegister ? (int) $lastNomorRegister : 0;
        $jumlah = (int) $request->jumlah_total;

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('barang', 'public');
        }

        DB::transaction(function () use (
            $request,
            $kodeBarang,
            $nextNumber,
            $jumlah,
            $fotoPath,
            $namaBarangTrimmed
        ) {
            for ($i = 0; $i < $jumlah; $i++) {
                $nomorRegister = str_pad($nextNumber + $i + 1, 6, '0', STR_PAD_LEFT);
                $kodeBarcode = 'BRG-' . strtoupper(uniqid());

                Barang::create([
                    'kode_barang'       => $kodeBarang,
                    'kode_barcode'      => $kodeBarcode,
                    'nama_barang'       => $namaBarangTrimmed,
                    'id_kategori'       => $request->id_kategori,
                    'id_lokasi'         => $request->id_lokasi,
                    'nomor_register'    => $nomorRegister,
                    'merk_type'         => $request->merk_type,
                    'bahan'             => $request->bahan,
                    'asal_usul'         => $request->asal_usul,
                    'harga'             => $request->harga,
                    'tahun_pengadaan'   => $request->tahun_pengadaan,
                    'jumlah_total'      => 1,
                    'jumlah_tersedia'   => 1,
                    'satuan'            => $request->satuan,
                    'kondisi'           => $request->kondisi,
                    'status'            => $request->status ?? 'tersedia',
                    'deskripsi'         => $request->deskripsi,
                    'foto'              => $fotoPath,
                ]);
            }
        });

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang'        => 'sometimes|string|max:100',
            'nama_barang'        => 'required|string|max:255',
            'id_kategori'        => 'required|exists:kategori,id',
            'id_lokasi'          => 'required|exists:lokasi,id',
            'nomor_register'     => 'nullable|string|max:100',
            'merk_type'          => 'nullable|string|max:100',
            'bahan'              => 'nullable|string|max:100',
            'asal_usul'          => 'nullable|in:Pembelian,Hibah,Dropping,Lainnya',
            'harga'              => 'nullable|numeric',
            'tahun_pengadaan'    => [
                'nullable',
                'digits:4',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],
            'satuan'             => 'required|string|max:20',
            'kondisi'            => 'required|in:baik,rusak_ringan,rusak_berat',
            'status'             => 'required|in:tersedia,hilang',
            'deskripsi'          => 'nullable|string|max:500',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $fotoPath = $barang->foto;

        if ($request->hasFile('foto')) {
            $this->deletePhotoIfUnused($barang->foto, $barang->getKey());
            $fotoPath = $request->file('foto')->store('barang', 'public');
        }

        $barang->update([
            'nama_barang'        => $request->nama_barang,
            'id_kategori'        => $request->id_kategori,
            'id_lokasi'          => $request->id_lokasi,
            'nomor_register'     => $request->nomor_register,
            'merk_type'          => $request->merk_type,
            'bahan'              => $request->bahan,
            'asal_usul'          => $request->asal_usul,
            'harga'              => $request->harga,
            'tahun_pengadaan'    => $request->tahun_pengadaan,
            'jumlah_total'       => 1,
            'jumlah_tersedia'    => $request->status === 'hilang' ? 0 : 1,
            'satuan'             => $request->satuan,
            'kondisi'            => $request->kondisi,
            'status'             => $request->status,
            'deskripsi'          => $request->deskripsi,
            'foto'               => $fotoPath,
        ]);

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->status === 'dipinjam') {
            return redirect()->back()
                ->with('error', 'Barang tidak dapat dihapus karena sedang dipinjam.');
        }

        $this->deletePhotoIfUnused($barang->foto, $barang->getKey());

        $barang->delete();

        return redirect()->back()
            ->with('success', 'Barang berhasil dihapus.');
    }

    // Halaman detail barang
    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'lokasi']);
        return view('barang.show', compact('barang'));
    }

    public function updateKondisi(Request $request, Barang $barang)
    {
        $request->validate([
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
        ]);

        $barang->update([
            'kondisi' => $request->kondisi,
        ]);

        return redirect()->route('admin.barang.show', $barang)
                         ->with('success', 'Kondisi barang berhasil diperbarui.');
    }

    // Generate QR Code dari kode_barcode
    public function qrcode(Request $request)
    {
        $kodeBarcode = $request->query('code');

        if (!$kodeBarcode) {
            return response('Invalid QR code request', 400);
        }

        try {
            // Generate QR code sebagai SVG
            $qr = QrCode::format('svg')
                        ->size(300)
                        ->errorCorrection('H')
                        ->generate($kodeBarcode);

            return response($qr)
                ->header('Content-Type', 'image/svg+xml')
                ->header('Cache-Control', 'no-cache, must-revalidate');
        } catch (\Exception $e) {
            return response('Error generating QR code: ' . $e->getMessage(), 500);
        }
    }

    // Halaman scan barcode (kamera)
    public function scan()
    {
        return view('barang.scan');
    }

    // Hasil scan — cari barang berdasarkan kode
    public function scanResult(Request $request)
    {
        $barang = Barang::with(['kategori', 'lokasi'])
                        ->where('kode_barcode', $request->kode)
                        ->first();

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json([
            'id'              => $barang->id,
            'nama_barang'     => $barang->nama_barang,
            'kode_barang'     => $barang->kode_barang,
            'kode_barcode'    => $barang->kode_barcode,
            'kategori'        => $barang->kategori->nama,
            'lokasi'          => $barang->lokasi->nama,
            'nomor_register'  => $barang->nomor_register,
            'merk_type'       => $barang->merk_type,
            'bahan'           => $barang->bahan,
            'asal_usul'       => $barang->asal_usul,
            'jumlah_total'    => $barang->jumlah_total,
            'jumlah_tersedia' => $barang->jumlah_tersedia,
            'status'          => $barang->status,
            'kondisi'         => $barang->kondisi,
            'deskripsi'       => $barang->deskripsi ?? '-',
            'detail_url'      => route('admin.barang.show', $barang->id),
        ]);
    }
}


