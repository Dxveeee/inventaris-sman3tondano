<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AdminPeminjamanController;
use App\Http\Middleware\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Landing page — accessible without login
Route::get('/', function () {
    $stats = [
        'total'         => \App\Models\Barang::count(),
        'baik'          => \App\Models\Barang::where('kondisi', 'baik')->count(),
        'rusak_ringan'  => \App\Models\Barang::where('kondisi', 'rusak_ringan')->count(),
        'rusak_berat'   => \App\Models\Barang::where('kondisi', 'rusak_berat')->count(),
        'tersedia'      => \App\Models\Barang::where('status', 'tersedia')->count(),
        'dipinjam'      => \App\Models\Barang::where('status', 'dipinjam')->count(),
        'hilang'        => \App\Models\Barang::where('status', 'hilang')->count(),
        'kategori'      => \App\Models\Kategori::count(),
        'lokasi'        => \App\Models\Lokasi::count(),
    ];

    return view('landing', compact('stats'));
})->name('landing');

// Dashboard
Route::middleware(['auth', 'role:admin,kepala_sekolah'])->group(function () {
    Route::get('/admin/dashboard', function () {
    $totalBarang    = \App\Models\Barang::count();
    $totalKategori  = \App\Models\Kategori::count();
    $totalLokasi    = \App\Models\Lokasi::count();
    $kondisiBaik    = \App\Models\Barang::where('kondisi', 'baik')->count();
    $rusakRingan    = \App\Models\Barang::where('kondisi', 'rusak_ringan')->count();
    $rusakBerat     = \App\Models\Barang::where('kondisi', 'rusak_berat')->count();
    $tersedia       = \App\Models\Barang::where('status', 'tersedia')->count();
    $dipinjam       = \App\Models\Barang::where('status', 'dipinjam')->count();
    $hilang         = \App\Models\Barang::where('status', 'hilang')->count();

    // Data donut chart kondisi
    $kondisiData = [$kondisiBaik, $rusakRingan, $rusakBerat, 0];

    // Bar chart - barang per kategori
    $barangPerKategori = \App\Models\Kategori::withCount('barang')
        ->having('barang_count', '>', 0)
        ->orderBy('barang_count', 'desc')
        ->get()
        ->map(function ($kategori) {
            return [
                'nama'   => $kategori->nama,
                'jumlah' => $kategori->barang_count,
            ];
        });

    // Pie chart - barang per jenis
    $barangPerJenis = \App\Models\Barang::select(
            'nama_barang',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('nama_barang')
        ->orderBy('total', 'desc')
        ->get();

    // Hanya 1 return view di akhir
    return view('admin.dashboard', compact(
        'totalBarang',
        'totalKategori',
        'totalLokasi',
        'kondisiBaik',
        'rusakRingan',
        'rusakBerat',
        'tersedia',
        'dipinjam',
        'hilang',
        'kondisiData',
        'barangPerKategori',
        'barangPerJenis',
    ));
    })->name('admin.dashboard');

    // Alias agar kepala.dashboard tetap valid (misal ada link lama)
    Route::get('/kepala/dashboard', fn() => redirect()->route('admin.dashboard'))
         ->name('kepala.dashboard');

    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::put('/admin/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    Route::resource('admin/lokasi', LokasiController::class)->names('admin.lokasi');

    Route::resource('admin/pengguna', PenggunaController::class)->names('admin.pengguna');
    Route::get('/admin/pengguna', [PenggunaController::class, 'index'])
        ->name('admin.pengguna.index');

    Route::post('/admin/pengguna', [PenggunaController::class, 'store'])
        ->name('admin.pengguna.store');

    Route::delete('/admin/pengguna/{id}', [PenggunaController::class, 'destroy'])
        ->name('admin.pengguna.destroy');

    // Admin peminjaman routes
    Route::get('/admin/peminjaman', [AdminPeminjamanController::class, 'index'])
        ->name('admin.peminjaman.index');
    Route::post('/admin/peminjaman/{id}/approve', [AdminPeminjamanController::class, 'approve'])
        ->name('admin.peminjaman.approve');
    Route::post('/admin/peminjaman/{id}/reject', [AdminPeminjamanController::class, 'reject'])
        ->name('admin.peminjaman.reject');
    Route::post('/admin/peminjaman/{id}/dipinjam', [AdminPeminjamanController::class, 'dipinjam'])
        ->name('admin.peminjaman.dipinjam');
    Route::get('/admin/peminjaman/{id}/surat', [AdminPeminjamanController::class, 'cetakSurat'])
        ->name('admin.peminjaman.surat');
    Route::get('/admin/peminjaman/{id}/surat-permohonan', [AdminPeminjamanController::class, 'lihatSuratPermohonan'])
        ->name('admin.peminjaman.surat-permohonan');
    Route::post('/admin/peminjaman/{id}/surat-persetujuan-ttd', [AdminPeminjamanController::class, 'uploadSuratPersetujuanTtd'])
        ->name('admin.peminjaman.surat-persetujuan-ttd.upload');
    Route::get('/admin/peminjaman/{id}/return', [AdminPeminjamanController::class, 'returnForm'])
        ->name('admin.peminjaman.return.form');
    Route::post('/admin/peminjaman/{id}/return', [AdminPeminjamanController::class, 'returnProcess'])
        ->name('admin.peminjaman.return.process');
    });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('barang', BarangController::class)
         ->only(['store', 'update', 'destroy']);

    Route::patch('/admin/barang/{barang}/kondisi', [BarangController::class, 'updateKondisi'])
         ->name('admin.barang.updateKondisi');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/barang/{barang}',        [BarangController::class, 'show'])   ->name('admin.barang.show');
    Route::get('/admin/barang/qrcode/generate', [BarangController::class, 'qrcode']) ->name('admin.barang.qrcode');
    Route::get('/scan',                         [BarangController::class, 'scan'])    ->name('admin.barang.scan');
    Route::get('/scan/result',                  [BarangController::class, 'scanResult'])->name('admin.barang.scan.result');

    Route::get('/admin/laporan',               [LaporanController::class, 'index'])      ->name('laporan.index');
    Route::get('/admin/laporan/export/pdf',    [LaporanController::class, 'exportPdf'])   ->name('laporan.exportPdf');
    Route::get('/admin/laporan/export/excel',  [LaporanController::class, 'exportExcel']) ->name('laporan.exportExcel');
});

require __DIR__.'/auth.php';

// Peminjam routes (protected)
Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->group(function () {
    Route::get('/dashboard', [PeminjamanController::class, 'dashboard'])->name('peminjam.dashboard');
    Route::get('/barang', [PeminjamanController::class, 'barangTersedia'])->name('peminjam.barang.index');
    Route::get('/barang/lokasi/{idLokasi}', [PeminjamanController::class, 'pilihBarang'])->name('peminjam.barang.pilihBarang');
    Route::get('/barang/lokasi/{idLokasi}/barang/{namaBarang}', [PeminjamanController::class, 'pilihUnit'])->name('peminjam.barang.pilihUnit');
    Route::get('/peminjaman', [PeminjamanController::class, 'riwayat'])->name('peminjam.peminjaman.index');
    Route::post('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjam.peminjaman.create');
    Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjam.peminjaman.store');
    Route::get('/peminjaman/{id}/surat', [PeminjamanController::class, 'downloadSurat'])
        ->name('peminjam.peminjaman.surat');
    Route::get('/peminjaman/{id}/surat-permohonan', [PeminjamanController::class, 'downloadSuratPermohonan'])
        ->name('peminjam.peminjaman.surat-permohonan');
    Route::post('/peminjaman/{id}/surat-permohonan-ttd', [PeminjamanController::class, 'uploadSuratPermohonanTtd'])
        ->name('peminjam.peminjaman.surat-permohonan-ttd.upload');
    Route::get('/peminjaman/{id}/surat-persetujuan-ttd', [PeminjamanController::class, 'downloadSuratPersetujuanTtd'])
        ->name('peminjam.peminjaman.surat-persetujuan-ttd');
    Route::get('/profil', [PeminjamanController::class, 'profil'])->name('peminjam.profil');
    Route::get('/profil/password', [PeminjamanController::class, 'editPassword'])->name('peminjam.profil.password.edit');
    Route::post('/profil/password', [PeminjamanController::class, 'updatePassword'])->name('peminjam.profil.password.update');
});
