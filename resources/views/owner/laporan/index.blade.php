@extends('layouts.master')

@section('title', 'Manajemen Laporan')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h1 class="text-3xl font-bold mb-2">Manajemen Laporan</h1>
                <p class="text-blue-100 text-lg">Buat, kelola, dan filter laporan transaksi stok</p>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('reports.create') }}" class="bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group">
                    <i class="fas fa-plus mr-3 text-lg"></i>
                    Buat Laporan Baru
                </a>
                <button class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group" onclick="window.print()">
                    <i class="fas fa-print mr-3 text-lg"></i>
                    Print
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Filter Laporan</h2>
        <form action="{{ route('reports.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Tanggal Mulai -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Tanggal Mulai</label>
                    <div class="relative">
                        <i class="fas fa-calendar-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input
                            type="date"
                            name="tanggal_mulai"
                            value="{{ $filterParams['tanggal_mulai'] ?? '' }}"
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
                            type="date"
                            name="tanggal_akhir"
                            value="{{ $filterParams['tanggal_akhir'] ?? '' }}"
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                        >
                    </div>
                </div>

                <!-- Jenis Transaksi -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Jenis Transaksi</label>
                    <div class="relative">
                        <i class="fas fa-filter absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="jenis_transaksi" class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                            <option value="semua" {{ ($filterParams['jenis_transaksi'] ?? 'semua') == 'semua' ? 'selected' : '' }}>Semua</option>
                            <option value="masuk" {{ ($filterParams['jenis_transaksi'] ?? '') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="keluar" {{ ($filterParams['jenis_transaksi'] ?? '') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- Bahan Baku -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Bahan Baku</label>
                    <div class="relative">
                        <i class="fas fa-boxes absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="bahan_id" class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                            <option value="">Semua Bahan</option>
                            @foreach($bahans ?? [] as $bahan)
                                <option value="{{ $bahan->id }}" {{ (isset($filterParams['bahan_id']) && $filterParams['bahan_id'] == $bahan->id) ? 'selected' : '' }}>
                                    {{ $bahan->nama_bahan }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('reports.index') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-semibold">
                    Reset Filter
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Laporan Tersimpan -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Laporan Tersimpan</h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500">{{ $reports->total() }} laporan ditemukan</span>
                @if(request()->anyFilled(['tanggal_mulai', 'tanggal_akhir', 'jenis_transaksi', 'bahan_id']))
                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                    Filter Aktif
                </span>
                @endif
            </div>
        </div>

        @if($reports->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Laporan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bahan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reports as $report)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $report->nama_laporan }}</div>
                            <div class="text-sm text-gray-500">Dibuat oleh {{ $report->user->name ?? 'User' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $report->jenis_laporan == 'harian' ? 'bg-green-100 text-green-800' :
                                   ($report->jenis_laporan == 'bulanan' ? 'bg-blue-100 text-blue-800' :
                                   ($report->jenis_laporan == 'tahunan' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($report->jenis_laporan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if($report->jenis_laporan == 'harian')
                                {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('d/m/Y') }}
                            @elseif($report->jenis_laporan == 'bulanan')
                                {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('F Y') }}
                            @elseif($report->jenis_laporan == 'tahunan')
                                {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($report->tanggal_akhir)->format('d/m/Y') }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $report->jenis_transaksi == 'masuk' ? 'bg-green-100 text-green-800' :
                                   ($report->jenis_transaksi == 'keluar' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($report->jenis_transaksi) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $report->bahan->nama_bahan ?? 'Semua Bahan' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $report->status == 'published' ? 'bg-green-100 text-green-800' :
                                   ($report->status == 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('reports.show', $report) }}" class="text-blue-600 hover:text-blue-900 transition-colors duration-200 p-1 rounded hover:bg-blue-50" title="Lihat Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                @if($report->user_id == Auth::id())
                                <a href="{{ route('reports.edit', $report) }}" class="text-green-600 hover:text-green-900 transition-colors duration-200 p-1 rounded hover:bg-green-50" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route('reports.destroy', $report) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition-colors duration-200 p-1 rounded hover:bg-red-50" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $reports->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-file-alt text-5xl mb-4 text-gray-300"></i>
            <p class="text-lg text-gray-500 mb-2">
                @if(request()->anyFilled(['tanggal_mulai', 'tanggal_akhir', 'jenis_transaksi', 'bahan_id']))
                    Tidak ada laporan yang sesuai dengan filter yang dipilih.
                @else
                    Belum ada laporan yang disimpan.
                @endif
            </p>
            <a href="{{ route('reports.create') }}" class="mt-4 inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-plus mr-2"></i>Buat Laporan Pertama Anda
            </a>
        </div>
        @endif
    </div>
</div>

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
        .hover\:bg-gray-50:hover {
            background-color: transparent !important;
        }
    }
</style>
@endsection
