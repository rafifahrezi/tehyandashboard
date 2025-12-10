<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockMove extends Model
{
    use HasFactory;

    protected $fillable = [
        'bahan_id',
        'move_type',
        'qty',
        'reference_type',
        'reference_id',
        'stok_sebelum', // yg diamabil dari foregn nya bahans
        'stok_sesudah'
    ];

    // Relasi ke bahan
    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Polymorphic relation ke referensi transaksi (purchase, sales, dll)
     *
     * @return MorphTo
     */
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
    // protected static function booted()
    // {
    //     static::creating(function ($stockMove) {
    //         $bahan = $stockMove->bahan;

    //         // Stok sebelum
    //         $stockMove->stok = $bahan->stok_sekarang;

    //         // Hitung stok sesudah
    //         if ($stockMove->move_type === 'in') {
    //             $stockMove->stok_sesudah = $bahan->stok_sekarang + $stockMove->qty;
    //         } else {
    //             $stockMove->stok_sesudah = $bahan->stok_sekarang - $stockMove->qty;
    //         }
    //     });

    //     static::created(function ($stockMove) {
    //         // Update stok bahan
    //         $stockMove->bahan->updateStock($stockMove->qty, $stockMove->move_type);
    //     });
    // }

    /**
     * Event saat membuat transaksi stok
     * - Hitung stok sebelum dan sesudah
     * - Update stok bahan setelah transaksi selesai
     */
    protected static function booted()
    {
        static::creating(function ($stockMove) {
            $bahan = $stockMove->bahan;
            $stockMove->stok_sebelum = $bahan->stok_sekarang;
            $stockMove->stok_sesudah = ($stockMove->move_type === 'in')
                ? $bahan->stok_sekarang + $stockMove->qty
                : $bahan->stok_sekarang - $stockMove->qty;
        });

        static::created(function ($stockMove) {
            $stockMove->bahan->updateStock($stockMove->qty, $stockMove->move_type);
        });

        static::deleting(function ($stockMove) {
            // Kembalikan stok saat menghapus transaksi
            $stockMove->bahan->updateStock(
                $stockMove->move_type === 'in' ? -$stockMove->qty : $stockMove->qty,
                $stockMove->move_type
            );
        });
    }
}
