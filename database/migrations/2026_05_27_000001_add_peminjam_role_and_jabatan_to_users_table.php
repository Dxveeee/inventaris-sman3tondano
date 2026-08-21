<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPeminjamRoleAndJabatanToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','kepala_sekolah','peminjam') NOT NULL DEFAULT 'admin' AFTER `email`");

        Schema::table('users', function (Blueprint $table) {
            $table->enum('jabatan', ['Guru', 'Siswa'])->nullable()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('jabatan');
        });

        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','kepala_sekolah') NOT NULL DEFAULT 'admin' AFTER `email`");
    }
}
