<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BahanController extends Controller
{
    public function index()
    {
        $bahan = Bahan::with('category')->get();
        return view('bahan.index', compact('bahan'));
    }

    public function create()
    {
        $categories = Category::all();
        $satuanOptions = Bahan::SATUAN_OPTIONS;
        $statusOptions = Bahan::STATUS_OPTIONS;

        return view('bahan.create', compact('categories', 'satuanOptions', 'statusOptions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'satuan' => 'required|in:' . implode(',', array_keys(Bahan::SATUAN_OPTIONS)),
            'harga' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',
            'min_stok' => 'required|numeric|min:0',
            'is_active' => 'in:aman,warning,habis,kritis'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $bahan = Bahan::create($request->all());

        // Otomatis update status stok
        $bahan->updateStokStatus();

        return redirect()->route('bahan.index')
            ->with('success', 'Bahan berhasil ditambahkan');
    }

    public function edit(Bahan $bahan)
    {
        $categories = Category::all();
        $satuanOptions = Bahan::SATUAN_OPTIONS;
        $statusOptions = Bahan::STATUS_OPTIONS;

        return view('bahan.edit', compact('bahan', 'categories', 'satuanOptions', 'statusOptions'));
    }

    public function update(Request $request, Bahan $bahan)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'satuan' => 'required|in:' . implode(',', array_keys(Bahan::SATUAN_OPTIONS)),
            'harga' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',
            'min_stok' => 'required|numeric|min:0',
            'is_active' => 'in:aman,warning,habis,kritis'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $bahan->update($request->all());

        // Otomatis update status stok
        $bahan->updateStokStatus();

        return redirect()->route('bahan.index')
            ->with('success', 'Bahan berhasil diupdate');
    }

    public function destroy(Bahan $bahan)
    {
        $bahan->delete();

        return redirect()->route('bahan.index')
            ->with('success', 'Bahan berhasil dihapus');
    }

    // Metode untuk update stok
    public function updateStok(Request $request, Bahan $bahan)
    {
        $validator = Validator::make($request->all(), [
            'stok' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $bahan->stok = $request->stok;
        $bahan->updateStokStatus();

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil diupdate',
            'status' => $bahan->is_active
        ]);
    }
}
=================
 public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,nama',
            'unit' => 'required|in:kg,g,liter,ml,pack,pcs,dus',
            'current_stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $category = Category::where('nama', $validatedData['category'])->first();

        $bahan = Bahan::create([
            'kode_bahan' => $this->generateKodeBahan($category->id),
            'nama_bahan' => $validatedData['name'],
            'category_id' => $category->id,
            'satuan' => $validatedData['unit'],
            'harga' => $validatedData['price_per_unit'],
            'supplier' => $validatedData['supplier'],
            'stok' => $validatedData['current_stock'],
            'min_stok' => $validatedData['min_stock'],
            'tanggal_masuk' => now(),
            'tanggal_kadaluarsa' => now()->addMonths(6),
            'is_active' => $validatedData['current_stock'] > $validatedData['min_stock'] ? 'aman' : 'kritis',
        ]);

        return redirect()->back()->with('success', 'Bahan baku berhasil ditambahkan');
    }

    private function generateKodeBahan($categoryId)
    {
        $prefix = match($categoryId) {
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

    public function update(Request $request, $id)
    {
        $bahan = Bahan::findOrFail($id);

        $validatedData = $request->validate([
            // Similar validation to store method
        ]);

        $bahan->update($validatedData);

        return redirect()->back()->with('success', 'Bahan baku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();

        return redirect()->back()->with('success', 'Bahan baku berhasil dihapus');
    }