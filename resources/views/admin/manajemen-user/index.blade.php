@extends('layouts.master')

@section('title', $pageTitle)

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $pageTitle }}</h1>
                    <p class="text-blue-100 text-lg">{{ $pageDescription }}</p>
                </div>

                @hasrole('owner')
                    <a href="{{ route('manajemen.user.create') }}"
                        class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center group">
                        <i class="fas fa-user-plus mr-3 text-lg group-hover:translate-x-1 transition"></i>
                        Tambah User
                    </a>
                @endhasrole
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Total User</p>
                        <p class="text-3xl font-bold mt-1">{{ $stats['total_user'] }}</p>
                    </div>
                    <i class="fas fa-users text-3xl opacity-80"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Administrator</p>
                        <p class="text-3xl font-bold mt-1">{{ $stats['administrator'] }}</p>
                    </div>
                    <i class="fas fa-user-shield text-3xl opacity-80"></i>
                </div>
            </div>
        </div>

        <!-- Users List -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Daftar User</h2>
            </div>

            <div class="p-6">
                @if ($users->isEmpty())
                    <div class="text-center py-16">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-users text-4xl text-blue-500"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada user</h3>
                        <p class="text-gray-600 mb-8">Mulai tambahkan user pertama Anda.</p>
                        @hasrole('owner')
                            <a href="{{ route('manajemen.user.create') }}"
                                class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition">
                                <i class="fas fa-user-plus mr-3"></i> Tambah User Pertama
                            </a>
                        @endhasrole
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach ($users as $user)
                            <div x-data id="user-card-{{ $user->id }}"
                                class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 group">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-lg group-hover:text-blue-600 transition">
                                                {{ $user->name }}
                                            </h3>
                                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right space-y-2">
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                        {{ $user->roles->first()?->name === 'owner' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($user->roles->first()?->name ?? 'user') }}
                                        </span>
                                        <span class="block text-xs text-green-600 font-medium">
                                            <i class="fas fa-circle text-[8px] mr-1"></i>Aktif
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-3 text-sm text-gray-600 mb-6">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-phone text-blue-500"></i>
                                        {{ $user->telp ?? '-' }}
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-briefcase text-green-500"></i>
                                        {{ $user->jabatan ?? '-' }}
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-calendar text-purple-500"></i>
                                        Bergabung {{ $user->created_at->format('d M Y') }}
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
                                    
                                    @can('update', $user)
                                        <a href="{{ route('manajemen.user.edit', $user) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    @endcan

                                    <div class="flex items-center gap-3">
                                        @if ($user->telp)
                                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $user->telp) }}"
                                                target="_blank" class="text-green-600 hover:text-green-700">
                                                <i class="fab fa-whatsapp text-xl"></i>
                                            </a>
                                        @endif

                                        @can('delete', $user)
                                            <button type="button"
                                                @click="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                class="text-red-600 hover:text-red-800 px-3 py-2 transition">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Snackbar Notification -->
        <x-snackbar-notification />

        <!-- Confirm Delete Modal -->
        <div x-data="deleteHandler()" x-show="$store.deleteUser.isOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
            @keydown.escape.window="$store.deleteUser.close()" @click.self="$store.deleteUser.close()">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" @click.stop>

                <div class="bg-red-600 text-white p-6 text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold">Hapus User?</h3>
                </div>

                <div class="p-6 text-center">
                    <p class="text-gray-700 mb-2">Yakin ingin menghapus user:</p>
                    <p class="text-xl font-bold text-gray-900" x-text="$store.deleteUser.userName"></p>
                    <p class="text-sm text-gray-500 mt-4">
                        Tindakan ini <strong>tidak dapat dibatalkan</strong>.
                    </p>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex gap-3">
                    <button @click="$store.deleteUser.close()"
                        class="flex-1 py-3 border border-gray-300 rounded-xl hover:bg-gray-100 font-medium transition">
                        Batal
                    </button>
                    <button @click="confirmDelete()"
                        class="flex-1 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 font-medium transition">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('deleteUser', {
                isOpen: false,
                userId: null,
                userName: '',

                open(userId, userName) {
                    this.userId = Number(userId);
                    this.userName = userName || 'Unknown';
                    this.isOpen = true;
                },

                close() {
                    this.isOpen = false;
                    this.userId = null;
                    this.userName = '';
                }
            });

            Alpine.data('deleteHandler', () => ({
                async confirmDelete() {
                    const store = Alpine.store('deleteUser');
                    const userId = store.userId;
                    const userName = store.userName;

                    if (!userId || isNaN(userId)) {
                        Alpine.store('snackbar').show({
                            type: 'error',
                            title: 'Error',
                            message: 'ID user tidak valid.',
                            duration: 5000
                        });
                        return;
                    }

                    store.close(); // Close immediately

                    Alpine.store('snackbar').show({
                        type: 'info',
                        title: 'Menghapus...',
                        message: `Sedang menghapus "${userName}"...`,
                        duration: 0
                    });

                    try {
                        const deleteUrl = '{{ route('manajemen.user.destroy', ':id') }}'.replace(
                            ':id', userId);
                        const response = await axios.delete(deleteUrl);

                        const card = document.getElementById(`user-card-${userId}`);
                        if (card) {
                            card.classList.add('opacity-0', 'scale-95');
                            setTimeout(() => card.remove(), 400);
                        }

                        Alpine.store('snackbar').show(response.data.notification || {
                            type: 'success',
                            title: 'Berhasil!',
                            message: `"${userName}" berhasil dihapus.`,
                            duration: 4000
                        });

                    } catch (error) {
                        const notif = error.response?.data?.notification || {
                            type: 'error',
                            title: 'Gagal!',
                            message: 'Tidak dapat menghapus user. Coba lagi.',
                            duration: 6000
                        };
                        Alpine.store('snackbar').show(notif);
                    }
                }
            }));
        });

        document.addEventListener('DOMContentLoaded', () => {
            const notification = @json(session('notification'));
            if (notification) {
                Alpine.store('snackbar').show(notification);
            }
        });

        // Global helper to open modal
        function openDeleteModal(userId, userName) {
            Alpine.store('deleteUser').open(userId, userName);
        }
    </script>
@endsection
