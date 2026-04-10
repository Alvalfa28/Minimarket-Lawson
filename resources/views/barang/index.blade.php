@extends('layouts.app')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-800">Data Barang</h2>
        <p class="text-gray-500">Kelola informasi produk secara real-time.</p>
    </div>
    <div class="flex gap-3">
        <div class="text-sm bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200 self-center">
            📅 {{ now()->translatedFormat('d F Y') }}
        </div>
        <button onclick="openModal('tambah')" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-sm transition flex items-center gap-2">
            <span>+</span> Tambah Barang
        </button>
    </div>
</div>

{{-- Notifikasi Sukses --}}
@if(session('success'))
<div id="alert-success" class="fixed top-5 right-5 z-[9999] bg-green-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 animate-in fade-in slide-in-from-right-8 duration-300">
    <span class="text-2xl">✅</span>
    <div>
        <p class="font-bold">Berhasil!</p>
        <p class="text-xs opacity-90">{{ session('success') }}</p>
    </div>
</div>
<script>setTimeout(() => { document.getElementById('alert-success').remove(); }, 3000);</script>
@endif

{{-- Tabel Data --}}
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
    <div class="p-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
        <h4 class="text-lg font-bold text-gray-800">Seluruh Produk Lawson</h4>
        <span class="text-[10px] bg-blue-100 text-blue-600 px-4 py-1.5 rounded-full font-black uppercase tracking-wider">
            {{ $barangs->count() }} Total Produk
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-400 text-[10px] uppercase font-black tracking-widest">
                <tr>
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Nama Produk</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4 text-right">Harga Jual</th>
                    <th class="px-6 py-4 text-center">Stok</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($barangs as $b)
                <tr class="hover:bg-blue-50/30 transition group">
                    <td class="px-6 py-4 font-mono text-sm text-blue-600 font-bold tracking-tighter">{{ $b->kode_barang }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-700 leading-none">{{ $b->nama_barang }}</p>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase">{{ $b->satuan ?? 'Pcs' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-[10px] font-black uppercase tracking-tighter">
                            {{ $b->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-700 text-right">
                        Rp {{ number_format($b->harga_jual, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1.5 {{ $b->stok <= ($b->stok_minimum ?? 5) ? 'bg-red-50 text-red-600 border-red-100' : 'bg-green-50 text-green-600 border-green-100' }} rounded-xl text-xs font-black border">
                            {{ $b->stok }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">
                            <button onclick='editBarang(@json($b))' class="bg-gray-100 hover:bg-blue-600 hover:text-white p-2 rounded-xl text-gray-400 transition shadow-sm">
                                ✏️
                            </button>
                            <form action="{{ route('barang.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $b->nama_barang }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-gray-100 hover:bg-red-600 hover:text-white p-2 rounded-xl text-gray-400 transition shadow-sm">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL FORM --}}
<div id="modalBarang" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl w-full max-w-xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h3 id="modalTitle" class="text-xl font-black text-gray-800 tracking-tight">Tambah Produk</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-3xl font-light">&times;</button>
        </div>
        
        <form id="formBarang" action="{{ route('barang.store') }}" method="POST" class="p-8">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Kode Barang</label>
                    <input type="text" name="kode_barang" id="input_kode" class="w-full bg-gray-50 border border-gray-200 p-3.5 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition font-bold" required>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Nama Produk</label>
                    <input type="text" name="nama_barang" id="input_nama" class="w-full bg-gray-50 border border-gray-200 p-3.5 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition font-bold" required>
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Harga Jual (Rp)</label>
                    <input type="number" name="harga_jual" id="input_harga" class="w-full bg-gray-50 border border-gray-200 p-3.5 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition font-bold" value="0">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Stok Saat Ini</label>
                    <input type="number" name="stok" id="input_stok" class="w-full bg-gray-50 border border-gray-200 p-3.5 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition font-bold" value="0">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Kategori (Departemen)</label>
                    <select name="kategori" id="input_kategori" class="w-full bg-gray-50 border border-gray-200 p-3.5 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition font-bold cursor-pointer">
                        <optgroup label="Makanan & Minuman">
                            <option value="Food & Snack">🍿 Makanan Ringan / Snack</option>
                            <option value="Beverage">🥤 Minuman (Botol/Kaleng)</option>
                            <option value="Ready to Eat">🍱 Makanan Siap Saji (Bento/Onigiri)</option>
                            <option value="Instant Food">🍜 Mie Instan & Kaleng</option>
                            <option value="Bread & Pastry">🍞 Roti & Kue</option>
                        </optgroup>
                        <optgroup label="Kebutuhan Harian">
                            <option value="Personal Care">🧼 Sabun & Perawatan Tubuh</option>
                            <option value="Home Care">🧹 Pembersih Rumah Tangga</option>
                            <option value="Health Care">💊 Obat & Kesehatan</option>
                            <option value="Baby Care">🍼 Kebutuhan Bayi</option>
                        </optgroup>
                        <optgroup label="Lainnya">
                            <option value="Stationery">✏️ Alat Tulis & Kantor</option>
                            <option value="Miscellaneous">📦 Lain-lain / Umum</option>
                        </optgroup>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Satuan</label>
                    <input type="text" name="satuan" id="input_satuan" class="w-full bg-gray-50 border border-gray-200 p-3.5 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition font-bold" value="Pcs">
                </div>
            </div>

            <div class="flex gap-4 pt-10">
                <button type="button" onclick="closeModal()" class="flex-1 text-gray-400 font-black py-4 hover:bg-gray-50 rounded-2xl transition uppercase tracking-widest text-xs">Batal</button>
                <button type="submit" id="btnSubmit" class="flex-1 bg-blue-600 text-white font-black py-4 rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-200 transition uppercase tracking-widest text-xs">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modalBarang');
    const form = document.getElementById('formBarang');
    const title = document.getElementById('modalTitle');
    const methodInput = document.getElementById('formMethod');

    function openModal(mode) {
        modal.classList.remove('hidden');
        if(mode === 'tambah') {
            title.innerText = "Tambah Produk Baru";
            form.action = "{{ route('barang.store') }}";
            methodInput.value = "POST";
            form.reset();
            document.getElementById('input_kategori').value = "Food & Snack";
            document.getElementById('input_satuan').value = "Pcs";
        }
    }

    function editBarang(barang) {
        modal.classList.remove('hidden');
        title.innerText = "Perbarui Produk: " + barang.nama_barang;
        form.action = `/barang/${barang.id}`;
        methodInput.value = "PUT";
        
        document.getElementById('input_kode').value = barang.kode_barang;
        document.getElementById('input_nama').value = barang.nama_barang;
        document.getElementById('input_harga').value = barang.harga_jual;
        document.getElementById('input_stok').value = barang.stok;
        document.getElementById('input_kategori').value = barang.kategori;
        document.getElementById('input_satuan').value = barang.satuan;
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection