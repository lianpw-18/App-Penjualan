# 📊 Aplikasi Pajak Pertambahan Nilai (PPN) Pada Laporan Penjualan UMKM Sansin Indonesia

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![License](https://img.shields.io/badge/Status-Tugas%20Akhir%20D3-success?style=for-the-badge)]()

Aplikasi berbasis web ini dikembangkan untuk memenuhi syarat kelulusan **Jenjang Diploma Tiga (D3) Program Studi Komputerisasi Akuntansi**. 

Sistem ini dirancang guna mengatasi kendala pencatatan semi-manual berbasis lembar kerja (Excel) di **UMKM fashion Sansin Indonesia**, mengotomatisasi perhitungan **Pajak Pertambahan Nilai (PPN 11%)**, serta menyajikan laporan penjualan dan rekonsiliasi perpajakan secara *real-time* dan akurat.

---

## 📌 Latar Belakang & Tujuan Proyek

UMKM fashion **Sansin Indonesia** bergerak di bidang produksi dan penjualan busana muslimah (gamis, abaya, khimar, dan bahan tekstil). Sebelumnya, pencatatan transaksi masuk-keluar barang serta rekapitulasi penjualan masih menggunakan metode semi-manual berbasis spreadsheet yang memiliki kelemahan:
- Rawan terjadi kesalahan hitung (*human error*) pada kalkulasi diskon dan PPN.
- Sulit memantau ketersediaan stok bahan baku dan produk jadi secara langsung (*real-time*).
- Rekonsiliasi antara **PPN Masukan** (dari pembelian bahan/supplier) dan **PPN Keluaran** (dari transaksi penjualan ke konsumen) memakan waktu lama saat penutupan periode pembukuan.

Dengan kehadiran aplikasi ini, seluruh proses operasional mulai dari inventori, kasir kas, pesanan daring (*e-commerce*), hingga pelaporan pajak terintegrasi dalam satu sistem terpusat.

---

## 🚀 Fitur Utama

Sistem ini mendukung pengelolaan multi-peran (*Role-Based Access Control*) dengan fitur-fitur komprehensif:

### 1. 🛡️ Modul Admin (Backoffice & Pengelolaan Penuh)
- **Master Data Produk & Inventori**:
  - Manajemen Bahan Masuk / Pembelian Barang (Kain, Tekstil, dll.)
  - Manajemen Produk Penjualan (Gamis, Abaya, Khimar, Kaftan, dll.)
  - Fitur Import Data Produk via File Excel (`.xlsx`)
  - Fitur *Archive / Soft Delete*, *Restore*, dan *Permanent Delete* produk
  - Pengelolaan Kategori, Satuan Ukuran (Pcs, Set, Meter), dan Supplier
- **Transaksi Inventori**:
  - **Produk Masuk**: Pencatatan restock dan barang masuk dari supplier
  - **Produk Keluar**: Pencatatan pengeluaran barang non-penjualan / retur
- **Pengaturan Diskon & PPN**:
  - Konfigurasi status aktif/non-aktif Diskon & PPN
  - Pengaturan persentase PPN dinamis (standar 11%) dan persentase diskon
- **Manajemen Karyawan & Pengguna**:
  - Pengelolaan data akun karyawan, hak akses (*role*), dan kredensial login
- **Manajemen Pesanan Online (E-Commerce)**:
  - Verifikasi bukti pembayaran dari pemesanan katalog publik
  - Pembaruan status pesanan (Menunggu Pembayaran, Diproses, Dikirim, Selesai, Dibatalkan)
  - Pengisian nomor resi ekspedisi dan nomor pelacakan kurir
- **Monitoring Stok Real-Time**:
  - Dashboard monitoring status stok produk: **Aman**, **Menipis (Minimum)**, dan **Habis**
  - Widget grafik komposisi keuangan (*Doughnut Chart*) dan produk terlaris

### 2. 🧾 Menu Penjualan & Kasir (Point of Sale / POS)
- Antarmuka kasir cepat dengan pencarian produk cerdas (*autocomplete*)
- Kalkulasi otomatis subtotal, potongan diskon, dan tarif PPN 11%
- Perhitungan uang diterima dan kembalian secara instan
- Cetak struk/nota transaksi penjualan

### 3. 🛍️ Katalog Publik & Portal E-Commerce Pelanggan
- Halaman katalog produk dengan visual modern dan responsif
- Fitur keranjang belanja dan formulir *checkout* pengiriman
- Integrasi data wilayah administrasi Indonesia (Provinsi, Kota/Kabupaten, Kecamatan, Desa/Kelurahan)
- Halaman **Pesanan Saya** untuk customer:
  - Pelacakan status pengiriman pesanan secara *real-time*
  - Unggah bukti pembayaran transfer bank
- Manajemen profil pengguna dan ubah kata sandi

### 4. 📈 Laporan Akuntansi & Perpajakan Lengkap (Cetak PDF / Export)
- **Laporan Penjualan**: Rekap transaksi per periode, filter tanggal, dan kasir
- **Laporan Produk Masuk & Laporan Produk Keluar**: Audit arus fisik barang
- **Laporan Stok Produk**: Rekapitulasi kuantitas dan nilai aset inventori
- **Laporan PPN Masukan**: Rekap pajak masukan dari faktur pembelian bahan baku
- **Laporan PPN Keluaran**: Rekap pajak keluaran dari faktur penjualan produk
- **Laporan PPN Keseluruhan**: Rekonsiliasi arus pajak untuk mengetahui posisi **PPN Kurang Bayar** atau **PPN Lebih Bayar** pada masa pajak berjalan

---

## 💻 Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan arsitektur modern yang andal dan terstruktur:

| Komponen | Teknologi | Deskripsi |
| :--- | :--- | :--- |
| **Backend** | **PHP ^8.2 / ^8.4** & **Laravel Framework** | Arsitektur MVC, ORM Eloquent, Route & Middleware Security |
| **Frontend** | **Blade Templating**, **Bootstrap 5**, **HTML5**, **CSS3** | Tampilan antarmuka modern, interaktif, dan ramah seluler (*mobile-responsive*) |
| **Interaktivitas UI** | **JavaScript**, **jQuery**, **Chart.js**, **SweetAlert2**, **DataTables** | Visualisasi grafik keuangan, tabel data dinamis, dan dialog modal interaktif |
| **Database** | **MySQL / MariaDB** (phpMyAdmin / Laragon) | Penyimpanan data relasional ternormalisasi |
| **Integrasi Wilayah** | **Laravolt Indonesia** | Database master provinsi, kota, kecamatan, dan kelurahan |
| **Ekspor Dokumen** | **DomPDF** & **Maatwebsite Excel** | Cetak invoice/laporan PDF resmi dan ekspor/impor spreadsheet |
| **Metodologi & Desain** | **OOAD (Object-Oriented Analysis & Design)** | Pemodelan UML: *Use Case Diagram*, *Activity Diagram*, *Sequence Diagram* via Draw.io |

---

## ⚙️ Panduan Instalasi & Menjalankan Aplikasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan pengembangan lokal (misalnya menggunakan **Laragon** atau **XAMPP**):

### 1. Kloning Repositori
```bash
git clone https://github.com/lianpw-18/App-Penjualan.git
cd App-Penjualan
```

### 2. Pasang Dependensi Composer
```bash
composer install
```

### 3. Konfigurasi Lingkungan (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan pengaturan basis data:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_penjualan_ppn
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat Application Key
```bash
php artisan key:generate
```

### 5. Buat Symbolic Link Storage
```bash
php artisan storage:link
```

### 6. Jalankan Migrasi & Seeder Database
Pastikan layanan MySQL telah aktif, buat database sesuai konfigurasi di atas, lalu jalankan:
```bash
php artisan migrate --seed
```

### 7. Jalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui peramban web di:
```text
http://127.0.0.1:8000
```

---

## 🔑 Akun Demo Pengujian

Aplikasi telah dilengkapi seeder data awal untuk berbagai level peran pengguna:

| Role / Peran | Email | Kata Sandi | Halaman Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `1234` | `/admin/login` / Dashboard & Laporan Lengkap |
| **Kasir** | `kasir@gmail.com` | `1234` | `/admin/login` / Kasir POS & Laporan Penjualan |
| **Pelanggan** | `pelanggan@gmail.com` | `1234` | `/login` / Katalog, Keranjang & Pesanan Saya |

---

## 📁 Struktur Direktori Utama

```text
├── app/
│   ├── Http/Controllers/     # Pengendali logika bisnis (POS, PPN, Katalog, dll.)
│   ├── Models/                  # Model Eloquent (Penjualan, Pembelian, PPN, User)
├── config/                      # Konfigurasi aplikasi Laravel
├── database/
│   ├── migrations/              # Skema tabel basis data
│   └── seeders/                 # Data inisialisasi awal (User, Produk, Kategori)
├── public/                      # Aset publik statis (CSS, JS, Gambar Produk)
├── resources/
│   └── views/                   # Template tampilan Blade (Admin, Kasir, Customer)
├── routes/
│   └── web.php                  # Definisi rute antarmuka web & middleware
└── storage/                     # File upload, bukti pembayaran, dan log
```

---

## 🎓 Keterangan Akademik

Proyek ini disusun sebagai bagian dari penyusunan **Tugas Akhir**:
- **Jenjang**: Diploma Tiga (D3)
- **Program Studi**: Komputerisasi Akuntansi
- **Studi Kasus**: UMKM Sansin Indonesia (Fashion & Busana Muslimah)
