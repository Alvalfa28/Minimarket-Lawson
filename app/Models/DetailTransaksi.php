<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    // Paksa Laravel menggunakan nama tabel tunggal sesuai migrasi
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id', 
        'barang_id', 
        'jumlah', 
        'harga_satuan', 
        'subtotal'
    ];
}