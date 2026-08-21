<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePeminjamanTableAddLokasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add columns only if they do not already exist
        if (! Schema::hasColumn('peminjaman', 'nama_barang') ||
            ! Schema::hasColumn('peminjaman', 'id_lokasi')) {

            Schema::table('peminjaman', function (Blueprint $table) {
                if (! Schema::hasColumn('peminjaman', 'nama_barang')) {
                    $table->string('nama_barang')->nullable();
                }

                if (! Schema::hasColumn('peminjaman', 'id_lokasi')) {
                    $table->unsignedBigInteger('id_lokasi')->nullable();
                    $table->foreign('id_lokasi')
                        ->references('id')
                        ->on('lokasi')
                        ->onDelete('set null');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('peminjaman', 'id_lokasi') ||
            Schema::hasColumn('peminjaman', 'nama_barang')) {

            Schema::table('peminjaman', function (Blueprint $table) {
                if (Schema::hasColumn('peminjaman', 'id_lokasi')) {
                    try {
                        $table->dropForeign(['id_lokasi']);
                    } catch (\Throwable $e) {
                        // ignore if foreign doesn't exist
                    }

                    $table->dropColumn('id_lokasi');
                }

                if (Schema::hasColumn('peminjaman', 'nama_barang')) {
                    $table->dropColumn('nama_barang');
                }
            });
        }
    }
}
