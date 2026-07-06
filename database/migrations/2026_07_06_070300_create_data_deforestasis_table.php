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
        Schema::create('data_deforestasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyebab_deforestasi_id')->nullable();
            $table->foreign('penyebab_deforestasi_id')->references('id')->on('md_penyebab_deforestasis')->onDelete('cascade');
            $table->foreignId('kabupaten_kota_id')->nullable();
            $table->foreign('kabupaten_kota_id')->references('id')->on('regencies')->onDelete('cascade');
            $table->string('tahun')->nullable();
            $table->string('nilai')->nullable();
            $table->enum('status_aktif', ['1', '0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_deforestasis');
    }
};
