<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\StockMove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StockMoveRequest;
use Illuminate\Support\Facades\Log;

class TransaksiStokController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StockMove::with(['bahan', 'user'])->latest();


        if ($request->filled('bahan_id')) {
            $query->where('bahan_id', $request->bahan_id);
        }

        if ($request->filled('move_type')) {
            $query->where('move_type', $request->move_type);
        }

        if ($request->filled('periode')) {
            $range = $this->periodDateRange($request->periode);
            if ($range) {
                $query->whereBetween('created_at', [$range[0], $range[1]]);
            }
        }
        // Hitung aktivitas hari ini
        $aktivitasHariIni = StockMove::whereBetween('created_at', $this->periodDateRange('daily'))
            ->count();

        $stockMoves = $query->paginate(10)->withQueryString();

        $transactions = $stockMoves->map(function ($item) {
            return [
                'tanggal'        => $item->created_at->format('d M Y H:i'),
                'bahan'          => $item->bahan->nama_bahan,
                'jenis'          => $item->move_type === 'in' ? 'Masuk' : 'Keluar',
                'jenis_color'    => $item->move_type === 'in' ? 'green' : 'red',
                'jumlah'         => $item->qty,
                'stok_sebelum'   => $item->stok_sebelum,
                'stok_sesudah'   => $item->stok_sesudah,
                'pegawai'        => $item->user->name ?? 'Admin nih (?)',
                'keterangan'     => $item->reference_type ?? '-',
            ];
        });

        return view('admin.transaksi-stok.index', [
            'pageTitle'       => 'Transaksi Stok',
            'pageDescription' => 'Catat keluar masuk stok bahan baku',
            'filters'         => [
                'jenis' => [
                    'in' => 'Masuk',
                    'out' => 'Keluar',
                ],
                'bahan'   => Bahan::pluck('nama_bahan', 'id'),
                'periode' => ['Harian', 'Mingguan', 'Bulanan'],
            ],
            'transactions'    => $transactions,
            'pagination'      => $stockMoves,
            'aktivitasHariIni' => $aktivitasHariIni,
        ]);
    }

    /* =======================================================
     * LOGIKA PERHITUNGAN STOK – SINGLE SOURCE OF TRUTH
     * ======================================================= */


    // Calculate Filter Periode
    private function periodDateRange($periode)
    {
        switch ($periode) {
            case 'daily':
                return [
                    now()->startOfDay(),
                    now()->endOfDay()
                ];

            case 'weekly':
                return [
                    now()->startOfWeek(), // Senin
                    now()->endOfWeek()    // Minggu
                ];

            case 'monthly':
                return [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ];

            default:
                 return null;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bahans = Bahan::where('is_active', true)
            ->orderBy('nama_bahan')
            ->get();

        return view('admin.transaksi-stok.create', [
            'pageTitle' => 'Buat Transaksi Baru',
            'pageDescription' => 'Tambahkan transaksi masuk/keluar stok bahan baku',
            'bahans' => $bahans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockMoveRequest $request)
    {
        try {
            // Jalankan transaksi database
            $stockMove = DB::transaction(function () use ($request) {
                // Ambil bahan dengan lock untuk mencegah race condition
                $bahan = Bahan::lockForUpdate()->findOrFail($request->bahan_id);

                // Validasi stok keluar
                if ($request->move_type === 'out' && $bahan->stok_sekarang < $request->qty) {
                    throw new \Exception('Stok tidak mencukupi. Stok tersedia: ' . $bahan->stok_sekarang);
                }

                // Hitung stok baru
                $stokSebelum = $bahan->stok_sekarang;
                $stokSesudah = $request->move_type === 'in'
                    ? $stokSebelum + $request->qty
                    : $stokSebelum - $request->qty;

                // Simpan transaksi
                $stockMove = StockMove::create([
                    'bahan_id'       => $bahan->id,
                    'move_type'      => $request->move_type,
                    'qty'            => $request->qty,
                    'stok_sebelum'   => $stokSebelum,
                    'stok_sesudah'   => $stokSesudah,
                    'reference_type' => $request->reference_type,
                    'reference_id'   => $request->reference_id,
                ]);

                // Update stok bahan
                $bahan->update(['stok_sekarang' => $stokSesudah]);

                return $stockMove;
            });

            // Redirect untuk tampilan web
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'data'    => $stockMove,
                    'message' => 'Transaksi berhasil disimpan!',
                ], 201);
            }

            return redirect()->route('transaksi.stok-admin.store')
                ->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            // Handle error
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
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
    public function update(StockMoveRequest $request, $id)
    {
        
        try {
            return DB::transaction(function () use ($request, $id) {
                // Lock record untuk mencegah race condition
                $stockMove = StockMove::lockForUpdate()->findOrFail($id);
                $bahan = Bahan::lockForUpdate()->findOrFail($stockMove->bahan_id);

                // 1. Rollback stok lama (kembalikan ke nilai sebelum transaksi)
                $this->rollbackStock($stockMove, $bahan);

                // 2. Validasi stok untuk transaksi baru
                $this->validateStock($request->move_type, $request->qty, $bahan);

                // 3. Hitung stok baru
                [$stokSebelum, $stokSesudah] = $this->calculateNewStock(
                    $request->move_type,
                    $request->qty,
                    $bahan->stok_sekarang
                );

                // 4. Update transaksi stok
                $stockMove->update([
                    'move_type'      => $request->move_type,
                    'qty'            => $request->qty,
                    'stok_sebelum'   => $stokSebelum,
                    'stok_sesudah'   => $stokSesudah,
                    'reference_type' => $request->reference_type,
                    'reference_id'   => $request->reference_id,
                ]);

                // 5. Update stok bahan
                $bahan->update([
                    'stok_sekarang' => $stokSesudah
                ]);


                return response()->json([
                    'success' => true,
                    'data'    => $stockMove,
                    'message' => 'Transaksi stok berhasil diupdate'
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $stockMove = StockMove::findOrFail($id);
                $bahan = $stockMove->bahan;

                // Kembalikan stok
                $bahan->update([
                    'stok_sekarang' => $stockMove->move_type === 'in'
                        ? $bahan->stok_sekarang - $stockMove->qty
                        : $bahan->stok_sekarang + $stockMove->qty
                ]);

                $stockMove->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi stok berhasil dihapus'
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
}
