@php
    $currentRoute = request()->route()->getName();
    // Define menu items
    $menuItems = [
        [
            'title' => 'Dashboard',
            'url' => route('dashboard'),
            'icon' => 'fas fa-chart-pie',
            'active' => $currentRoute === 'dashboard',
            'badge' => null
        ],
        [
            'title' => 'Manajemen Bahan',
            'url' => route('manajemen.bahan'),
            'icon' => 'fas fa-boxes',
            'active' => $currentRoute === 'manajemen.bahan',
            'badge' => null
        ],
        [
            'title' => 'Transaksi Stok',
            'url' => route('transaksi.stok'),
            'icon' => 'fas fa-exchange-alt',
            'active' => $currentRoute === 'transaksi.stok',
            'badge' => null
        ],
        [
            'title' => 'Laporan',
            'url' => route('laporan'),
            'icon' => 'fas fa-chart-bar',
            'active' => $currentRoute === 'laporan',
            'badge' => null
        ],
        [
            'title' => 'Manajemen User',
            'url' => route('manajemen.user'),
            'icon' => 'fas fa-users',
            'active' => $currentRoute === 'manajemen.user',
            'badge' => null
        ]
    ];

    $user = [
        'name' => 'rafffahrezi4',
        'role' => 'Pemilik Toko / Admin War...',
        'initial' => 'R'
    ];

    // Mock data for low stock warning
    $lowStockCount = 3;
@endphp

<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-white/80 backdrop-blur-xl border-r border-slate-200/60 sidebar-transition transform lg:translate-x-0 lg:static fixed inset-y-0 left-0 z-50 -translate-x-full">
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="border-b border-slate-200/60 p-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <i class="fas fa-boxes text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="font-bold text-slate-900 text-lg">StokKedai</h2>
                    <p class="text-xs text-slate-500">Manajemen Stok Pintar</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Content -->
        <div class="flex-1 overflow-y-auto p-3">
            <!-- Navigation Menu -->
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 py-3">
                    Menu Utama
                </h3>
                
                <nav class="space-y-1">
                    @foreach($menuItems as $item)
                    <a href="{{ $item['url'] }}" 
                       class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 mb-1
                              {{ $item['active'] 
                                 ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-lg shadow-indigo-500/20' 
                                 : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-700' }}">
                        
                        <!-- Icon -->
                        <i class="{{ $item['icon'] }} w-5 h-5 {{ $item['active'] ? 'text-white' : 'text-slate-400 group-hover:text-indigo-600' }}"></i>
                        
                        <!-- Menu Text -->
                        <span class="font-medium flex-1">{{ $item['title'] }}</span>
                        
                        <!-- Badge for Dashboard -->
                        @if($item['title'] === 'Dashboard' && $lowStockCount > 0)
                        <span class="bg-amber-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                            {{ $lowStockCount }}
                        </span>
                        @endif
                    </a>
                    @endforeach
                </nav>
            </div>

            <!-- Low Stock Warning -->
            @if($lowStockCount > 0)
            <div class="mx-3 p-4 bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl border border-amber-200/60">
                <div class="flex items-start gap-3">
                    <i class="fas fa-bell w-5 h-5 text-amber-600 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-semibold text-amber-900">
                            Peringatan Stok
                        </p>
                        <p class="text-xs text-amber-700 mt-1">
                            {{ $lowStockCount }} bahan mencapai stok minimum
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Footer -->
        <div class="border-t border-slate-200/60 p-4">
            <div class="space-y-3">
                <!-- User Info -->
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-sm">
                            {{ $user['initial'] }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-900 text-sm truncate">
                            {{ $user['name'] }}
                        </p>
                        <p class="text-xs text-slate-500 truncate">
                            {{ $user['role'] }}
                        </p>
                    </div>
                </div>

                <!-- Logout Button -->
                <button class="w-full flex items-center gap-2 px-4 py-2 text-slate-600 border border-slate-200 rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all duration-200">
                    <i class="fas fa-sign-out-alt w-4 h-4"></i>
                    <span class="font-medium">Keluar</span>
                </button>
            </div>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>