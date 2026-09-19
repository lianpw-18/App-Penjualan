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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pesanan')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Penerima & Alamat
            $table->string('nama_penerima');
            $table->string('no_telepon');
            $table->text('alamat_lengkap');
            $table->string('provinsi')->default('Jawa Tengah');
            $table->string('kota')->default('Purworejo');
            $table->string('kecamatan')->nullable();
            $table->string('kode_pos')->nullable();
            $table->text('catatan')->nullable();

            // Ekspedisi & Ongkir
            $table->string('ekspedisi'); // JNE, J&T, SiCepat, Anteraja, POS
            $table->string('layanan_ekspedisi')->default('Reguler'); // Reguler, Next Day, Cargo
            $table->decimal('ongkir', 12, 2)->default(0);
            $table->string('estimasi_pengiriman')->nullable(); // e.g. "1-2 Hari"
            $table->string('no_resi')->nullable();

            // Rincian Keuangan
            $table->decimal('subtotal_produk', 12, 2);
            $table->decimal('total_diskon', 12, 2)->default(0);
            $table->decimal('total_ppn', 12, 2)->default(0);
            $table->decimal('total_bayar', 12, 2);

            // Pembayaran & Status
            $table->string('metode_pembayaran'); // transfer_bca, transfer_mandiri, transfer_bri, qris, cod
            $table->string('status_pesanan')->default('menunggu_pembayaran'); 
            // status: menunggu_pembayaran, diproses, dikirim, selesai, dibatalkan
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamp('tgl_pembayaran')->nullable();

            $table->timestamps();
        });

        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->foreignId('penjualan_barang_id')->nullable()->constrained('penjualan_barangs')->onDelete('set null');
            $table->string('nm_barang');
            $table->decimal('harga_satuan', 12, 2);
            $table->integer('jumlah');
            $table->decimal('diskon_persen', 5, 2)->default(0);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
        Schema::dropIfExists('pesanans');
    }
};
