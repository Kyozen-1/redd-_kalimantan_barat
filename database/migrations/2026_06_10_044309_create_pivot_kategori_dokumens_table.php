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
        Schema::create('pivot_kategori_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->nullable();
            $table->foreign('kategori_id')->references('id')->on('md_kategori_dokumens')->onDelete('cascade');
            $table->foreignId('dokumen_id')->nullable();
            $table->foreign('dokumen_id')->references('id')->on('dokumen_galeris')->onDelete('cascade');
            $table->enum('status_aktif', ['1', '0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_kategori_dokumens');
    }
};
