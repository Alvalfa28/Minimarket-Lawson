@extends('layouts.app') {{-- Ini memanggil file resources/views/layouts/app.blade.php --}}

@section('content')
    {{-- Bagian Atas Dashboard --}}
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-800">Dashboard</h2>
            <p class="text-gray-500">Ringkasan data inventori Lawson secara real-time.</p>
        </div>
        <div class="text-sm bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
            📅 {{ now()->translatedFormat('d F Y') }}
        </div>
    </div>

    {{-- Ringkasan Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 font-semibold uppercase">Total Item</p>
                    <h3 class="text-4xl font-black text-gray-800 mt-1">{{ $totalBarang }}</h3>
                </div>
                <div class="p-4 bg-blue-50 rounded-xl text-2xl">📦</div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 font-semibold uppercase text-red-400">Stok Kritis</p>
                    <h3 class="text-4xl font-black text-red-600 mt-1">{{ $stokMenipis }}</h3>
                </div>
                <div class="p-4 bg-red-50 rounded-xl text-2xl">⚠️</div>
            </div>
            <p class="text-xs text-red-400 mt-4 italic">* Perlu segera re-order</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 font-semibold uppercase">Status Sistem</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-1">Normal</h3>
                </div>
                <div class="p-4 bg-green-50 rounded-xl text-2xl">✅</div>
            </div>
        </div>
    </div>

    {{-- Tabel Barang Terbaru --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="p-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h4 class="text-lg font-bold text-gray-800">Daftar Barang Terbaru</h4>
            <a href="{{ route('barang.index') }}" class="text-blue-600 text-sm font-semibold hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-400 text-xs uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Kode Barang</th>
                        <th class="px-6 py-4">Nama Produk</th>
                        <th class="px-6 py-4 text-center">Status Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($barangTerbaru as $b)
                    <tr class="hover:bg-blue-50/50 transition">
                        <td class="px-6 py-4 font-mono text-sm text-blue-600 font-bold">{{ $b->kode_barang }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-700">{{ $b->nama_barang }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($b->stok <= ($b->stok_minimum ?? 10))
                                <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-[10px] font-bold uppercase">
                                    Kritis: {{ $b->stok }} Pcs
                                </span>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-[10px] font-bold uppercase">
                                    Aman: {{ $b->stok }} Pcs
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection