<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporanData = [
            'pageTitle' => 'Laporan & Analisis',
            'pageDescription' => 'Insight lengkap pergerakan stok bahan baku',
            'stats' => [
                'total_masuk' => [
                    'value' => '12.00',
                    'transaksi' => '1 transaksi',
                    'icon' => 'fas fa-arrow-down',
                    'color' => 'green'
                ],
                'total_keluar' => [
                    'value' => '0.00',
                    'transaksi' => '0 transaksi',
                    'icon' => 'fas fa-arrow-up',
                    'color' => 'red'
                ],
                'total_transaksi' => [
                    'value' => '1',
                    'description' => 'Semua aktivitas',
                    'icon' => 'fas fa-exchange-alt',
                    'color' => 'blue'
                ],
                'pegawai_aktif' => [
                    'value' => '1',
                    'description' => 'Yang bertransaksi',
                    'icon' => 'fas fa-users',
                    'color' => 'purple'
                ]
            ],
            'filters' => [
                'jenis_transaksi' => ['Semua', 'Masuk', 'Keluar'],
                'bahan_baku' => ['Semua Bahan', 'Beras Bali', 'Gula Pasir', 'Minyak Goreng', 'Garam Halus']
            ],
            'tren_harian' => [
                'periode' => '14 hari terakhir',
                'data' => [
                    ['date' => '16 Okt', 'masuk' => 12, 'keluar' => 0],
                    ['date' => '15 Okt', 'masuk' => 8, 'keluar' => 5],
                    ['date' => '14 Okt', 'masuk' => 15, 'keluar' => 3],
                    ['date' => '13 Okt', 'masuk' => 6, 'keluar' => 8],
                    ['date' => '12 Okt', 'masuk' => 10, 'keluar' => 4],
                    ['date' => '11 Okt', 'masuk' => 7, 'keluar' => 6],
                    ['date' => '10 Okt', 'masuk' => 12, 'keluar' => 2],
                    ['date' => '9 Okt', 'masuk' => 9, 'keluar' => 7],
                    ['date' => '8 Okt', 'masuk' => 11, 'keluar' => 3],
                    ['date' => '7 Okt', 'masuk' => 5, 'keluar' => 9],
                    ['date' => '6 Okt', 'masuk' => 14, 'keluar' => 1],
                    ['date' => '5 Okt', 'masuk' => 8, 'keluar' => 6],
                    ['date' => '4 Okt', 'masuk' => 13, 'keluar' => 2],
                    ['date' => '3 Okt', 'masuk' => 7, 'keluar' => 8]
                ]
            ],
            'top_bahan' => [
                'title' => 'Top 5 Bahan Paling Aktif',
                'subtitle' => 'Berdasarkan total transaksi',
                'data' => [
                    ['name' => 'Beras Bali', 'transaksi' => 8, 'persentase' => 35],
                    ['name' => 'Gula Pasir', 'transaksi' => 6, 'persentase' => 25],
                    ['name' => 'Minyak Goreng', 'transaksi' => 5, 'persentase' => 20],
                    ['name' => 'Garam Halus', 'transaksi' => 3, 'persentase' => 12],
                    ['name' => 'Tepung Terigu', 'transaksi' => 2, 'persentase' => 8]
                ]
            ],
            'rekap_pegawai' => [
                'title' => 'Aktivitas Pegawai',
                'data' => [
                    ['name' => 'rafffahrez4', 'transaksi' => 12, 'role' => 'Administrator'],
                    ['name' => 'siti_aminah', 'transaksi' => 8, 'role' => 'Pegawai'],
                    ['name' => 'budi_santoso', 'transaksi' => 5, 'role' => 'Pegawai'],
                    ['name' => 'maya_sari', 'transaksi' => 3, 'role' => 'Pegawai']
                ]
            ]
        ];

        return view('laporan.index', compact('laporanData'));
    }
}
