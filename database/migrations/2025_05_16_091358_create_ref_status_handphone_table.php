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
        Schema::create('ref_status_handphone', function (Blueprint $table) {
            $table->id();
            $table->string('status_handphone');
            $table->timestamps();
        });

        $statusHandphone = [
            ['id' => 1, 'status_handphone' => 'Tersedia'],
            ['id' => 2, 'status_handphone' => 'Terjual'],
            ['id' => 3, 'status_handphone' => 'Diretur Pelanggan'],
            ['id' => 4, 'status_handphone' => 'Retur Ke Supplier'],
        ];

        DB::table('ref_status_handphone')->insert($statusHandphone);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_status_handphone');
    }
};
