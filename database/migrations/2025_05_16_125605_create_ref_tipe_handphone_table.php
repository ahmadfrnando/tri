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
        Schema::create('ref_tipe_handphone', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tipe');
            $table->timestamps();
        });

        $data = [
            ['id' => 1, 'nama_tipe' => 'Smartphone'],
            ['id' => 2, 'nama_tipe' => 'Future Phone'],
            ['id' => 3, 'nama_tipe' => 'Tablet'],
        ];
        DB::table('ref_tipe_handphone')->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_tipe_handphone');
    }
};
