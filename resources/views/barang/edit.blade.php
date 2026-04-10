@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <a href="{{ route('barang.index') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition mb-2">
                <span class="mr-2">⬅️</span> Kembali ke Daftar Barang
            </a>
            <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Edit Produk</h2>
            <p class="text-gray-500">Perbarui informasi untuk item <span class="text-blue-600 font-bold">{{ $barang->nama_barang }}</span></p>
        </div>
        <div class="text-xs bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100 self-start md:self-center font-mono text-gray-400">
            ID: #{{ $barang->id }}
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="p-6 bg-gray-50/50 border-b border-gray-100 flex items-center gap-3">
            <div class="w-2 h-6 bg-blue-600 rounded-full"></div>
            <h4 class="text-lg font-bold text-gray-800">Form Perubahan Data</h4>
        </div>
        
        <form action="{{ route('barang.update', $barang->id) }}" method="POST" class="p-8 md:p-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Kode Barang (Permanen)</label>
                        <input type="text" value="{{ $barang->kode_barang }}" 
                            class="w-full bg-gray-100 border border-gray-200 p-4 rounded-2xl text-gray-500 font-mono cursor-not-allowed shadow-inner" readonly>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nama Produk</label>
                        <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" 
                            class="w-full bg-white border border-gray-200 p-4 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Kategori Departemen</label>
                        <select name="kategori" class="w-full bg-white border border-gray-200 p-4 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm cursor-pointer">
                            {{-- Gunakan kategori yang sama dengan Modal di Index --}}
                            <optgroup label="Makanan & Minuman">
                                <option value="Food & Snack" {{ $barang->kategori == 'Food & Snack' ? 'selected' : '' }}>🍿 Makanan Ringan / Snack</option>
                                <option value="Beverage" {{ $barang->kategori == 'Beverage' ? 'selected' : '' }}>🥤 Minuman (Botol/Kaleng)</option>
                                <option value="Ready to Eat" {{ $barang->kategori == 'Ready to Eat' ? 'selected' : '' }}>🍱 Makanan Siap Saji</option>
                                <option value="Instant Food" {{ $barang->kategori == 'Instant Food' ? 'selected' : '' }}>🍜 Mie Instan & Kaleng</option>
                                <option value="Bread & Pastry" {{ $barang->kategori == 'Bread & Pastry' ? 'selected' : '' }}>🍞 Roti & Kue</option>
                            </optgroup>
                            <optgroup label="Kebutuhan Harian">
                                <option value="Personal Care" {{ $barang->kategori == 'Personal Care' ? 'selected' : '' }}>🧼 Sabun & Perawatan Tubuh</option>
                                <option value="Home Care" {{ $barang->kategori == 'Home Care' ? 'selected' : '' }}>🧹 Pembersih Rumah Tangga</option>
                                <option value="Health Care" {{ $barang->kategori == 'Health Care' ? 'selected' : '' }}>💊 Obat & Kesehatan</option>
                                <option value="Baby Care" {{ $barang->kategori == 'Baby Care' ? 'selected' : '' }}>🍼 Kebutuhan Bayi</option>
                            </optgroup>
                            <optgroup label="Lainnya">
                                <option value="Stationery" {{ $barang->kategori == 'Stationery' ? 'selected' : '' }}>✏️ Alat Tulis & Kantor</option>
                                <option value="Miscellaneous" {{ $barang->kategori == 'Miscellaneous' ? 'selected' : '' }}>📦 Lain-lain / Umum</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Stok Saat Ini</label>
                            <input type="number" name="stok" value="{{ $barang->stok }}" 
                                class="w-full bg-white border border-gray-200 p-4 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Batas Minimum</label>
                            <input type="number" name="stok_minimum" value="{{ $barang->stok_minimum }}" 
                                class="w-full bg-white border border-gray-200 p-4 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Harga Jual (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-4 text-gray-400 font-bold">Rp</span>
                            <input type="number" name="harga_jual" value="{{ $barang->harga_jual }}" 
                                class="w-full bg-white border border-gray-200 p-4 pl-12 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Satuan</label>
                        <input type="text" name="satuan" value="{{ $barang->satuan }}" 
                            class="w-full bg-white border border-gray-200 p-4 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm" placeholder="Pcs, Pack, Kg, dll">
                    </div>
                    
                    <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                        <p class="text-[10px] text-blue-600 leading-relaxed font-bold uppercase tracking-wide">
                            ℹ️ Tips: Pastikan Stok Minimum terisi untuk mengaktifkan peringatan stok kritis di Dashboard.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-50 flex flex-col md:flex-row gap-4">
                <button type="submit" class="flex-[2] bg-blue-600 text-white font-black py-4 rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('barang.index') }}" class="flex-1 bg-gray-100 text-gray-500 text-center font-bold py-4 rounded-2xl hover:bg-gray-200 transition-all uppercase tracking-widest text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection