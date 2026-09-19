<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    // Tambahkan casting untuk memastikan tipe data yang tepat
    protected $casts = [
        'pemasukan' => 'decimal:2',
        'pengeluaran' => 'decimal:2', 
        'saldo' => 'decimal:2',
        'tanggal' => 'date'
    ];
}