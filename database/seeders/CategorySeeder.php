<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data existing
        DB::table('categories')->delete();

        // Data kategori
        $categories = [
            [
                'nama' => 'Bahan Pokok',
                'deskripsi' => 'Bahan dasar yang sangat penting dalam proses produksi',
                'tipe' => 'bahan_pokok',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Bahan Tambahan',
                'deskripsi' => 'Bahan pendukung yang melengkapi proses produksi',
                'tipe' => 'bahan_tambahan',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Bahan Mentah',
                'deskripsi' => 'Bahan yang belum diolah atau diproses',
                'tipe' => 'bahan_mentah',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Bahan Jadi',
                'deskripsi' => 'Bahan yang sudah selesai diproses dan siap digunakan',
                'tipe' => 'bahan_jadi',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        // Masukkan data ke database
        DB::table('categories')->insert($categories);
    }
}
