@extends('layouts.master')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Bahan Baku</h1>
        <nav class="text-sm text-gray-500">
            <a href="{{ route('manajemen.bahan.index') }}" class="hover:text-blue-600">Manajemen Bahan</a> /
            <span class="text-blue-600">Tambah Bahan</span>
        </nav>
    </div>

    <!-- Snackbar Component -->
    <x-snackbar-notification />

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <form action="{{ route('manajemen.bahan.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Kolom Kiri -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Bahan <span class="text-red-500">*</span>
                        </label>
                        <input name="nama_bahan" value="{{ old('nama_bahan') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                               placeholder="Contoh: Tepung Terigu">
                        @error('nama_bahan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Stok Awal <span class="text-red-500">*</span>
                            </label>
                            <input name="stok_sekarang" type="number" step="0.01" min="0"
                                   value="{{ old('stok_sekarang', 0) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('stok_sekarang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Stok Minimal <span class="text-red-500">*</span>
                            </label>
                            <input name="min_stok" type="number" step="0.01" min="0"
                                   value="{{ old('min_stok', 0) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('min_stok')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <select name="satuan" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Satuan</option>
                            @foreach (\App\Models\Bahan::getSatuanOptions() as $value => $label)
                                <option value="{{ $value }}" {{ old('satuan') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('satuan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Harga per Satuan <span class="text-red-500">*</span>
                        </label>
                        <input name="harga" type="number" step="0.01" min="0"
                               value="{{ old('harga') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Contoh: 15000">
                        @error('harga')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Supplier <span class="text-red-500">*</span>
                        </label>
                        <input name="supplier" value="{{ old('supplier') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Contoh: Toko ABC">
                        @error('supplier')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk</label>
                            <input name="tanggal_masuk" type="date" value="{{ old('tanggal_masuk') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('tanggal_masuk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kadaluarsa</label>
                            <input name="tanggal_kadaluarsa" type="date" value="{{ old('tanggal_kadaluarsa') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('tanggal_kadaluarsa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Bahan</label>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center">
                                <input type="radio" name="is_active" value="1"
                                       {{ old('is_active', 1) == 1 ? 'checked' : '' }}
                                       class="mr-2 text-blue-600 focus:ring-blue-500">
                                <span>Aktif</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="is_active" value="0"
                                       {{ old('is_active') == 0 ? 'checked' : '' }}
                                       class="mr-2 text-red-600 focus:ring-red-500">
                                <span>Non-Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end space-x-4 mt-10 pt-6 border-t border-gray-200">
                <a href="{{ route('manajemen.bahan.index') }}"
                   class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition shadow-md hover:shadow-lg">
                    Simpan Bahan Baku
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Snackbar Component (pastikan sudah ada di components/snackbar-notification.blade.php) -->
<x-snackbar-notification />

<script>
document.addEventListener('DOMContentLoaded', () => {
    @if (session('notification'))
        // Dispatch event ke snackbar component
        document.querySelector('x-snackbar-notification')?.dispatchEvent(
            new CustomEvent('show-snackbar', {
                detail: @json(session('notification'))
            })
        );

        // Auto redirect setelah snackbar muncul (jika success)
        @if (session('notification.type') === 'success')
            setTimeout(() => {
                window.location.href = "{{ route('manajemen.bahan.index') }}";
            }, 5000); // 5 detik sesuai duration
        @endif
    @endif
});
</script>
@endsection