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
        Schema::create('pivot_gambar_beritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_id')->nullable();
            $table->foreign('berita_id')->references('id')->on('beritas')->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->string('image_path')->nullable();
            $table->enum('status_aktif', ['1', '0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_gambar_beritas');
    }
};
