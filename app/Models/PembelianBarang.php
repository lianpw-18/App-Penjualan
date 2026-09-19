<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBarang extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    protected $fillable = [
        'kd_pembelian_barang',
        'nm_barang',
        'deskripsi',
        'stok',
        'harga_beli',
        'kategori_id',
        'satuan_id',
        'user_id'
    ];

    // Casting
    protected $casts = [
        'harga_beli' => 'decimal:2',
        'stok' => 'integer'
    ];

    // Relasi dengan Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi dengan Satuan
    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan ProdukMasuk berdasarkan nama produk (one to many)
    public function produkMasuk()
    {
        return $this->hasMany(ProdukMasuk::class, 'nm_produk', 'nm_barang');
    }

    // Accessor untuk format currency
    public function getFormattedHargaBeliAttribute()
    {
        return 'Rp ' . number_format($this->harga_beli, 0, ',', '.');
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    // Scope untuk filter berdasarkan satuan
    public function scopeBySatuan($query, $satuanId)
    {
        return $query->where('satuan_id', $satuanId);
    }

    // Scope untuk barang yang masih ada stoknya
    public function scopeHasStock($query)
    {
        return $query->where('stok', '>', 0);
    }
}