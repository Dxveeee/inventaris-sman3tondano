<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'id_pengguna',
        'id_barang',
        'nama_barang',
        'id_lokasi',
        'jumlah_pinjam',
        'tanggal_pengajuan',
        'tanggal_disetujui',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'kondisi_kembali',
        'status',
        'nomor_surat',
        'keterangan_penolakan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_disetujui' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
    ];

    public function peminjam(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(PeminjamanDetail::class, 'id_peminjaman');
    }
}
