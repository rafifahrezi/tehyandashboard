<?php
// database/migrations/2026_01_05_create_reports_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('nama_laporan');
            $table->enum('jenis_laporan', ['harian', 'bulanan', 'tahunan', 'custom']);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_akhir')->nullable();
            $table->enum('jenis_transaksi', ['semua', 'masuk', 'keluar'])->default('semua');
            $table->foreignId('bahan_id')->nullable()->constrained('bahans')->onDelete('set null');
            // $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->json('filter_params')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
