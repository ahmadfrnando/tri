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
        Schema::create('ref_status_usulan', function (Blueprint $table) {
            $table->id();
            $table->string('status_usulan');
            $table->timestamps();
        });

        $data = [
            ['id' => 1, 'status_usulan' => 'Diusulkan'],
            ['id' => 2, 'status_usulan' => 'Diterima'],
            ['id' => 3, 'status_usulan' => 'Diproses'],
            ['id' => 4, 'status_usulan' => 'Ditolak'],
        ];
        DB::table('ref_status_usulan')->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_status_usulan');
    }
};
