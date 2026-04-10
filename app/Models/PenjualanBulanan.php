<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanBulanan extends Model
{
    use HasFactory;

    // Nama tabel di HeidiSQL kamu
    protected $table = 'penjualan_bulanan';

    // Kolom yang boleh diisi
    protected $fillable = ['barang_id', 'bulan', 'tahun', 'total_terjual'];

    /**
     * Relasi ke model Barang
     * Penjualan ini miliknya (belongsTo) satu Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}