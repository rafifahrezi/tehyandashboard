@extends('layouts.master')

@section('title', 'Detail Laporan: ' . $report->nama_laporan)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h1 class="text-3xl font-bold mb-2">Detail Laporan</h1>
                <p class="text-blue-100 text-lg">{{ $report->nama_laporan }}</p>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('reports.edit', $report) }}" class="bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group">
                    <i class="fas fa-edit mr-3 text-lg"></i>
                    Edit Laporan
                </a>
                <a href="{{ route('reports.index') }}" class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group">
                    <i class="fas fa-arrow-left mr-3 text-lg"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Informasi Utama -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Laporan</h2>

        <div class="space-y-4">
            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-600">Nama Laporan</span>
                <span class="font-semibold text-gray-900">{{ $report->nama_laporan }}</span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-600">Jenis Laporan</span>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                    {{ $report->jenis_laporan == 'harian' ? 'bg-green-100 text-green-800' :
                       ($report->jenis_laporan == 'bulanan' ? 'bg-blue-100 text-blue-800' :
                       ($report->jenis_laporan == 'tahunan' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')) }}">
                    {{ ucfirst($report->jenis_laporan) }}
                </span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-600">Periode</span>
                <span class="font-semibold text-gray-900">
                    @if($report->jenis_laporan == 'harian')
                        {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('d/m/Y') }}
                    @elseif($report->jenis_laporan == 'bulanan')
                        {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('F Y') }}
                    @elseif($report->jenis_laporan == 'tahunan')
                        {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($report->tanggal_akhir)->format('d/m/Y') }}
                    @endif
                </span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-600">Jenis Transaksi</span>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                    {{ $report->jenis_transaksi == 'masuk' ? 'bg-green-100 text-green-800' :
                       ($report->jenis_transaksi == 'keluar' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst($report->jenis_transaksi) }}
                </span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-600">Bahan Baku</span>
                <span class="font-semibold text-gray-900">{{ $report->bahan->nama_bahan ?? 'Semua Bahan' }}</span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-600">Status</span>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                    {{ $report->status == 'published' ? 'bg-green-100 text-green-800' :
                       ($report->status == 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst($report->status) }}
                </span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-600">Dibuat Oleh</span>
                <span class="font-semibold text-gray-900">{{ $report->user->name ?? 'User' }}</span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-600">Tanggal Dibuat</span>
                <span class="font-semibold text-gray-900">{{ $report->created_at->format('d/m/Y H:i') }}</span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <span class="text-gray-600">Terakhir Diupdate</span>
                <span class="font-semibold text-gray-900">{{ $report->updated_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
