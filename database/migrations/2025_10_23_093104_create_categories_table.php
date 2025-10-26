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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            // Deskripsi kategori (opsional)
            $table->text('deskripsi')->nullable();
            // Enum untuk tipe kategori
            $table->enum('tipe', [
                'bahan_pokok',
                'bahan_tambahan',
                'bahan_mentah',
                'bahan_jadi'
            ])->default('bahan_pokok');
            // Status aktif
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
