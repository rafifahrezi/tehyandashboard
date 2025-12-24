@extends('layouts.master')

@section('title', $pageTitle)

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $pageTitle }}</h1>
                <p class="text-gray-600 mt-1">{{ $pageDescription }}</p>
            </div>

            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-500">
                <a href="{{ route('manajemen.user.index') }}" class="hover:text-blue-600">Manajemen User</a>
                <span class="mx-2">/</span>
                <span class="text-blue-600 font-medium">Edit User</span>
            </nav>
        </div>

        <!-- Form Edit User -->
        <form 
            action="{{ route('manajemen.user.update', $user) }}" 
            method="POST"
            class="bg-white rounded-xl border border-gray-100 shadow-lg p-6 md:p-8 space-y-6"
        >
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Kolom Kiri: Data Pribadi -->
                <div class="space-y-5">
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Masukkan nama lengkap"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="contoh@email.com"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon
                        </label>
                        <input
                            type="text"
                            name="telp"
                            value="{{ old('telp', $user->telp) }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="081234567890"
                        >
                        @error('telp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jabatan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jabatan
                        </label>
                        <input
                            type="text"
                            name="jabatan"
                            value="{{ old('jabatan', $user->jabatan) }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Misal: Kasir, Admin, dll"
                        >
                        @error('jabatan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan: Akses & Keamanan -->
                <div class="space-y-5">
                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Role Pengguna <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="role"
                            required
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        >
                            <option value="">Pilih Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password (opsional) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Kosongkan jika tidak ingin mengubah"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Ulangi password baru"
                        >
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status Akun
                        </label>
                        <div class="flex space-x-6">
                            <label class="inline-flex items-center">
                                <input
                                    type="radio"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                    class="form-radio text-blue-600"
                                >
                                <span class="ml-2">Aktif</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input
                                    type="radio"
                                    name="is_active"
                                    value="0"
                                    {{ old('is_active', !$user->is_active) ? 'checked' : '' }}
                                    class="form-radio text-red-600"
                                >
                                <span class="ml-2">Non-Aktif</span>
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row sm:justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a
                    href="{{ route('manajemen.user.index') }}"
                    class="px-5 py-2.5 text-center bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-5 py-2.5 text-center bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection