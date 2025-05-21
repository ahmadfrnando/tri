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
        Schema::create('ref_ram_handphone', function (Blueprint $table) {
            $table->id();
            $table->string('ram');
            $table->timestamps();
        });

        $ramData = [
            ['id' => 1, 'ram' => '2GB'],
            ['id' => 2, 'ram' => '4GB'],
            ['id' => 3, 'ram' => '6GB'],
            ['id' => 4, 'ram' => '8GB'],
            ['id' => 5, 'ram' => '12GB'],
            ['id' => 6, 'ram' => '16GB'],
        ];

        DB::table('ref_ram_handphone')->insert($ramData);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_ram_handphone');
    }
};
