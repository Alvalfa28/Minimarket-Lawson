@extends('layouts.app')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Laporan Penjualan</h2>
        <p class="text-gray-500">Riwayat transaksi bulanan produk Lawson.</p>
    </div>
    <div class="flex gap-3">
        <div class="hidden md:block text-sm bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200 self-center font-medium font-mono text-gray-600">
            📅 {{ now()->translatedFormat('d F Y') }}
        </div>
        <button onclick="document.getElementById('modalJual').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-100 transition flex items-center gap-2 transform active:scale-95">
            <span class="text-xl">+</span> Input Penjualan
        </button>
    </div>
</div>

{{-- AREA PENCARIAN & SORTIR --}}
<div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
    <div class="flex gap-4 items-center w-full md:w-auto">
        <div class="flex gap-2 p-1 bg-gray-100 rounded-2xl border border-gray-200">
            <a href="{{ route('laporan.index', ['sort' => 'tahun', 'order' => 'desc', 'search' => $search]) }}" 
               class="px-4 py-2 text-xs font-bold rounded-xl transition {{ $sortField == 'tahun' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Terbaru
            </a>
            <a href="{{ route('laporan.index', ['sort' => 'total_terjual', 'order' => 'desc', 'search' => $search]) }}" 
               class="px-4 py-2 text-xs font-bold rounded-xl transition {{ $sortField == 'total_terjual' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Terlaris
            </a>
        </div>

        {{-- TOMBOL HAPUS MASAL --}}
        <button id="btnDeleteSelected" onclick="submitBulkDelete()" class="hidden bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-xl text-xs font-black transition border border-red-100 animate-in fade-in slide-in-from-left-2">
            🗑️ Hapus Terpilih (<span id="countSelected">0</span>)
        </button>
    </div>

    <form action="{{ route('laporan.index') }}" method="GET" id="searchForm" class="relative w-full md:w-80 group">
        <input type="hidden" name="sort" value="{{ $sortField }}">
        <input type="hidden" name="order" value="{{ $sortOrder }}">
        <input type="text" name="search" id="searchInput" value="{{ $search }}" autocomplete="off" placeholder="Cari Nama atau Kode Produk..." 
               class="w-full pl-11 pr-10 py-3 bg-white border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm group-hover:border-gray-300">
        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔍</div>
        @if($search)
            <a href="{{ route('laporan.index', ['sort' => $sortField, 'order' => $sortOrder]) }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 hover:text-red-500 transition text-xl font-bold">&times;</a>
        @endif
    </form>
</div>

{{-- FORM BULK DELETE & TABEL DATA --}}
<form id="bulkDeleteForm" action="{{ route('laporan.bulkDelete') }}" method="POST">
    @csrf @method('DELETE')
    <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-400 text-[10px] uppercase font-black tracking-widest border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-5 w-10">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition cursor-pointer">
                        </th>
                        <th class="px-8 py-5">
                            <a href="{{ route('laporan.index', ['sort' => 'tahun', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-blue-600 transition flex items-center gap-1">
                                Bulan & Tahun {!! $sortField == 'tahun' ? ($sortOrder == 'asc' ? '↑' : '↓') : '↕' !!}
                            </a>
                        </th>
                        <th class="px-8 py-5">Nama Produk</th>
                        <th class="px-8 py-5 text-center">
                            <a href="{{ route('laporan.index', ['sort' => 'total_terjual', 'order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="hover:text-blue-600 transition flex items-center justify-center gap-1">
                                Jumlah Terjual {!! $sortField == 'total_terjual' ? ($sortOrder == 'asc' ? '↑' : '↓') : '↕' !!}
                            </a>
                        </th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($laporan as $l)
                    <tr class="hover:bg-blue-50/30 transition group">
                        <td class="px-8 py-5">
                            <input type="checkbox" name="ids[]" value="{{ $l->id }}" class="sub_chk w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition cursor-pointer">
                        </td>
                        <td class="px-8 py-5 font-bold text-gray-800">
                            {{ \Carbon\Carbon::createFromDate($l->tahun, $l->bulan, 1)->translatedFormat('F Y') }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-800 group-hover:text-blue-600 transition">{{ $l->barang->nama_barang ?? 'Produk Tidak Ditemukan' }}</span>
                                <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter">{{ $l->barang->kode_barang ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="inline-block bg-gray-100 group-hover:bg-blue-100 text-gray-600 group-hover:text-blue-700 px-4 py-2 rounded-xl font-black text-xs transition min-w-[90px]">
                                {{ number_format($l->total_terjual, 0, ',', '.') }} Pcs
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="openEditModal({{ $l->id }}, '{{ $l->barang->nama_barang ?? 'Produk' }}', {{ $l->total_terjual }})" 
                                        class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 transition border border-amber-100">✏️</button>
                                <button type="button" onclick="confirmSingleDelete({{ $l->id }})" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition border border-red-100">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-8 py-20 text-center text-gray-400 italic">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</form>

{{-- Hidden Form for Single Delete --}}
<form id="singleDeleteForm" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>

{{-- MODAL INPUT --}}
<div id="modalJual" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden transform transition-all animate-in fade-in zoom-in duration-200">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Catat Penjualan</h3>
            <button onclick="document.getElementById('modalJual').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <form action="{{ route('laporan.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Pilih Produk Lawson</label>
                <select name="barang_id" class="w-full bg-gray-50 border border-gray-200 p-3.5 rounded-xl outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled selected>-- Pilih Produk --</option>
                    @foreach($barangs as $b)
                        <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Periode</label>
                    <input type="month" name="bulan_tahun" class="w-full bg-gray-50 border border-gray-200 p-3.5 rounded-xl outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jumlah</label>
                    <input type="number" name="total_terjual" class="w-full bg-gray-50 border border-gray-200 p-3.5 rounded-xl outline-none focus:ring-2 focus:ring-blue-500" placeholder="0" min="1" required>
                </div>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('modalJual').classList.add('hidden')" class="flex-1 text-gray-500 font-bold py-3.5 hover:bg-gray-100 rounded-xl transition">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden transform transition-all animate-in fade-in zoom-in duration-200">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center text-gray-800">
            <h3 class="text-xl font-bold">Edit Penjualan</h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-2xl text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form id="formEdit" method="POST" class="p-6 space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nama Produk</label>
                <input type="text" id="edit_nama" class="w-full bg-gray-100 border-none p-3.5 rounded-xl text-gray-500 cursor-not-allowed" readonly>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jumlah Terjual</label>
                <input type="number" name="total_terjual" id="edit_jumlah" class="w-full bg-gray-50 border border-gray-200 p-3.5 rounded-xl outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="flex-1 text-gray-500 font-bold py-3.5 hover:bg-gray-100 rounded-xl transition">Batal</button>
                <button type="submit" class="flex-1 bg-amber-500 text-white font-bold py-3.5 rounded-xl hover:bg-amber-600 shadow-lg shadow-amber-200 transition">Update Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Logic Search Real-time
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    let typingTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => { searchForm.submit(); }, 500); 
    });

    // Logic Checkbox & Bulk Delete
    const selectAll = document.getElementById('selectAll');
    const subCheckboxes = document.querySelectorAll('.sub_chk');
    const btnDeleteSelected = document.getElementById('btnDeleteSelected');
    const countSelected = document.getElementById('countSelected');

    selectAll.addEventListener('click', function() {
        subCheckboxes.forEach(cb => cb.checked = selectAll.checked);
        updateDeleteButton();
    });

    subCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateDeleteButton);
    });

    function updateDeleteButton() {
        const checkedCount = document.querySelectorAll('.sub_chk:checked').length;
        if (checkedCount > 0) {
            btnDeleteSelected.classList.remove('hidden');
            countSelected.innerText = checkedCount;
        } else {
            btnDeleteSelected.classList.add('hidden');
        }
    }

    function submitBulkDelete() {
        if (confirm('Apakah Anda yakin ingin menghapus data terpilih?')) {
            document.getElementById('bulkDeleteForm').submit();
        }
    }

    // Logic Modal Edit & Delete
    function openEditModal(id, nama, jumlah) {
        document.getElementById('formEdit').action = "/laporan/" + id;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_jumlah').value = jumlah;
        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function confirmSingleDelete(id) {
        if (confirm('Hapus data ini?')) {
            const form = document.getElementById('singleDeleteForm');
            form.action = "/laporan/" + id;
            form.submit();
        }
    }

    window.onload = function() {
        if(searchInput.value !== "") {
            const val = searchInput.value;
            searchInput.value = ''; searchInput.focus(); searchInput.value = val;
        }
    };
</script>
@endsection