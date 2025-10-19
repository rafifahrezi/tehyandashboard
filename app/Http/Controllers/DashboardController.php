<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Sample data - in a real app, this would come from your database
        $dashboardData = [
            'user' => [
                'name' => 'rafffahrezid'
            ],
            'transactions' => [
                'last7Days' => [
                    ['date' => '12 Okt', 'count' => 5],
                    ['date' => '13 Okt', 'count' => 3],
                    ['date' => '14 Okt', 'count' => 7],
                    ['date' => '15 Okt', 'count' => 6],
                    ['date' => '16 Okt', 'count' => 4],
                    ['date' => '17 Okt', 'count' => 2],
                    ['date' => '18 Okt', 'count' => 8],
                ],
                'todayIn' => [
                    'count' => 0,
                    'transactions' => 0
                ],
                'todayOut' => [
                    'count' => 0,
                    'transactions' => 0
                ]
            ],
            'stock' => [
                'warnings' => 0,
                'status' => 'semua aman',
                'message' => 'Tidak ada bahan di bawah stok minimum',
                'inventoryValue' => 440000,
                'items' => [
                    'total' => 1,
                    'description' => 'item bahan kelku'
                ],
                'notes' => [
                    '2 bitkung beotaratan hanga per unit'
                ]
            ],
            'recentActivity' => [
                [
                    'product' => 'Beras Bali',
                    'user' => 'rafffahrezid',
                    'date' => '16 Okt 17:25',
                    'quantity' => '12 pack'
                ]
            ]
        ];

        return view('admin.dashboard.index', compact('dashboardData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.index', [
            'title' => 'Dashboard'
        ]);
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
