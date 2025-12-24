@extends('layouts.master')

@section('content')
<div x-data="bahanManagement()" class="space-y-6">
    <!-- Components -->
    <x-confirm-modal />
    <x-snackbar-notification />

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Bahan Baku</h1>
                <p class="text-gray-600 mt-1">Kelola bahan baku produksi dengan mudah</p>
            </div>
            <a href="{{ route('manajemen.bahan.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Bahan Baku
            </a>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input x-model.debounce.500ms="searchQuery" placeholder="Cari bahan baku..."
                       class="pl-10 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <select x-model="selectedCategory"
                    class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Grid Bahan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="bahan in filteredBahans" :key="bahan.id">
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 x-text="bahan.nama_bahan" class="font-bold text-lg text-gray-900"></h3>
                        <span class="text-sm text-gray-500 font-mono" x-text="bahan.kode_bahan"></span>
                    </div>
                    <span :class="statusClass(bahan.status)"
                          class="px-3 py-1 rounded-full text-xs font-medium border uppercase"
                          x-text="bahan.status"></span>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 font-medium">Stok</span>
                            <span class="font-semibold" x-text="`${bahan.stok_sekarang} ${bahan.satuan}`"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div :style="`width: ${stokPercentage(bahan)}%`"
                                 :class="progressClass(bahan.status)"
                                 class="h-2 rounded-full transition-all"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-gray-600 text-xs block">Harga/Unit</span>
                            <span class="font-semibold">Rp <span x-text="formatRupiah(bahan.harga)"></span></span>
                        </div>
                        <div>
                            <span class="text-gray-600 text-xs block">Supplier</span>
                            <span class="font-medium" x-text="bahan.supplier"></span>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <span class="text-gray-600 text-xs block">Kategori</span>
                        <span class="font-medium" x-text="bahan.category_name || '-'"></span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex justify-between">
                    <button @click="editBahan(bahan)"
                            class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </button>
                    <button @click="deleteBahan(bahan)"
                            class="text-red-600 hover:text-red-800 font-medium text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2.375 2.375 0 0116.138 21H7.862a2.375 2.375 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="!filteredBahans.length" class="text-center py-12">
        <div class="bg-white rounded-xl shadow-sm p-12 border border-gray-100">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada bahan baku</h3>
            <p class="text-gray-500 mb-6">Mulai tambahkan bahan baku pertama Anda.</p>
            <a href="{{ route('manajemen.bahan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Bahan Baku
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

        // Helper
        formatRupiah(angka) {
            return Number(angka || 0).toLocaleString('id-ID');
        },
        statusClass(status) {
            const classes = {
                aman: 'bg-green-100 text-green-800 border-green-200',
                warning: 'bg-yellow-100 text-yellow-800 border-yellow-200',
                kritis: 'bg-red-100 text-red-800 border-red-200',
                habis: 'bg-red-100 text-red-800 border-red-200'
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        },
        progressClass(status) {
            const colors = { aman: 'bg-green-500', warning: 'bg-yellow-500', kritis: 'bg-red-500', habis: 'bg-red-600' };
            return colors[status] || 'bg-gray-400';
        },
        stokPercentage(bahan) {
            const ratio = bahan.stok_sekarang / (bahan.min_stok || 1);
            return Math.min(ratio * 100, 100);
        },

        get filteredBahans() {
            return this.bahans.filter(bahan => {
                const search = this.searchQuery.toLowerCase();
                const matchesSearch = !search || bahan.nama_bahan.toLowerCase().includes(search);
                const matchesCategory = !this.selectedCategory || bahan.category_id == this.selectedCategory;
                return matchesSearch && matchesCategory;
            });
        },
        

        editBahan(bahan) {
            window.location.href = `/manajemen/bahan/${bahan.id}/edit`;
        },

        deleteBahan(bahan) {
            // Validasi sederhana: pastikan bahan ada
            if (!bahan || !bahan.id) {
                Alpine.store('snackbar').show({
                    type: 'error',
                    title: 'Error',
                    message: 'Data bahan tidak valid.',
                    duration: 3500
                });
                return;
            }
            Alpine.store('confirmModal').open({
                title: 'Hapus Bahan Baku?',
                message: `Yakin ingin menghapus "${bahan.nama_bahan}"?`,
                additionalInfo: 'Data akan dihapus permanen dan tidak dapat dikembalikan.',
                onConfirm: async () => {
                    try {
                        const response = await axios.delete(`/manajemen-bahan/${bahan.id}`);
                        if (response.data.success) {
                            this.bahans = this.bahans.filter(b => b.id !== bahan.id);
                            Alpine.store('snackbar').show(response.data.notification);
                        } else {
                            // Jika gagal (meskipun jarang, sesuai controller)
                            Alpine.store('snackbar').show(response.data.notification);
                        }
                    } catch (error) {
                        // Handle error dari axios (network/server error)
                        const notif = error.response?.data?.notification || {
                            type: 'error',
                            title: 'Error',
                            message: 'Gagal menghapus bahan baku. Periksa koneksi internet.',
                            duration: 4500
                        };
                        Alpine.store('snackbar').show(notif);
                    }
                }
            });
        }
        
    }));
});
</script>
@endsection