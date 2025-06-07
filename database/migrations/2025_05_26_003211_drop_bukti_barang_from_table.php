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
        Schema::table('barang_masuk', function (Blueprint $table) {
            $table->dropColumn('bukti_barang_masuk');
        });
        Schema::table('barang_keluar', function (Blueprint $table) {
            $table->dropColumn('bukti_barang_keluar');
        });
        Schema::table('data_barang_rusak', function (Blueprint $table) {
            $table->dropColumn('bukti_barang_rusak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_masuk', function (Blueprint $table) {
            $table->string('bukti_barang');
        });
        Schema::table('barang_keluar', function (Blueprint $table) {
            $table->string('bukti_barang');
        });
        Schema::table('data_barang_rusak', function (Blueprint $table) {
            $table->string('bukti_barang');
        });
    }
};
