<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')
                  ->constrained('kategori')
                  ->onDelete('restrict');
            $table->foreignId('id_lokasi')
                  ->constrained('lokasi')
                  ->onDelete('restrict');
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->integer('jumlah_total');
            $table->integer('jumlah_tersedia');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat']);
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
