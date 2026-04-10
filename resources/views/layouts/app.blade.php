<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Lawson RSUD Sayang' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-blue-900 text-white hidden md:block flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold tracking-widest text-center">LAWSON <span class="text-blue-400">APP</span></h1>
                <p class="text-xs text-blue-300 text-center uppercase mt-1">RSUD Sayang Edition</p>
            </div>
            
            <nav class="mt-6 px-4">
                {{-- Menu Semua Role --}}
                <a href="{{ route('dashboard') }}" class="flex items-center py-3 px-4 rounded-lg mb-2 transition {{ request()->routeIs('dashboard') ? 'bg-blue-800' : 'hover:bg-blue-800' }}">
                    <span class="mr-3">📊</span> Dashboard
                </a>

                {{-- Menu Khusus Admin & Gudang --}}
                @if(in_array(auth()->user()->role, ['admin', 'gudang']))
                <a href="{{ route('barang.index') }}" class="flex items-center py-3 px-4 rounded-lg mb-2 transition {{ request()->routeIs('barang.*') ? 'bg-blue-800' : 'hover:bg-blue-800' }}">
                    <span class="mr-3">📦</span> Data Barang
                </a>
                @endif

                {{-- Menu Khusus Admin & Manajer --}}
                @if(in_array(auth()->user()->role, ['admin', 'manajer']))
                <a href="{{ route('peramalan.index') }}" class="flex items-center py-3 px-4 rounded-lg mb-2 transition {{ request()->routeIs('peramalan.*') ? 'bg-blue-800' : 'hover:bg-blue-800' }}">
                    <span class="mr-3">🔮</span> Peramalan Stok
                </a>
                @endif

                {{-- Menu Khusus Admin, Manajer & Kasir (Kasir hanya input, Manajer/Admin lihat laporan) --}}
                @if(in_array(auth()->user()->role, ['admin', 'manajer', 'kasir']))
                <a href="{{ route('laporan.index') }}" class="flex items-center py-3 px-4 rounded-lg mb-2 transition {{ request()->routeIs('laporan.*') ? 'bg-blue-800' : 'hover:bg-blue-800' }}">
                    <span class="mr-3">📝</span> Laporan Penjualan
                </a>
                @endif

                <hr class="my-6 border-blue-700">
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full py-3 px-4 bg-red-600 hover:bg-red-700 rounded-lg transition text-sm font-bold uppercase">
                        <span class="mr-3">🚪</span> KELUAR
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <div class="text-gray-500 font-medium text-sm italic">
                    Sistem Informasi Inventori Lawson - <span class="text-blue-600 font-bold uppercase">{{ auth()->user()->role }} MODE</span>
                </div>
                <div class="flex items-center">
                    <div class="text-right mr-4">
                        <p class="text-sm font-bold text-gray-800 leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-semibold text-blue-500 uppercase tracking-tighter">{{ auth()->user()->role }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold shadow-md border-2 border-blue-100">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>