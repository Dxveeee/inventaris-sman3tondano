<?php

namespace App\Models;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'id_kategori',
        'kode_barcode',
        'id_lokasi',
        'kode_barang',
        'nama_barang',
        'nomor_register',
        'merk_type',
        'bahan',
        'asal_usul',
        'harga',
        'tahun_pengadaan',
        'jumlah_total',
        'jumlah_tersedia',
        'satuan',
        'kondisi',
        'status',
        'deskripsi',
        'foto',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Relasi ke Lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }

    // // Relasi ke Peminjaman
    // public function peminjaman()
    // {
    //     return $this->hasMany(Peminjaman::class, 'id_barang');
    // }

    public static function generateKode(Kategori $kategori)
    {
        $prefix = strtoupper($kategori->kode_prefix ?? 'XX');
        $prefix = preg_replace('/[^A-Z0-9]/', '', $prefix);
        $prefix = $prefix ?: 'XX';

        $suffixStart = strlen($prefix) + 1;
        $latest = self::where('kode_barang', 'like', $prefix . '%')
            ->orderByRaw("CAST(SUBSTRING(kode_barang, {$suffixStart}) AS UNSIGNED) DESC")
            ->first();

        $nextNumber = 1;
        if ($latest && preg_match('/(\d+)$/', $latest->kode_barang, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
