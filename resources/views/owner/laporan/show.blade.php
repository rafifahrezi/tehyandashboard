@extends('layouts.master')

@section('title', $report->nama_laporan)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h1 class="text-3xl font-bold mb-2">{{ $report->nama_laporan }}</h1>
                <p class="text-blue-100 text-lg">
                    {{ $report->jenis_laporan == 'harian' ? 'Laporan Harian' :
                       ($report->jenis_laporan == 'bulanan' ? 'Laporan Bulanan' :
                       ($report->jenis_laporan == 'tahunan' ? 'Laporan Tahunan' : 'Laporan Custom')) }}
                    • {{ $report->periode }}
                </p>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('reports.edit', $report) }}" class="bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center group">
                    <i class="fas fa-edit mr-3 text-lg"></i>
                    Edit
                </a>
                <button onclick="window.print()" class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center group">
                    <i class="fas fa-print mr-3 text-lg"></i>
                    Print
                </button>
            </div>
        </div>
    </div>

    <!-- Report Info -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Laporan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="space-y-2">
                <p class="text-sm text-gray-500">Jenis Laporan</p>
                <p class="font-semibold capitalize">{{ $report->jenis_laporan }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-500">Periode</p>
                <p class="font-semibold">{{ $report->periode }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-500">Status</p>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                    {{ $report->status == 'published' ? 'bg-green-100 text-green-800' :
                       ($report->status == 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ $report->status }}
                </span>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-500">Jenis Transaksi</p>
                <p class="font-semibold">{{ $report->jenis_transaksi == 'semua' ? 'Semua' : ucfirst($report->jenis_transaksi) }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-500">Bahan</p>
                <p class="font-semibold">{{ $report->bahan ? $report->bahan->nama_bahan : 'Semua Bahan' }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-500">Dibuat Oleh</p>
                <p class="font-semibold">{{ $report->user->name ?? 'User' }}</p>
            </div>
        </div>
    </div>

    <!-- Laporan Data (copy dari index.blade.php) -->
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

    <!-- Back Button -->
    <div class="flex justify-center">
        <a href="{{ route('reports.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Laporan
        </a>
    </div>
</div>
@endsection
