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

            // 2. Ubah is_active dari boolean ke enum
            $table->dropColumn('is_active');
        });

        Schema::table('bahans', function (Blueprint $table) {
            $table->enum('is_active', ['active', 'inactive', 'archived'])
                ->default('active')
                ->before('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bahans', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('bahans', function (Blueprint $table) {

            // rollback ke boolean
            $table->boolean('is_active')
                ->default(true)
                ->before('created_at');
        });
    }
};
