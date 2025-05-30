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
         Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->integer('id_handphone');
            $table->date('tanggal_keluar');
            $table->decimal('harga_keluar', 10, 2);
            $table->text('bukti_barang_keluar')->nullable();
            $table->integer('id_kondisi');
            $table->integer('id_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
