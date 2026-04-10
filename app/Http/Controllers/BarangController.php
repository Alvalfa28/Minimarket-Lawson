<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index() 
    {
        $barangs = Barang::orderBy('created_at', 'desc')->get();
        return view('barang.index', compact('barangs'));
    }

    public function create() 
    {
        return view('barang.create');
    }

    public function store(Request $request) 
    {
        // PERBAIKAN: Ganti 'barangs' menjadi 'barang' pada unique rule
        $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang',
            'nama_barang' => 'required',
            'harga_jual'  => 'required|numeric',
            'stok'        => 'required|numeric',
        ]);

        $data = $request->all();
        
        $data['kategori']     = $request->kategori ?? 'Lainnya'; 
        $data['stok_minimum'] = $request->stok_minimum ?? 5;
        $data['satuan']       = $request->satuan ?? 'Pcs';
        $data['harga_beli']   = $request->harga_beli ?? 0;

        Barang::create($data);
        
        return redirect()->route('barang.index')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function edit($id) 
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id) 
    {
        $barang = Barang::findOrFail($id);

        // PERBAIKAN: Ganti 'barangs' menjadi 'barang' pada unique rule
        $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang,' . $id,
            'nama_barang' => 'required',
            'harga_jual'  => 'required|numeric',
            'stok'        => 'required|numeric',
        ]);

        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Data produk ' . $barang->nama_barang . ' berhasil diperbarui!');
    }

    public function destroy($id) 
    {
        $barang = Barang::findOrFail($id);
        $nama_barang = $barang->nama_barang;
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Produk ' . $nama_barang . ' telah dihapus.');
    }
}