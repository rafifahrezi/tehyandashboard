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
        Schema::table('users', function (Blueprint $table) {
            $table->string('telp')->nullable()->after('email'); // Tambah kolom telp
            $table->string('jabatan')->nullable()->after('telp'); // Tambah kolom jabatan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('telp'); // Hapus kolom telp
            $table->dropColumn('jabatan'); // Hapus kolom jabatan
        });
    }
};
