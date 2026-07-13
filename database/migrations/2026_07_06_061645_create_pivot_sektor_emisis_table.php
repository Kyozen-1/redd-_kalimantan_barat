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
        Schema::create('pivot_sektor_emisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emisi_id')->nullable();
            $table->foreign('emisi_id')->references('id')->on('md_emisis')->onDelete('cascade');
            $table->foreignId('sektor_emisi_id')->nullable();
            $table->foreign('sektor_emisi_id')->references('id')->on('md_sektor_emisis')->onDelete('cascade');
            $table->enum('status_aktif', ['1', '0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_sektor_emisis');
    }
};
