<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuratFieldsToPeminjamanTable extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tanggal_pinjam_rencana')->nullable()->after('tanggal_pengajuan');
            $table->string('file_permohonan_ttd')->nullable()->after('nomor_surat');
            $table->string('file_persetujuan_ttd')->nullable()->after('file_permohonan_ttd');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_pinjam_rencana',
                'file_permohonan_ttd',
                'file_persetujuan_ttd',
            ]);
        });
    }
}
