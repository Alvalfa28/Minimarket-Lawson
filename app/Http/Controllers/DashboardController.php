<?php

namespace App\Http\Controllers;

use App\Models\Barang; // Pastikan Model Barang di-import
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Total Item
        $totalBarang = Barang::count();

        // 2. Ambil Stok Kritis (Definisikan variabel ini!)
        // Asumsi: stok kritis adalah stok yang kurang dari atau sama dengan stok_minimum
        $stokMenipis = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();

        // 3. Ambil 5 barang terbaru
        $barangTerbaru = Barang::latest()->take(5)->get();

        // 4. Kirim SEMUA variabel ke view
        // Pastikan nama file view-nya 'dashboard.index' sesuai lokasi folder kamu
        return view('dashboard.index', compact('totalBarang', 'stokMenipis', 'barangTerbaru'));
    }
}