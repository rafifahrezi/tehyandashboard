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
        Schema::create('stock_moves', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel bahans
            $table->foreignId('bahan_id')
                ->constrained('bahans')
                ->onDelete('cascade');

            $table->enum('move_type', ['in', 'out']);
            $table->decimal('qty', 10, 2);
            
            // Stok sebelum (diambil otomatis dari bahans.stok_sekarang)
            $table->decimal('stok_sebelum', 10, 2);
            // Stok sesudah dihitung otomatis
            $table->decimal('stok_sesudah', 10, 2);

            // Polymorphic reference
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();


            $table->timestamps();

            $table->index(['reference_type', 'reference_id']);
        });
    }
};
