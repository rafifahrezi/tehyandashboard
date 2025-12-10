@extends('layouts.master')

@section('title', $pageTitle)

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <h1 class="text-3xl font-bold mb-2">{{ $pageTitle }}</h1>
                    <p class="text-blue-100 text-lg">{{ $pageDescription }}</p>
                </div>

                <a href="{{ route('transaksi.stok-admin.create') }}"
                    class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group">
                    <i class="fas fa-plus-circle mr-3 text-lg"></i>
                    Transaksi Baru
                </a>

            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Transaksi</p>
                        <p class="text-2xl font-bold mt-1">{{ $transactions->count() }}</p>
                    </div>
                    <i class="fas fa-exchange-alt text-2xl opacity-80"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Stok Masuk</p>
                        <p class="text-2xl font-bold mt-1">{{ $transactions->where('jenis', 'Masuk')->count() }}</p>
                    </div>
                    <i class="fas fa-arrow-down text-2xl opacity-80"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Stok Keluar</p>
                        <p class="text-2xl font-bold mt-1">{{ $transactions->where('jenis', 'Keluar')->count() }}</p>
                    </div>
                    <i class="fas fa-arrow-up text-2xl opacity-80"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Aktivitas Hari Ini</p>
                        <p class="text-2xl font-bold mt-1">{{ $aktivitasHariIni }}</p>
                    </div>
                    <i class="fas fa-calendar-day text-2xl opacity-80"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100" x-data="transaksiFilter()">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                <!-- Jenis -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Jenis Transaksi</label>
                    <select x-model="move_type" @change="refresh()" class="w-full px-4 py-3 border-2 rounded-xl">
                        <option value="">Semua</option>
                        @foreach ($filters['jenis'] as $kode => $label)
                            <option value="{{ $kode }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Bahan -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Bahan Baku</label>
                    <select x-model="bahan_id" @change="refresh()" class="w-full px-4 py-3 border-2 rounded-xl">
                        <option value="">Semua</option>
                        @foreach ($filters['bahan'] as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Periode -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Periode</label>
                    <select x-model="periode" @change="refresh()" class="w-full px-4 py-3 border-2 rounded-xl">
                        <option value="">Semua</option>
                        <option value="daily">Harian</option>
                        <option value="weekly">Mingguan</option>
                        <option value="monthly">Bulanan</option>
                    </select>

                </div>

                <!-- Loading Indicator -->
                <div class="flex items-end">
                    <div x-show="loading" class="text-blue-600 font-semibold animate-pulse">
                        Loading...
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
                    @role('owner')
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
                    @endrole
                </div>
            </div>

            <div id="transactions-container">
                @include('admin.transaksi-stok.partials.transactions', [
                    'transactions' => $transactions,
                    'pagination' => $pagination,
                ])
            </div>
        </div>

        <!-- Empty State -->
        @if ($transactions->count() === 0)
            <div
                class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl shadow-lg p-16 border-2 border-dashed border-gray-200 text-center">
                <div
                    class="w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-exchange-alt text-3xl text-blue-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada transaksi</h3>
                <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">Mulai catat aktivitas stok dengan membuat transaksi
                    pertama</p>
                <button
                    class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
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

        function transaksiFilter() {
            return {
                move_type: '{{ request('move_type') }}',
                bahan_id: '{{ request('bahan_id') }}',
                periode: '{{ request('periode') }}',
                loading: false,

                async refresh() {
                    this.loading = true;

                    const params = new URLSearchParams({
                        move_type: this.move_type || '',
                        bahan_id: this.bahan_id || '',
                        periode: this.periode || '',
                    });

                    const res = await fetch(`{{ route('transaksi.stok-admin') }}?${params.toString()}`, {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    });

                    const html = await res.text();

                    // Ambil hanya partial table
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    const table = doc.querySelector("#transactions-container").innerHTML;

                    document.querySelector("#transactions-container").innerHTML = table;

                    this.loading = false;
                }
            }
        }
    </script>

    <style>
        @media print {
            .bg-gradient-to-r {
                background: #2563eb !important;
                color: white !important;
            }

            .shadow-lg,
            .shadow-xl {
                box-shadow: none !important;
            }

            button {
                display: none !important;
            }
        }
    </style>
@endsection
