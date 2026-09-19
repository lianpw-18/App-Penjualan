<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PembelianBarangController;
use App\Http\Controllers\PenjualanBarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokProdukController;
use App\Http\Controllers\ProdukMasukController;
use App\Http\Controllers\ProdukKeluarController;
use App\Http\Controllers\LaporanPPnKeseluruhanController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\SettingPenjualanController;
use App\Http\Controllers\LaporanProdukMasukController;
use App\Http\Controllers\LaporanProdukKeluarController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesananCustomerController;
use App\Http\Controllers\PesananAdminController;

// Public Catalog & Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/katalog', [LandingController::class, 'index'])->name('katalog');
Route::get('/katalog/{id}', [LandingController::class, 'show'])->name('katalog.detail');
Route::get('/api/katalog/products', [LandingController::class, 'apiProducts'])->name('katalog.api');

// E-Commerce Checkout Helper Routes (Address & Tracking)
Route::get('/checkout/cities', [CheckoutController::class, 'getCities'])->name('checkout.cities');
Route::get('/checkout/districts', [CheckoutController::class, 'getDistricts'])->name('checkout.districts');
Route::get('/checkout/villages', [CheckoutController::class, 'getVillages'])->name('checkout.villages');
Route::post('/checkout/shipping', [CheckoutController::class, 'calculateShipping'])->name('checkout.shipping');
Route::get('/checkout/success/{no_pesanan}', [CheckoutController::class, 'success'])
    ->where('no_pesanan', '.*')
    ->name('checkout.success');
Route::get('/checkout/tracking/{no_pesanan}', [CheckoutController::class, 'tracking'])
    ->where('no_pesanan', '.*')
    ->name('checkout.tracking');

// Dedicated Cashier / Admin POS Login Page
Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm'])->name('login.admin');

// Standard Authentication Routes (Login, Register, Logout)
Auth::routes();

// Protected Customer & Checkout Routes (Must be logged in)
Route::middleware('auth')->group(function () {
    // E-Commerce Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

    // Customer Dashboard ("Pesanan Saya")
    Route::get('/pesanan-saya', [PesananCustomerController::class, 'index'])->name('customer.pesanan');
    Route::get('/pesanan-saya/{id}/tracking', [PesananCustomerController::class, 'tracking'])->name('customer.pesanan.tracking');
    Route::get('/pesanan-saya/{id}', [PesananCustomerController::class, 'show'])->name('customer.pesanan.detail');

    // Customer Profile ("Profil Saya")
    Route::get('/profil', [PesananCustomerController::class, 'profile'])->name('customer.profile');
    Route::post('/profil/update', [PesananCustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::post('/profil/password', [PesananCustomerController::class, 'updatePassword'])->name('customer.profile.password');
});

Route::middleware('auth')->group(function () {
    Route::group(['middleware'  => 'checkRole:admin,kasir,kepala toko'], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/refresh-stok', [HomeController::class, 'refreshStok']);
        Route::get('/dashboard/validate-stok', [HomeController::class, 'validateStok']);
        
        // Route untuk produk terlaris di dashboard - accessible by all roles
        Route::get('/dashboard/best-selling-products', [HomeController::class, 'getBestSellingProducts'])->name('dashboard.best-selling');
    });

    // PERBAIKAN: Pindahkan route laporan penjualan ke sini agar bisa diakses oleh kasir
    Route::group(['middleware' => 'checkRole:admin,kasir,kepala toko'], function () {
        Route::get('/laporan-penjualan/get-data', [LaporanPenjualanController::class, 'getDataPenjualan']);
        Route::get('/laporan-penjualan', [PenjualanController::class, 'laporanIndex'])->name('laporan-penjualan.index');
        Route::get('/laporan-penjualan/print-penjualan', [LaporanPenjualanController::class, 'printLaporanPenjualan']);

        // Kelola Pesanan Online (Web E-Commerce)
        Route::get('/admin/pesanan-online', [PesananAdminController::class, 'index'])->name('pesanan-admin.index');
        Route::post('/admin/pesanan-online/{id}/status', [PesananAdminController::class, 'updateStatus'])->name('pesanan-admin.status');
    });

    Route::group(['middleware' => 'checkRole:admin,kasir'], function () {
        Route::get('/api/menu-penjualan', [PenjualanController::class, 'getAutoCompleteData']);
        Route::resource('/menu-penjualan', PenjualanController::class);
    });

    Route::group(['middleware' => 'checkRole:admin'], function () {
        Route::get('/pembelian-barang/get-data', [PembelianBarangController::class, 'getDataPembelianBarang'])->name('pembelian-barang.get-data');
        Route::post('/pembelian-barang/import', [PembelianBarangController::class, 'import'])->name('pembelian-barang.import');
        Route::get('/pembelian-barang/{id}/detail', [PembelianBarangController::class, 'getDetailPembelianBarang'])->name('pembelian-barang.detail');
        Route::resource('/pembelian-barang', PembelianBarangController::class);

        // === PENJUALAN BARANG ROUTES === 
        // DataTable Ajax untuk get data utama
        Route::get('/penjualan-barang/get-data', [PenjualanBarangController::class, 'getDataPenjualanBarang'])->name('penjualan-barang.getData');
        // Import Excel
        Route::post('/penjualan-barang/import', [PenjualanBarangController::class, 'import'])->name('penjualan-barang.import');
        // Hidden Products Routes - BARU DITAMBAHKAN
        Route::get('/penjualan-barang/hidden-products', [PenjualanBarangController::class, 'hiddenProducts'])->name('penjualan-barang.hidden');
        Route::post('/penjualan-barang/{id}/restore', [PenjualanBarangController::class, 'restore'])->name('penjualan-barang.restore');
        Route::post('/penjualan-barang/{id}/force-delete', [PenjualanBarangController::class, 'forceDelete'])->name('penjualan-barang.force-delete');
        // Resource CRUD (index, create, store, show, edit, update, destroy)
        Route::resource('/penjualan-barang', PenjualanBarangController::class);

        Route::get('/kategori/get-data', [KategoriController::class, 'getDataKategori']);
        Route::resource('/kategori', KategoriController::class);
        Route::get('/supplier/get-data', [SupplierController::class, 'getDataSupplier']);
        Route::resource('/supplier', SupplierController::class);
        Route::get('/satuan/get-data', [SatuanController::class, 'getDataSatuan']);
        Route::resource('/satuan', SatuanController::class);
        Route::get('/karyawan/get-data', [KaryawanController::class, 'getDataKaryawan']);
        Route::resource('/karyawan', KaryawanController::class);
        
        Route::get('/produk-masuk/get-data', [ProdukMasukController::class, 'getDataProdukMasuk']);
        Route::get('/produk-masuk/pembelian-barang/{id}', [ProdukMasukController::class, 'getPembelianBarangDetail']);
        Route::get('/api/produk-masuk', [ProdukMasukController::class, 'getAutoCompleteData']);
        Route::post('/produk-masuk/import', [ProdukMasukController::class, 'import'])->name('produkmasuk.import');
        Route::resource('/produk-masuk', ProdukMasukController::class); // Ini harus paling bawah
        
        // Routes untuk Produk Keluar
        Route::get('/produk-keluar/get-data', [ProdukKeluarController::class, 'getDataProdukKeluar']);
        Route::get('/produk-keluar/get-produk-by-supplier', [ProdukKeluarController::class, 'getProdukBySupplier']);
        Route::get('/produk-keluar/get-produk-detail', [ProdukKeluarController::class, 'getProdukDetail']);
        Route::resource('/produk-keluar', ProdukKeluarController::class);
    });

    Route::group(['middleware'  => 'checkRole:admin,kepala toko'], function () {
        Route::get('/stok-produk', [StokProdukController::class, 'index'])->name('stok-produk.index');
        Route::get('/stok-produk/get-data', [StokProdukController::class, 'getDataStok'])->name('stok-produk.get-data');
        Route::get('/stok-produk/laporan-stok', [StokProdukController::class, 'printLaporanStok'])->name('stok-produk.laporan-stok');
        
        Route::get('/laporan-produk-masuk/get-data', [LaporanProdukMasukController::class, 'getLaporanProdukMasuk']);
        Route::get('/laporan-produk-masuk', [LaporanProdukMasukController::class, 'index']);
        Route::get('/laporan-produk-masuk/print-produk-masuk', [LaporanProdukMasukController::class, 'printLaporanProdukMasuk']);
        Route::get('/laporan-produk-keluar/get-data', [LaporanProdukKeluarController::class, 'getlaporanProdukKeluar']);
        Route::get('/laporan-produk-keluar', [LaporanProdukKeluarController::class, 'index']);
        Route::get('/laporan-produk-keluar/print-produk-keluar', [LaporanProdukKeluarController::class, 'printLaporanProdukKeluar']);
        
        Route::get('/laporan-ppn-keseluruhan/get-data', [LaporanPPnKeseluruhanController::class, 'getDataPPnKeseluruhan']);
        Route::get('/laporan-ppn-keseluruhan', [LaporanPPnKeseluruhanController::class, 'index']);
        Route::get('/laporan-ppn-keseluruhan/print-ppn-keseluruhan', [LaporanPPnKeseluruhanController::class, 'printLaporanPPnKeseluruhan']);
        Route::get('/setting-penjualan', [SettingPenjualanController::class, 'index']);
        Route::post('/setting-penjualan/update-diskon', [SettingPenjualanController::class, 'updateDiskon']);
        Route::post('/setting-penjualan/update-ppn', [SettingPenjualanController::class, 'updatePpn']);
    });

    Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
});