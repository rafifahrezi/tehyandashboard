<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\StockMove;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function getLast7DaysChartData()
    {
        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
            $dates[] = now()->subDays($i)->format('Y-m-d');
        }

        $stockInData = StockMove::selectRaw('DATE(created_at) as date, SUM(qty) as total')
            ->where('move_type', 'in')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $stockOutData = StockMove::selectRaw('DATE(created_at) as date, SUM(qty) as total')
            ->where('move_type', 'out')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $chartData = [];
        foreach ($dates as $date) {
            $stockIn = $stockInData[$date] ?? 0;
            $stockOut = $stockOutData[$date] ?? 0;

            $chartData[] = [
                'date' => $date,
                'stock_in' => (int)$stockIn,
                'stock_out' => (int)$stockOut,
                'count' => (int)$stockIn + (int)$stockOut,
            ];
        }

        return $chartData;
    }

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

        /* =========================
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

        /* ===============================
        * CHART DATA - 7 HARI TERAKHIR
        * =============================== */
        $chartData7Days = $this->getLast7DaysChartData();

        // Format untuk chart 7 hari terakhir
        $last7DaysFormatted = [];
        foreach ($chartData7Days as $data) {
            $date = \Carbon\Carbon::parse($data['date'])->translatedFormat('d M');
            $last7DaysFormatted[] = [
                'date' => $date,
                'stock_in' => $data['stock_in'],
                'stock_out' => $data['stock_out'],
                'count' => $data['stock_in'] + $data['stock_out'],
            ];
        }

        // Dashboard data dengan data real
        $dashboardData = [
            'user' => [
                'name' => auth()->user()->name
            ],
            'transactions' => [
                'last7Days' => $last7DaysFormatted,
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
            'chartData' => [
                'labels_7days' => array_column($last7DaysFormatted, 'date'),
                'stock_in_7days' => array_column($last7DaysFormatted, 'stock_in'),
                'stock_out_7days' => array_column($last7DaysFormatted, 'stock_out'),
            ],
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
}
