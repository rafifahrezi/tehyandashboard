@extends('layouts.master')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Bahan Baku</h1>
        <nav class="text-sm text-gray-500">
            <a href="{{ route('manajemen.bahan-admin') }}" class="hover:text-blue-600">Manajemen Bahan</a> / 
            <span class="text-blue-600">Tambah Bahan</span>
        </nav>
    </div>

    {{-- Tampilkan pesan sukses --}}
    @if(session('success'))
    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    {{-- Tampilkan error validasi --}}
    @if($errors->any())
    <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form 
        action="{{ route('manajemen.bahan-admin.store') }}" 
        method="POST" 
        class="bg-white rounded-xl border border-gray-100 shadow-lg p-8 space-y-6"
    >
        @csrf
        <div class="grid md:grid-cols-2 gap-6">
            {{-- Kolom Kiri --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Bahan <span class="text-red-500">*</span>
                    </label>
                    <input 
                        name="nama_bahan" 
                        value="{{ old('nama_bahan') }}"
                        placeholder="Masukkan nama bahan" 
                        required
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="category_id" 
                        required
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    >
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option 
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Stok Awal <span class="text-red-500">*</span>
                        </label>
                        <input 
                            name="stok" 
                            type="number" 
                            value="{{ old('stok', 0) }}"
                            step="0.01" 
                            placeholder="0" 
                            required 
                            min="0"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Stok Minimal <span class="text-red-500">*</span>
                        </label>
                        <input 
                            name="min_stok" 
                            type="number" 
                            value="{{ old('min_stok', 0) }}"
                            step="0.01"
                            placeholder="0" 
                            required 
                            min="0"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        >
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Harga Bahan <span class="text-red-500">*</span>
                    </label>
                    <input 
                        name="harga" 
                        type="number" 
                        value="{{ old('harga', 0) }}"
                        step="0.01" 
                        placeholder="Masukkan harga" 
                        required
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Supplier <span class="text-red-500">*</span>
                    </label>
                    <input 
                        name="supplier" 
                        value="{{ old('supplier') }}"
                        placeholder="Masukkan nama Supplier/Toko" 
                        required
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    >
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Masuk
                        </label>
                        <input 
                            name="tanggal_masuk" 
                            type="date"
                            value="{{ old('tanggal_masuk') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kadaluarsa
                        </label>
                        <input 
                            name="tanggal_kadaluarsa" 
                            type="date"
                            value="{{ old('tanggal_kadaluarsa') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Satuan <span class="text-red-500">*</span>
                    </label>
                    <input 
                        name="satuan" 
                        value="{{ old('satuan') }}"
                        placeholder="Masukkan satuan " 
                        required
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Bahan
                    </label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input 
                                type="radio" 
                                name="status" 
                                value="aktif" 
                                {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }}
                                class="form-radio text-blue-600"
                            >
                            <span class="ml-2">Aktif</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input 
                                type="radio" 
                                name="status" 
                                value="nonaktif" 
                                {{ old('status') == 'nonaktif' ? 'checked' : '' }}
                                class="form-radio text-red-600"
                            >
                            <span class="ml-2">Non-Aktif</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4 mt-8">
            <a 
                href="{{ route('manajemen.bahan-admin') }}"
                class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 font-medium"
            >
                Batal
            </a>
            <button 
                type="submit"
                class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium"
            >
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
