<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Paksa Laravel menggunakan nama tabel tunggal
    protected $table = 'barang'; 

    protected $fillable = [
        'kode_barang', 'nama_barang', 'kategori', 'harga_jual', 
        'stok', 'stok_minimum', 'satuan', 'harga_beli'
    ];

    public function penjualan()
    {
        return $this->hasMany(PenjualanBulanan::class, 'barang_id');
    }
}