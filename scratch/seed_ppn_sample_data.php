<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\ProdukMasuk;
use App\Models\ProdukKeluar;
use App\Models\Supplier;
use App\Models\PenjualanBarang;
use Illuminate\Support\Facades\DB;

echo "=== SEEDING SAMPLE DATA FOR LAPORAN PPN KESELURUHAN ===\n";

$adminUser = App\Models\User::where('role_id', 1)->first() ?? App\Models\User::first();
$userId = $adminUser ? $adminUser->id : 1;

$supplier1 = Supplier::find(1) ?? Supplier::first();
$supplier2 = Supplier::find(2) ?? Supplier::first();
$supplier3 = Supplier::find(3) ?? Supplier::first();

// Clean up existing sample data if re-run (keep id 1 if already there)
ProdukMasuk::where('id', '>', 1)->delete();
ProdukKeluar::truncate();

// Sample Data Array across multiple dates in September 2026
$samplesMasuk = [
    [
        'kd_transaksi' => 'PRD-IN-8012',
        'nm_produk'    => 'Kain Katun Toyobo Premium Grade A',
        'tgl_masuk'    => '2026-09-10',
        'stok_masuk'   => 50,
        'harga_beli'   => 50000,
        'total_harga'  => 2500000, // PPN Masuk 11% = 275.000
        'supplier_id'  => $supplier1->id,
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-IN-8025',
        'nm_produk'    => 'Abaya Basic Jetblack Saudi Roll Fabric',
        'tgl_masuk'    => '2026-09-12',
        'stok_masuk'   => 20,
        'harga_beli'   => 150000,
        'total_harga'  => 3000000, // PPN Masuk 11% = 330.000
        'supplier_id'  => $supplier2->id,
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-IN-8038',
        'nm_produk'    => 'Bahan Gamis Ceruty Babydoll 2 Layer Mawar',
        'tgl_masuk'    => '2026-09-14',
        'stok_masuk'   => 10,
        'harga_beli'   => 180000,
        'total_harga'  => 1800000, // PPN Masuk 11% = 198.000
        'supplier_id'  => $supplier3->id,
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-IN-8049',
        'nm_produk'    => 'Kain Silk Armani Champagne Grade Original',
        'tgl_masuk'    => '2026-09-15',
        'stok_masuk'   => 10,
        'harga_beli'   => 220000,
        'total_harga'  => 2200000, // PPN Masuk 11% = 242.000
        'supplier_id'  => $supplier1->id,
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-IN-8061',
        'nm_produk'    => 'Kaftan Silk Bordir Payet Dubai Glitz',
        'tgl_masuk'    => '2026-09-16',
        'stok_masuk'   => 10,
        'harga_beli'   => 260000,
        'total_harga'  => 2600000, // PPN Masuk 11% = 286.000
        'supplier_id'  => $supplier2->id,
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-IN-8073',
        'nm_produk'    => 'Khimar Syari Non-Pet Ceruty 3 Layer Syar\'i',
        'tgl_masuk'    => '2026-09-17',
        'stok_masuk'   => 20,
        'harga_beli'   => 65000,
        'total_harga'  => 1300000, // PPN Masuk 11% = 143.000
        'supplier_id'  => $supplier3->id,
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-IN-8089',
        'nm_produk'    => 'Set Gamis French Khimar Mahabbah Series',
        'tgl_masuk'    => '2026-09-18',
        'stok_masuk'   => 20,
        'harga_beli'   => 195000,
        'total_harga'  => 3900000, // PPN Masuk 11% = 429.000
        'supplier_id'  => $supplier1->id,
        'user_id'      => $userId,
    ],
];

foreach ($samplesMasuk as $item) {
    ProdukMasuk::create($item);
}
echo "Added " . count($samplesMasuk) . " sample ProdukMasuk records.\n";

$samplesKeluar = [
    [
        'kd_transaksi' => 'PRD-OUT-5011',
        'nm_produk'    => 'Kain Katun Toyobo Premium Grade A',
        'tgl_keluar'   => '2026-09-10',
        'stok_keluar'  => 33,
        'harga_beli'   => 1650000, // Total nilai = 1.650.000 -> PPN 11% = 181.500
        'total_harga'  => 1650000,
        'deskripsi'    => 'Pengeluaran untuk produksi pesanan seragam pengajian',
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-OUT-5024',
        'nm_produk'    => 'Abaya Basic Jetblack Saudi',
        'tgl_keluar'   => '2026-09-12',
        'stok_keluar'  => 8,
        'harga_beli'   => 2200000, // PPN 11% = 242.000
        'total_harga'  => 2200000,
        'deskripsi'    => 'Pengiriman pesanan grosir butik mitra Bandung',
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-OUT-5037',
        'nm_produk'    => 'Gamis Ceruty Babydoll 2 Layer Mawar',
        'tgl_keluar'   => '2026-09-14',
        'stok_keluar'  => 8,
        'harga_beli'   => 2560000, // PPN 11% = 281.600
        'total_harga'  => 2560000,
        'deskripsi'    => 'Distribusi toko cabang Yogyakarta',
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-OUT-5049',
        'nm_produk'    => 'Dress Muslimah Silk Armani Champagne',
        'tgl_keluar'   => '2026-09-15',
        'stok_keluar'  => 5,
        'harga_beli'   => 1925000, // PPN 11% = 211.750
        'total_harga'  => 1925000,
        'deskripsi'    => 'Pesanan khusus wisuda muslimah',
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-OUT-5062',
        'nm_produk'    => 'Kaftan Silk Bordir Payet Dubai',
        'tgl_keluar'   => '2026-09-16',
        'stok_keluar'  => 8,
        'harga_beli'   => 3600000, // PPN 11% = 396.000
        'total_harga'  => 3600000,
        'deskripsi'    => 'Pengeluaran display pameran busana muslimah Jakarta',
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-OUT-5075',
        'nm_produk'    => 'Khimar Syari Non-Pet Ceruty 3 Layer',
        'tgl_keluar'   => '2026-09-17',
        'stok_keluar'  => 15,
        'harga_beli'   => 1785000, // PPN 11% = 196.350
        'total_harga'  => 1785000,
        'deskripsi'    => 'Pengiriman pesanan reseller Surabaya',
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-OUT-5088',
        'nm_produk'    => 'Set Gamis French Khimar Mahabbah',
        'tgl_keluar'   => '2026-09-18',
        'stok_keluar'  => 8,
        'harga_beli'   => 2792000, // PPN 11% = 307.120
        'total_harga'  => 2792000,
        'deskripsi'    => 'Pengeluaran pesanan online e-commerce website',
        'user_id'      => $userId,
    ],
    [
        'kd_transaksi' => 'PRD-OUT-5099',
        'nm_produk'    => 'Gamis Daily Linen Katun Bordir Bunga',
        'tgl_keluar'   => '2026-09-19',
        'stok_keluar'  => 6,
        'harga_beli'   => 1290000, // PPN 11% = 141.900
        'total_harga'  => 1290000,
        'deskripsi'    => 'Pengeluaran penjualan POS kasir toko',
        'user_id'      => $userId,
    ],
];

foreach ($samplesKeluar as $item) {
    ProdukKeluar::create($item);
}
echo "Added " . count($samplesKeluar) . " sample ProdukKeluar records.\n";

echo "Total ProdukMasuk in DB: " . ProdukMasuk::count() . "\n";
echo "Total ProdukKeluar in DB: " . ProdukKeluar::count() . "\n";
echo "=== SEEDING COMPLETED SUCCESSFULLY ===\n";
