<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$c = new App\Http\Controllers\LaporanPPnKeseluruhanController();
$data = $c->getDataArusKas(request())->getData();
echo "Calculated groups: " . count($data) . "\n";
$totKeluar = 0;
$totMasuk = 0;
$totSelisih = 0;
foreach ($data as $d) {
    $totKeluar += $d->ppn_pengeluaran;
    $totMasuk += $d->ppn_pemasukan;
    $totSelisih += $d->selisih;
}
echo "Total PPN Pengeluaran: Rp " . number_format($totKeluar, 0, ',', '.') . "\n";
echo "Total PPN Pemasukan: Rp " . number_format($totMasuk, 0, ',', '.') . "\n";
echo "Total Selisih: Rp " . number_format($totSelisih, 0, ',', '.') . "\n";
