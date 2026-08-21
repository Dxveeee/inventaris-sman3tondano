<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBarangTableAddDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->string('nomor_register')->nullable()->after('kode_barang');
            $table->string('merk_type')->nullable()->after('nomor_register');
            $table->string('bahan')->nullable()->after('merk_type');
            $table->enum('asal_usul', ['Pembelian', 'Hibah', 'Dropping', 'Lainnya'])
                ->nullable()
                ->after('bahan');
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
            $table->dropColumn(['nomor_register', 'merk_type', 'bahan', 'asal_usul']);
        });
    }
}
