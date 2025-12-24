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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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

        $categories = Category::all();

        return view('admin.bahan-baku.index', [
            'materials' => $bahans,
            'categories' => $categories,
            'pageTitle' => 'Manajemen Bahan Baku',
            'pageDescription' => 'Kelola dan pantau stok bahan baku Anda',
        ]);
    }

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
        $bahan = Bahan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_bahan' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'satuan' => 'required|string|max:50',
            'min_stok' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('toast', [
                    'type' => 'error',
                    'title' => 'Validasi Gagal',
                    'message' => 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali data Anda.',
                    'duration' => 10000
                ]);
        }

        DB::beginTransaction();
        try {
            $bahan->update([
                'nama_bahan' => $request->nama_bahan,
                'category_id' => $request->category_id,
                'satuan' => $request->satuan,
                'min_stok' => $request->min_stok,
                'harga' => $request->harga,
                'supplier' => $request->supplier,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'is_active' => $request->is_active ?? $bahan->is_active,
            ]);

            DB::commit();

            return redirect()->route('manajemen.bahan-admin')
                ->with('toast', [
                    'type' => 'success',
                    'title' => 'Berhasil!',
                    'message' => 'Data bahan baku berhasil diperbarui.',
                    'duration' => 4000
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating bahan (id=' . $id . '): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return redirect()->back()
                ->withInput()
                ->with('toast', [
                    'type' => 'error',
                    'title' => 'Kesalahan Sistem',
                    'message' => 'Terjadi kesalahan sistem saat memperbarui bahan baku. Silakan coba lagi.',
                    'duration' => 6000
                ]);
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
            // Validasi ID numerik dan cari bahan
            $bahan = Bahan::findOrFail($id);

            // Ambil semua kategori untuk dropdown
            $categories = Category::all();

            // Render view edit dengan data bahan dan kategori
            return view('admin.bahan-baku.edit', [
                'bahan' => $bahan,
                'satuanOptions'  => Bahan::getSatuanOptions(),
                'categories' => $categories
            ]);
        } catch (ModelNotFoundException $e) {
            // Redirect dengan pesan error via toast
            return redirect()
                ->route('manajemen.bahan-admin') // Sesuaikan nama route indeks
                ->with('toast', [
                    'type' => 'error',
                    'title' => 'Bahan Tidak Ditemukan',
                    'message' => 'Bahan yang diminta tidak ditemukan atau telah dihapus.',
                    'duration' => 6000
                ]);
        } catch (\Exception $e) {
            Log::error('Error fetching bahan for edit (id=' . $id . '): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return redirect()
                ->route('manajemen.bahan-admin')
                ->with('toast', [
                    'type' => 'error',
                    'title' => 'Kesalahan Sistem',
                    'message' => 'Terjadi kesalahan saat membuka form edit. Silakan coba lagi.',
                    'duration' => 6000
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $bahan = Bahan::findOrFail($id);
            $namaBahan = $bahan->nama_bahan;

            $bahan->delete();

            return response()->json([
                'success' => true,
                'notification' => [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => "Bahan baku \"{$namaBahan}\" berhasil dihapus.",
                    'duration' => 4000,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting bahan', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'notification' => [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Terjadi kesalahan saat menghapus bahan baku.',
                    'duration' => 5000,
                ]
            ], 500);
        }
    }
}
