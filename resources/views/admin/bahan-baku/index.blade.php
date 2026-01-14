@extends('layouts.master')

@section('content')
    <div class="space-y-6">
        <!-- Include Confirm Modal Component -->
        <x-confirm-modal />
        {{-- <x-snackbar-notification /> --}}

        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-2xl font-bold text-gray-900">Manajemen Bahan Baku</h1>
                    <p class="text-gray-600 mt-1">Kelola bahan baku produksi dengan mudah</p>
                </div>
                <a href="{{ route('manajemen.bahan.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Bahan Baku
                </a>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="searchQuery" placeholder="Cari bahan baku..."
                        class="form-input pl-10 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="relative">
                    <select id="selectedCategory"
                        class="form-select w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Bahan Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="bahanGrid">
            @foreach ($materials as $bahan)
                <div
                    class="bg-white rounded-xl shadow-sm p-6 transition-all duration-200 hover:shadow-md border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $bahan['nama_bahan'] }}</h3>
                            <span class="text-sm text-gray-500 font-mono">{{ $bahan['kode_bahan'] }}</span>
                        </div>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-medium border
                            @if ($bahan['status'] === 'aman') bg-green-100 text-green-800 border-green-200
                            @elseif($bahan['status'] === 'warning') bg-yellow-100 text-yellow-800 border-yellow-200
                            @elseif($bahan['status'] === 'kritis') bg-red-100 text-red-800 border-red-200
                            @elseif($bahan['status'] === 'habis') bg-red-100 text-white-800 border-red-200 @endif">
                            {{ strtoupper($bahan['status']) }}
                        </span>
                    </div>

                    <div class="space-y-3 text-sm">
                        <!-- Stok Information -->
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600 font-medium">Stok</span>
                                <span class="font-semibold text-gray-900">{{ $bahan['stok_sekarang'] }} /
                                    {{ $bahan['min_stok'] }} {{ $bahan['satuan'] }}</span>
                            </div>
                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div
                                    class="h-2 rounded-full transition-all duration-300
                                    @if ($bahan['status'] === 'aman') bg-green-500
                                    @elseif($bahan['status'] === 'warning') bg-yellow-500
                                    @elseif($bahan['status'] === 'kritis') bg-red-500 @endif">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div>
                                <span class="text-gray-600 block text-xs">Harga/Unit</span>
                                <span class="font-semibold text-gray-900 text-sm">Rp {{ $bahan['harga'] }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600 block text-xs">Supplier</span>
                                <span class="font-medium text-gray-900 text-sm">{{ $bahan['supplier'] }}</span>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-gray-100">
                            <span class="text-gray-600 block text-xs">Kategori</span>
                            <span class="font-medium text-gray-900 text-sm">{{ $bahan['category_name'] }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('manajemen.bahan.edit', $bahan['id']) }}"
                            class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit
                        </a>

                        <div x-data="{
                            openDeleteConfirm(bahanId) {
                                Alpine.store('confirm').open({
                                    title: 'Konfirmasi Hapus',
                                    message: 'Apakah Anda yakin ingin menghapus bahan ini? Tidakan ini tidak dapat dibatalkan.',
                                    onConfirm: () => {
                                        // Submit form secara aman setelah konfirmasi
                                        this.$refs[`deleteForm${bahanId}`].submit();
                                    }
                                });
                            }
                        }">
                            <form method="POST" action="{{ route('manajemen.bahan.destroy', $bahan['id']) }}"
                                x-ref="deleteForm{{ $bahan['id'] }}">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button type="button" @click="openDeleteConfirm({{ $bahan['id'] }})"
                                class="text-red-600 hover:text-red-800 font-medium text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Hapus
                            </button>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if (count($materials) === 0)
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-100">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada bahan baku</h3>
                    <p class="text-gray-500 mb-6">Tidak ada bahan baku yang sesuai dengan kriteria pencarian Anda.</p>
                    <a href="{{ route('manajemen.bahan.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Tambah Bahan Baku Pertama
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('confirm', {
                show: false,
                title: '',
                message: '',
                onConfirm: null,

                open({
                    title,
                    message,
                    onConfirm
                }) {
                    this.title = title;
                    this.message = message;
                    this.onConfirm = onConfirm;
                    this.show = true;
                },

                close() {
                    this.show = false;
                    this.onConfirm = null;
                },

                confirm() {
                    if (this.onConfirm) {
                        this.onConfirm();
                    }
                    this.close();
                }
            });
        });
    </script>
@endsection
