@extends('layouts.master')

@section('title', 'Dashboard Administrator')

@section('content')
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Dashboard</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stok Masuk Hari ini -->
                <div
                    class="bg-blue-50 rounded-lg p-4 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-900">Stok Masuk Hari ini</p>
                            <p class="text-2xl font-bold text-blue-900">
                                {{ $dashboardData['transactions']['todayIn']['count'] }}</p>
                            <p class="text-xs text-blue-700">{{ $dashboardData['transactions']['todayIn']['transactions'] }}
                                transaksi</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-arrow-down text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Stok Keluar Hari ini -->
                <div
                    class="bg-green-50 rounded-lg p-4  hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-900">Stok Keluar Hari ini</p>
                            <p class="text-2xl font-bold text-green-900">
                                {{ $dashboardData['transactions']['todayOut']['count'] }}</p>
                            <p class="text-xs text-green-700">
                                {{ $dashboardData['transactions']['todayOut']['transactions'] }} transaksi</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-arrow-up text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Peringatan Stok -->
                @if ($lowStockCount > 0)
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-yellow-900">Peringatan Stok</p>
                                <p class="text-2xl font-bold text-yellow-900">
                                    {{ $lowStockCount }}
                                </p>
                                <p class="text-xs text-yellow-700">
                                    {{ $warningCount }} warning {{ $kritisCount }} kritis
                                </p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Nilai Inventori -->
                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-900">Nilai Inventori</p>
                            {{-- <p class="text-2xl font-bold text-purple-900">Rp
                                {{ number_format($dashboardData['stock']['inventoryValue'], 0, ',', '.') }}</p>
                            <p class="text-xs text-purple-700">Total Nilai Stok</p> --}}
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
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Grafik Transaksi</h2>
                            <p class="text-sm text-gray-600">7 hari terakhir</p>
                        </div>
                    </div>

                    <!-- Chart Container -->
                    <div class="h-64">
                        <canvas id="transactionChart"></canvas>
                    </div>

                    <!-- Chart Legend -->
                    <div class="flex justify-center space-x-6 mt-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">Stok Masuk</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">Stok Keluar</span>
                        </div>
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
                                {{ $dashboardData['stock']['items']['total'] }}
                                {{ $dashboardData['stock']['items']['description'] }}
                            </p>
                            @foreach ($dashboardData['stock']['notes'] as $note)
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
                        @foreach ($dashboardData['recentActivity'] as $activity)
                            <div class="border-l-4 border-blue-500 pl-4 py-2">
                                <h3 class="font-medium text-gray-900">{{ $activity['product'] }}</h3>
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <span>{{ $activity['user'] }} • {{ $activity['date'] }}</span>
                                </div>
                                <p class="text-sm text-gray-700 mt-1">{{ $activity['quantity'] }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        <button
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200">
                            <a href="{{ route('transaksi.stok.index') }}">Lihat Semua Transaksi </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('chart-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari PHP - menggunakan data real dari controller
            const last7Days = @json($dashboardData['transactions']['last7Days'] ?? []);

            // Ekstrak data untuk chart
            const labels = last7Days.map(day => day.date);
            const stockInData = last7Days.map(day => day.stock_in || 0);
            const stockOutData = last7Days.map(day => day.stock_out || 0);

            // Chart configuration untuk bar chart
            const chartData = {
                labels: labels,
                datasets: [
                    {
                        label: 'Stok Masuk',
                        data: stockInData,
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8,
                    },
                    {
                        label: 'Stok Keluar',
                        data: stockOutData,
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8,
                    }
                ]
            };

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.85)',
                        titleFont: {
                            size: 12,
                            family: "'Inter', sans-serif",
                            weight: '600'
                        },
                        bodyFont: {
                            size: 12,
                            family: "'Inter', sans-serif"
                        },
                        padding: 12,
                        cornerRadius: 6,
                        boxPadding: 6,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                const value = context.parsed.y;
                                label += value + ' unit';
                                return label;
                            },
                            title: function(context) {
                                return context[0].label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                family: "'Inter', sans-serif"
                            },
                            color: '#6b7280',
                            maxRotation: 0
                        },
                        // Caption untuk sumbu X
                        title: {
                            display: true,
                            text: 'Tanggal (7 Hari Terakhir)',
                            color: '#4b5563',
                            font: {
                                size: 12,
                                family: "'Inter', sans-serif",
                                weight: '600'
                            },
                            padding: {
                                top: 10,
                                bottom: 0
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false,
                            drawTicks: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                family: "'Inter', sans-serif"
                            },
                            color: '#6b7280',
                            callback: function(value) {
                                return value;
                            },
                            padding: 8
                        },
                        // Caption untuk sumbu Y
                        title: {
                            display: true,
                            text: 'Jumlah Unit',
                            color: '#4b5563',
                            font: {
                                size: 12,
                                family: "'Inter', sans-serif",
                                weight: '600'
                            },
                            padding: {
                                top: 0,
                                bottom: 10
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                hover: {
                    mode: 'index',
                    intersect: false
                }
            };

            // Get canvas context
            const ctx = document.getElementById('transactionChart');
            if (!ctx) {
                console.error('Canvas element not found!');
                return;
            }

            // Create bar chart
            const transactionChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: chartOptions
            });
        });
    </script>
@endpush
