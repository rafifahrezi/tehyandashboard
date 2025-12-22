@extends('layouts.master')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <h1 class="text-2xl font-bold mb-6">{{ $pageTitle }}</h1>
    <p class="text-gray-600 mb-8">{{ $pageDescription }}</p>

    <div class="mb-4">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="#" class="hover:text-blue-600 transition-colors duration-200">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('manajemen.user-admin') }}" class="hover:text-blue-600 transition-colors duration-200">
                Manajemen User
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-blue-600 font-medium">Tambah User</span>
        </nav>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <form action="{{ route('manajemen.user-admin.store') }}" method="POST">
            @csrf

            <!-- Nama -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 @error('name') border-red-500 @enderror"
                    placeholder="Masukkan nama lengkap" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 @error('email') border-red-500 @enderror"
                    placeholder="contoh@perusahaan.com" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 @error('password') border-red-500 @enderror"
                        placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                        placeholder="Ulangi password" required>
                </div>
            </div>

            <!-- Telp -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                <input type="text" name="telp" value="{{ old('telp') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 @error('telp') border-red-500 @enderror"
                    placeholder="Contoh: 081234567890">
                @error('telp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jabatan -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 @error('jabatan') border-red-500 @enderror"
                    placeholder="Contoh: Staff IT, Manager HR">
                @error('jabatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Departemen -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Departemen</label>
                <select name="department"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300 @error('department') border-red-500 @enderror">
                    <option value="">Pilih Departemen</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department }}" {{ old('department') == $department ? 'selected' : '' }}>
                            {{ $department }}
                        </option>
                    @endforeach
                </select>
                @error('department')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role (Spatie Permission) -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                <select name="role" required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300 @error('role') border-red-500 @enderror">
                    <option value="">Pilih Role</option>
                    @foreach ($roles as $roleName)
                        <option value="{{ $roleName }}" {{ old('role') == $roleName ? 'selected' : '' }}>
                            {{ ucfirst($roleName) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('manajemen.user-admin') }}"
                    class="text-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition">
                    <i class="fas fa-arrow-left mr-2"></i> Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium transition shadow-lg hover:shadow-xl flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i> Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Snackbar Notification -->
<div id="snackbar" class="fixed bottom-6 right-6 z-50 px-6 py-4 rounded-lg shadow-2xl text-white font-medium text-sm flex items-center space-x-3 transform translate-y-20 opacity-0 transition-all duration-500">
    <i id="snackbarIcon" class="fas text-xl"></i>
    <span id="snackbarMessage"></span>
</div>

<script>
    function showSnackbar(message, type = 'success') {
        const snackbar = document.getElementById('snackbar');
        const icon = document.getElementById('snackbarIcon');
        const msg = document.getElementById('snackbarMessage');

        // Set content
        msg.textContent = message;
        if (type === 'success') {
            snackbar.className = snackbar.className.replace(/bg-\w+-\d+/g, 'bg-green-600');
            icon.className = 'fas fa-check-circle text-xl';
        } else {
            snackbar.className = snackbar.className.replace(/bg-\w+-\d+/g, 'bg-red-600');
            icon.className = 'fas fa-exclamation-triangle text-xl';
        }

        // Show
        snackbar.classList.remove('translate-y-20', 'opacity-0');
        snackbar.classList.add('translate-y-0', 'opacity-100');

        // Auto hide & redirect
        setTimeout(() => {
            snackbar.classList.remove('translate-y-0', 'opacity-100');
            snackbar.classList.add('translate-y-20', 'opacity-0');

            // Redirect setelah snackbar hilang
            setTimeout(() => {
                window.location.href = "{{ route('manajemen.user-admin') }}"; // Ganti ke 'manajemen.user-owner' jika perlu
            }, 600);
        }, 4000); // Tampil 4 detik
    }

    // Tampilkan snackbar berdasarkan session
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            showSnackbar("{{ session('success') }}", 'success');
        @elseif (session('error'))
            showSnackbar("{{ session('error') }}", 'error');
        @endif
    });
</script>

<style>
    /* Animasi Snackbar */
    #snackbar.translate-y-0 {
        transform: translateY(0);
        opacity: 1;
    }
    #snackbar.translate-y-20 {
        transform: translateY(5rem);
        opacity: 0;
    }
</style>
@endsection