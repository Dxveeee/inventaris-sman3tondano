<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $fillable = ['nama', 'deskripsi', 'kode_prefix'];

    public function barang()
    {
        return $this->hasMany(\App\Models\Barang::class, 'id_kategori');
    }
}
