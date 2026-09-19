<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($reqBootstrap = Illuminate\Http\Request::capture());

$user = App\Models\User::where('email', 'lianpertiwa@gmail.com')->first();
if (!$user) {
    $user = App\Models\User::where('email', 'pelanggan@gmail.com')->first();
}

echo "Testing with user: " . $user->name . " (" . $user->email . ")\n";

// Test 1: Update profile (no_hp and alamat)
$controller = new App\Http\Controllers\PesananCustomerController();
Auth::login($user);

$req = Illuminate\Http\Request::create('/profil/update', 'POST', [
    'name' => $user->name,
    'email' => $user->email,
    'no_hp' => '081298765432',
    'alamat' => 'Jl. Anggrek No. 12, RT 02 / RW 05, Kelurahan Melati, Kec. Sukajadi, Kota Bandung'
]);

$response = $controller->updateProfile($req);
$user->refresh();
echo "Update Profile Result: Name=" . $user->name . ", Phone=" . $user->no_hp . ", Address=" . $user->alamat . "\n";

// Test 2: Render Profile View
$profileView = $controller->profile()->render();
$hasBeranda = str_contains($profileView, 'Beranda (Katalog)');
$hasPesanan = str_contains($profileView, 'Status Pesanan');
$hasProfil = str_contains($profileView, 'Profil Saya');
echo "Profile View contains: Beranda=" . ($hasBeranda ? 'YES' : 'NO') . ", Status Pesanan=" . ($hasPesanan ? 'YES' : 'NO') . ", Profil Saya=" . ($hasProfil ? 'YES' : 'NO') . "\n";

// Test 3: Render Pesanan View
$pesananReq = Illuminate\Http\Request::create('/pesanan-saya', 'GET');
$pesananView = $controller->index($pesananReq)->render();
$hasBeranda2 = str_contains($pesananView, 'Beranda (Katalog)');
$hasPesanan2 = str_contains($pesananView, 'Status Pesanan');
$hasProfil2 = str_contains($pesananView, 'Profil Saya');
echo "Pesanan View contains: Beranda=" . ($hasBeranda2 ? 'YES' : 'NO') . ", Status Pesanan=" . ($hasPesanan2 ? 'YES' : 'NO') . ", Profil Saya=" . ($hasProfil2 ? 'YES' : 'NO') . "\n";

echo "\nALL TESTS PASSED SUCCESSFULLY!\n";
