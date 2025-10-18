@extends('layouts.app')

@section('title', $userData['pageTitle'])

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h1 class="text-3xl font-bold mb-2">{{ $userData['pageTitle'] }}</h1>
                <p class="text-blue-100 text-lg">{{ $userData['pageDescription'] }}</p>
            </div>
            
            <button 
                id="tambahUserBtn"
                class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center group"
            >
                <i class="fas fa-user-plus mr-3 text-lg"></i>
                Tambah User
            </button>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total User</p>
                    <p class="text-2xl font-bold mt-1">{{ $userData['stats']['total_user'] }}</p>
                </div>
                <i class="fas fa-users text-2xl opacity-80"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Administrator</p>
                    <p class="text-2xl font-bold mt-1">{{ $userData['stats']['administrator'] }}</p>
                </div>
                <i class="fas fa-user-shield text-2xl opacity-80"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Pegawai</p>
                    <p class="text-2xl font-bold mt-1">{{ $userData['stats']['pegawai'] }}</p>
                </div>
                <i class="fas fa-user-tie text-2xl opacity-80"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Aktif</p>
                    <p class="text-2xl font-bold mt-1">{{ $userData['stats']['active'] }}</p>
                </div>
                <i class="fas fa-check-circle text-2xl opacity-80"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium">Pending</p>
                    <p class="text-2xl font-bold mt-1">{{ $userData['stats']['pending'] }}</p>
                </div>
                <i class="fas fa-clock text-2xl opacity-80"></i>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <!-- Role Filter -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Role</label>
                <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                    <option value="">Semua Role</option>
                    @foreach($userData['roles'] as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Department Filter -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Departemen</label>
                <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                    <option value="">Semua Departemen</option>
                    @foreach($userData['departments'] as $department)
                        <option value="{{ $department }}">{{ $department }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Status</label>
                <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
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
                    <input 
                        type="text" 
                        placeholder="Cari user..." 
                        class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                    >
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
                    <p class="text-gray-600 mt-1">Total {{ count($userData['users']) }} user terdaftar</p>
                </div>
            </div>
        </div>

        <!-- Users Grid -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($userData['users'] as $user)
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">
                    <!-- User Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                {{ $user['avatar'] }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                    {{ $user['name'] }}
                                </h3>
                                <p class="text-sm text-gray-600">{{ $user['email'] }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                {{ $user['role'] == 'Administrator' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $user['role'] }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-circle mr-1 text-xs"></i>
                                {{ $user['status'] }}
                            </span>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-phone w-5 text-center mr-3 text-blue-500"></i>
                            <span>{{ $user['phone'] }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-building w-5 text-center mr-3 text-green-500"></i>
                            <span>{{ $user['department'] }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-calendar-alt w-5 text-center mr-3 text-purple-500"></i>
                            <span>Bergabung: {{ $user['join_date'] }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-clock w-5 text-center mr-3 text-amber-500"></i>
                            <span>Login terakhir: {{ $user['last_login'] }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <button class="text-blue-600 hover:text-blue-800 font-medium text-sm py-2 px-4 rounded-lg transition-all duration-200 hover:bg-blue-50 edit-user-btn" data-user='@json($user)'>
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </button>
                        <div class="flex space-x-2">
                            <button class="text-gray-600 hover:text-gray-800 font-medium text-sm py-2 px-3 rounded-lg transition-all duration-200 hover:bg-gray-100">
                                <i class="fas fa-envelope"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800 font-medium text-sm py-2 px-3 rounded-lg transition-all duration-200 hover:bg-red-50">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-200 px-6 py-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="text-sm text-gray-600 mb-4 lg:mb-0">
                    Menampilkan <span class="font-semibold">{{ count($userData['users']) }}</span> user
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Sebelumnya
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        1
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        2
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    @if(count($userData['users']) === 0)
    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl shadow-lg p-16 border-2 border-dashed border-gray-200 text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-users text-3xl text-blue-500"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada user</h3>
        <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">Mulai kelola tim Anda dengan menambahkan user pertama</p>
        <button id="tambahUserEmptyBtn" class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-user-plus mr-3"></i>
            Tambah User Pertama
        </button>
    </div>
    @endif
</div>

<!-- Add User Modal -->
<div id="tambahUserModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm items-center justify-center z-50 hidden animate-fade-in">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full mx-4 max-h-[85vh] overflow-hidden transform transition-all duration-300 scale-95">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Tambah User Baru</h2>
                    <p class="text-blue-100">Isi form berikut untuk menambahkan user baru ke sistem</p>
                </div>
                <button id="closeUserModal" class="text-white hover:text-blue-200 transition duration-200">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <form class="p-8 space-y-6">
            @csrf
            
            <!-- Grid untuk Nama dan Email -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            placeholder="Nama lengkap user"
                            class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                            required
                        >
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="email" 
                            placeholder="email@example.com"
                            class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Grid untuk Role dan Departemen -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Role -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Role</label>
                    <div class="relative">
                        <i class="fas fa-user-tag absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select class="w-full pl-12 pr-10 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                            <option value="">Pilih Role</option>
                            @foreach($userData['roles'] as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- Departemen -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Departemen</label>
                    <div class="relative">
                        <i class="fas fa-building absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select class="w-full pl-12 pr-10 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300">
                            <option value="">Pilih Departemen</option>
                            @foreach($userData['departments'] as $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Telepon -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Nomor Telepon</label>
                <div class="relative">
                    <i class="fas fa-phone absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input 
                        type="tel" 
                        placeholder="+62 812-3456-7890"
                        class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                    >
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <button 
                    type="button" 
                    id="batalUserBtn"
                    class="px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-semibold transform hover:scale-105"
                >
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center"
                >
                    <i class="fas fa-user-plus mr-2"></i>
                    Tambah User
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>

<!-- JavaScript for Modal and Interactions -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('tambahUserModal');
        const tambahUserBtn = document.getElementById('tambahUserBtn');
        const tambahUserEmptyBtn = document.getElementById('tambahUserEmptyBtn');
        const batalUserBtn = document.getElementById('batalUserBtn');
        const closeUserModal = document.getElementById('closeUserModal');

        // Open modal with animation
        function openUserModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                modal.querySelector('.max-w-2xl').classList.remove('scale-95');
                modal.querySelector('.max-w-2xl').classList.add('scale-100');
            }, 10);
        }

        // Close modal with animation
        function closeUserModalFunc() {
            modal.querySelector('.max-w-2xl').classList.remove('scale-100');
            modal.querySelector('.max-w-2xl').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 200);
        }

        // Event listeners
        if (tambahUserBtn) {
            tambahUserBtn.addEventListener('click', openUserModal);
        }

        if (tambahUserEmptyBtn) {
            tambahUserEmptyBtn.addEventListener('click', openUserModal);
        }

        if (batalUserBtn) {
            batalUserBtn.addEventListener('click', closeUserModalFunc);
        }

        if (closeUserModal) {
            closeUserModal.addEventListener('click', closeUserModalFunc);
        }

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeUserModalFunc();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeUserModalFunc();
            }
        });

        // Edit user functionality
        document.querySelectorAll('.edit-user-btn').forEach(button => {
            button.addEventListener('click', function() {
                const user = JSON.parse(this.getAttribute('data-user'));
                console.log('Editing user:', user);
                // Implement edit functionality here
                openUserModal();
            });
        });

        // Filter functionality
        const filters = document.querySelectorAll('select');
        const searchInput = document.querySelector('input[type="text"]');
        
        filters.forEach(filter => {
            filter.addEventListener('change', function(e) {
                console.log('Filter changed:', e.target.value);
                // Implement filter logic here
            });
        });

        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    console.log('Searching for:', e.target.value);
                    // Implement search logic here
                }, 500);
            });
        }

        // Add hover effects to user cards
        document.querySelectorAll('.bg-gradient-to-br.from-gray-50').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(-1px)';
            });
        });
    });
</script>
@endsection