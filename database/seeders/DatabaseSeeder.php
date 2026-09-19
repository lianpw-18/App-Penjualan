<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\PembelianBarang;
use App\Models\PenjualanBarang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Kas;
use App\Models\SettingPenjualan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1️⃣ Buat role terlebih dahulu
        $roleAdmin    = Role::firstOrCreate(['role' => 'admin']);
        $roleKepala   = Role::firstOrCreate(['role' => 'kepala toko']);
        $roleKasir    = Role::firstOrCreate(['role' => 'kasir']);
        $rolePelanggan = Role::firstOrCreate(['role' => 'pelanggan']);

        // 2️⃣ Buat user
        $admin = User::firstOrCreate(['email' => 'admin@gmail.com'], [
            'name'      => 'admin',
            'password'  => bcrypt('1234'),
            'role_id'   => $roleAdmin->id
        ]);

        $kasir = User::firstOrCreate(['email' => 'kasir@gmail.com'], [
            'name'      => 'Kasir Butik',
            'password'  => bcrypt('1234'),
            'role_id'   => $roleKasir->id
        ]);

        $pelanggan = User::firstOrCreate(['email' => 'pelanggan@gmail.com'], [
            'name'      => 'Siti Pelanggan',
            'password'  => bcrypt('1234'),
            'role_id'   => $rolePelanggan->id
        ]);

        // 3️⃣ Buat kategori
        $katGamis = Kategori::create([
            'kategori'  => "Gamis Syar'i",
            'user_id'   => $admin->id
        ]);
        $katAbaya = Kategori::create([
            'kategori'  => 'Abaya & Kaftan',
            'user_id'   => $admin->id
        ]);
        $katDress = Kategori::create([
            'kategori'  => 'Dress Muslimah',
            'user_id'   => $admin->id
        ]);
        $katKhimar = Kategori::create([
            'kategori'  => 'Khimar & Hijab',
            'user_id'   => $admin->id
        ]);
        $katBahan = Kategori::create([
            'kategori'  => 'Bahan Kain & Tekstil',
            'user_id'   => $admin->id
        ]);

        // Satuan
        $satuanPcs = Satuan::create([
            'satuan'  => 'Pcs',
            'user_id' => $admin->id
        ]);
        $satuanSet = Satuan::create([
            'satuan'  => 'Set',
            'user_id' => $admin->id
        ]);
        $satuanMeter = Satuan::create([
            'satuan'  => 'Meter',
            'user_id' => $admin->id
        ]);

        // 4️⃣ Supplier
        Supplier::create([
            'supplier'  => 'Toko 51 Baledono',
            'alamat'    => 'Baledono, Purworejo',
            'user_id'   => $admin->id
        ]);
        Supplier::create([
            'supplier'  => 'Toko Daya Agung Purworejo',
            'alamat'    => 'Baledono, Purworejo',
            'user_id'   => $admin->id
        ]);
        Supplier::create([
            'supplier'  => 'Konveksi Hijab & Gamis Solo',
            'alamat'    => 'Pasar Klewer, Surakarta',
            'user_id'   => $admin->id
        ]);

        // 5️⃣ Setting penjualan
        SettingPenjualan::create([
            'diskon_enabled'    => 1,
            'diskon_presentase' => 10,
            'ppn_enabled'       => 1,
            'ppn_presentase'    => 11,
        ]);

        // 6️⃣ Kas awal
        Kas::create([
            'tanggal'       => now()->toDateString(),
            'saldo'         => 100000.00,
            'pengeluaran'   => 0.00,
            'pemasukan'     => 0.00
        ]);

        // 7️⃣ Data Pembelian Barang (Bahan Masuk)
        PembelianBarang::create([
            'kd_pembelian_barang' => 'PRD-1001',
            'nm_barang'           => 'Kain Katun Toyobo Fodu',
            'deskripsi'           => 'Kain katun toyobo jepang kualitas fodu, halus, adem, dan menyerap keringat.',
            'stok'                => 500,
            'harga_beli'          => 45000,
            'kategori_id'         => $katBahan->id,
            'satuan_id'           => $satuanMeter->id,
            'user_id'             => $admin->id
        ]);

        PembelianBarang::create([
            'kd_pembelian_barang' => 'PRD-1002',
            'nm_barang'           => 'Kain Ceruty Babydoll Premium',
            'deskripsi'           => 'Bahan ceruty babydoll jatuh, lembut, mewah untuk gamis layer.',
            'stok'                => 800,
            'harga_beli'          => 35000,
            'kategori_id'         => $katBahan->id,
            'satuan_id'           => $satuanMeter->id,
            'user_id'             => $admin->id
        ]);

        // 8️⃣ Data Penjualan Barang (Koleksi Gamis & Busana Muslim untuk Katalog Publik)
        $products = [
            [
                'kd_penjualan_barang' => 'GMS-001',
                'nm_barang'           => 'Abaya Basic Jetblack Saudi',
                'deskripsi'           => 'Abaya basic hitam pekat elegan menggunakan kain Jetblack Saudi export quality. Busui friendly dengan resleting depan, wudhu friendly manset karet elastis.',
                'stok'                => 45,
                'harga_beli'          => 150000,
                'harga_jual'          => 275000,
                'diskon_persen'       => 10,
                'ppn_persen'          => 11,
                'kategori_id'         => $katAbaya->id,
                'satuan_id'           => $satuanPcs->id,
                'user_id'             => $admin->id,
            ],
            [
                'kd_penjualan_barang' => 'GMS-002',
                'nm_barang'           => 'Gamis Ceruty Babydoll 2 Layer Mawar',
                'deskripsi'           => 'Gamis syari cantik dengan bahan Ceruty Babydoll original full furing katun hero. Motif floral soft dengan tali pinggang adjustabele dan aksen rempel anggun.',
                'stok'                => 38,
                'harga_beli'          => 180000,
                'harga_jual'          => 320000,
                'diskon_persen'       => 15,
                'ppn_persen'          => 11,
                'kategori_id'         => $katGamis->id,
                'satuan_id'           => $satuanSet->id,
                'user_id'             => $admin->id,
            ],
            [
                'kd_penjualan_barang' => 'GMS-003',
                'nm_barang'           => 'Dress Muslimah Silk Armani Champagne',
                'deskripsi'           => 'Dress mewah berbahan Armani Silk premium berkarakteristik shiny dove, lembut dan dingin di kulit. Cocok untuk kondangan, wisuda, dan hari raya.',
                'stok'                => 24,
                'harga_beli'          => 220000,
                'harga_jual'          => 385000,
                'diskon_persen'       => 5,
                'ppn_persen'          => 11,
                'kategori_id'         => $katDress->id,
                'satuan_id'           => $satuanPcs->id,
                'user_id'             => $admin->id,
            ],
            [
                'kd_penjualan_barang' => 'GMS-004',
                'nm_barang'           => 'Set Gamis French Khimar Mahabbah',
                'deskripsi'           => 'Setelan gamis syari komplit dengan French Khimar model V-shape. Bahan Cey Airflow Crinkle ironless (tidak perlu disetrika), sangat praktis.',
                'stok'                => 50,
                'harga_beli'          => 195000,
                'harga_jual'          => 349000,
                'diskon_persen'       => 20,
                'ppn_persen'          => 11,
                'kategori_id'         => $katGamis->id,
                'satuan_id'           => $satuanSet->id,
                'user_id'             => $admin->id,
            ],
            [
                'kd_penjualan_barang' => 'GMS-005',
                'nm_barang'           => 'Kaftan Silk Bordir Payet Dubai',
                'deskripsi'           => 'Kaftan premium dengan detail bordir manual khas Timur Tengah dan payet mutiara sintetis. All size fit to XXL dengan tali serut dalam.',
                'stok'                => 18,
                'harga_beli'          => 260000,
                'harga_jual'          => 450000,
                'diskon_persen'       => 10,
                'ppn_persen'          => 11,
                'kategori_id'         => $katAbaya->id,
                'satuan_id'           => $satuanPcs->id,
                'user_id'             => $admin->id,
            ],
            [
                'kd_penjualan_barang' => 'GMS-006',
                'nm_barang'           => 'Gamis Daily Linen Katun Bordir Bunga',
                'deskripsi'           => 'Gamis kasual harian dari bahan Linen Rami natural mix Katun. Cutting A-line lebar, saku kanan kiri, sangat adem dan nyaman seharian.',
                'stok'                => 60,
                'harga_beli'          => 120000,
                'harga_jual'          => 215000,
                'diskon_persen'       => 0,
                'ppn_persen'          => 11,
                'kategori_id'         => $katDress->id,
                'satuan_id'           => $satuanPcs->id,
                'user_id'             => $admin->id,
            ],
            [
                'kd_penjualan_barang' => 'GMS-007',
                'nm_barang'           => 'Khimar Syari Non-Pet Ceruty 3 Layer',
                'deskripsi'           => 'Khimar jumbo menutup dada dan punggung dengan 3 layer ceruty anggun. Jahitan tepi rapi (bukan neci), nyaman tanpa rasa gerah.',
                'stok'                => 75,
                'harga_beli'          => 65000,
                'harga_jual'          => 119000,
                'diskon_persen'       => 10,
                'ppn_persen'          => 11,
                'kategori_id'         => $katKhimar->id,
                'satuan_id'           => $satuanPcs->id,
                'user_id'             => $admin->id,
            ],
            [
                'kd_penjualan_barang' => 'GMS-008',
                'nm_barang'           => 'Abaya Turkey Ruffle Pleated Sage Green',
                'deskripsi'           => 'Abaya modis gaya Turki dengan detail pleated plisket halus di bagian lengan dan bawah rok. Warna sage green pastel yang kekinian.',
                'stok'                => 30,
                'harga_beli'          => 170000,
                'harga_jual'          => 295000,
                'diskon_persen'       => 12,
                'ppn_persen'          => 11,
                'kategori_id'         => $katAbaya->id,
                'satuan_id'           => $satuanPcs->id,
                'user_id'             => $admin->id,
            ],
        ];

        foreach ($products as $p) {
            PenjualanBarang::create($p);
        }
    }
}
