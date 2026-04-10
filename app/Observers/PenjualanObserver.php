<?php

namespace App\Observers;

use App\Models\PenjualanBulanan;

class PenjualanObserver
{
    /**
     * Handle the PenjualanBulanan "created" event.
     */
    public function created(PenjualanBulanan $penjualan)
    {
        // 1. Ambil data barang yang terkait dengan penjualan ini
        // (Pastikan di Model PenjualanBulanan sudah ada function barang())
        $barang = $penjualan->barang;

        if ($barang) {
            // 2. Kurangi kolom 'stok' di tabel barang sejumlah yang terjual
            $barang->decrement('stok', $penjualan->total_terjual);
        }
    }

    /**
     * Handle the PenjualanBulanan "updated" event.
     */
    public function updated(PenjualanBulanan $penjualanBulanan): void
    {
        //
    }

    /**
     * Handle the PenjualanBulanan "deleted" event.
     */
    public function deleted(PenjualanBulanan $penjualanBulanan): void
    {
        //
    }

    /**
     * Handle the PenjualanBulanan "restored" event.
     */
    public function restored(PenjualanBulanan $penjualanBulanan): void
    {
        //
    }

    /**
     * Handle the PenjualanBulanan "force deleted" event.
     */
    public function forceDeleted(PenjualanBulanan $penjualanBulanan): void
    {
        //
    }
}
