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
        Schema::create('usulan_barang_baru', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->integer('jumlah');
            $table->string('tujuan_pengusulan');
            $table->integer('id_user');
            $table->integer('id_status_usulan')->default(1);
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulan_barang_baru');
    }
};
