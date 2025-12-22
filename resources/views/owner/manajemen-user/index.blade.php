@extends('layouts.master')

@section('title', $pageTitle)

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <h1 class="text-3xl font-bold mb-2">{{ $pageTitle }}</h1>
                    <p class="text-blue-100 text-lg">{{ $pageDescription }}</p>
                    <h3>Ini ada di Owner</h3>
                    <p>232</p>
                </div>

                <a href="{{ route('manajemen.user-owner.create') }}"
                    class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group">
                    <i class="fas fa-user-plus mr-3 text-lg"></i>
                    Tambah User
                </a>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="flex justify-center">
            <div class="flex flex-wrap justify-center gap-6 max-w-6xl">
                <!-- Total User -->
                <div
                    class="flex-1 min-w-[200px] max-w-[250px] bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total User</p>
                            <p class="text-2xl font-bold mt-1">{{ $stats['total_user'] }}</p>
                        </div>
                        <i class="fas fa-users text-2xl opacity-80"></i>
                    </div>
                </div>
                <!-- Administrator -->
                <div
                    class="flex-1 min-w-[200px] max-w-[250px] bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Pegawai</p>
                            <p class="text-2xl font-bold mt-1">{{ $stats['administrator'] }}</p>
                        </div>
                        <i class="fas fa-user-shield text-2xl opacity-80"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                <!-- Role Filter -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Role</label>
                    <select
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                        <option value="">Semua Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Department Filter -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Departemen</label>
                    <select
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                        <option value="">Semua Departemen</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department }}">{{ ucfirst($department) }}</option>
                        @endforeach
                        {{-- @foreach ($userData['departments'] as $department)
                            <option value="{{ $department }}">{{ $department }}</option>
                        @endforeach --}}
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Status</label>
                    <select
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Non-Aktif</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>

                <!-- Search -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Cari User</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" placeholder="Cari user..."
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300">
                    </div>
                </div>
            </div>
        </div>

        <!-- Users List Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Section Header -->
            <div class="border-b border-gray-200 p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Daftar User</h2>
                        {{-- <p class="text-gray-600 mt-1">Total {{ count($userData['users']) }} user terdaftar</p> --}}
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($users as $user)
                        <div
                            class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-200 p-6
                       hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">

                            <!-- User Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl
                                   flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600">
                                            {{ $user->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-col items-end space-y-2">
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                            {{ $user->role === 'Administrator' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $user->role }}
                                    </span>

                                    <span
                                        class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-circle mr-1 text-xs"></i>
                                        Aktif
                                    </span>
                                </div>
                            </div>

                            <!-- User Details -->
                            <div class="space-y-3 mb-6 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-phone w-5 mr-3 text-blue-500"></i>
                                    {{ $user->telp ?? '-' }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-building w-5 mr-3 text-green-500"></i>
                                    {{ $user->jabatan ?? '-' }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt w-5 mr-3 text-purple-500"></i>
                                    Bergabung: {{ $user->created_at->format('d M Y') }}
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                                <!-- User Info -->
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-bold text-lg">{{ $user->name }}</h3>
                                        <p class="text-gray-600">{{ $user->email }}</p>
                                        <span class="text-sm text-gray-500">{{ $user->role }}</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex justify-between items-center pt-4 border-t border-gray-200 mt-4">
                                    <!-- Edit -->
                                    <button class="text-blue-600 hover:text-blue-800 font-medium text-sm edit-user-btn"
                                        data-user-id="{{ $user->id }}">
                                        <i class="fas fa-edit mr-2"></i> Edit
                                    </button>

                                    <div class="flex items-center space-x-3">
                                        {{-- WhatsApp Button --}}
                                        @if ($user->telp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->telp) }}"
                                                target="_blank"
                                                class="text-green-600 hover:text-green-700 hover:bg-green-50 rounded-lg px-3 py-2 transition"
                                                title="Chat WhatsApp">
                                                <i class="fab fa-whatsapp text-lg"></i>
                                            </a>
                                        @endif

                                        {{-- Delete Button --}}
                                        @can('delete', $user)
                                            <button type="button"
                                                onclick="openConfirmModal('{{ $user->name }}', 'delete-form-{{ $user->id }}')"
                                                class="text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg px-3 py-2 transition">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan


                                    </div>
                                </div>

                                <!-- Hidden Delete Form -->
                                <form id="delete-form-{{ $user->id }}"
                                    action="{{ route('manajemen.user-owner.destroy', $user->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada data user.</p>
                    @endforelse
                </div>
            </div>


            <!-- Empty State -->
            @if ($users->isEmpty())
                <div
                    class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl shadow-lg p-16 border-2 border-dashed border-gray-200 text-center">
                    <div
                        class="w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-3xl text-blue-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada user</h3>
                    <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">Mulai kelola tim Anda dengan menambahkan user
                        pertama
                    </p>
                    <a href="#"
                        class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-user-plus mr-3"></i>
                        Tambah User Pertama
                    </a>
                </div>
            @endif
        </div>

        {{-- <div id="confirmModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-md">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600 mb-6">
                    Yakin ingin menghapus user
                    <span id="confirmUserName" class="font-semibold"></span>?
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex justify-end gap-3">
                    <button data-cancel class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Batal
                    </button>
                    <button data-confirm class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Include Confirm Modal Component -->
        <x-confirm-modal />

        <!-- Snackbar Notification -->
        @if (session('success') || session('error'))
            <div id="snackbar"
                class="fixed bottom-6 right-6 z-50 px-6 py-4 rounded-lg shadow-lg text-white text-sm font-medium animate-fade-in
         {{ session('success') ? 'bg-green-600' : 'bg-red-600' }}">
                {{ session('success') ?? session('error') }}
            </div>
            <script>
                setTimeout(() => {
                    const snackbar = document.getElementById('snackbar');
                    if (snackbar) snackbar.remove();
                }, 5000);
            </script>
        @endif


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

            .animate-fade-in {
                animation: fade-in 0.3s ease-out;
            }
        </style>

    @endsection
