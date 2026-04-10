<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BarangSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('barang')->truncate();

        $data = [
            // 1-10: MAKANAN READY-TO-EAT (Oden & Bento)
            ['kode_barang' => 'LW-001', 'nama_barang' => 'Odeng Original', 'kategori' => 'Makanan Ready-to-Eat', 'harga_beli' => 8000, 'harga_jual' => 12000, 'stok' => 100, 'stok_minimum' => 10, 'satuan' => 'Tusuk'],
            ['kode_barang' => 'LW-002', 'nama_barang' => 'Spicy Odeng', 'kategori' => 'Makanan Ready-to-Eat', 'harga_beli' => 8500, 'harga_jual' => 13000, 'stok' => 80, 'stok_minimum' => 10, 'satuan' => 'Tusuk'],
            ['kode_barang' => 'LW-003', 'nama_barang' => 'Onigiri Salmon Mayo', 'kategori' => 'Makanan Ready-to-Eat', 'harga_beli' => 11000, 'harga_jual' => 15000, 'stok' => 50, 'stok_minimum' => 5, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-004', 'nama_barang' => 'Chicken Nanban Bento', 'kategori' => 'Makanan Ready-to-Eat', 'harga_beli' => 28000, 'harga_jual' => 35000, 'stok' => 25, 'stok_minimum' => 5, 'satuan' => 'Pack'],
            ['kode_barang' => 'LW-005', 'nama_barang' => 'Tteokbokki Small', 'kategori' => 'Makanan Ready-to-Eat', 'harga_beli' => 15000, 'harga_jual' => 20000, 'stok' => 30, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-006', 'nama_barang' => 'Gyu Don Bento', 'kategori' => 'Makanan Ready-to-Eat', 'harga_beli' => 30000, 'harga_jual' => 38000, 'stok' => 15, 'stok_minimum' => 3, 'satuan' => 'Pack'],
            ['kode_barang' => 'LW-007', 'nama_barang' => 'Chikuwa Oden', 'kategori' => 'Makanan Ready-to-Eat', 'harga_beli' => 6000, 'harga_jual' => 9000, 'stok' => 60, 'stok_minimum' => 10, 'satuan' => 'Tusuk'],
            ['kode_barang' => 'LW-008', 'nama_barang' => 'Salmon Ball Oden', 'kategori' => 'Makanan Ready-to-Eat', 'harga_beli' => 7000, 'harga_jual' => 10000, 'stok' => 55, 'stok_minimum' => 10, 'satuan' => 'Tusuk'],
            ['kode_barang' => 'LW-009', 'nama_barang' => 'Sosis Bakar Jumbo', 'kategori' => 'Makanan Ready-to-Eat', 'harga_beli' => 12000, 'harga_jual' => 18000, 'stok' => 40, 'stok_minimum' => 5, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-010', 'nama_barang' => 'Karage Stick', 'kategori' => 'Makanan Ready-to-Eat', 'harga_beli' => 10000, 'harga_jual' => 15000, 'stok' => 45, 'stok_minimum' => 5, 'satuan' => 'Tusuk'],

            // 11-20: MINUMAN BARISTA
            ['kode_barang' => 'LW-011', 'nama_barang' => 'Ice Caramel Macchiato', 'kategori' => 'Minuman Barista', 'harga_beli' => 15000, 'harga_jual' => 22000, 'stok' => 50, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-012', 'nama_barang' => 'Ice Caffè Latte', 'kategori' => 'Minuman Barista', 'harga_beli' => 13000, 'harga_jual' => 18000, 'stok' => 60, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-013', 'nama_barang' => 'Hot Americano', 'kategori' => 'Minuman Barista', 'harga_beli' => 10000, 'harga_jual' => 15000, 'stok' => 30, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-014', 'nama_barang' => 'Matcha Latte Ice', 'kategori' => 'Minuman Barista', 'harga_beli' => 18000, 'harga_jual' => 25000, 'stok' => 40, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-015', 'nama_barang' => 'Ice Chocolate', 'kategori' => 'Minuman Barista', 'harga_beli' => 15000, 'harga_jual' => 20000, 'stok' => 35, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-016', 'nama_barang' => 'Earl Grey Milk Tea', 'kategori' => 'Minuman Barista', 'harga_beli' => 16000, 'harga_jual' => 22000, 'stok' => 25, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-017', 'nama_barang' => 'Java Brown Sugar Latte', 'kategori' => 'Minuman Barista', 'harga_beli' => 15000, 'harga_jual' => 19000, 'stok' => 40, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-018', 'nama_barang' => 'Ice Hazelnut Latte', 'kategori' => 'Minuman Barista', 'harga_beli' => 17000, 'harga_jual' => 24000, 'stok' => 30, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-019', 'nama_barang' => 'Hot Café Mocha', 'kategori' => 'Minuman Barista', 'harga_beli' => 16000, 'harga_jual' => 21000, 'stok' => 20, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-020', 'nama_barang' => 'Ice Thai Tea', 'kategori' => 'Minuman Barista', 'harga_beli' => 12000, 'harga_jual' => 18000, 'stok' => 45, 'stok_minimum' => 5, 'satuan' => 'Cup'],

            // 21-30: SNACK & IMPOR
            ['kode_barang' => 'LW-021', 'nama_barang' => 'Lays Seaweed Japan', 'kategori' => 'Snack & Impor', 'harga_beli' => 12000, 'harga_jual' => 16500, 'stok' => 40, 'stok_minimum' => 5, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-022', 'nama_barang' => 'Pocky Chocolate Large', 'kategori' => 'Snack & Impor', 'harga_beli' => 13000, 'harga_jual' => 17500, 'stok' => 50, 'stok_minimum' => 5, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-023', 'nama_barang' => 'Nissin Cup Noodle Seafood', 'kategori' => 'Snack & Impor', 'harga_beli' => 15000, 'harga_jual' => 20000, 'stok' => 35, 'stok_minimum' => 5, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-024', 'nama_barang' => 'Calbee Potato Chips', 'kategori' => 'Snack & Impor', 'harga_beli' => 11000, 'harga_jual' => 15000, 'stok' => 40, 'stok_minimum' => 5, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-025', 'nama_barang' => 'Tao Kae Noi Big Sheet', 'kategori' => 'Snack & Impor', 'harga_beli' => 4500, 'harga_jual' => 7000, 'stok' => 100, 'stok_minimum' => 10, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-026', 'nama_barang' => 'KitKat Green Tea Japan', 'kategori' => 'Snack & Impor', 'harga_beli' => 18000, 'harga_jual' => 25000, 'stok' => 20, 'stok_minimum' => 5, 'satuan' => 'Pack'],
            ['kode_barang' => 'LW-027', 'nama_barang' => 'Meiji Hello Panda', 'kategori' => 'Snack & Impor', 'harga_beli' => 8000, 'harga_jual' => 11000, 'stok' => 60, 'stok_minimum' => 5, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-028', 'nama_barang' => 'Samyang Hot Chicken Ramen', 'kategori' => 'Snack & Impor', 'harga_beli' => 19000, 'harga_jual' => 26000, 'stok' => 30, 'stok_minimum' => 5, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-029', 'nama_barang' => 'Yan Yan Double Hazelnut', 'kategori' => 'Snack & Impor', 'harga_beli' => 9000, 'harga_jual' => 13000, 'stok' => 40, 'stok_minimum' => 5, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-030', 'nama_barang' => 'Jagabee Seaweed', 'kategori' => 'Snack & Impor', 'harga_beli' => 14000, 'harga_jual' => 19000, 'stok' => 25, 'stok_minimum' => 5, 'satuan' => 'Pcs'],

            // 31-40: MINUMAN KEMASAN
            ['kode_barang' => 'LW-031', 'nama_barang' => 'Mineral Water 600ml', 'kategori' => 'Minuman Kemasan', 'harga_beli' => 3000, 'harga_jual' => 5000, 'stok' => 200, 'stok_minimum' => 20, 'satuan' => 'Botol'],
            ['kode_barang' => 'LW-032', 'nama_barang' => 'Pocari Sweat 500ml', 'kategori' => 'Minuman Kemasan', 'harga_beli' => 7000, 'harga_jual' => 9500, 'stok' => 100, 'stok_minimum' => 10, 'satuan' => 'Botol'],
            ['kode_barang' => 'LW-033', 'nama_barang' => 'Teh Botol Sosro 450ml', 'kategori' => 'Minuman Kemasan', 'harga_beli' => 6000, 'harga_jual' => 8500, 'stok' => 80, 'stok_minimum' => 10, 'satuan' => 'Botol'],
            ['kode_barang' => 'LW-034', 'nama_barang' => 'Coca Cola 390ml', 'kategori' => 'Minuman Kemasan', 'harga_beli' => 5500, 'harga_jual' => 7500, 'stok' => 70, 'stok_minimum' => 10, 'satuan' => 'Botol'],
            ['kode_barang' => 'LW-035', 'nama_barang' => 'Milk Life Chocolate 200ml', 'kategori' => 'Minuman Kemasan', 'harga_beli' => 5000, 'harga_jual' => 7000, 'stok' => 50, 'stok_minimum' => 5, 'satuan' => 'Botol'],
            ['kode_barang' => 'LW-036', 'nama_barang' => 'Ichitan Thai Milk Green Tea', 'kategori' => 'Minuman Kemasan', 'harga_beli' => 7500, 'harga_jual' => 10000, 'stok' => 45, 'stok_minimum' => 5, 'satuan' => 'Botol'],
            ['kode_barang' => 'LW-037', 'nama_barang' => 'Mogu Mogu Lychee', 'kategori' => 'Minuman Kemasan', 'harga_beli' => 8500, 'harga_jual' => 11000, 'stok' => 40, 'stok_minimum' => 5, 'satuan' => 'Botol'],
            ['kode_barang' => 'LW-038', 'nama_barang' => 'Ultra Milk Full Cream 250ml', 'kategori' => 'Minuman Kemasan', 'harga_beli' => 6000, 'harga_jual' => 8000, 'stok' => 60, 'stok_minimum' => 10, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-039', 'nama_barang' => 'Minute Maid Pulpy Orange', 'kategori' => 'Minuman Kemasan', 'harga_beli' => 7000, 'harga_jual' => 9000, 'stok' => 50, 'stok_minimum' => 5, 'satuan' => 'Botol'],
            ['kode_barang' => 'LW-040', 'nama_barang' => 'Bear Brand 189ml', 'kategori' => 'Minuman Kemasan', 'harga_beli' => 9500, 'harga_jual' => 12000, 'stok' => 40, 'stok_minimum' => 5, 'satuan' => 'Pcs'],

            // 41-50: ROTI & DESSERT
            ['kode_barang' => 'LW-041', 'nama_barang' => 'Sandwich Egg Mayo', 'kategori' => 'Roti & Dessert', 'harga_beli' => 14000, 'harga_jual' => 19000, 'stok' => 15, 'stok_minimum' => 3, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-042', 'nama_barang' => 'Sandwich Smoked Beef', 'kategori' => 'Roti & Dessert', 'harga_beli' => 16000, 'harga_jual' => 22000, 'stok' => 12, 'stok_minimum' => 3, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-043', 'nama_barang' => 'Pudding Chocolate Lawson', 'kategori' => 'Roti & Dessert', 'harga_beli' => 10000, 'harga_jual' => 14000, 'stok' => 20, 'stok_minimum' => 5, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-044', 'nama_barang' => 'Dorayaki Chocolate', 'kategori' => 'Roti & Dessert', 'harga_beli' => 9000, 'harga_jual' => 12500, 'stok' => 25, 'stok_minimum' => 5, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-045', 'nama_barang' => 'Mochi Ichigo Daifuku', 'kategori' => 'Roti & Dessert', 'harga_beli' => 15000, 'harga_jual' => 22000, 'stok' => 10, 'stok_minimum' => 2, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-046', 'nama_barang' => 'Soft Serve Ice Cream Vanilla', 'kategori' => 'Roti & Dessert', 'harga_beli' => 5000, 'harga_jual' => 8000, 'stok' => 100, 'stok_minimum' => 0, 'satuan' => 'Cup'],
            ['kode_barang' => 'LW-047', 'nama_barang' => 'Cheese Danish', 'kategori' => 'Roti & Dessert', 'harga_beli' => 11000, 'harga_jual' => 16000, 'stok' => 15, 'stok_minimum' => 3, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-048', 'nama_barang' => 'Waffle Original', 'kategori' => 'Roti & Dessert', 'harga_beli' => 12000, 'harga_jual' => 17000, 'stok' => 15, 'stok_minimum' => 3, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-049', 'nama_barang' => 'Choco Lava Cake', 'kategori' => 'Roti & Dessert', 'harga_beli' => 15000, 'harga_jual' => 21000, 'stok' => 10, 'stok_minimum' => 2, 'satuan' => 'Pcs'],
            ['kode_barang' => 'LW-050', 'nama_barang' => 'Eclair Chocolate', 'kategori' => 'Roti & Dessert', 'harga_beli' => 13000, 'harga_jual' => 18000, 'stok' => 12, 'stok_minimum' => 3, 'satuan' => 'Pcs'],

            // 51-55: KEBUTUHAN HARIAN
            ['kode_barang' => 'LW-051', 'nama_barang' => 'Tisu Basah Lawson 10s', 'kategori' => 'Kebutuhan Harian', 'harga_beli' => 5000, 'harga_jual' => 8500, 'stok' => 40, 'stok_minimum' => 5, 'satuan' => 'Pack'],
            ['kode_barang' => 'LW-052', 'nama_barang' => 'Masker Sensi 3-Ply', 'kategori' => 'Kebutuhan Harian', 'harga_beli' => 7000, 'harga_jual' => 10000, 'stok' => 100, 'stok_minimum' => 10, 'satuan' => 'Pack'],
            ['kode_barang' => 'LW-053', 'nama_barang' => 'Baterai AA Alkaline 2s', 'kategori' => 'Kebutuhan Harian', 'harga_beli' => 15000, 'harga_jual' => 21000, 'stok' => 20, 'stok_minimum' => 5, 'satuan' => 'Pack'],
            ['kode_barang' => 'LW-054', 'nama_barang' => 'Hand Sanitizer 50ml', 'kategori' => 'Kebutuhan Harian', 'harga_beli' => 11000, 'harga_jual' => 16000, 'stok' => 30, 'stok_minimum' => 5, 'satuan' => 'Botol'],
            ['kode_barang' => 'LW-055', 'nama_barang' => 'Payung Transparan Lawson', 'kategori' => 'Kebutuhan Harian', 'harga_beli' => 35000, 'harga_jual' => 55000, 'stok' => 10, 'stok_minimum' => 2, 'satuan' => 'Pcs'],
        ];

        DB::table('barang')->insert($data);
        Schema::enableForeignKeyConstraints();
    }
}