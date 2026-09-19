<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProdukMasuk extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $fillable = [
        'kd_transaksi',
        'nm_produk',
        'tgl_masuk',
        'stok_masuk',
        'harga_beli',
        'total_harga',
        'user_id',
        'supplier_id',
    ];

    protected $casts = [
        'tgl_masuk' => 'date',
        'harga_beli' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'stok_masuk' => 'integer'
    ];

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

    public function getTglMasukAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getPpnMasukanAttribute()
    {
        return $this->total_harga * 0.11;
    }

    public function getFormattedTotalHargaAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getFormattedHargaBeliAttribute()
    {
        return 'Rp ' . number_format($this->harga_beli, 0, ',', '.');
    }

    public function getFormattedPpnMasukanAttribute()
    {
        return 'Rp ' . number_format($this->ppn_masukan, 0, ',', '.');
    }

    public function getPembelianBarangAttribute()
    {
        return PembelianBarang::where('nm_barang', $this->nm_produk)
                             ->with(['kategori', 'satuan'])
                             ->first();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterByDate($query, $startDate = null, $endDate = null)
    {
        if ($startDate && $endDate) {
            return $query->whereBetween('tgl_masuk', [$startDate, $endDate]);
        } elseif ($startDate) {
            return $query->where('tgl_masuk', '>=', $startDate);
        } elseif ($endDate) {
            return $query->where('tgl_masuk', '<=', $endDate);
        }
        
        return $query;
    }
}