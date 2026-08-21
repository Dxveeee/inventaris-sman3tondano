<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeIdBarangNullableInPeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('peminjaman', 'id_barang')) {
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->unsignedBigInteger('id_barang')->nullable()->change();
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
        if (Schema::hasColumn('peminjaman', 'id_barang')) {
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->unsignedBigInteger('id_barang')->nullable(false)->change();
            });
        }
    }
}
