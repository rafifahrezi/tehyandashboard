<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Static data - in real application, this would come from database
        $bahanBakuData = [
            'pageTitle' => 'Manajemen Bahan Baku',
            'pageDescription' => 'Kelola semua bahan baku kedai Anda',
            'categories' => ['Semua Kategori', 'Bahan Pokok', 'Bahan Tambahan', 'Bahan Mentah', 'Bahan Jadi'],
            'materials' => [
                [
                    'id' => 1,
                    'name' => 'Beras Bali',
                    'category' => 'bahan pokok',
                    'currentStock' => 22,
                    'minStock' => 2,
                    'unit' => 'pack',
                    'pricePerUnit' => 20000,
                    'supplier' => 'Fadri',
                    'location' => 'Rak A1',
                    'status' => 'aman'
                ],
                [
                    'id' => 2,
                    'name' => 'Gula Pasir',
                    'category' => 'bahan pokok',
                    'currentStock' => 15,
                    'minStock' => 5,
                    'unit' => 'kg',
                    'pricePerUnit' => 15000,
                    'supplier' => 'Toko Sumber',
                    'location' => 'Rak A2',
                    'status' => 'aman'
                ],
                [
                    'id' => 3,
                    'name' => 'Minyak Goreng',
                    'category' => 'bahan pokok',
                    'currentStock' => 8,
                    'minStock' => 10,
                    'unit' => 'liter',
                    'pricePerUnit' => 25000,
                    'supplier' => 'Supplier Minyak',
                    'location' => 'Rak B1',
                    'status' => 'warning'
                ],
                [
                    'id' => 4,
                    'name' => 'Garam Halus',
                    'category' => 'bahan tambahan',
                    'currentStock' => 5,
                    'minStock' => 3,
                    'unit' => 'kg',
                    'pricePerUnit' => 8000,
                    'supplier' => 'Toko Sumber',
                    'location' => 'Rak C1',
                    'status' => 'aman'
                ]
            ]
        ];

        return view('bahan-baku.index', compact('bahanBakuData'));
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
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'current_stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
            'location' => 'required|string|max:255'
        ]);

        // In real application, save to database
        // Material::create($validated);

        return redirect()->route('manajemen.bahan')->with('success', 'Bahan baku berhasil ditambahkan!');
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
