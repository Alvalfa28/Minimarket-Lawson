<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    // Paksa Laravel menggunakan nama tabel tunggal sesuai migrasi
    protected $table = 'transaksi';

    protected $fillable = [
        'kode_transaksi', 
        'tanggal', 
        'user_id', 
        'total_harga'
    ];
}