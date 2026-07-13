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
        Schema::create('data_emisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pivot_sektor_emisi_id')->nullable();
            $table->foreign('pivot_sektor_emisi_id')->references('id')->on('pivot_sektor_emisis')->onDelete('cascade');
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
        Schema::dropIfExists('data_emisis');
    }
};
