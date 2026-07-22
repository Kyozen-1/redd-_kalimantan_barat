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
        Schema::create('perhutanan_sosials', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa');
            $table->foreignId('kabupaten_kota_id')->nullable();
            $table->foreign('kabupaten_kota_id')->references('id')->on('regencies')->onDelete('set null');
            $table->string('skema')->default('Hutan Desa (HD)');
            $table->string('nama_lembaga');
            $table->string('nomor_sk');
            $table->enum('status_aktif', ['0', '1'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perhutanan_sosials');
    }
};
