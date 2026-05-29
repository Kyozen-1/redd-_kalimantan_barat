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
        Schema::create('lp_mekanisme_sections', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('lp_mekanisme_sections');
    }
};
