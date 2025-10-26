<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

     protected $table = 'categories';

    // Konstanta untuk tipe kategori
    public const TIPE_OPTIONS = [
        'bahan_pokok' => 'Bahan Pokok',
        'bahan_tambahan' => 'Bahan Tambahan',
        'bahan_mentah' => 'Bahan Mentah',
        'bahan_jadi' => 'Bahan Jadi'
    ];

    // Kolom yang bisa diisi
    protected $fillable = [
        'nama',
        'deskripsi',
        'tipe',
        'is_active'
    ];

    // Relasi one-to-one dengan Bahan
    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id', 'id');
    }

    // Scope untuk filter aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk filter berdasarkan tipe
    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    // Mutator untuk nama (membuat nama selalu kapital)
    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = ucwords(strtolower($value));
    }
}
