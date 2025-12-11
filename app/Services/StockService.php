<?php

namespace App\Services;

use App\Models\Bahan;

class StockService
{
    public function getLowStockCount(): int
    {
        return Bahan::whereColumn('stok_sekarang', '<=', 'stok_minimum')->count();
    }

    public function getLowStockItems()
    {
        return Bahan::whereColumn('stok_sekarang', '<=', 'stok_minimum')->get();
    }
}
