@extends('layouts.app')

@section('title', $transaksiData['pageTitle'])

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h1 class="text-3xl font-bold mb-2">{{ $transaksiData['pageTitle'] }}</h1>
                <p class="text-blue-100 text-lg">{{ $transaksiData['pageDescription'] }}</p>
            </div>
            
            <button class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group">
                <i class="fas fa-plus-circle mr-3 text-lg"></i>
                Transaksi Baru
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Transaksi</p>
                    <p class="text-2xl font-bold mt-1">{{ count($transaksiData['transactions']) }}</p>
                </div>
                <i class="fas fa-exchange-alt text-2xl opacity-80"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Stok Masuk</p>
                    <p class="text-2xl font-bold mt-1">{{ collect($transaksiData['transactions'])->where('jenis', 'Masuk')->count() }}</p>
                </div>
                <i class="fas fa-arrow-down text-2xl opacity-80"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Stok Keluar</p>
                    <p class="text-2xl font-bold mt-1">{{ collect($transaksiData['transactions'])->where('jenis', 'Keluar')->count() }}</p>
                </div>
                <i class="fas fa-arrow-up text-2xl opacity-80"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Aktivitas Hari Ini</p>
                    <p class="text-2xl font-bold mt-1">3</p>
                </div>
                <i class="fas fa-calendar-day text-2xl opacity-80"></i>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <!-- Jenis Transaksi Filter -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Jenis Transaksi</label>
                <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                    @foreach($transaksiData['filters']['jenis'] as $jenis)
                        <option value="{{ $jenis }}">{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Bahan Filter -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Bahan Baku</label>
                <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                    @foreach($transaksiData['filters']['bahan'] as $bahan)
                        <option value="{{ $bahan }}">{{ $bahan }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Periode Filter -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Periode</label>
                <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                    @foreach($transaksiData['filters']['periode'] as $periode)
                        <option value="{{ $periode }}">{{ $periode }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Search -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Cari Transaksi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input 
                        type="text" 
                        placeholder="Cari transaksi..." 
                        class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                    >
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Transaksi Section -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Section Header -->
        <div class="border-b border-gray-200 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Riwayat Transaksi</h2>
                    <p class="text-gray-600 mt-1">Semua aktivitas keluar masuk stok</p>
                </div>
                <div class="flex items-center space-x-3 mt-4 lg:mt-0">
                    <button class="flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        <i class="fas fa-file-export mr-2"></i>
                        Export
                    </button>
                    <button class="flex items-center text-gray-600 hover:text-gray-800 font-medium">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Bahan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stok Sebelum</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stok Sesudah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($transaksiData['transactions'] as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <!-- Tanggal -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $transaction['tanggal'] }}</div>
                        </td>
                        
                        <!-- Bahan -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $transaction['bahan'] }}</div>
                        </td>
                        
                        <!-- Jenis -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                {{ $transaction['jenis_color'] == 'green' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas {{ $transaction['jenis'] == 'Masuk' ? 'fa-arrow-down mr-1' : 'fa-arrow-up mr-1' }} text-xs"></i>
                                {{ $transaction['jenis'] }}
                            </span>
                        </td>
                        
                        <!-- Jumlah -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold 
                                {{ $transaction['jenis'] == 'Masuk' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction['jumlah'] }}
                            </div>
                        </td>
                        
                        <!-- Stok Sebelum -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">{{ $transaction['stok_sebelum'] }}</div>
                        </td>
                        
                        <!-- Stok Sesudah -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $transaction['stok_sesudah'] }}</div>
                        </td>
                        
                        <!-- Pegawai -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3">
                                    {{ substr($transaction['pegawai'], 0, 1) }}
                                </div>
                                <span class="text-sm text-gray-700">{{ $transaction['pegawai'] }}</span>
                            </div>
                        </td>
                        
                        <!-- Keterangan -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600 max-w-xs truncate" title="{{ $transaction['keterangan'] }}">
                                {{ $transaction['keterangan'] }}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="border-t border-gray-200 px-6 py-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="text-sm text-gray-600 mb-4 lg:mb-0">
                    Menampilkan <span class="font-semibold">{{ count($transaksiData['transactions']) }}</span> transaksi
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Sebelumnya
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        1
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        2
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    @if(count($transaksiData['transactions']) === 0)
    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl shadow-lg p-16 border-2 border-dashed border-gray-200 text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-exchange-alt text-3xl text-blue-500"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada transaksi</h3>
        <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">Mulai catat aktivitas stok dengan membuat transaksi pertama</p>
        <button class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus-circle mr-3"></i>
            Buat Transaksi Pertama
        </button>
    </div>
    @endif
</div>

<!-- JavaScript for Interactions -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filters = document.querySelectorAll('select');
        const searchInput = document.querySelector('input[type="text"]');
        
        filters.forEach(filter => {
            filter.addEventListener('change', function(e) {
                console.log('Filter changed:', e.target.value);
                // Implement filter logic here
            });
        });

        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    console.log('Searching for:', e.target.value);
                    // Implement search logic here
                }, 500);
            });
        }

        // Export functionality
        document.querySelector('button:contains("Export")').addEventListener('click', function() {
            console.log('Exporting data...');
            // Implement export logic here
        });

        // Print functionality
        document.querySelector('button:contains("Print")').addEventListener('click', function() {
            window.print();
        });

        // Add hover effects to table rows
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
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
    }
</style>
@endsection