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
    ];

    // Casting untuk tipe data
    protected $casts = [
        'harga' => 'decimal:2',
        'stok_sekarang' => 'decimal:2',
        'min_stok' => 'decimal:2'
    ];

    // Relasi dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Relasi ke stock moves (satu bahan memiliki banyak transaksi stok)
    public function stockMoves()
    {
        return $this->hasMany(StockMove::class);
    }

    // Scope untuk filter status
    public function scopeActive($query)
    {
        return $query->where('is_active', 'aman');
    }

    // Method untuk mengecek status stok
    public function checkStokStatus()
    {
        if ($this->stok_sekarang <= 0) {
            return 'habis';
        } elseif ($this->stok_sekarang <= $this->min_stok) {
            return 'kritis';
        } elseif ($this->stok_sekarang <= ($this->min_stok * 1.5)) {
            return 'warning';
        }
        return 'aman';
    }

    // Update stok bahan
    public function updateStock(float $qty, string $moveType): void
    {
        if ($moveType === 'in') {
            $this->stok_sekarang += $qty;
        } else {
            $this->stok_sekarang -= $qty;
        }
        $this->save();
    }

    // Tambahkan method static untuk memudahkan akses dari view/controller
    public static function getSatuanOptions(): array
    {
        return self::SATUAN_OPTIONS;
    }
}
