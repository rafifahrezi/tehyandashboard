<?php

namespace Database\Seeders;

use App\Models\Bahan;
use App\Models\StockMove;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockMoveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahans = Bahan::all();

        if ($bahans->count() === 0) {
            $this->command->warn("⚠️ Tidak ada data Bahan. Seeder StockMove dilewati.");
            return;
        }

        foreach ($bahans as $bahan) {

            // Jika stok belum diset
            if ($bahan->stok_sekarang === null) {
                $bahan->update(['stok_sekarang' => rand(10, 30)]);
            }

            // Transaksi IN
            StockMove::create([
                'bahan_id' => $bahan->id,
                'move_type' => 'in',
                'qty' => rand(3, 10),
                'reference_type' => null,
                'reference_id' => null,
            ]);

            // Transaksi OUT
            StockMove::create([
                'bahan_id' => $bahan->id,
                'move_type' => 'out',
                'qty' => rand(1, 5),
                'reference_type' => null,
                'reference_id' => null,
            ]);
        }

        $this->command->info("✅ StockMoveSeeder selesai dijalankan.");
    }
}
