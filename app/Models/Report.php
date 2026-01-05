<?php
// app/Models/Report.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_laporan',
        'jenis_laporan',
        'tanggal_mulai',
        'tanggal_akhir',
        'jenis_transaksi',
        'bahan_id',
        'filter_params',
        'status',
        'user_id'
    ];

    protected $casts = [
        'filter_params' => 'array',
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function getPeriodeAttribute()
    {
        if ($this->jenis_laporan === 'harian') {
            return 'Harian - ' . $this->tanggal_mulai->format('d/m/Y');
        } elseif ($this->jenis_laporan === 'bulanan') {
            return 'Bulanan - ' . $this->tanggal_mulai->format('F Y');
        } elseif ($this->jenis_laporan === 'tahunan') {
            return 'Tahunan - ' . $this->tanggal_mulai->format('Y');
        } else {
            return $this->tanggal_mulai->format('d/m/Y') . ' - ' . $this->tanggal_akhir->format('d/m/Y');
        }
    }
}
