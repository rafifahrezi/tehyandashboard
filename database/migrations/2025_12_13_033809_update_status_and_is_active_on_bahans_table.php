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

            $table->dropColumn('status');

            $table->enum('status', ['aman', 'warning', 'habis', 'kritis'])
                ->default('aman')
                ->before('created_at');

            // 2️⃣ Ubah is_active menjadi ENUM
            $table->enum('is_active', ['active', 'inactive', 'archived'])
                ->default('active')
                ->before('created_at')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bahans', function (Blueprint $table) {

            // rollback is_active
            $table->dropColumn('is_active');
        });

        Schema::table('bahans', function (Blueprint $table) {

            // rollback ke boolean
            $table->boolean('is_active')
                ->default(true)
                ->before('created_at');

            // rollback status
            $table->dropColumn('status');
        });
    }
};
