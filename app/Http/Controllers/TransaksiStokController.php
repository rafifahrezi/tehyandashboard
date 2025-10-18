<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksiData = [
            'pageTitle' => 'Transaksi Stok',
            'pageDescription' => 'Catat keluar masuk stok bahan baku',
            'transactions' => [
                [
                    'id' => 1,
                    'tanggal' => '16 Okt 2024 17:25',
                    'bahan' => 'Beras Bali',
                    'jenis' => 'Masuk',
                    'jumlah' => '+12 pack',
                    'stok_sebelum' => '10 pack',
                    'stok_sesudah' => '22 pack',
                    'pegawai' => 'rafffahrez4',
                    'keterangan' => 'Nambah lagi nih Ref: av-1212',
                    'jenis_color' => 'green'
                ],
                [
                    'id' => 2,
                    'tanggal' => '15 Okt 2024 14:30',
                    'bahan' => 'Gula Pasir',
                    'jenis' => 'Keluar',
                    'jumlah' => '-5 kg',
                    'stok_sebelum' => '20 kg',
                    'stok_sesudah' => '15 kg',
                    'pegawai' => 'rafffahrez4',
                    'keterangan' => 'Untuk produksi harian',
                    'jenis_color' => 'red'
                ],
                [
                    'id' => 3,
                    'tanggal' => '15 Okt 2024 10:15',
                    'bahan' => 'Minyak Goreng',
                    'jenis' => 'Masuk',
                    'jumlah' => '+10 liter',
                    'stok_sebelum' => '8 liter',
                    'stok_sesudah' => '18 liter',
                    'pegawai' => 'staff1',
                    'keterangan' => 'Restock dari supplier',
                    'jenis_color' => 'green'
                ],
                [
                    'id' => 4,
                    'tanggal' => '14 Okt 2024 16:45',
                    'bahan' => 'Garam Halus',
                    'jenis' => 'Keluar',
                    'jumlah' => '-2 kg',
                    'stok_sebelum' => '7 kg',
                    'stok_sesudah' => '5 kg',
                    'pegawai' => 'staff2',
                    'keterangan' => 'Pemakaian dapur',
                    'jenis_color' => 'red'
                ],
                [
                    'id' => 5,
                    'tanggal' => '14 Okt 2024 09:20',
                    'bahan' => 'Beras Bali',
                    'jenis' => 'Masuk',
                    'jumlah' => '+15 pack',
                    'stok_sebelum' => '5 pack',
                    'stok_sesudah' => '20 pack',
                    'pegawai' => 'rafffahrez4',
                    'keterangan' => 'Stock awal bulan',
                    'jenis_color' => 'green'
                ]
            ],
            'filters' => [
                'jenis' => ['Semua Jenis', 'Masuk', 'Keluar'],
                'bahan' => ['Semua Bahan', 'Beras Bali', 'Gula Pasir', 'Minyak Goreng', 'Garam Halus'],
                'periode' => ['Hari Ini', 'Minggu Ini', 'Bulan Ini', '3 Bulan Terakhir', 'Custom']
            ]
        ];

        return view('transaksi-stok.index', compact('transaksiData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
