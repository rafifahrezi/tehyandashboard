<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\StockMove;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todayRange = [
            now()->startOfDay(),
            now()->endOfDay()
        ];

        /* ============================
         * LOW STOCK (WARNING + KRITIS)
         * ============================ */
        $lowStockSummary = Bahan::selectRaw('status, COUNT(*) as total')
            ->whereIn('status', ['warning', 'kritis'])
            ->groupBy('status')
            ->pluck('total', 'status');

        $warningCount = $lowStockSummary['warning'] ?? 0;
        $kritisCount  = $lowStockSummary['kritis'] ?? 0;
        $lowStockCount = $warningCount + $kritisCount;

        /* ============================
        * STOK MASUK & KELUAR HARI INI
        * ============================ */
        $todayIn = StockMove::where('move_type', 'in')
            ->whereBetween('created_at', $todayRange);

        $todayOut = StockMove::where('move_type', 'out')
            ->whereBetween('created_at', $todayRange);

        /**
         * =========================
         * INFORMASI STOK
         * =========================
         */

        $stockSummary = Bahan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $warning = $stockSummary['warning'] ?? 0;
        $kritis  = $stockSummary['kritis'] ?? 0;
        $habis   = $stockSummary['habis'] ?? 0;

        // Tentukan status global
        if ($habis > 0) {
            $stockStatus = 'habis';
            $message = 'Beberapa bahan stoknya habis';
        } elseif ($kritis > 0) {
            $stockStatus = 'kritis';
            $message = 'Beberapa bahan berada pada stok kritis';
        } elseif ($warning > 0) {
            $stockStatus = 'warning';
            $message = 'Ada bahan dengan stok menipis';
        } else {
            $stockStatus = 'aman';
            $message = 'Semua stok dalam kondisi aman';
        }

        $stockInfo = [
            'status'  => $stockStatus,
            'message' => $message,
            'items'   => [
                'total' => $warning + $kritis + $habis,
                'description' => 'bahan perlu perhatian',
            ],
            'notes' => array_filter([
                $warning ? "{$warning} bahan status warning" : null,
                $kritis ? "{$kritis} bahan status kritis" : null,
                $habis  ? "{$habis} bahan status habis" : null,
            ])
        ];

        /* ===============================
         * RECENT TRANSACTIONS
         * =============================== */
        $recentActivity = StockMove::with('bahan')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'product'  => $item->bahan->nama_bahan,
                    'user'     => auth()->user()->name,
                    'date'     => $item->created_at->format('d M Y H:i'),
                    'quantity' => ($item->move_type === 'in' ? '+' : '-')
                        . $item->qty . ' unit',
                    'type'     => $item->move_type,
                ];
            });

        // Sample data 
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
                    'count'        => $todayIn->sum('qty'),
                    'transactions' => $todayIn->count(),
                ],
                'todayOut' => [
                    'count'        => $todayOut->sum('qty'),
                    'transactions' => $todayOut->count(),
                ],
            ],
            'stock' => $stockInfo,
            'recentActivity' => $recentActivity,
        ];

        // Define the minimum stock threshold
        $minimumStockThreshold = 5; 
        $lowStockCount = Bahan::where('stok_sekarang', '<=', $minimumStockThreshold)->count();


        return view('admin.dashboard.index', compact(
            'dashboardData',
            'warningCount',
            'kritisCount',
            'lowStockCount',
            'stockInfo'
        ));
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
