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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('penumpang_id')->constrained('penumpangs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('jadwal_id')->constrained('jadwals')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('kuantitas');
            $table->string('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
