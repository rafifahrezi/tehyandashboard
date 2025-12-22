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
                <a href="{{ route('manajemen.user-owner') }}" class="hover:text-blue-600 transition-colors duration-200">
                    Manajemen User
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-blue-600 font-medium">Tambah User</span>
            </nav>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <form action="{{ route('manajemen.user-owner.store') }}" method="POST">
                @csrf

                <!-- Nama -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                    <input type="text" name="name"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                    placeholder="Masukkan nama pengguna" required>
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                        placeholder="Masukkan email pengguna" required>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                        placeholder="Masukkan password" required>
                </div>

                <!-- Telp -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" name="telp"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                        placeholder="Masukkan nomor telepon">
                </div>

                <!-- Jabatan -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan</label>
                    <input type="text" name="jabatan"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                        placeholder="Masukkan jabatan Contoh: Pegawai">
                </div>

                <!-- Departemen -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Departemen</label>
                    <select name="department"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                        <option value="">Pilih Departemen</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department }}">{{ $department }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-8">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-save mr-3 text-lg"></i>
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 rounded-t-2xl text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold">Pengguna Berhasil Ditambahkan</h3>
                        <p class="text-blue-100 text-sm mt-1">Data pengguna telah disimpan</p>
                    </div>
                    <button type="button" onclick="closeSuccessModal()" class="text-white hover:text-blue-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <!-- Modal Body -->
            <div class="p-6">
                <div class="space-y-4">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-lg">Pengguna Ditambahkan</h4>
                        <p class="text-gray-600 mt-2">Data pengguna telah diperbarui</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Waktu</p>
                                <p class="font-semibold text-gray-900" id="successTime"></p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Status</p>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Berhasil
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="border-t border-gray-200 p-6">
                <div class="flex justify-center space-x-3">
                    <button type="button" onclick="closeSuccessModal()"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl flex items-center">
                        <i class="fas fa-check mr-2"></i>
                        Oke, Mengerti
                    </button>
                    <button type="button" onclick="goToUsers()"
                        class="px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-xl hover:bg-blue-50 transition-all duration-200 font-medium flex items-center">
                        <i class="fas fa-list mr-2"></i>
                        Lihat Daftar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan modal success
        function showSuccessModal() {
            const modal = document.getElementById('successModal');
            const box = modal.querySelector('.max-w-md');
            modal.classList.remove('hidden');
            setTimeout(() => {
                box.classList.remove('scale-95');
                box.classList.add('scale-100');
            }, 10);

            // Update waktu
            const now = new Date();
            document.getElementById('successTime').textContent =
                now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

            // Redirect ke halaman daftar pengguna setelah 7 detik
            setTimeout(() => {
                window.location.href = "{{ route('manajemen.user-owner') }}";
            }, 7000);
        }

        // Fungsi untuk menutup modal success
        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            const box = modal.querySelector('.max-w-md');
            box.classList.remove('scale-100');
            box.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // Fungsi untuk pergi ke halaman daftar pengguna
        function goToUsers() {
            window.location.href = "{{ route('manajemen.user-owner') }}";
        }

        // Event listener untuk menampilkan modal jika ada session success
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                showSuccessModal();
            @endif
        });
    </script>
@endsection
