@extends('layouts.app')

@section('title', 'Dashboard Administrator')

@section('content')
<div class="space-y-8">
    <!-- Welcome Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Dashboard</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stok Masuk Hari ini -->
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-900">Stok Masuk Hari ini</p>
                        <p class="text-2xl font-bold text-blue-900">{{ $dashboardData['transactions']['todayIn']['count'] }}</p>
                        <p class="text-xs text-blue-700">{{ $dashboardData['transactions']['todayIn']['transactions'] }} transaksi</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-arrow-down text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Stok Keluar Hari ini -->
            <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-900">Stok Keluar Hari ini</p>
                        <p class="text-2xl font-bold text-green-900">{{ $dashboardData['transactions']['todayOut']['count'] }}</p>
                        <p class="text-xs text-green-700">{{ $dashboardData['transactions']['todayOut']['transactions'] }} transaksi</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-arrow-up text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Peringatan Stok -->
            <div class="bg-yellow-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-yellow-900">Peringatan Stok</p>
                        <p class="text-2xl font-bold text-yellow-900">{{ $dashboardData['stock']['warnings'] }}</p>
                        <p class="text-xs text-yellow-700">{{ $dashboardData['stock']['status'] }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Nilai Inventori -->
            <div class="bg-purple-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-900">Nilai Inventori</p>
                        <p class="text-2xl font-bold text-purple-900">Rp {{ number_format($dashboardData['stock']['inventoryValue'], 0, ',', '.') }}</p>
                        <p class="text-xs text-purple-700">Total Nilai Stok</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Charts and Stock Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Grafik Transaksi -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Grafik Transaksi</h2>
                <p class="text-sm text-gray-600 mb-4">7 hari terakhir</p>
                
                <!-- Simple Bar Chart -->
                <div class="h-64 flex items-end justify-between space-x-2 pt-4">
                    @foreach($dashboardData['transactions']['last7Days'] as $day)
                    <div class="flex flex-col items-center flex-1">
                        <div class="bg-blue-500 rounded-t w-full" style="height: {{ $day['count'] * 20 }}px;"></div>
                        <span class="text-xs text-gray-600 mt-2">{{ $day['date'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Stock Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Stok</h2>
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                        <i class="fas fa-check-circle mr-1"></i>
                        Semua Stok Aman
                    </span>
                </div>
                
                <div class="space-y-3">
                    <p class="text-sm text-gray-700">{{ $dashboardData['stock']['message'] }}</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-900">
                            {{ $dashboardData['stock']['items']['total'] }} {{ $dashboardData['stock']['items']['description'] }}
                        </p>
                        @foreach($dashboardData['stock']['notes'] as $note)
                        <p class="text-xs text-gray-600 mt-1"><em>{{ $note }}</em></p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Recent Transactions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Transaksi Terbaru</h2>
                <p class="text-sm text-gray-600 mb-4">Aktivitas stok terkini</p>
                
                <div class="space-y-4">
                    @foreach($dashboardData['recentActivity'] as $activity)
                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <h3 class="font-medium text-gray-900">{{ $activity['product'] }}</h3>
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>{{ $activity['user'] }} • {{ $activity['date'] }}</span>
                        </div>
                        <p class="text-sm text-gray-700 mt-1">{{ $activity['quantity'] }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- View All Button -->
                <div class="mt-6">
                    <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200">
                        Lihat Semua Transaksi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection