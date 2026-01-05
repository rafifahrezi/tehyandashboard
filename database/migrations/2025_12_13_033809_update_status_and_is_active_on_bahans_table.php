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
        Schema::table('bahans', function (Blueprint $table) {
            // HAPUS baris ini karena kolom status belum ada:
            // $table->dropColumn('status');

            // Ganti dengan: Tambah kolom status jika belum ada
            if (!Schema::hasColumn('bahans', 'status')) {
                $table->enum('status', ['aman', 'warning', 'habis', 'kritis'])
                    ->default('aman')
                    ->after('is_active');
            }

            // Install doctrine/dbal dulu untuk modify column:
            // composer require doctrine/dbal
            $table->enum('is_active', ['active', 'inactive', 'archived'])
                ->default('active')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bahans', function (Blueprint $table) {
            // Kembalikan is_active ke enum semula
            $table->enum('is_active', ['aman', 'warning', 'habis', 'kritis'])
                ->default('aman')
                ->change();

            // Hapus kolom status
            $table->dropColumn(['status']);
        });
    }
};
