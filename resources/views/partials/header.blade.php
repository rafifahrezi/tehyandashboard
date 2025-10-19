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
                            @include('partials.user-dropdown')
                        </div>
                    </div>
                </div>
            </header>
