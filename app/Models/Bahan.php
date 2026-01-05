<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahans';

    // Enum Constants untuk Satuan dan Status
    public const SATUAN_OPTIONS = [
        'kg' => 'Kilogram',
        'gram' => 'Gram',
        'liter' => 'Liter',
        'ml' => 'Mili Liter',
        'pcs' => 'Pieces',
        'pack' => 'Pack',
        'box' => 'Box'
    ];

    public const STATUS_OPTIONS = [
        'aman' => 'Stok Aman',
        'warning' => 'Stok Menipis',
        'habis' => 'Stok Habis',
        'kritis' => 'Stok Kritis'
    ];

    protected $fillable = [
        'kode_bahan',
        'nama_bahan',
        'category_id',
        'satuan',
        'harga',
        'supplier',
        'stok_sekarang',
        'min_stok',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'is_active'
        // ❌ status TIDAK di-fill manual
    ];

    protected $casts = [
        'stok_sekarang' => 'float',
        'min_stok' => 'float',
        'harga' => 'decimal:2',
    ];

    /**
     * 🔥 MODEL EVENT
     */
    public function refreshStatus(): void
    {
        $this->status = $this->determineStockStatus();
        $this->saveQuietly(); // tidak trigger observer loop
    }

    /**
     * 🔥 SINGLE SOURCE OF TRUTH
     */
    public function determineStockStatus(): string
    {
        if ($this->stok_sekarang <= 0) {
            return 'habis';
        }

        if ($this->stok_sekarang <= ($this->min_stok * 0.5)) {
            return 'kritis';
        }

        if ($this->stok_sekarang < $this->min_stok) {
            return 'warning';
        }

        return 'aman';
    }

    /* ===============================
     | APPLY STOCK MOVE
     ===============================*/
    public function applyStockMove(string $type, float $qty): void
    {
        if ($type === 'out' && $this->stok_sekarang < $qty) {
            throw new \Exception('Stok tidak mencukupi');
        }

        $this->stok_sekarang = $type === 'in'
            ? $this->stok_sekarang + $qty
            : $this->stok_sekarang - $qty;

        $this->save();
        $this->refreshStatus();
    }

    public function rollbackStockMove(string $type, float $qty): void
    {
        $this->stok_sekarang = $type === 'in'
            ? $this->stok_sekarang - $qty
            : $this->stok_sekarang + $qty;

        $this->save();
        $this->refreshStatus();
    }

    /* ===============================
     * EVENT MODEL
     * =============================== */
    protected static function booted()
    {
        static::saving(function ($bahan) {
            $bahan->status = $bahan->determineStockStatus();
        });
    }


    // Tambahkan method static untuk memudahkan akses dari view/controller
    public static function getSatuanOptions(): array
    {
        return self::SATUAN_OPTIONS;
    }

    /* ================= RELATION ================= */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockMoves()
    {
        return $this->hasMany(StockMove::class);
    }

}
