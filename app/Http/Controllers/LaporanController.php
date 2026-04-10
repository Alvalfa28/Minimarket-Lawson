<?php

namespace App\Http\Controllers;

use App\Models\PenjualanBulanan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Parameter Input (Search & Sort)
        $search = $request->get('search');
        $sortField = $request->get('sort', 'tahun'); 
        $sortOrder = $request->get('order', 'desc');

        // 2. Query Data Laporan dengan Filter & Sorting
        $laporan = PenjualanBulanan::with('barang')
            // Logika Pencarian Real-time
            ->when($search, function($query) use ($search) {
                return $query->whereHas('barang', function($q) use ($search) {
                    $q->where('nama_barang', 'LIKE', "%{$search}%")
                      ->orWhere('kode_barang', 'LIKE', "%{$search}%");
                });
            })
            // Logika Pengurutan Tabel
            ->orderBy($sortField, $sortOrder)
            ->when($sortField == 'tahun', function($query) use ($sortOrder) {
                return $query->orderBy('bulan', $sortOrder);
            })
            ->get();

        // 3. Data Pendukung untuk Modal (DIURUTKAN BERDASARKAN KODE BARANG)
        $barangs = Barang::orderBy('kode_barang', 'asc')->get();

        return view('laporan.index', compact('laporan', 'barangs', 'search', 'sortField', 'sortOrder'));
    }

    public function store(Request $request)
    {
        // Validasi Input (Pastikan table 'barang' tunggal)
        $request->validate([
            'barang_id'     => 'required|exists:barang,id',
            'bulan_tahun'   => 'required',
            'total_terjual' => 'required|numeric|min:1',
        ]);

        // Pecah input bulan (format: 2026-03)
        $dateParts = explode('-', $request->bulan_tahun);
        
        // Simpan Data Penjualan
        PenjualanBulanan::create([
            'barang_id'     => $request->barang_id,
            'bulan'         => (int)$dateParts[1],
            'tahun'         => $dateParts[0],
            'total_terjual' => $request->total_terjual,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Data penjualan Lawson berhasil dicatat!');
    }

    // --- FITUR BARU: UPDATE DATA ---
    public function update(Request $request, $id)
    {
        $request->validate([
            'total_terjual' => 'required|numeric|min:1',
        ]);

        $laporan = PenjualanBulanan::findOrFail($id);
        $laporan->update([
            'total_terjual' => $request->total_terjual
        ]);

        return redirect()->route('laporan.index')->with('success', 'Data penjualan berhasil diperbarui!');
    }

    // --- FITUR BARU: HAPUS DATA ---
    public function destroy($id)
    {
        $laporan = PenjualanBulanan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Data penjualan berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return redirect()->back()->with('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
        }

        // Menghapus banyak data sekaligus
        // Catatan: Observer tetap akan berjalan jika menggunakan model-based delete
        $dataPenjualan = \App\Models\PenjualanBulanan::whereIn('id', $ids)->get();
        
        foreach ($dataPenjualan as $data) {
            $data->delete();
        }

        return redirect()->route('laporan.index')->with('success', 'Data pilihan berhasil dihapus dari sistem Lawson!');
    }
}