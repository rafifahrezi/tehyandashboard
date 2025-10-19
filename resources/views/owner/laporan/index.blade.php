@extends('layouts.master')

@section('title', $laporanData['pageTitle'])

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h1 class="text-3xl font-bold mb-2">{{ $laporanData['pageTitle'] }}</h1>
                <p class="text-blue-100 text-lg">{{ $laporanData['pageDescription'] }}</p>
            </div>

            <div class="flex space-x-3">
                <button class="bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group">
                    <i class="fas fa-file-export mr-3 text-lg"></i>
                    Export PDF
                </button>
                <button class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group">
                    <i class="fas fa-print mr-3 text-lg"></i>
                    Print
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Filter Laporan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Tanggal Mulai -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Tanggal Mulai</label>
                <div class="relative">
                    <i class="fas fa-calendar-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="text"
                        placeholder="dd/mm/yyyy"
                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                    >
                </div>
            </div>

            <!-- Tanggal Akhir -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Tanggal Akhir</label>
                <div class="relative">
                    <i class="fas fa-calendar-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="text"
                        placeholder="dd/mm/yyyy"
                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                    >
                </div>
            </div>

            <!-- Jenis Transaksi -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Jenis Transaksi</label>
                <div class="relative">
                    <i class="fas fa-filter absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <select class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                        @foreach($laporanData['filters']['jenis_transaksi'] as $jenis)
                            <option value="{{ $jenis }}">{{ $jenis }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Bahan Baku -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Bahan Baku</label>
                <div class="relative">
                    <i class="fas fa-boxes absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <select class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                        @foreach($laporanData['filters']['bahan_baku'] as $bahan)
                            <option value="{{ $bahan }}">{{ $bahan }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Filter Actions -->
        <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
            <button class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-semibold">
                Reset
            </button>
            <button class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                <i class="fas fa-chart-bar mr-2"></i>
                Terapkan Filter
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($laporanData['stats'] as $key => $stat)
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2 capitalize">
                        {{ str_replace('_', ' ', $key) }}
                    </p>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $stat['value'] }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $stat['transaksi'] ?? $stat['description'] }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-{{ $stat['color'] }}-500 to-{{ $stat['color'] }}-600 rounded-xl flex items-center justify-center text-white">
                    <i class="{{ $stat['icon'] }} text-xl"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tren Transaksi Harian -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Tren Transaksi Harian</h3>
                    <p class="text-gray-600 mt-1">{{ $laporanData['tren_harian']['periode'] }}</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 font-medium text-sm py-2 px-4 rounded-lg transition-all duration-200 hover:bg-blue-50">
                    <i class="fas fa-expand mr-2"></i>
                    Detail
                </button>
            </div>

            <!-- Chart Container -->
            <div class="h-64 relative">
                <!-- Chart Bars -->
                <div class="flex items-end justify-between h-48 space-x-1">
                    @foreach($laporanData['tren_harian']['data'] as $day)
                    <div class="flex flex-col items-center flex-1 group">
                        <!-- Masuk Bar -->
                        <div
                            class="w-full bg-gradient-to-t from-green-500 to-green-400 rounded-t hover:from-green-600 hover:to-green-500 transition-all duration-300 cursor-pointer shadow-md mb-1"
                            style="height: {{ ($day['masuk'] / 15) * 100 }}%"
                            title="Masuk: {{ $day['masuk'] }}"
                        ></div>
                        <!-- Keluar Bar -->
                        <div
                            class="w-full bg-gradient-to-t from-red-500 to-red-400 rounded-t hover:from-red-600 hover:to-red-500 transition-all duration-300 cursor-pointer shadow-md"
                            style="height: {{ ($day['keluar'] / 15) * 100 }}%"
                            title="Keluar: {{ $day['keluar'] }}"
                        ></div>
                        <!-- Date Label -->
                        <span class="text-xs text-gray-600 mt-2 font-medium">{{ $day['date'] }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Legend -->
                <div class="flex justify-center space-x-6 mt-4">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-600">Stok Masuk</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-600">Stok Keluar</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 5 Bahan Paling Aktif -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $laporanData['top_bahan']['title'] }}</h3>
                    <p class="text-gray-600 mt-1">{{ $laporanData['top_bahan']['subtitle'] }}</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 font-medium text-sm py-2 px-4 rounded-lg transition-all duration-200 hover:bg-blue-50">
                    <i class="fas fa-list mr-2"></i>
                    Lihat Semua
                </button>
            </div>

            <div class="space-y-4">
                @foreach($laporanData['top_bahan']['data'] as $index => $bahan)
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white text-sm font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $bahan['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ $bahan['transaksi'] }} transaksi</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div
                                class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full"
                                style="width: {{ $bahan['persentase'] }}%"
                            ></div>
                        </div>
                        <span class="text-sm font-semibold text-gray-700 w-8">{{ $bahan['persentase'] }}%</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Additional Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Aktivitas Pegawai -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">{{ $laporanData['rekap_pegawai']['title'] }}</h3>
                <button class="text-blue-600 hover:text-blue-800 font-medium text-sm py-2 px-4 rounded-lg transition-all duration-200 hover:bg-blue-50">
                    <i class="fas fa-users mr-2"></i>
                    Semua Pegawai
                </button>
            </div>

            <div class="space-y-4">
                @foreach($laporanData['rekap_pegawai']['data'] as $pegawai)
                <div class="flex items-center justify-between p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center text-white font-bold">
                            {{ substr($pegawai['name'], 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $pegawai['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ $pegawai['role'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-900">{{ $pegawai['transaksi'] }}</p>
                        <p class="text-sm text-gray-500">transaksi</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Ringkasan Bulanan -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Ringkasan Bulan Ini</h3>
                <button class="text-blue-600 hover:text-blue-800 font-medium text-sm py-2 px-4 rounded-lg transition-all duration-200 hover:bg-blue-50">
                    <i class="fas fa-calendar mr-2"></i>
                    Detail
                </button>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-800 text-sm font-medium">Total Masuk</p>
                                <p class="text-2xl font-bold text-green-900">47 item</p>
                            </div>
                            <i class="fas fa-arrow-down text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-800 text-sm font-medium">Total Keluar</p>
                                <p class="text-2xl font-bold text-red-900">23 item</p>
                            </div>
                            <i class="fas fa-arrow-up text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-800 text-sm font-medium">Nilai Transaksi</p>
                            <p class="text-2xl font-bold text-blue-900">Rp 2.4JT</p>
                        </div>
                        <i class="fas fa-coins text-blue-600 text-xl"></i>
                    </div>
                </div>

                <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-800 text-sm font-medium">Rata-rata/hari</p>
                            <p class="text-2xl font-bold text-purple-900">5 transaksi</p>
                        </div>
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 rounded-2xl shadow-lg p-8 border border-blue-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-4 lg:mb-0">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Butuh Laporan Lebih Detail?</h3>
                <p class="text-gray-600">Generate laporan custom dengan kriteria yang lebih spesifik</p>
            </div>
            <div class="flex space-x-3">
                <button class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 border border-blue-200">
                    <i class="fas fa-cog mr-2"></i>
                    Laporan Custom
                </button>
                <button class="bg-blue-600 text-white hover:bg-blue-700 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-download mr-2"></i>
                    Download Excel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Interactive Elements -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Date picker initialization (you can integrate with a date picker library)
        const dateInputs = document.querySelectorAll('input[placeholder="dd/mm/yyyy"]');
        dateInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.type = 'date';
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.type = 'text';
                }
            });
        });

        // Filter functionality
        const filters = document.querySelectorAll('select');
        filters.forEach(filter => {
            filter.addEventListener('change', function(e) {
                console.log('Filter changed:', e.target.value);
                // Implement filter logic here
            });
        });

        // Chart bar hover effects
        const chartBars = document.querySelectorAll('.group');
        chartBars.forEach(bar => {
            bar.addEventListener('mouseenter', function() {
                const bars = this.querySelectorAll('div[class*="bg-gradient"]');
                bars.forEach(b => {
                    b.style.transform = 'scale(1.1)';
                });
            });

            bar.addEventListener('mouseleave', function() {
                const bars = this.querySelectorAll('div[class*="bg-gradient"]');
                bars.forEach(b => {
                    b.style.transform = 'scale(1)';
                });
            });
        });

        // Export functionality
        document.querySelector('button:contains("Export PDF")').addEventListener('click', function() {
            console.log('Exporting PDF...');
            // Implement PDF export logic here
        });

        // Print functionality
        document.querySelector('button:contains("Print")').addEventListener('click', function() {
            window.print();
        });

        // Apply filter button
        document.querySelector('button:contains("Terapkan Filter")').addEventListener('click', function() {
            console.log('Applying filters...');
            // Implement filter application logic here
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
        button {
            display: none !important;
        }
        .hover\\:shadow-xl:hover {
            box-shadow: none !important;
        }
    }
</style>
@endsection
