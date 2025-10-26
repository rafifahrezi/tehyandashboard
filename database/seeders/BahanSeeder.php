<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Category;

class BahanSeeder extends Seeder
{
    public function run()
    {
        // Hapus data existing
        DB::table('bahans')->delete();

        // Ambil ID kategori
        $categories = Category::all()->keyBy('tipe');

        // Data Bahan
        $bahans = [
            // Bahan Pokok
            [
                'kode_bahan' => 'BP001',
                'nama_bahan' => 'Beras',
                'category_id' => $categories['bahan_pokok']->id,
                'harga' => 120000.00,
                'supplier' => 'Toko Fadri',
                'satuan' => 'kg',
                'stok' => 30.00,
                'min_stok' => 5.00,
                'tanggal_masuk' => Carbon::now(),
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(6),
                'is_active' => 'aman',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'kode_bahan' => 'BP002',
                'nama_bahan' => 'Gula',
                'category_id' => $categories['bahan_pokok']->id,
                'harga' => 120000.00,
                'supplier' => 'Toko Fadri',
                'satuan' => 'kg',
                'stok' => 22.00,
                'min_stok' => 7.00,
                'tanggal_masuk' => Carbon::now(),
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(6),
                'is_active' => 'aman',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Bahan Tambahan
            [
                'kode_bahan' => 'BT001',
                'nama_bahan' => 'Garam',
                'category_id' => $categories['bahan_tambahan']->id,
                'harga' => 10000.00,
                'supplier' => 'Toko Fadri',
                'satuan' => 'kg',
                'stok' => 18.00,
                'min_stok' => 4.00,
                'tanggal_masuk' => Carbon::now(),
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(6),
                'is_active' => 'aman',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'kode_bahan' => 'BT002',
                'nama_bahan' => 'Penyedap Rasa',
                'category_id' => $categories['bahan_tambahan']->id,
                'harga' => 9000.00,
                'supplier' => 'Toko Fadri',
                'satuan' => 'kg',
                'stok' => 45.00,
                'min_stok' => 5.00,
                'tanggal_masuk' => Carbon::now(),
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(6),
                'is_active' => 'aman',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            // Bahan Mentah
            [
                'kode_bahan' => 'BM001',
                'nama_bahan' => 'Daging Sapi',
                'category_id' => $categories['bahan_mentah']->id,
                'harga' => 150000.00,
                'supplier' => 'Toko Fadri',
                'satuan' => 'kg',
                'stok' => 11.00,
                'min_stok' => 3.00,
                'tanggal_masuk' => Carbon::now(),
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(6),
                'is_active' => 'aman',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Bahan Jadi
            [
                'kode_bahan' => 'BJ001',
                'nama_bahan' => 'Roti Tawar',
                'category_id' => $categories['bahan_jadi']->id,
                'harga' => 17500.00,
                'supplier' => 'Toko Fadri',
                'satuan' => 'kg',
                'stok' => 12.00,
                'min_stok' => 2.00,
                'tanggal_masuk' => Carbon::now(),
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(6),
                'is_active' => 'aman',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        // Masukkan data ke database
        DB::table('bahans')->insert($bahans);
    }
}
