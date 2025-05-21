<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ref_kondisi_barang', function (Blueprint $table) {
            $table->id();
            $table->string('kondisi_barang');
        });


        $kondisiBarang = [
            ['id' => 1, 'kondisi_barang' => 'Baik'],
            ['id' => 2, 'kondisi_barang' => 'Rusak Ringan'],
            ['id' => 3, 'kondisi_barang' => 'Rusak Berat'],
            ['id' => 4, 'kondisi_barang' => 'Sedang Diperbaiki'],
        ];

        DB::table('ref_kondisi_barang')->insert($kondisiBarang);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_kondisi_barang');
    }
};
