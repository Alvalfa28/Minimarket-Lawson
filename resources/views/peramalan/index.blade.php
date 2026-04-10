@extends('layouts.app')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Peramalan Stok</h2>
        <p class="text-gray-500">Prediksi kebutuhan menggunakan metode Weighted Moving Average (WMA-3).</p>
    </div>
    <div class="text-sm bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200 font-medium font-mono text-gray-600">
        📅 {{ now()->translatedFormat('d F Y') }}
    </div>
</div>

{{-- Form Input --}}
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <form action="{{ route('peramalan.hitung') }}" method="POST">
        @csrf
        <label class="block text-xs font-bold text-gray-400 uppercase mb-3 tracking-widest">Pilih Produk Lawson</label>
        <div class="flex flex-col md:flex-row gap-4">
            <select name="barang_id" class="flex-1 bg-gray-50 border border-gray-200 p-3.5 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition appearance-none font-medium text-gray-700 cursor-pointer" required>
                <option value="" disabled {{ !isset($selectedBarang) ? 'selected' : '' }}>-- Pilih Produk --</option>
                @foreach($barangs as $b)
                    <option value="{{ $b->id }}" {{ (isset($selectedBarang) && $selectedBarang->id == $b->id) ? 'selected' : '' }}>
                        {{ $b->kode_barang }} - {{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-blue-100 transition flex items-center justify-center transform active:scale-95">
                Hitung Prediksi
            </button>
        </div>
    </form>
</div>

@if(isset($hasil))
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    {{-- Card Hasil Prediksi & Akurasi MAPE --}}
    <div class="md:col-span-1 space-y-6">
        <div class="bg-white p-8 rounded-3xl shadow-sm border-b-[10px] border-blue-600 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5 text-6xl text-blue-600 font-black tracking-tighter">WMA3</div>
            <p class="text-xs font-black text-blue-500 uppercase tracking-widest mb-4">Estimasi Stok Bulan Depan</p>
            <h3 class="text-7xl font-black text-gray-800 leading-tight">
                {{ $hasil }}<span class="text-xl font-normal text-gray-400 ml-2 italic text-shadow-none">Pcs</span>
            </h3>
            <div class="mt-6 pt-6 border-t border-gray-100">
                <p class="text-sm text-gray-600 leading-relaxed italic">
                    Hasil untuk <span class="font-bold text-blue-600">{{ $selectedBarang->nama_barang }}</span> dibulatkan ke atas (ceil) sesuai standar pengadaan stok.
                </p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest">Uji Akurasi MAPE</h4>
                <span class="px-3 py-1 {{ $kategori['bg'] }} {{ $kategori['color'] }} rounded-full text-[10px] font-black uppercase">
                    {{ $kategori['label'] }}
                </span>
            </div>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-black text-gray-800">{{ $nilaiMape }}%</span>
                <span class="text-gray-400 text-xs mb-1 font-bold">Error Rate</span>
            </div>
        </div>
    </div>

    {{-- Tabel Histori & Formulasi --}}
    <div class="md:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="p-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h4 class="text-lg font-bold text-gray-800 tracking-tight">Data Historis & Pembobotan</h4>
            <span class="text-[10px] bg-blue-100 text-blue-600 px-3 py-1.5 rounded-xl font-bold uppercase tracking-wider">Metode: WMA (3,2,1)</span>
        </div>
        
        <div class="p-6 flex-1">
            <div class="grid grid-cols-1 gap-3">
                @foreach($history->take(3) as $key => $h)
                <div class="flex justify-between items-center p-4 bg-gray-50/50 rounded-2xl border border-gray-100 transition hover:border-blue-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex flex-col items-center justify-center shadow-sm">
                            <p class="text-[9px] text-gray-400 font-bold leading-none mb-1">BOBOT</p>
                            <p class="font-black text-blue-600 leading-none">{{ 3 - $key }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-0 font-mono">Periode</p>
                            <p class="font-bold text-gray-800 leading-none mt-1">
                                {{ \Carbon\Carbon::createFromDate($h->tahun, $h->bulan, 1)->translatedFormat('F Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-gray-400 font-bold uppercase mb-0">Terjual</p>
                        <p class="text-xl font-black text-gray-800">{{ number_format($h->total_terjual, 0, ',', '.') }} <span class="text-xs font-normal text-gray-400 font-mono">Pcs</span></p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Formulasi Matematis yang Diperbarui (Sesuai masukan warna) --}}
            <div class="mt-6 p-5 bg-gray-50 border border-gray-100 rounded-2xl text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                <p class="text-[9px] text-gray-400 font-black uppercase mb-3 tracking-[0.2em]">Formulasi Matematis (WMA)</p>
                <div class="flex flex-wrap justify-center items-center gap-2 text-gray-700 font-mono text-[11px]">
                    
                    <span class="bg-white px-2 py-1 rounded-lg border border-transparent shadow-sm">
                        (<span class="text-blue-600 font-bold">{{ $history[0]->total_terjual }}</span>×3)
                    </span>
                    
                    <span class="text-gray-300">+</span>
                    
                    <span class="bg-white px-2 py-1 rounded-lg border border-transparent shadow-sm">
                        (<span class="text-blue-600 font-bold">{{ $history[1]->total_terjual }}</span>×2)
                    </span>
                    
                    <span class="text-gray-300">+</span>
                    
                    <span class="bg-white px-2 py-1 rounded-lg border border-transparent shadow-sm">
                        (<span class="text-blue-600 font-bold">{{ $history[2]->total_terjual }}</span>×1)
                    </span>
                    
                    <span class="text-gray-400">/ 6</span>
                    <span class="text-gray-400">=</span>
                    
                    <span class="bg-blue-600 px-4 py-1.5 rounded-xl font-black text-white text-sm shadow-md shadow-blue-100 ml-1">
                        {{ $hasil }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-100 text-red-600 p-4 rounded-2xl font-bold text-center animate-shake mt-4">
    ⚠️ {{ session('error') }}
</div>
@endif
@endsection