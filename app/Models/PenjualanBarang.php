<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanBarang extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $guarded = ['id'];
    protected $table = 'penjualan_barangs';

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
        'diskon_persen' => 'decimal:2',
        'ppn_persen' => 'decimal:2',
        'is_hidden' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke model Kategori
     * PERBAIKAN: Pastikan foreign key dan local key benar
     */
    public function kategori()
    {
        // Cek apakah field kategori_id ada di tabel penjualan_barangs
        // dan pastikan mengarah ke primary key yang benar di tabel kategoris
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    /**
     * Relasi ke model Satuan  
     * PERBAIKAN: Pastikan foreign key dan local key benar
     */
    public function satuan()
    {
        // Cek apakah field satuan_id ada di tabel penjualan_barangs
        // dan pastikan mengarah ke primary key yang benar di tabel satuans
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
    }

    /**
     * Relasi ke model Supplier (jika ada)
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Relasi ke model User (jika ada)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Scope untuk filter berdasarkan stok
     */
    public function scopeStokTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    /**
     * Scope untuk produk yang tidak disembunyikan
     */
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    /**
     * Scope untuk produk yang disembunyikan
     */
    public function scopeHidden($query)
    {
        return $query->where('is_hidden', true);
    }

    /**
     * Accessor untuk format harga beli
     */
    public function getFormattedHargaBeliAttribute()
    {
        return 'Rp. ' . number_format($this->harga_beli, 0, ',', '.');
    }

    /**
     * Accessor untuk format harga jual
     */
    public function getFormattedHargaJualAttribute()
    {
        return 'Rp. ' . number_format($this->harga_jual, 0, ',', '.');
    }

    /**
     * Accessor untuk status stok
     */
    public function getStatusStokAttribute()
    {
        if ($this->stok > 10) {
            return 'Aman';
        } elseif ($this->stok > 5) {
            return 'Perhatian';
        } else {
            return 'Kritis';
        }
    }

    /**
     * Accessor untuk menghitung nominal diskon
     */
    public function getNominalDiskonAttribute()
    {
        return $this->harga_jual * ($this->diskon_persen / 100);
    }

    /**
     * Accessor untuk harga setelah diskon
     */
    public function getHargaSetelahDiskonAttribute()
    {
        return $this->harga_jual - $this->nominal_diskon;
    }

    /**
     * Accessor untuk menghitung nominal PPN
     */
    public function getNominalPpnAttribute()
    {
        return $this->harga_setelah_diskon * ($this->ppn_persen / 100);
    }

    /**
     * Accessor untuk harga final (setelah diskon + PPN)
     */
    public function getHargaFinalAttribute()
    {
        return $this->harga_setelah_diskon + $this->nominal_ppn;
    }

    /**
     * Accessor untuk format nominal diskon
     */
    public function getFormattedNominalDiskonAttribute()
    {
        return 'Rp. ' . number_format($this->nominal_diskon, 0, ',', '.');
    }

    /**
     * Accessor untuk format harga setelah diskon
     */
    public function getFormattedHargaSetelahDiskonAttribute()
    {
        return 'Rp. ' . number_format($this->harga_setelah_diskon, 0, ',', '.');
    }

    /**
     * Accessor untuk format nominal PPN
     */
    public function getFormattedNominalPpnAttribute()
    {
        return 'Rp. ' . number_format($this->nominal_ppn, 0, ',', '.');
    }

    /**
     * Accessor untuk format harga final
     */
    public function getFormattedHargaFinalAttribute()
    {
        return 'Rp. ' . number_format($this->harga_final, 0, ',', '.');
    }
}