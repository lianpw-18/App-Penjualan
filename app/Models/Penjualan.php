<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    protected $guarded = ['id'];

    // Fillable sesuai dengan kolom yang ada
    protected $fillable = [
        'kd_pembelian_barang', // sesuai nama kolom di tabel
        'tgl_transaksi',
        'jumlah_pembayaran',
        'sub_total',
        'uang_kembalian', // kolom ini ada di tabel
        'diskon',
        'ppn'
    ];

    // Cast untuk tipe data yang tepat
    protected $casts = [
        'tgl_transaksi' => 'date',
        'jumlah_pembayaran' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'uang_kembalian' => 'decimal:2',
        'diskon' => 'integer', // di tabel bertipe int
        'ppn' => 'integer', // di tabel bertipe int
    ];

    // Relasi yang sudah ada - TIDAK DIHAPUS
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    // TAMBAHAN RELASI BARU - untuk mengatasi error
    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }

    // Jika menggunakan nama tabel yang berbeda, bisa juga coba ini:
    // public function detailPenjualans()
    // {
    //     return $this->hasMany(DetailPenjualan::class, 'penjualan_id', 'id');
    // }

    // Atau jika nama tabel detail berbeda:
    // public function detailPenjualans()
    // {
    //     return $this->hasMany('App\Models\DetailPenjualan', 'penjualan_id');
    // }
}
