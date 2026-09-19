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
        Schema::table('penjualan_barangs', function (Blueprint $table) {
            $table->decimal('diskon_persen', 5, 2)->default(0)->after('harga_jual');
            $table->decimal('ppn_persen', 5, 2)->default(11)->after('diskon_persen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan_barangs', function (Blueprint $table) {
            $table->dropColumn(['diskon_persen', 'ppn_persen']);
        });
    }
};