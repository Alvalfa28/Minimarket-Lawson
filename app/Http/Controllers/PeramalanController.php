<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PenjualanBulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeramalanController extends Controller
{
    public function index()
    {
        $barangs = Barang::orderBy('kode_barang', 'asc')->get();
        return view('peramalan.index', compact('barangs'));
    }

    public function hitung(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id'
        ]);

        $selectedBarang = Barang::findOrFail($request->barang_id);

        // 1. AMBIL DATA HISTORIS (3 Bulan Terakhir)
        $history = PenjualanBulanan::where('barang_id', $request->barang_id)
                    ->orderBy('tahun', 'desc')
                    ->orderBy('bulan', 'desc')
                    ->take(4) // Ambil 4 data: 3 untuk ramalan, 1 untuk cek MAPE (aktual)
                    ->get();

        if ($history->count() < 3) {
            return back()->with('error', 'Data penjualan ' . $selectedBarang->nama_barang . ' minimal harus 3 bulan untuk peramalan WMA.');
        }

        // 2. LOGIKA WMA (Berdasarkan J.E.4 Proposal)
        // Urutan: $history[0] = Bulan Terbaru (t), $history[1] = (t-1), $history[2] = (t-2)
        $bobot1 = 3; // Bobot tertinggi untuk data paling baru
        $bobot2 = 2;
        $bobot3 = 1;
        $totalBobot = 6;

        $perhitunganWma = (
            ($history[0]->total_terjual * $bobot1) + 
            ($history[1]->total_terjual * $bobot2) + 
            ($history[2]->total_terjual * $bobot3)
        ) / $totalBobot;

        // Gunakan ceil() agar hasil 55.83 menjadi 56 (Sesuai Revisi J.E.4)
        $hasilRamalan = ceil($perhitunganWma);

        // 3. LOGIKA MAPE (Berdasarkan J.E.5 Proposal)
        // Kita bandingkan data aktual bulan terbaru dengan ramalan yang seharusnya terjadi
        $nilaiMape = 0;
        $kategori = ['label' => 'Belum Tersedia', 'color' => 'text-gray-500', 'bg' => 'bg-gray-100'];

        if ($history->count() >= 4) {
            // Prediksi bulan lalu (menggunakan data t-1, t-2, t-3)
            $prediksiLalu = (
                ($history[1]->total_terjual * 3) + 
                ($history[2]->total_terjual * 2) + 
                ($history[3]->total_terjual * 1)
            ) / 6;
            
            $aktualSekarang = $history[0]->total_terjual;

            if ($aktualSekarang > 0) {
                $nilaiMape = (abs($aktualSekarang - $prediksiLalu) / $aktualSekarang) * 100;
                $nilaiMape = round($nilaiMape, 2);
                $kategori = $this->getKategoriAkurasi($nilaiMape);
            }
        }

        return view('peramalan.index', [
            'barangs' => Barang::orderBy('kode_barang', 'asc')->get(),
            'selectedBarang' => $selectedBarang,
            'history' => $history,
            'hasil' => $hasilRamalan,
            'nilaiMape' => $nilaiMape,
            'kategori' => $kategori
        ]);
    }

    private function getKategoriAkurasi($mape)
    {
        if ($mape <= 10) return ['label' => 'Sangat Akurat', 'color' => 'text-green-600', 'bg' => 'bg-green-100'];
        if ($mape <= 20) return ['label' => 'Baik', 'color' => 'text-blue-600', 'bg' => 'bg-blue-100'];
        if ($mape <= 50) return ['label' => 'Cukup', 'color' => 'text-yellow-600', 'bg' => 'bg-yellow-100'];
        return ['label' => 'Tidak Akurat', 'color' => 'text-red-600', 'bg' => 'bg-red-100'];
    }
}