<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', config('app.name', 'Dashboard Administrator'))</title>
    
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    {{-- Vite Directive untuk CSS dan JavaScript --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Font Awesome via NPM (Recommended) --}}
    @if(file_exists(public_path('build/fontawesome.css')))
        <link rel="stylesheet" href="{{ asset('build/fontawesome.css') }}">
    @else
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @endif

    {{-- Additional Head Scripts/Styles --}}
    @stack('head-scripts')
</head>
<body class="bg-gray-50 antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b sticky top-0 z-40">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between py-4">
                        <div class="flex items-center">
                            <button 
                                id="sidebarToggle" 
                                class="lg:hidden text-gray-600 hover:text-gray-900 mr-4"
                                aria-label="Toggle Sidebar"
                            >
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <h1 class="text-xl font-semibold text-gray-800">
                                @yield('page_header', 'Dashboard')
                            </h1>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            @include('layouts.user-dropdown')
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <p class="text-center text-gray-500 text-sm">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Dashboard Administrator') }}
                        <span class="mx-2">|</span> 
                        Versi {{ config('app.version', '1.0.0') }}
                    </p>
                </div>
            </footer>
        </div>
    </div>

    {{-- Sidebar Toggle Script --}}
    @push('head-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                });

                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', (event) => {
                    const isLargeScreen = window.innerWidth >= 1024;
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnToggle = sidebarToggle.contains(event.target);

                    if (!isLargeScreen && !isClickInsideSidebar && !isClickOnToggle) {
                        sidebar.classList.add('-translate-x-full');
                    }
                });
            }
        });
    </script>
    @endpush

    {{-- Additional Body Scripts --}}
    @stack('body-scripts')
</body>
</html>
