<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Tambahkan ini
use App\Models\Barang;

class PenjualanBulananSeeder extends Seeder
{
    public function run()
    {
        // 1. Matikan proteksi foreign key dan gunakan nama tabel yang benar
        Schema::disableForeignKeyConstraints();
        
        // Pastikan nama tabel di sini 'penjualan_bulanan' (tanpa 's') 
        // sesuaikan dengan yang ada di PHPMyAdmin kamu
        DB::table('penjualan_bulanan')->truncate();

        $barangs = Barang::all();

        if ($barangs->isEmpty()) {
            $this->command->error("Data barang kosong! Jalankan BarangSeeder dulu.");
            return;
        }

        $dataLaporan = [];
        
        $daftarBulan = [
            '2026-01', '2026-02', '2026-03', '2026-04', '2026-05', '2026-06',
            '2026-07', '2026-08', '2026-09', '2026-10', '2026-11', '2026-12'
        ];

        // 2. Loop untuk membuat 55 data acak
        for ($i = 0; $i < 55; $i++) {
            $barang = $barangs->random();
            $bulanInput = $daftarBulan[array_rand($daftarBulan)];
            $fullDate = $bulanInput . "-01";

            $dataLaporan[] = [
                'barang_id'     => $barang->id,
                'bulan'         => $fullDate,
                'tahun'         => '2026',
                'total_terjual' => rand(5, 100),
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }

        // 3. Masukkan ke database (pastikan nama tabel konsisten)
        DB::table('penjualan_bulanan')->insert($dataLaporan);
        
        Schema::enableForeignKeyConstraints();

        $this->command->info("Berhasil membuat 55 data simulasi laporan penjualan Lawson!");
    }
}