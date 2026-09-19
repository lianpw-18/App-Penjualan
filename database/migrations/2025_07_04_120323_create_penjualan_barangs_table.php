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
        Schema::create('penjualan_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kd_penjualan_barang')->unique();
            $table->string('nm_barang');
            $table->text('deskripsi');
            $table->integer('stok')->nullable()->default('0');
            $table->decimal('harga_beli')->nullable()->default('0');
            $table->decimal('harga_jual')->nullable()->default('0');
            $table->foreignId('kategori_id');
            $table->foreignId('satuan_id');
            $table->foreignId('user_id');
            $table->timestamps();
        });
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_barangs');
    }
};
