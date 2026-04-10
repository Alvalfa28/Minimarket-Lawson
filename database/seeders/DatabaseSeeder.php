<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barang;
use App\Models\PenjualanBulanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan Data Lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Barang::truncate();
        PenjualanBulanan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Membuat User dengan Role Lengkap
        $users = [
            ['name' => 'Admin Lawson', 'email' => 'admin@lawson.com', 'pass' => 'admin123', 'role' => 'admin'],
            ['name' => 'Staf Gudang', 'email' => 'gudang@lawson.com', 'pass' => 'gudang123', 'role' => 'gudang'],
            ['name' => 'Kasir Lawson', 'email' => 'kasir@lawson.com', 'pass' => 'kasir123', 'role' => 'kasir'],
        ];

        foreach ($users as $u) {
            User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => Hash::make($u['pass']),
                'role' => $u['role'],
            ]);
        }

        // 3. Daftar Produk Lawson (Data untuk TA/Skripsi)
        $produkLawson = [
            ['kode' => 'LW-001', 'nama' => 'Onigiri Tuna Mayo', 'kat' => 'Ready-to-Eat', 'harga' => 12000, 'stok' => 15, 'min' => 10],
            ['kode' => 'LW-002', 'nama' => 'Ichitan Thai Milk Tea', 'kat' => 'Minuman Kemasan', 'harga' => 10000, 'stok' => 5, 'min' => 12], // Stok Kritis
            ['kode' => 'LW-003', 'nama' => 'Odeng Original', 'kat' => 'Hot Snack', 'harga' => 15000, 'stok' => 25, 'min' => 15],
            ['kode' => 'LW-004', 'nama' => 'Bento Chicken Nanban', 'kat' => 'Ready-to-Eat', 'harga' => 38000, 'stok' => 8, 'min' => 10], // Stok Kritis
            ['kode' => 'LW-005', 'nama' => 'Tteokbokki Cheese', 'kat' => 'Hot Snack', 'harga' => 25000, 'stok' => 12, 'min' => 10],
            ['kode' => 'LW-006', 'nama' => 'Sandwich Fruit Cream', 'kat' => 'Dessert', 'harga' => 18000, 'stok' => 4, 'min' => 8], // Stok Kritis
            ['kode' => 'LW-007', 'nama' => 'Double Choco Muffin', 'kat' => 'Bakery', 'harga' => 12000, 'stok' => 20, 'min' => 10],
            ['kode' => 'LW-008', 'nama' => 'Iced Caffe Latte', 'kat' => 'Minuman Fresh', 'harga' => 15000, 'stok' => 30, 'min' => 15],
            ['kode' => 'LW-009', 'nama' => 'Spicy Chicken Karaage', 'kat' => 'Hot Snack', 'harga' => 14000, 'stok' => 2, 'min' => 10], // Stok Kritis
            ['kode' => 'LW-010', 'nama' => 'Samyang Bowl Hot', 'kat' => 'Mie Instan', 'harga' => 22000, 'stok' => 18, 'min' => 10],
        ];

        // 4. Generate Data Barang & Penjualan Historis (Looping)
        foreach ($produkLawson as $p) {
            $barang = Barang::create([
                'kode_barang' => $p['kode'],
                'nama_barang' => $p['nama'],
                'kategori'    => $p['kat'],
                'satuan'      => 'Pcs',
                'harga_beli'  => $p['harga'] * 0.75, // Margin 25%
                'harga_jual'  => $p['harga'],
                'stok'        => $p['stok'],
                'stok_minimum'=> $p['min'],
            ]);

            // Buat Data Penjualan 6 Bulan Terakhir (Oktober 2025 - Maret 2026)
            // Penting untuk perhitungan WMA di fitur Peramalan
            $bulanTahun = [
                ['b' => 10, 't' => 2025], ['b' => 11, 't' => 2025], ['b' => 12, 't' => 2025],
                ['b' => 1, 't' => 2026], ['b' => 2, 't' => 2026], ['b' => 3, 't' => 2026],
            ];

            foreach ($bulanTahun as $bt) {
                PenjualanBulanan::create([
                    'barang_id' => $barang->id,
                    'bulan' => $bt['b'],
                    'tahun' => $bt['t'],
                    'total_terjual' => rand(30, 80), // Data acak untuk simulasi
                ]);
            }
        }
    }
}