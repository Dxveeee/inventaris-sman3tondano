<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_barang');
            $table->unsignedInteger('jumlah_pinjam');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_disetujui')->nullable();
            $table->date('tanggal_kembali_rencana');
            $table->date('tanggal_kembali_aktual')->nullable();
            $table->enum('kondisi_kembali', ['Baik', 'Rusak', 'Hilang'])->nullable();
            $table->enum('status', ['Menunggu', 'Disetujui', 'Dipinjam', 'Dikembalikan', 'Ditolak'])->default('Menunggu');
            $table->text('keterangan_penolakan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_pengguna')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('id_barang')
                  ->references('id')->on('barang')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
}
