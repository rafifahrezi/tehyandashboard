<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BahanController extends Controller
{
    private const TOAST_DURATION = 6000;
    private const SUCCESS_DURATION = 4000;
    private const ERROR_TITLE = 'Kesalahan Sistem';
    private const NOT_FOUND_TITLE = 'Bahan Tidak Ditemukan';

    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Ambil semua bahan dengan relasi category
    $bahans = Bahan::with('category')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($bahan) {
            return [
                'id' => $bahan->id,
                'kode_bahan' => $bahan->kode_bahan,
                'nama_bahan' => $bahan->nama_bahan,
                'category_id' => $bahan->category_id,
                'category_name' => $bahan->category->nama ?? 'Tidak Berkategori',
                'satuan' => $bahan->satuan,
                'harga' => number_format($bahan->harga, 0, ',', '.'),
                'supplier' => $bahan->supplier,
                'stok_sekarang' => $bahan->stok_sekarang,
                'min_stok' => $bahan->min_stok,
                'status' => $bahan->status,
                'tanggal_masuk' => Carbon::parse($bahan->tanggal_masuk)->format('d M Y'),
                'tanggal_kadaluarsa' => Carbon::parse($bahan->tanggal_kadaluarsa)->format('d M Y'),
            ];
        });

    // Ambil semua kategori
    $categories = Category::all();

    return view('admin.bahan-baku.index', [
        'materials' => $bahans,
        'categories' => $categories,
        'pageTitle' => 'Manajemen Bahan Baku',
        'pageDescription' => 'Kelola dan pantau stok bahan baku Anda',
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.bahan-baku.create', [
            'categories' => $categories,
            'satuanOptions'  => Bahan::getSatuanOptions(),
            'pageTitle' => 'Manajemen Bahan Baku',
            'pageDescription' => 'Kelola data bahan baku',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bahan'     => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'satuan'         => 'required|string|max:50',
            'stok_sekarang'  => 'required|numeric|min:0',
            'min_stok'       => 'required|numeric|min:0',
            'harga'          => 'required|numeric|min:0',
            'supplier'       => 'required|string|max:255',
            'lokasi'         => 'nullable|string|max:255',
            'tanggal_masuk'  => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
            'is_active'      => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('notification', [
                    'type'     => 'error',
                    'title'    => 'Validasi Gagal',
                    'message'  => 'Periksa kembali isian form Anda.',
                    'duration' => 8000
                ]);
        }

        try {
            DB::transaction(function () use ($request) {
                $kodeBahan = $this->generateKodeBahan($request->category_id);

                Bahan::create([
                    'kode_bahan'       => $kodeBahan,
                    'nama_bahan'       => $request->nama_bahan,
                    'category_id'      => $request->category_id,
                    'satuan'           => $request->satuan,
                    'stok_sekarang'    => $request->stok_sekarang,
                    'min_stok'         => $request->min_stok,
                    'harga'            => $request->harga,
                    'supplier'         => $request->supplier,
                    'lokasi'           => $request->lokasi,
                    'tanggal_masuk'    => $request->tanggal_masuk,
                    'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                    'is_active'        => $request->is_active ?? true,
                ]);
            });

            return redirect()
                ->route('manajemen.bahan.index')
                ->with('notification', [
                    'type'     => 'success',
                    'title'    => 'Berhasil!',
                    'message'  => 'Bahan baku berhasil ditambahkan.',
                    'duration' => 5000
                ]);
        } catch (\Exception $e) {
            Log::error('Error creating bahan: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('notification', [
                    'type'     => 'error',
                    'title'    => 'Gagal!',
                    'message'  => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    'duration' => 8000
                ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bahan = $this->findBahanOrFail($id);
        $validated = $this->validateBahanData($request);
        if ($validated !== true) {
            return $validated;
        }
        try {
            DB::beginTransaction();
            $bahan->update($request->only([
                'nama_bahan',
                'category_id',
                'satuan',
                'min_stok',
                'harga',
                'supplier',
                'tanggal_masuk',
                'tanggal_kadaluarsa',
                'status',
            ]));
            DB::commit();
            Log::info('Bahan updated successfully', [
                'id' => $id,
                'nama_bahan' => $bahan->nama_bahan,
                'user_id' => auth()->id(),
            ]);
            return redirect()->route('manajemen.bahan.index')
                ->with('toast', $this->createToastResponse('success', 'Berhasil!', 'Data bahan baku berhasil diperbarui.', self::SUCCESS_DURATION));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating bahan', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('toast', $this->createToastResponse('error', self::ERROR_TITLE, 'Terjadi kesalahan saat memperbarui data bahan baku.', self::TOAST_DURATION));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $bahan = $this->findBahanOrFail($id);
            return view('admin.bahan-baku.edit', [
                'bahan' => $bahan,
                'satuanOptions' => Bahan::getSatuanOptions(),
                'categories' => Category::all(),
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->handleNotFoundError('Bahan yang diminta tidak ditemukan atau telah dihapus.');
        } catch (\Throwable $e) {
            return $this->handleSystemError('Terjadi kesalahan saat membuka form edit.', $e, 'edit bahan (id=' . $id . ')');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $bahan = $this->findBahanOrFail($id);
            DB::beginTransaction();
            $bahanName = $bahan->nama_bahan;
            $bahan->delete();
            DB::commit();
            Log::info('Bahan deleted successfully', [
                'id' => $id,
                'nama_bahan' => $bahanName,
                'user_id' => auth()->id(),
            ]);
            return redirect()->route('manajemen.bahan.index')
                ->with('toast', $this->createToastResponse('success', 'Berhasil!', "Bahan baku '{$bahanName}' berhasil dihapus.", self::SUCCESS_DURATION));
        } catch (ModelNotFoundException $e) {
            return $this->handleNotFoundError('Bahan yang diminta tidak dapat dihapus karena tidak ditemukan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting bahan', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);
            return redirect()->back()
                ->with('toast', $this->createToastResponse('error', self::ERROR_TITLE, 'Terjadi kesalahan saat menghapus bahan baku. Silakan coba lagi.', self::TOAST_DURATION));
        }
    }

    /**
     * Logic Private
     */

    /**
     * Generate Kode Bahan
     */
    private function generateKodeBahan($categoryId)
    {
        $prefix = match ($categoryId) {
            1 => 'BP', // Bahan Pokok
            2 => 'BT', // Bahan Tambahan
            3 => 'BM', // Bahan Mentah
            4 => 'BJ', // Bahan Jadi
            default => 'BB' // Bahan Baku
        };

        $lastBahan = Bahan::where('kode_bahan', 'like', $prefix . '%')
            ->orderBy('kode_bahan', 'desc')
            ->first();

        $number = $lastBahan
            ? intval(substr($lastBahan->kode_bahan, 2)) + 1
            : 1;

        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    
    /* Validate Data Bahan */
    private function validateBahanData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bahan' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'satuan' => 'required|string|max:50',
            'min_stok' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_kadaluarsa' => 'nullable|date|after_or_equal:tanggal_masuk',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        if ($validator->fails()) {
            Log::warning('Validation failed for bahan', [
                'errors' => $validator->errors()->all(),
                'user_id' => auth()->id(),
            ]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('toast', $this->createToastResponse('error', 'Validasi Gagal', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali data Anda.', self::TOAST_DURATION));
        }
        return true;
    }
    /**
     * Find bahan by ID or throw exception.
     *
     * @param int $id
     * @return \App\Models\Bahan
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    private function findBahanOrFail($id)
    {
        return Bahan::findOrFail($id);
    }
    /**
     * Create toast response array.
     *
     * @param string $type
     * @param string $title
     * @param string $message
     * @param int $duration
     * @return array
     */
    private function createToastResponse(string $type, string $title, string $message, int $duration): array
    {
        return [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'duration' => $duration,
        ];
    }
    /**
     * Handle not found error response.
     *
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleNotFoundError(string $message)
    {
        Log::warning('Resource not found', [
            'user_id' => auth()->id(),
            'message' => $message,
        ]);
        return redirect()->route('manajemen.bahan.index')
            ->with('toast', $this->createToastResponse('error', self::NOT_FOUND_TITLE, $message, self::TOAST_DURATION));
    }
    /**
     * Handle system error response.
     *
     * @param string $userMessage
     * @param \Throwable $exception
     * @param string $context
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleSystemError(string $userMessage, \Throwable $exception, string $context)
    {
        Log::error('System error: ' . $context, [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('manajemen.bahan.index')
            ->with('toast', $this->createToastResponse('error', self::ERROR_TITLE, $userMessage, self::TOAST_DURATION));
    }
}
