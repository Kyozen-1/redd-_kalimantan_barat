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
        Schema::create('laporan_emisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('document_file_excel_path')->nullable();
            $table->string('document_file_pdf_path')->nullable();
            $table->string('document_file_word_path')->nullable();
            $table->enum('status_aktif', ['1', '0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_emisis');
    }
};
