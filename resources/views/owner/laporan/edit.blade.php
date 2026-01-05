@extends('layouts.master')

@section('title', 'Edit Laporan: ' . $report->nama_laporan)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Laporan</h1>
            <p class="text-gray-600">Perbarui informasi laporan</p>
        </div>

        <form action="{{ route('reports.update', $report) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nama Laporan -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Nama Laporan *</label>
                    <input
                        type="text"
                        name="nama_laporan"
                        value="{{ $report->nama_laporan }}"
                        required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    >
                </div>

                <!-- Jenis Laporan -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Jenis Laporan *</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label class="flex items-center p-4 border-2 {{ $report->jenis_laporan == 'harian' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-xl cursor-pointer hover:border-blue-500">
                            <input type="radio" name="jenis_laporan" value="harian" class="mr-3" {{ $report->jenis_laporan == 'harian' ? 'checked' : '' }} required>
                            <div>
                                <div class="font-semibold">Harian</div>
                                <div class="text-sm text-gray-500">Laporan harian</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 {{ $report->jenis_laporan == 'bulanan' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-xl cursor-pointer hover:border-blue-500">
                            <input type="radio" name="jenis_laporan" value="bulanan" class="mr-3" {{ $report->jenis_laporan == 'bulanan' ? 'checked' : '' }}>
                            <div>
                                <div class="font-semibold">Bulanan</div>
                                <div class="text-sm text-gray-500">Laporan bulanan</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 {{ $report->jenis_laporan == 'tahunan' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-xl cursor-pointer hover:border-blue-500">
                            <input type="radio" name="jenis_laporan" value="tahunan" class="mr-3" {{ $report->jenis_laporan == 'tahunan' ? 'checked' : '' }}>
                            <div>
                                <div class="font-semibold">Tahunan</div>
                                <div class="text-sm text-gray-500">Laporan tahunan</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 {{ $report->jenis_laporan == 'custom' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-xl cursor-pointer hover:border-blue-500">
                            <input type="radio" name="jenis_laporan" value="custom" class="mr-3" {{ $report->jenis_laporan == 'custom' ? 'checked' : '' }}>
                            <div>
                                <div class="font-semibold">Custom</div>
                                <div class="text-sm text-gray-500">Periode kustom</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Tanggal Custom -->
                <div id="custom-date-fields" class="{{ $report->jenis_laporan == 'custom' ? '' : 'hidden' }} space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Tanggal Mulai *</label>
                            <input
                                type="date"
                                name="tanggal_mulai"
                                value="{{ $report->jenis_laporan == 'custom' ? $report->tanggal_mulai->format('Y-m-d') : '' }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl"
                                {{ $report->jenis_laporan == 'custom' ? 'required' : '' }}
                            >
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Tanggal Akhir *</label>
                            <input
                                type="date"
                                name="tanggal_akhir"
                                value="{{ $report->jenis_laporan == 'custom' ? $report->tanggal_akhir->format('Y-m-d') : '' }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl"
                                {{ $report->jenis_laporan == 'custom' ? 'required' : '' }}
                            >
                        </div>
                    </div>
                </div>

                <!-- Filter -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Jenis Transaksi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Jenis Transaksi</label>
                        <select name="jenis_transaksi" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl">
                            <option value="semua" {{ $report->jenis_transaksi == 'semua' ? 'selected' : '' }}>Semua Transaksi</option>
                            <option value="masuk" {{ $report->jenis_transaksi == 'masuk' ? 'selected' : '' }}>Stok Masuk</option>
                            <option value="keluar" {{ $report->jenis_transaksi == 'keluar' ? 'selected' : '' }}>Stok Keluar</option>
                        </select>
                    </div>

                    <!-- Bahan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Bahan (Opsional)</label>
                        <select name="bahan_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl">
                            <option value="">Semua Bahan</option>
                            @foreach($bahans ?? [] as $bahan)
                                <option value="{{ $bahan->id }}" {{ $report->bahan_id == $bahan->id ? 'selected' : '' }}>
                                    {{ $bahan->nama_bahan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Status Laporan</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="status" value="draft" class="mr-2" {{ $report->status == 'draft' ? 'checked' : '' }}>
                            <span class="text-gray-700">Draft</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status" value="published" class="mr-2" {{ $report->status == 'published' ? 'checked' : '' }}>
                            <span class="text-gray-700">Published</span>
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('reports.show', $report) }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200 font-semibold">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                        Perbarui Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisLaporanRadios = document.querySelectorAll('input[name="jenis_laporan"]');
        const customDateFields = document.getElementById('custom-date-fields');

        jenisLaporanRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customDateFields.classList.remove('hidden');
                    // Set required pada tanggal
                    customDateFields.querySelectorAll('input[type="date"]').forEach(input => {
                        input.required = true;
                    });
                } else {
                    customDateFields.classList.add('hidden');
                    // Hapus required
                    customDateFields.querySelectorAll('input[type="date"]').forEach(input => {
                        input.required = false;
                    });
                }
            });
        });
    });
</script>
@endsection
