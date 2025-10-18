<div class="flex items-center space-x-4">
    <div class="text-right">
        <p class="text-sm font-medium text-gray-900">
            {{ auth()->user()->name ?? 'Guest' }}
        </p>
        <p class="text-xs text-gray-500">
            {{ auth()->user()->role ?? 'Visitor' }}
        </p>
    </div>
    <div class="dropdown relative">
        <button 
            class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold"
            onclick="toggleDropdown()"
        >
            {{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}
        </button>
        
        {{-- Dropdown Menu --}}
        <div 
            id="userDropdown" 
            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50"
        >
            <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                <i class="fas fa-user mr-2"></i>Profile
            </a>
            <form method="POST" action="#">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</div>

@push('head-scripts')
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        const dropdown = document.getElementById('userDropdown');
        const dropdownButton = event.target.closest('.dropdown');
        
        if (!dropdownButton && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
@endpush
