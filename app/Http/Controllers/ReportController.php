<?php
// app/Http\Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Bahan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Display a listing of reports dengan filter
    public function index(Request $request)
    {
        // Query dasar
        $query = Report::with(['user', 'bahan'])
            ->where(function($q) {
                $q->where('user_id', Auth::id())
                  ->orWhere('status', 'published');
            });

        // Filter berdasarkan input
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_akhir', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('jenis_transaksi') && $request->jenis_transaksi != 'semua') {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        if ($request->filled('bahan_id')) {
            $query->where('bahan_id', $request->bahan_id);
        }

        // Pagination
        $reports = $query->latest()->paginate(10);

        // Ambil semua bahan untuk dropdown filter
        $bahans = Bahan::all();

        // Ambil parameter filter untuk mengisi form
        $filterParams = $request->only(['tanggal_mulai', 'tanggal_akhir', 'jenis_transaksi', 'bahan_id']);

        return view('owner.laporan.index', compact('reports', 'bahans', 'filterParams'));
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
        // Cek apakah user berhak melihat laporan ini
        if ($report->user_id !== Auth::id() && $report->status !== 'published') {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        return view('owner.laporan.show', compact('report'));
    }

    // Show form for editing report
    public function edit(Report $report)
    {
        // Cek apakah user berhak mengedit laporan ini
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Anda hanya dapat mengedit laporan yang Anda buat.');
        }

        $bahans = Bahan::all();
        return view('owner.laporan.edit', compact('report', 'bahans'));
    }

    // Update the specified report
    public function update(Request $request, Report $report)
    {
        // Cek apakah user berhak mengupdate laporan ini
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Anda hanya dapat mengupdate laporan yang Anda buat.');
        }

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
        // Cek apakah user berhak menghapus laporan ini
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Anda hanya dapat menghapus laporan yang Anda buat.');
        }

        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function printList(Request $request)
    {
        // Gunakan filter yang sama seperti di index
        $query = Report::with(['user', 'bahan'])
            ->when($request->tanggal_mulai, function($query) use ($request) {
                return $query->where('tanggal_mulai', '>=', $request->tanggal_mulai);
            })
            ->when($request->tanggal_akhir, function($query) use ($request) {
                return $query->where('tanggal_akhir', '<=', $request->tanggal_akhir);
            })
            ->when($request->jenis_transaksi && $request->jenis_transaksi != 'semua', function($query) use ($request) {
                return $query->where('jenis_transaksi', $request->jenis_transaksi);
            })
            ->when($request->bahan_id, function($query) use ($request) {
                return $query->where('bahan_id', $request->bahan_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'reports' => $query,
            'filterParams' => $request->only(['tanggal_mulai', 'tanggal_akhir', 'jenis_transaksi', 'bahan_id']),
            'user' => auth()->user(),
        ];

        $filename = 'Daftar_Laporan_' . now()->format('Ymd_His') . '.pdf';

        $pdf = Pdf::loadView('owner.laporan.print-list', $data);
        return $pdf->stream($filename);
    }
}
