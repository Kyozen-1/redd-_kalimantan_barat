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
        Schema::table('md_lsms', function (Blueprint $table) {
            $table->foreignId('md_wilayah_cakupan_id')->nullable();
            $table->foreign('md_wilayah_cakupan_id')->references('id')->on('md_wilayah_cakupans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('md_lsm', function (Blueprint $table) {
            //
        });
    }
};
