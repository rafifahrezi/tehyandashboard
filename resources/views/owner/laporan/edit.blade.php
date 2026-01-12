@extends('layouts.master')

@section('title', 'Edit Laporan: ' . $report->nama_laporan)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h1 class="text-3xl font-bold mb-2">Edit Laporan</h1>
                <p class="text-blue-100 text-lg">{{ $report->nama_laporan }}</p>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('reports.show', $report) }}" class="bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group">
                    <i class="fas fa-eye mr-3 text-lg"></i>
                    Lihat Detail
                </a>
                <a href="{{ route('reports.index') }}" class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group">
                    <i class="fas fa-arrow-left mr-3 text-lg"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Form Edit -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <form action="{{ route('reports.update', $report) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Laporan -->
                <div class="space-y-2">
                    <label for="nama_laporan" class="block text-sm font-semibold text-gray-700">Nama Laporan *</label>
                    <div class="relative">
                        <i class="fas fa-file-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input
                            type="text"
                            id="nama_laporan"
                            name="nama_laporan"
                            value="{{ old('nama_laporan', $report->nama_laporan) }}"
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                            placeholder="Masukkan nama laporan"
                            required
                        >
                    </div>
                    @error('nama_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Laporan -->
                <div class="space-y-2">
                    <label for="jenis_laporan" class="block text-sm font-semibold text-gray-700">Jenis Laporan *</label>
                    <div class="relative">
                        <i class="fas fa-calendar absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select id="jenis_laporan" name="jenis_laporan" class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300" required>
                            <option value="harian" {{ old('jenis_laporan', $report->jenis_laporan) == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="bulanan" {{ old('jenis_laporan', $report->jenis_laporan) == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="tahunan" {{ old('jenis_laporan', $report->jenis_laporan) == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                            <option value="custom" {{ old('jenis_laporan', $report->jenis_laporan) == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('jenis_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Mulai (Hanya muncul jika custom) -->
                <div class="space-y-2" id="tanggal_mulai_container">
                    <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700">Tanggal Mulai</label>
                    <div class="relative">
                        <i class="fas fa-calendar-day absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input
                            type="date"
                            id="tanggal_mulai"
                            name="tanggal_mulai"
                            value="{{ old('tanggal_mulai', $report->tanggal_mulai ? \Carbon\Carbon::parse($report->tanggal_mulai)->format('Y-m-d') : '') }}"
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                        >
                    </div>
                    @error('tanggal_mulai')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Akhir (Hanya muncul jika custom) -->
                <div class="space-y-2" id="tanggal_akhir_container">
                    <label for="tanggal_akhir" class="block text-sm font-semibold text-gray-700">Tanggal Akhir</label>
                    <div class="relative">
                        <i class="fas fa-calendar-day absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input
                            type="date"
                            id="tanggal_akhir"
                            name="tanggal_akhir"
                            value="{{ old('tanggal_akhir', $report->tanggal_akhir ? \Carbon\Carbon::parse($report->tanggal_akhir)->format('Y-m-d') : '') }}"
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                        >
                    </div>
                    @error('tanggal_akhir')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Transaksi -->
                <div class="space-y-2">
                    <label for="jenis_transaksi" class="block text-sm font-semibold text-gray-700">Jenis Transaksi *</label>
                    <div class="relative">
                        <i class="fas fa-exchange-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select id="jenis_transaksi" name="jenis_transaksi" class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300" required>
                            <option value="semua" {{ old('jenis_transaksi', $report->jenis_transaksi) == 'semua' ? 'selected' : '' }}>Semua</option>
                            <option value="masuk" {{ old('jenis_transaksi', $report->jenis_transaksi) == 'masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="keluar" {{ old('jenis_transaksi', $report->jenis_transaksi) == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('jenis_transaksi')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bahan Baku -->
                <div class="space-y-2">
                    <label for="bahan_id" class="block text-sm font-semibold text-gray-700">Bahan Baku</label>
                    <div class="relative">
                        <i class="fas fa-boxes absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select id="bahan_id" name="bahan_id" class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                            <option value="">Semua Bahan</option>
                            @foreach($bahans ?? [] as $bahan)
                                <option value="{{ $bahan->id }}" {{ old('bahan_id', $report->bahan_id) == $bahan->id ? 'selected' : '' }}>
                                    {{ $bahan->nama_bahan }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('bahan_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label for="status" class="block text-sm font-semibold text-gray-700">Status *</label>
                    <div class="relative">
                        <i class="fas fa-tag absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select id="status" name="status" class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300" required>
                            <option value="draft" {{ old('status', $report->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $report->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status', $report->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('reports.show', $report) }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-semibold">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisLaporanSelect = document.getElementById('jenis_laporan');
        const tanggalMulaiContainer = document.getElementById('tanggal_mulai_container');
        const tanggalAkhirContainer = document.getElementById('tanggal_akhir_container');
        const tanggalMulaiInput = document.getElementById('tanggal_mulai');
        const tanggalAkhirInput = document.getElementById('tanggal_akhir');

        // Fungsi untuk menampilkan/menyembunyikan field tanggal
        function toggleTanggalFields() {
            if (jenisLaporanSelect.value === 'custom') {
                tanggalMulaiContainer.style.display = 'block';
                tanggalAkhirContainer.style.display = 'block';
                tanggalMulaiInput.required = true;
                tanggalAkhirInput.required = true;
            } else {
                tanggalMulaiContainer.style.display = 'none';
                tanggalAkhirContainer.style.display = 'none';
                tanggalMulaiInput.required = false;
                tanggalAkhirInput.required = false;
            }
        }

        // Inisialisasi saat halaman dimuat
        toggleTanggalFields();

        // Event listener saat jenis laporan berubah
        jenisLaporanSelect.addEventListener('change', toggleTanggalFields);

        // Validasi form
        document.querySelector('form').addEventListener('submit', function(e) {
            if (jenisLaporanSelect.value === 'custom') {
                const mulai = tanggalMulaiInput.value;
                const akhir = tanggalAkhirInput.value;

                if (!mulai || !akhir) {
                    e.preventDefault();
                    alert('Tanggal mulai dan tanggal akhir harus diisi untuk jenis laporan custom.');
                    return;
                }

                if (new Date(akhir) < new Date(mulai)) {
                    e.preventDefault();
                    alert('Tanggal akhir tidak boleh lebih awal dari tanggal mulai.');
                    return;
                }
            }
        });
    });
</script>

<style>
    @media print {
        .bg-gradient-to-r {
            background: #2563eb !important;
            color: white !important;
        }
        .shadow-lg, .shadow-xl {
            box-shadow: none !important;
        }
        button, .flex.space-x-3, .flex.justify-end {
            display: none !important;
        }
        nav {
            display: none !important;
        }
    }
</style>
@endsection
