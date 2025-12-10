@extends('layouts.master')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold mb-6">{{ $pageTitle }}</h1>
    <p class="text-gray-600 mb-8">{{ $pageDescription }}</p>

    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100" x-data="{
            stok_sekarang: 0,
            move_type: '',
            qty: 0,
            description: '',
            errors: {},
            showStockWarning: false,
            currentStock: 0,
            stockUnit: 'kg',
            selectedBahan: null,
            moveType: '',
            quantity: 0,
            
            updateStok(event) {
                if (event.target.value > this.stok_sekarang && this.move_type === 'out') {
                    this.showStockWarning = true;
                    event.target.value = this.stok_sekarang;
                } else {
                    this.showStockWarning = false;
                }
            },
            
            validateStock() {
                if (this.moveType === 'out' && parseFloat(this.quantity) > this.currentStock) {
                    this.showStockWarning = true;
                    this.errors.quantity = 'Jumlah melebihi stok tersedia';
                } else {
                    this.showStockWarning = false;
                    this.errors.quantity = null;
                }
            },
            
            confirmSubmit(event) {
                if (!this.isFormValid) {
                    event.preventDefault();
                    this.showToast('Harap isi semua field dengan benar', 'error');
                    return;
                }
                
                if (!confirm('Apakah Anda yakin ingin menyimpan transaksi ini?')) {
                    event.preventDefault();
                } else {
                    this.showToast('Transaksi berhasil disimpan!', 'success');
                }
            },
            
            showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium animate-fade-in ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                }`;
                toast.innerHTML = `
                    <div class=" flex items-center">
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} mr-2"></i>
        ${message}
    </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
    toast.classList.add('animate-fade-out');
    setTimeout(() => toast.remove(), 300);
    }, 3000);
    },

    get isFormValid() {
    return this.selectedBahan && this.moveType && this.quantity > 0 &&
    !(this.moveType === 'out' && parseFloat(this.quantity) > this.currentStock);
    }
    }">
    <form action="{{ route('transaksi.stok-admin') }}" method="POST" @submit="confirmSubmit">
        @csrf

        <!-- Bahan Baku -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Bahan Baku</label>
            <select name="bahan_id"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300"
                x-on:change="
                            stok_sekarang = $event.target.selectedOptions[0].dataset.stok;
                            currentStock = parseFloat($event.target.selectedOptions[0].dataset.stok);
                            selectedBahan = $event.target.value;
                            validateStock();
                        " required>
                <option value="">Pilih Bahan Baku</option>
                @foreach ($bahans as $bahan)
                <option value="{{ $bahan->id }}" data-stok="{{ $bahan->stok_sekarang }}">
                    {{ $bahan->nama_bahan }} (Stok: {{ $bahan->stok_sekarang }})
                </option>
                @endforeach
            </select>
        </div>

        <!-- Stok Saat Ini -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Saat Ini</label>
            <input type="text" x-model="currentStock" class="w-full px-4 py-3 border-2 rounded-xl bg-gray-100"
                disabled>
        </div>

        <!-- Jenis Transaksi -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Transaction Type -->
            <div class="space-y-4">
                <label class="block text-lg font-semibold text-gray-900">
                    <i class="fas fa-exchange-alt text-blue-500 mr-2"></i>
                    Jenis Transaksi
                </label>

                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="move_type" value="in" class="sr-only peer"
                            x-model="moveType" @change="validateStock">
                        <div
                            class="p-4 border-2 border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300">
                            <i class="fas fa-arrow-down text-2xl text-green-600 mb-2"></i>
                            <p class="font-semibold text-gray-900">Stok Masuk</p>
                            <p class="text-sm text-gray-500">Penambahan stok</p>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="move_type" value="out" class="sr-only peer"
                            x-model="moveType" @change="validateStock">
                        <div
                            class="p-4 border-2 border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-gray-300">
                            <i class="fas fa-arrow-up text-2xl text-red-600 mb-2"></i>
                            <p class="font-semibold text-gray-900">Stok Keluar</p>
                            <p class="text-sm text-gray-500">Pengurangan stok</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Quantity Input -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <label class="block text-lg font-semibold text-gray-900">
                        <i class="fas fa-balance-scale text-blue-500 mr-2"></i>
                        Jumlah Transaksi
                    </label>
                    <span class="text-sm text-gray-500" x-text="stockUnit"></span>
                </div>

                <div class="relative">
                    <input type="number" name="qty" step="0.01" min="0.01"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 shadow-sm text-lg font-semibold"
                        placeholder="0.00" x-model="quantity" @input="validateStock" required
                        :class="{
                                    'border-red-300': errors.quantity,
                                    'border-green-300': moveType === 'in' && quantity > 0,
                                    'border-red-300': moveType === 'out' && quantity > 0
                                }">
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <button type="button" @click="quantity += 1; validateStock()" class="p-2 text-gray-500 hover:text-blue-600">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" @click="quantity > 0.01 ? quantity -= 1 : quantity = 0; validateStock()"
                            class="p-2 text-gray-500 hover:text-blue-600">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <!-- Stock Warning -->
                <div x-show="showStockWarning" x-transition.opacity.duration.300ms
                    class="p-3 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-red-600 mt-1 mr-2"></i>
                        <div>
                            <p class="text-red-800 font-medium">Stok tidak mencukupi!</p>
                            <p class="text-red-600 text-sm">
                                Stok tersedia: <span class="font-bold" x-text="currentStock"></span>
                                <span x-text="stockUnit"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keterangan -->
        <div class="space-y-4">
            <label class="block text-lg font-semibold text-gray-900">
                <i class="fas fa-sticky-note text-blue-500 mr-2"></i>
                Keterangan
            </label>

            <textarea name="reference_type" rows="4"
                class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 shadow-sm resize-none"
                placeholder="Masukkan keterangan transaksi (opsional). Contoh: 'Pembelian dari Supplier ABC', 'Rusak saat penyimpanan', 'Penyesuaian stock opname'"
                x-model="description"></textarea>
        </div>

        <!-- Stock Preview Card -->
        <div x-show="moveType && quantity > 0 && selectedBahan" 
            class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-6 border-2 border-blue-200 mt-6">
            <h3 class="font-bold text-gray-900 text-lg mb-4 flex items-center">
                <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                Preview Perubahan Stok
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-white rounded-lg border shadow-sm">
                    <p class="text-sm text-gray-600 mb-1">Stok Sebelum</p>
                    <p class="text-3xl font-bold text-gray-900" x-text="currentStock.toFixed(2)"></p>
                    <p class="text-xs text-gray-500" x-text="stockUnit"></p>
                </div>

                <div class="text-center p-4 bg-white rounded-lg border shadow-sm">
                    <p class="text-sm text-gray-600 mb-1">Jumlah Transaksi</p>
                    <p class="text-3xl font-bold"
                        :class="moveType === 'in' ? 'text-green-600' : 'text-red-600'"
                        x-text="`${moveType === 'in' ? '+' : '-'}${parseFloat(quantity).toFixed(2)}`">
                    </p>
                    <p class="text-xs text-gray-500" x-text="stockUnit"></p>
                </div>

                <div class="text-center p-4 bg-white rounded-lg border shadow-sm">
                    <p class="text-sm text-gray-600 mb-1">Stok Sesudah</p>
                    <p class="text-3xl font-bold text-gray-900"
                        x-text="moveType === 'in' 
                                    ? (currentStock + parseFloat(quantity)).toFixed(2) 
                                    : (currentStock - parseFloat(quantity)).toFixed(2)">
                    </p>
                    <p class="text-xs text-gray-500" x-text="stockUnit"></p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-6">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Stok Minimum</span>
                    <span>Stok Maksimum</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="h-3 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600"
                        :style="`width: ${Math.min(100, (moveType === 'in' 
                                    ? (currentStock + parseFloat(quantity)) 
                                    : (currentStock - parseFloat(quantity))) / 50 * 100)}%`">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="mt-8">
            <button type="submit" :disabled="!isFormValid"
                class="bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:shadow-lg">
                <i class="fas fa-save mr-3 text-lg"></i>
                Simpan Transaksi
            </button>
        </div>
    </form>
</div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-out {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }

    .animate-fade-out {
        animation: fade-out 0.3s ease-out;
    }

    /* Custom scrollbar */
    textarea::-webkit-scrollbar {
        width: 6px;
    }

    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    textarea::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    textarea::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Radio card selection animation */
    input[type="radio"]:checked+div {
        transform: scale(1.02);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection