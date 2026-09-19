<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKeluar extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    // TAMBAHKAN RELASI INI
    public function penjualanBarang()
    {
        return $this->belongsTo(PenjualanBarang::class, 'penjualan_barang_id');
    }

    // Metode untuk mendapatkan PPN berdasarkan nama produk
    public function getPenjualanBarangByName()
    {
        return PenjualanBarang::where('nm_barang', $this->nm_produk)->first();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedTotalHargaAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }
}