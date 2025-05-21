<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {   
        Schema::dropIfExists('handphone');

        Schema::create('handphone', function (Blueprint $table) {
            $table->id();
            $table->string('imei')->unique();
            $table->string('model');
            $table->decimal('ukuran_layar', 4, 1);
            $table->integer('id_ram');
            $table->integer('id_tipe_handphone');
            $table->integer('id_kondisi')->nullable();
            $table->integer('id_status')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handphone');
    }
};
