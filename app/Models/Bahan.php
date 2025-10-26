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
        'stok',
        'min_stok',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'is_active'
    ];

    // Casting untuk tipe data
    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'decimal:2',
        'min_stok' => 'decimal:2'
    ];

    // Relasi dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Scope untuk filter status
    public function scopeActive($query)
    {
        return $query->where('is_active', 'aman');
    }

    // Method untuk mengecek status stok
    public function checkStokStatus()
    {
        if ($this->stok <= 0) {
            return 'habis';
        } elseif ($this->stok <= $this->min_stok) {
            return 'kritis';
        } elseif ($this->stok <= ($this->min_stok * 1.5)) {
            return 'warning';
        }

        return 'aman';
    }

    // Mutator untuk update status otomatis
    public function updateStokStatus()
    {
        $this->is_active = $this->checkStokStatus();
        $this->save();
    }
}
