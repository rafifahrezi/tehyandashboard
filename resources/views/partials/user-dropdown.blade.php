@auth
<div 
    x-data="{ open: false }"
    class="flex items-center space-x-4 relative"
>
    <!-- User Info -->
    <div class="text-right">
        <p class="text-sm font-medium text-gray-900">
            {{ auth()->user()->name }}
        </p>
        <p class="text-xs text-gray-500">
            {{ auth()->user()->getRoleNames()->first() ?? 'User' }}
        </p>
    </div>

    <!-- Avatar Button -->
    <button
        @click="open = !open"
        class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold focus:outline-none"
    >
        {{ strtoupper(auth()->user()->name[0]) }}
    </button>

    <!-- Dropdown Menu -->
    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute right-0 top-12 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50"
    >
        <!-- Profile -->
        <a 
            href="{{ route('profile.edit') }}"
            class="flex items-center px-4 py-2 text-sm hover:bg-gray-100"
        >
            <i class="fas fa-user mr-2"></i> Profil
        </a>

        <!-- Divider -->
        <div class="border-t border-gray-100"></div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="w-full text-left flex items-center px-4 py-2 text-sm hover:bg-gray-100"
            >
                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
            </button>
        </form>
    </div>
</div>
@endauth
