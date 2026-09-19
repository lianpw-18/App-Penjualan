<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$cKeluar = new App\Http\Controllers\LaporanProdukKeluarController();
$resKeluar = $cKeluar->getlaporanProdukKeluar(request());
echo "Produk Keluar records: " . count($resKeluar->getData()) . "\n";

$cMasuk = new App\Http\Controllers\LaporanProdukMasukController();
$resMasuk = $cMasuk->getLaporanProdukMasuk(request());
echo "Produk Masuk records: " . count($resMasuk->getData()) . "\n";
