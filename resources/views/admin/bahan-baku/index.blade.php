@extends('layouts.master')

@section('title', $bahanBakuData['pageTitle'])

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-4 lg:mb-0">
                <h1 class="text-2xl font-bold text-gray-900">{{ $bahanBakuData['pageTitle'] }}</h1>
                <p class="text-gray-600 mt-2">{{ $bahanBakuData['pageDescription'] }}</p>
            </div>

            <button
                id="tambahBahanBtn"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 shadow-md hover:shadow-lg flex items-center"
            >
                <i class="fas fa-plus mr-2"></i>
                Tambah Bahan Baku
            </button>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 mr-3"></i>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Form Tambah Bahan Baku (Modal) -->
    <!-- Form Tambah Bahan Baku (Modal) -->
    <div id="tambahBahanModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden animate-fade-in">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full mx-4 max-h-[85vh] overflow-hidden transform transition-all duration-300 scale-95">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">Tambah Bahan Baku Baru</h2>
                        <p class="text-blue-100">Isi form berikut untuk menambahkan bahan baku baru</p>
                    </div>
                    <button id="closeModal" class="text-white hover:text-blue-200 transition duration-200">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="tambahBahanForm" action="{{ route('manajemen.bahan-admin.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <!-- Grid untuk Nama dan Kategori -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Nama Bahan -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700">Nama Bahan</label>
                        <div class="relative">
                            <i class="fas fa-tag absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Contoh: Beras Premium"
                                class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                required
                            >
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="space-y-2">
                        <label for="category" class="block text-sm font-semibold text-gray-700">Kategori</label>
                        <div class="relative">
                            <i class="fas fa-folder absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select
                                id="category"
                                name="category"
                                class="w-full pl-12 pr-10 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300"
                                required
                            >
                                <option value="">Pilih Kategori</option>
                                <option value="Bahan Pokok">Bahan Pokok</option>
                                <option value="Bahan Tambahan">Bahan Tambahan</option>
                                <option value="Bahan Mentah">Bahan Mentah</option>
                                <option value="Bahan Jadi">Bahan Jadi</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Grid untuk Satuan dan Stok -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Satuan -->
                    <div class="space-y-2">
                        <label for="unit" class="block text-sm font-semibold text-gray-700">Satuan</label>
                        <div class="relative">
                            <i class="fas fa-balance-scale absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select
                                id="unit"
                                name="unit"
                                class="w-full pl-12 pr-10 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300"
                                required
                            >
                                <option value="">Pilih Satuan</option>
                                <option value="kg">Kilogram (kg)</option>
                                <option value="g">Gram (g)</option>
                                <option value="liter">Liter</option>
                                <option value="ml">Milliliter (ml)</option>
                                <option value="pack">Pack</option>
                                <option value="pcs">Pcs</option>
                                <option value="dus">Dus</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Stok Saat Ini -->
                    <div class="space-y-2">
                        <label for="current_stock" class="block text-sm font-semibold text-gray-700">Stok Saat Ini</label>
                        <div class="relative">
                            <i class="fas fa-boxes absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input
                                type="number"
                                id="current_stock"
                                name="current_stock"
                                value="0"
                                min="0"
                                class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                required
                            >
                        </div>
                    </div>

                    <!-- Stok Minimum -->
                    <div class="space-y-2">
                        <label for="min_stock" class="block text-sm font-semibold text-gray-700">Stok Minimum</label>
                        <div class="relative">
                            <i class="fas fa-exclamation-triangle absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input
                                type="number"
                                id="min_stock"
                                name="min_stock"
                                value="0"
                                min="0"
                                class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                required
                            >
                        </div>
                    </div>
                </div>

                <!-- Harga Per Unit -->
                <div class="space-y-2">
                    <label for="price_per_unit" class="block text-sm font-semibold text-gray-700">Harga Per Unit (Rp)</label>
                    <div class="relative">
                        <i class="fas fa-tag absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input
                            type="number"
                            id="price_per_unit"
                            name="price_per_unit"
                            value="0"
                            min="0"
                            class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                            required
                        >
                    </div>
                </div>

                <!-- Grid untuk Supplier dan Lokasi -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Supplier -->
                    <div class="space-y-2">
                        <label for="supplier" class="block text-sm font-semibold text-gray-700">Supplier</label>
                        <div class="relative">
                            <i class="fas fa-truck absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input
                                type="text"
                                id="supplier"
                                name="supplier"
                                placeholder="Nama supplier"
                                class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                required
                            >
                        </div>
                    </div>

                    <!-- Lokasi Penyimpanan -->
                    <div class="space-y-2">
                        <label for="location" class="block text-sm font-semibold text-gray-700">Lokasi Penyimpanan</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input
                                type="text"
                                id="location"
                                name="location"
                                placeholder="Contoh: Rak A-1"
                                class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                required
                            >
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button
                        type="button"
                        id="batalBtn"
                        class="px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-semibold transform hover:scale-105"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Simpan Bahan Baku
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Search Input -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input
                    type="text"
                    placeholder="Cari bahan baku..."
                    class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                >
            </div>

            <!-- Category Filter -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-filter text-gray-400"></i>
                </div>
                <select class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition duration-200">
                    @foreach($bahanBakuData['categories'] as $category)
                        <option value="{{ $category }}" {{ $category === 'Semua Kategori' ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Materials Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($bahanBakuData['materials'] as $material)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-200">
            <!-- Header with Status -->
            <div class="border-b border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $material['name'] }}</h3>
                        <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full mt-1">
                            {{ $material['category'] }}
                        </span>
                    </div>
                    <div class="w-3 h-3 rounded-full
                        {{ $material['status'] === 'aman' ? 'bg-green-500' : 'bg-yellow-500' }}
                        {{ $material['status'] === 'warning' ? 'animate-pulse' : '' }}"
                        title="{{ $material['status'] === 'aman' ? 'Stok Aman' : 'Stok Menipis' }}">
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4">
                <!-- Stock Information -->
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Stok Saat Ini:</span>
                        <span class="font-medium text-gray-900">{{ $material['currentStock'] }} {{ $material['unit'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Stok Minimum:</span>
                        <span class="font-medium text-gray-900">{{ $material['minStock'] }} {{ $material['unit'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Harga/Unit:</span>
                        <span class="font-medium text-green-600">Rp {{ number_format($material['pricePerUnit'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>Level Stok</span>
                        <span>{{ number_format(($material['currentStock'] / ($material['minStock'] * 3)) * 100, 0) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full
                            {{ $material['currentStock'] > $material['minStock'] * 2 ? 'bg-green-500' :
                               ($material['currentStock'] > $material['minStock'] ? 'bg-yellow-500' : 'bg-red-500') }}"
                            style="width: {{ min(100, ($material['currentStock'] / ($material['minStock'] * 3)) * 100) }}%">
                        </div>
                    </div>
                </div>

                <!-- Supplier and Location -->
                <div class="space-y-2 text-sm">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-truck mr-2 w-4 text-center"></i>
                        <span>Supplier: {{ $material['supplier'] }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-map-marker-alt mr-2 w-4 text-center"></i>
                        <span>Lokasi: {{ $material['location'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-100">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">
                        ID: {{ str_pad($material['id'], 3, '0', STR_PAD_LEFT) }}
                    </span>
                    <button class="text-blue-600 hover:text-blue-800 font-medium text-sm py-1 px-3 rounded transition duration-200 edit-btn" data-material='@json($material)'>
                        <i class="fas fa-edit mr-1"></i>
                        Edit
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if(count($bahanBakuData['materials']) === 0)
    <div class="bg-white rounded-xl shadow-sm p-12 border border-gray-100 text-center">
        <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada bahan baku</h3>
        <p class="text-gray-600 mb-6">Mulai tambahkan bahan baku pertama Anda</p>
        <button id="tambahBahanEmptyBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
            <i class="fas fa-plus mr-2"></i>
            Tambah Bahan Baku
        </button>
    </div>
    @endif
</div>

<!-- JavaScript for Modal and Interactions -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('tambahBahanModal');
        const tambahBahanBtn = document.getElementById('tambahBahanBtn');
        const tambahBahanEmptyBtn = document.getElementById('tambahBahanEmptyBtn');
        const batalBtn = document.getElementById('batalBtn');
        const form = document.getElementById('tambahBahanForm');

        // Open modal
        function openModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close modal
        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            form.reset();
        }

        // Event listeners
        if (tambahBahanBtn) {
            tambahBahanBtn.addEventListener('click', openModal);
        }

        if (tambahBahanEmptyBtn) {
            tambahBahanEmptyBtn.addEventListener('click', openModal);
        }

        if (batalBtn) {
            batalBtn.addEventListener('click', closeModal);
        }

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Form submission handling
        form.addEventListener('submit', function(e) {
            // You can add form validation here
            console.log('Form submitted');
            // The form will submit normally via POST request
        });

        // Edit button functionality
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const material = JSON.parse(this.getAttribute('data-material'));
                console.log('Editing material:', material);
                // You can implement edit functionality here
                // For now, we'll just open the same modal with pre-filled data
                openModal();

                // Pre-fill form with material data (for edit functionality)
                document.getElementById('name').value = material.name;
                document.getElementById('category').value = material.category;
                document.getElementById('unit').value = material.unit;
                document.getElementById('current_stock').value = material.currentStock;
                document.getElementById('min_stock').value = material.minStock;
                document.getElementById('price_per_unit').value = material.pricePerUnit;
                document.getElementById('supplier').value = material.supplier;
                document.getElementById('location').value = material.location;
            });
        });

        // Search and filter functionality
        const searchInput = document.querySelector('input[type="text"]');
        const categorySelect = document.querySelector('select');

        let searchTimeout;
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    console.log('Searching for:', e.target.value);
                }, 500);
            });
        }

        if (categorySelect) {
            categorySelect.addEventListener('change', function(e) {
                console.log('Category selected:', e.target.value);
            });
        }
    });
</script>
@endsection
