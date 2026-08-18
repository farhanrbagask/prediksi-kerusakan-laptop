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
        Schema::create('data_latih', function (Blueprint $table) {
            $table->string('id_latih', 10)->primary();
            $table->enum('layar_blank', ['1', '2']);
            $table->enum('layar_bergaris', ['1', '2']);
            $table->enum('auto_restart', ['1', '2']);
            $table->enum('boot_loop', ['1', '2']);
            $table->enum('alarm_bios', ['1', '2']);
            $table->enum('error_disk', ['1', '2']);
            $table->enum('keyboard_touchpad_mati', ['1', '2']);
            $table->enum('baterai_cepat_habis', ['1', '2']);
            $table->enum('overheat', ['1', '2']);
            $table->enum('hang', ['1', '2']);
            $table->string('kelas', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_latih');
    }
};
