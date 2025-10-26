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
        Schema::create('bahans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bahan')->unique();
            $table->string('nama_bahan');

            // Foreign Key ke Category
            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('cascade');

            $table->enum('satuan', [
                'kg',
                'gram',
                'liter',
                'ml',
                'pcs',
                'pack',
                'box'
            ])->default('kg');

            $table->decimal('harga', 10, 2)->default(0);
            $table->string('supplier');

            // Stok
            $table->decimal('stok', 10, 2)->default(0);
            $table->decimal('min_stok', 10, 2)->default(0);

            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_kadaluarsa')->nullable();

            $table->enum('is_active', ['aman', 'warning', 'habis', 'kritis'])
                ->default('aman');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahans');
    }
};
