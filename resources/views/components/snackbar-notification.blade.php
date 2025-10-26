<div x-data="snackbarNotification()" 
     x-show="isVisible" 
     x-cloak
     class="fixed top-4 right-4 max-w-sm w-full z-[60] pointer-events-auto">
    <div class="bg-white rounded-lg shadow-lg p-4 border-l-4" :class="{
        'border-green-500': type === 'success',
        'border-red-500': type === 'error'
    }">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg x-show="type === 'success'" class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <svg x-show="type === 'error'" class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <div>
                    <h3 x-text="title" class="font-medium text-gray-900"></h3>
                    <p x-text="message" class="text-sm text-gray-500"></p>
                </div>
            </div>
            <button @click="hide" class="text-gray-400 hover:text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
