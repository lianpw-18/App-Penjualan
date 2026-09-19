<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// 1. Check routes
echo "Checking routes...\n";
echo "Route customer.pesanan: " . route('customer.pesanan') . "\n";
echo "Route customer.profile: " . route('customer.profile') . "\n";
echo "Route customer.profile.update: " . route('customer.profile.update') . "\n";
echo "Route customer.profile.password: " . route('customer.profile.password') . "\n";
echo "Route landing: " . route('landing') . "\n";

// 2. Check Pelanggan user
$pelanggan = App\Models\User::where('email', 'pelanggan@gmail.com')->first();
if ($pelanggan) {
    echo "Found pelanggan user ID: " . $pelanggan->id . " Name: " . $pelanggan->name . "\n";
    Auth::login($pelanggan);
    
    // Render profile view
    $totalPesanan = App\Models\Pesanan::where('user_id', $pelanggan->id)->count();
    $pesananAktif = App\Models\Pesanan::where('user_id', $pelanggan->id)->whereIn('status_pesanan', ['menunggu_pembayaran', 'diproses', 'dikirim'])->count();
    $pesananSelesai = App\Models\Pesanan::where('user_id', $pelanggan->id)->where('status_pesanan', 'selesai')->count();
    
    $profileView = view('customer.profile', [
        'user' => $pelanggan,
        'totalPesanan' => $totalPesanan,
        'pesananAktif' => $pesananAktif,
        'pesananSelesai' => $pesananSelesai
    ])->render();
    echo "Profile view rendered successfully! Length: " . strlen($profileView) . " bytes\n";
    
    // Render pesanan view
    $query = App\Models\Pesanan::with(['detailPesanans.penjualanBarang'])->where('user_id', $pelanggan->id)->orderBy('id', 'desc');
    $pesanans = $query->paginate(10);
    $pesananView = view('customer.pesanan', [
        'pesanans' => $pesanans,
        'status' => 'semua',
        'countSemua' => $totalPesanan,
        'countMenunggu' => 0,
        'countDiproses' => 0,
        'countDikirim' => 0,
        'countSelesai' => $pesananSelesai
    ])->render();
    echo "Pesanan view rendered successfully! Length: " . strlen($pesananView) . " bytes\n";
} else {
    echo "Pelanggan user not found.\n";
}
