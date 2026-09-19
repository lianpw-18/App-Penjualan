<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());
$admin = App\Models\User::where('role_id', 1)->first();
Auth::login($admin);
echo "Logged in as: " . $admin->name . "\n";

echo "Rendering laporan-ppn-keseluruhan.index view...\n";
$view = view('laporan-ppn-keseluruhan.index')->render();
echo "Rendered successfully! Length: " . strlen($view) . " bytes\n";

$hasKpiCards = str_contains($view, 'stat-kpi-card');
$hasTable = str_contains($view, 'id="table_id"');
$hasPreset = str_contains($view, 'preset-pill-btn');
$pdfView = view('laporan-ppn-keseluruhan.print-ppn-keseluruhan', [
    'data' => collect([]),
    'tanggalMulai' => '2026-09-01',
    'tanggalSelesai' => '2026-09-19',
    'totalPengeluaran' => 1958220,
    'totalPemasukan' => 1952500,
    'totalSelisih' => 5720
])->render();
echo "PDF View rendered successfully! Length: " . strlen($pdfView) . " bytes\n";
