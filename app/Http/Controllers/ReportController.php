<?php
// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Bahan;
use App\Models\Category;
use App\Models\StockMove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Method untuk generate data laporan
    private function generateReportData($params = [])
    {
        // Default values
        $startDate = $params['tanggal_mulai'] ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $params['tanggal_akhir'] ?? now()->format('Y-m-d');
        $jenisTransaksi = $params['jenis_transaksi'] ?? 'semua';
        $bahanId = $params['bahan_id'] ?? null;

        // Query Stock Moves
        $query = StockMove::with(['bahan'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($jenisTransaksi !== 'semua') {
            $query->where('move_type', $jenisTransaksi);
        }

        if ($bahanId) {
            $query->where('bahan_id', $bahanId);
        }

        $stockMoves = $query->get();

        // Hitung stats
        $totalTransaksi = $stockMoves->count();
        $totalMasuk = $stockMoves->where('move_type', 'in')->count();
        $totalKeluar = $stockMoves->where('move_type', 'out')->count();

        // Hitung nilai transaksi
        $totalNilai = 0;
        foreach ($stockMoves as $move) {
            $harga = $move->bahan->harga ?? 0;
            $totalNilai += $move->qty * $harga;
        }

        // Data tren harian (7 hari terakhir)
        $trenHarian = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::parse($endDate)->subDays($i)->format('Y-m-d');
            $masuk = StockMove::where('move_type', 'in')
                ->whereDate('created_at', $date)
                ->when($bahanId, function ($q) use ($bahanId) {
                    $q->where('bahan_id', $bahanId);
                })
                ->count();
            $keluar = StockMove::where('move_type', 'out')
                ->whereDate('created_at', $date)
                ->when($bahanId, function ($q) use ($bahanId) {
                    $q->where('bahan_id', $bahanId);
                })
                ->count();

            $trenHarian[] = [
                'date' => Carbon::parse($date)->format('d/m'),
                'masuk' => $masuk,
                'keluar' => $keluar
            ];
        }

        // Top 5 bahan paling aktif
        $topBahan = StockMove::select('bahan_id')
            ->selectRaw('COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($jenisTransaksi !== 'semua', function ($q) use ($jenisTransaksi) {
                $q->where('move_type', $jenisTransaksi);
            })
            ->groupBy('bahan_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $bahan = Bahan::find($item->bahan_id);
                return [
                    'name' => $bahan ? $bahan->nama_bahan : 'Unknown',
                    'transaksi' => $item->total,
                    'persentase' => 0
                ];
            });

        // Hitung persentase
        $totalTop = $topBahan->sum('transaksi');
        $topBahan = $topBahan->map(function ($item) use ($totalTop) {
            $item['persentase'] = $totalTop > 0 ? round(($item['transaksi'] / $totalTop) * 100, 1) : 0;
            return $item;
        });

        // Data rekap pegawai (contoh sederhana)
        $rekapPegawai = [
            [
                'name' => 'Admin',
                'role' => 'Administrator',
                'transaksi' => rand(20, 100)
            ],
            [
                'name' => 'Manager',
                'role' => 'Manager Gudang',
                'transaksi' => rand(10, 50)
            ]
        ];

        return [
            'pageTitle' => 'Laporan Transaksi Stok',
            'pageDescription' => 'Analisis pergerakan stok periode ' .
                Carbon::parse($startDate)->format('d/m/Y') . ' - ' .
                Carbon::parse($endDate)->format('d/m/Y'),
            'filters' => [
                'jenis_transaksi' => ['Semua', 'Masuk', 'Keluar'],
                'bahan_baku' => Bahan::pluck('nama_bahan')->toArray()
            ],
            'stats' => [
                'total_transaksi' => [
                    'value' => $totalTransaksi,
                    'transaksi' => 'Total transaksi',
                    'color' => 'blue',
                    'icon' => 'fas fa-exchange-alt'
                ],
                'stok_masuk' => [
                    'value' => $totalMasuk,
                    'transaksi' => 'Transaksi masuk',
                    'color' => 'green',
                    'icon' => 'fas fa-arrow-down'
                ],
                'stok_keluar' => [
                    'value' => $totalKeluar,
                    'transaksi' => 'Transaksi keluar',
                    'color' => 'red',
                    'icon' => 'fas fa-arrow-up'
                ],
                'total_nilai' => [
                    'value' => 'Rp ' . number_format($totalNilai, 0, ',', '.'),
                    'description' => 'Total nilai transaksi',
                    'color' => 'purple',
                    'icon' => 'fas fa-coins'
                ]
            ],
            'tren_harian' => [
                'periode' => '7 Hari Terakhir',
                'data' => $trenHarian
            ],
            'top_bahan' => [
                'title' => 'Top 5 Bahan Paling Aktif',
                'subtitle' => 'Berdasarkan jumlah transaksi',
                'data' => $topBahan
            ],
            'rekap_pegawai' => [
                'title' => 'Aktivitas Pegawai',
                'data' => $rekapPegawai
            ],
            'ringkasan_bulanan' => [
                'total_masuk' => $totalMasuk,
                'total_keluar' => $totalKeluar
            ]
        ];
    }

    // Display a listing of reports
    public function index(Request $request)
    {
        // Ambil parameter filter dari request
        $filterParams = $request->only(['tanggal_mulai', 'tanggal_akhir', 'jenis_transaksi', 'bahan_id']);

        // Generate laporan data berdasarkan filter
        if (!empty(array_filter($filterParams))) {
            $laporanData = $this->generateReportData($filterParams);
        } else {
            $laporanData = $this->generateReportData();
        }

        $reports = Report::where('user_id', Auth::id())
            ->orWhere('status', 'published')
            ->latest()
            ->paginate(10);

        $bahans = Bahan::all();

        return view('owner.laporan.index', compact('reports', 'laporanData', 'bahans', 'filterParams'));
    }

    // Show form for creating new report
    public function create()
    {
        $bahans = Bahan::all();
        return view('owner.laporan.create', compact('bahans'));
    }

    // Store a newly created report
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_laporan' => 'required|string|max:255',
            'jenis_laporan' => 'required|in:harian,bulanan,tahunan,custom',
            'tanggal_mulai' => 'required_if:jenis_laporan,custom|nullable|date',
            'tanggal_akhir' => 'required_if:jenis_laporan,custom|nullable|date|after_or_equal:tanggal_mulai',
            'jenis_transaksi' => 'required|in:semua,masuk,keluar',
            'bahan_id' => 'nullable|exists:bahans,id',
            'status' => 'required|in:draft,published,archived'
        ]);

        // Set tanggal berdasarkan jenis laporan
        $today = now();
        switch ($validated['jenis_laporan']) {
            case 'harian':
                $validated['tanggal_mulai'] = $today->format('Y-m-d');
                $validated['tanggal_akhir'] = $today->format('Y-m-d');
                break;
            case 'bulanan':
                $validated['tanggal_mulai'] = $today->startOfMonth()->format('Y-m-d');
                $validated['tanggal_akhir'] = $today->endOfMonth()->format('Y-m-d');
                break;
            case 'tahunan':
                $validated['tanggal_mulai'] = $today->startOfYear()->format('Y-m-d');
                $validated['tanggal_akhir'] = $today->endOfYear()->format('Y-m-d');
                break;
        }

        $validated['user_id'] = Auth::id();
        $validated['filter_params'] = json_encode([
            'jenis_transaksi' => $validated['jenis_transaksi'],
            'bahan_id' => $validated['bahan_id'],
        ]);

        Report::create($validated);

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dibuat.');
    }

    // Display the specified report
    public function show(Report $report)
    {
        $params = [
            'tanggal_mulai' => $report->tanggal_mulai,
            'tanggal_akhir' => $report->tanggal_akhir,
            'jenis_transaksi' => $report->jenis_transaksi,
            'bahan_id' => $report->bahan_id,
        ];

        $laporanData = $this->generateReportData($params);

        return view('owner.laporan.show', compact('report', 'laporanData'));
    }

    // Show form for editing report
    public function edit(Report $report)
    {
        $bahans = Bahan::all();
        return view('owner.laporan.edit', compact('report', 'bahans'));
    }

    // Update the specified report
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'nama_laporan' => 'required|string|max:255',
            'jenis_laporan' => 'required|in:harian,bulanan,tahunan,custom',
            'tanggal_mulai' => 'required_if:jenis_laporan,custom|nullable|date',
            'tanggal_akhir' => 'required_if:jenis_laporan,custom|nullable|date|after_or_equal:tanggal_mulai',
            'jenis_transaksi' => 'required|in:semua,masuk,keluar',
            'bahan_id' => 'nullable|exists:bahans,id',
            'status' => 'required|in:draft,published,archived'
        ]);

        // Update tanggal berdasarkan jenis laporan
        $today = now();
        switch ($validated['jenis_laporan']) {
            case 'harian':
                $validated['tanggal_mulai'] = $today->format('Y-m-d');
                $validated['tanggal_akhir'] = $today->format('Y-m-d');
                break;
            case 'bulanan':
                $validated['tanggal_mulai'] = $today->startOfMonth()->format('Y-m-d');
                $validated['tanggal_akhir'] = $today->endOfMonth()->format('Y-m-d');
                break;
            case 'tahunan':
                $validated['tanggal_mulai'] = $today->startOfYear()->format('Y-m-d');
                $validated['tanggal_akhir'] = $today->endOfYear()->format('Y-m-d');
                break;
        }

        $validated['filter_params'] = json_encode([
            'jenis_transaksi' => $validated['jenis_transaksi'],
            'bahan_id' => $validated['bahan_id'],
        ]);

        $report->update($validated);

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    // Remove the specified report
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
