<?php

namespace App\Models;

use Attribute;
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

    protected $casts = [
        'created_at' => 'datetime',
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
        static::created(function ($move) {
            $move->bahan->applyStockMove($move->move_type, $move->qty);
        });

        static::updated(function ($move) {
            if ($move->wasChanged(['qty', 'move_type'])) {
                $move->bahan->rollbackStockMove(
                    $move->getOriginal('move_type'),
                    $move->getOriginal('qty')
                );

                $move->bahan->applyStockMove($move->move_type, $move->qty);
            }
        });

        static::deleted(function ($move) {
            $move->bahan->rollbackStockMove($move->move_type, $move->qty);
        });
    }
}
