<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTanggalPengadaanToTahunPengadaanInBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn('tanggal_pengadaan');
            $table->string('tahun_pengadaan', 4)
                ->nullable()
                ->after('harga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn('tahun_pengadaan');
            $table->date('tanggal_pengadaan')
                ->nullable()
                ->after('harga');
        });
    }
}
