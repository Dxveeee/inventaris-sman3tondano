<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateBarangTableAddDipinjamStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "ALTER TABLE barang MODIFY COLUMN status ENUM('tersedia','dipinjam','hilang') NOT NULL DEFAULT 'tersedia'"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(
            "ALTER TABLE barang MODIFY COLUMN status ENUM('tersedia','hilang') NOT NULL DEFAULT 'tersedia'"
        );
    }
}
