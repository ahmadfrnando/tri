<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usulan_barang_baru', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
            $table->text('pesan')->nullable()->after('id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usulan_barang_baru', function (Blueprint $table) {
            $table->text('alasan_penolakan')->nullable()->after('id_user');
            $table->dropColumn('pesan');
        });
    }
};
