@extends('layouts.master')
@section('content')
    <div x-data="bahanManagement()" class="space-y-6">
        <!-- Include Confirm Modal Component -->
        <x-confirm-modal />
        <x-snackbar-notification />


        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-2xl font-bold text-gray-900">Manajemen Bahan Baku</h1>
                    <p class="text-gray-600 mt-1">Kelola bahan baku produksi dengan mudah</p>
                </div>
                <a href="{{ route('manajemen.bahan-admin.create') }}"
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
                    <input x-model.debounce.500ms="searchQuery" placeholder="Cari bahan baku..."
                        class="form-input pl-10 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="relative">
                    <select x-model="selectedCategory"
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="bahan in filteredBahans" :key="bahan.id">
                <div
                    class="bg-white rounded-xl shadow-sm p-6 transition-all duration-200 hover:shadow-md border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 x-text="bahan.nama_bahan" class="font-bold text-gray-900 text-lg mb-1"></h3>
                            <span class="text-sm text-gray-500 font-mono" x-text="bahan.kode_bahan"></span>
                        </div>
                        <span
                            :class="{
                                'bg-green-100 text-green-800 border-green-200': bahan.status === 'aman',
                                'bg-yellow-100 text-yellow-800 border-yellow-200': bahan.status === 'warning',
                                'bg-red-100 text-red-800 border-red-200': bahan.status === 'kritis'
                            }"
                            class="px-3 py-1 rounded-full text-xs font-medium border"
                            x-text="bahan.status.toUpperCase()"></span>
                    </div>

                    <div class="space-y-3 text-sm">
                        <!-- Stok Information -->
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600 font-medium">Stok</span>
                                <span class="font-semibold text-gray-900"
                                    x-text="`${bahan.stok} / ${bahan.min_stok} ${bahan.satuan}`"></span>
                            </div>
                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div :class="{
                                    'bg-green-500': bahan.status === 'aman',
                                    'bg-yellow-500': bahan.status === 'warning',
                                    'bg-red-500': bahan.status === 'kritis'
                                }"
                                    class="h-2 rounded-full transition-all duration-300"
                                    :style="`width: ${Math.min((bahan.stok / bahan.min_stok) * 100, 100)}%`"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div>
                                <span class="text-gray-600 block text-xs">Harga/Unit</span>
                                <span class="font-semibold text-gray-900 text-sm">
                                    Rp <span x-text="bahan.harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')"></span>
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600 block text-xs">Supplier</span>
                                <span class="font-medium text-gray-900 text-sm" x-text="bahan.supplier"></span>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-gray-100">
                            <span class="text-gray-600 block text-xs">Kategori</span>
                            <span class="font-medium text-gray-900 text-sm"
                                x-text="bahan.category_name || bahan.category?.nama || '-'"></span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex justify-between items-center pt-4 border-t border-gray-100">
                        <button @click="editBahan(bahan)"
                            class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit
                        </button>

                        <button @click="openDeleteConfirmation(bahan)"
                            class="text-red-600 hover:text-red-800 font-medium text-sm flex items-center transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State -->
        <div x-show="filteredBahans.length === 0" class="col-span-full">
            <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-100">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada bahan baku</h3>
                <p class="text-gray-500 mb-6">Tidak ada bahan baku yang sesuai dengan kriteria pencarian Anda.</p>
                <a href="{{ route('manajemen.bahan-admin.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Bahan Baku Pertama
                </a>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('bahanManagement', () => ({
                bahans: @json($materials ?? []),
                searchQuery: '',
                selectedCategory: '',
                isModalOpen: false,
                isSubmitting: false,
                snackbar: {
                    show: false,
                    message: '',
                    type: 'success'
                },
                currentBahan: {
                    id: null,
                    nama_bahan: '',
                    category_id: '',
                    satuan: '',
                    stok: 0,
                    min_stok: 0,
                    harga: 0,
                    supplier: '',
                    lokasi: '',
                    tanggal_masuk: '',
                    tanggal_kadaluarsa: '',
                    is_active: true
                },
                modalTitle: '',

                init() {
                    console.log('Bahan Management initialized');
                    console.log('Total bahans:', this.bahans.length);

                    this.bahans = this.bahans.map(bahan => ({
                        ...bahan,
                        status: this.calculateStatus(bahan)
                    }));
                },

                  // Function to show snackbar
                showSnackbar(notification) {
                    const event = new CustomEvent('show-snackbar', {
                        detail: notification
                    });
                    document.querySelector('x-snackbar-notification').dispatchEvent(event);
                },


                calculateStatus(bahan) {
                    const stokPercentage = (bahan.stok / bahan.min_stok) * 100;
                    if (stokPercentage >= 100) return 'aman';
                    if (stokPercentage >= 50) return 'warning';
                    return 'kritis';
                },

                formatRupiah(angka) {
                    if (!angka) return '0';
                    return Number(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                },

                get filteredBahans() {
                    return this.bahans.filter(bahan => {
                        const matchesSearch = !this.searchQuery ||
                            bahan.nama_bahan.toLowerCase().includes(this.searchQuery
                                .toLowerCase());
                        const matchesCategory = !this.selectedCategory ||
                            String(bahan.category_id) === String(this.selectedCategory);
                        return matchesSearch && matchesCategory;
                    });
                },

                openDeleteConfirmation(bahan) {
                    Alpine.store('confirmModal').open({
                        title: 'Hapus Bahan Baku',
                        message: `Apakah Anda yakin ingin menghapus bahan baku "${bahan.nama_bahan}"?`,
                        additionalInfo: 'Tindakan ini tidak dapat dibatalkan. Semua data yang terkait dengan bahan baku ini akan dihapus permanen.',
                        onConfirm: () => this.deleteBahan(bahan)
                    });
                },

                async deleteBahan(bahan) {
                    try {
                        console.log('Menghapus bahan:', bahan);

                        const response = await axios.delete(`/admin-manajemen-bahan/${bahan.id}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            }
                        });

                        const index = this.bahans.findIndex(b => b.id === bahan.id);
                        if (index !== -1) {
                            this.bahans.splice(index, 1);
                        }

                        this.showSnackbar(`Bahan "${bahan.nama_bahan}" berhasil dihapus`,
                        'success');

                    } catch (error) {
                        console.error('Error menghapus bahan:', error);
                        const errorMessage = error.response?.data?.message ||
                            'Terjadi kesalahan saat menghapus bahan';
                        this.showSnackbar(errorMessage, 'error');
                        throw error;
                    }
                },

                openModal(type, bahan = null) {
                    this.isModalOpen = true;
                    this.modalTitle = type === 'add' ? 'Tambah Bahan Baku' : 'Edit Bahan Baku';

                    if (type === 'edit' && bahan) {
                        this.currentBahan = {
                            ...bahan,
                            is_active: bahan.is_active ?? true
                        };
                    } else {
                        this.resetCurrentBahan();
                    }
                },

                closeModal() {
                    this.isModalOpen = false;
                    this.resetCurrentBahan();
                },

                resetCurrentBahan() {
                    this.currentBahan = {
                        id: null,
                        nama_bahan: '',
                        category_id: '',
                        satuan: '',
                        stok: 0,
                        min_stok: 0,
                        harga: 0,
                        supplier: '',
                        lokasi: '',
                        tanggal_masuk: '',
                        tanggal_kadaluarsa: '',
                        is_active: true
                    };
                },

                formatDate(dateString) {
                    if (!dateString) return null;
                    return new Date(dateString).toISOString().split('T')[0];
                },

                editBahan(bahan) {
                    const validationResult = this.validateBahanForEdit(bahan);

                    if (!validationResult.isValid) {
                        this.showSnackbar(validationResult.errors.join('. '), 'error');
                        return;
                    }

                    console.group('Edit Bahan Navigation');
                    console.log('Navigating to edit page for Bahan:', {
                        id: bahan.id,
                        name: bahan.nama_bahan
                    });
                    console.groupEnd();

                    try {
                        const editRoute = `{{ route('manajemen.bahan-admin.edit', ['id' => ':id']) }}`
                            .replace(':id', bahan.id);

                        window.location.href = editRoute;
                    } catch (error) {
                        console.error('Navigation Error:', error);
                        this.showSnackbar('Gagal membuka halaman edit', 'error');
                    }
                },

                validateBahanForEdit(bahan) {
                    const errors = [];

                    if (!bahan) {
                        errors.push('Objek bahan tidak valid');
                        return {
                            isValid: false,
                            errors
                        };
                    }

                    if (typeof bahan !== 'object') {
                        errors.push('Tipe data bahan harus objek');
                        return {
                            isValid: false,
                            errors
                        };
                    }

                    if (!bahan.id) {
                        errors.push('ID bahan tidak tersedia');
                        return {
                            isValid: false,
                            errors
                        };
                    }

                    if (isNaN(bahan.id)) {
                        errors.push('ID bahan harus berupa angka');
                        return {
                            isValid: false,
                            errors
                        };
                    }

                    if (!bahan.nama_bahan) {
                        errors.push('Nama bahan harus tersedia');
                        return {
                            isValid: false,
                            errors
                        };
                    }

                    return {
                        isValid: true,
                        errors: [],
                        data: {
                            id: bahan.id,
                            nama_bahan: bahan.nama_bahan
                        }
                    };
                },

                // Update deleteBahan function to use snackbar
                async deleteBahan(bahan) {
                    try {
                        console.log('Menghapus bahan:', bahan);

                        const response = await axios.delete(`/admin-manajemen-bahan/${bahan.id}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            }
                        });

                        // Hapus dari array lokal
                        const index = this.bahans.findIndex(b => b.id === bahan.id);
                        if (index !== -1) {
                            this.bahans.splice(index, 1);
                        }

                        // Show snackbar notification from backend
                        if (response.data.notification) {
                            this.showSnackbar(response.data.notification);
                        }

                    } catch (error) {
                        console.error('Error menghapus bahan:', error);

                        // Show snackbar notification from backend if available
                        if (error.response?.data?.notification) {
                            this.showSnackbar(error.response.data.notification);
                        } else {
                            const errorMessage = error.response?.data?.message ||
                                'Terjadi kesalahan saat menghapus bahan';
                            this.showSnackbar({
                                type: 'error',
                                title: 'Gagal Menghapus',
                                message: errorMessage,
                                duration: 6000
                            });
                        }
                        throw error;
                    }
                },
            }));
        });
    </script>
@endsection
