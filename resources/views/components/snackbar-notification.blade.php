<div x-data="snackbarNotification()" 
     x-show="isVisible" 
     x-cloak
     class="fixed top-4 right-4 max-w-sm w-full z-[60] pointer-events-auto"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95">
    <div class="bg-white rounded-lg shadow-2xl p-4 border-l-4 flex items-start gap-3"
         :class="{
             'border-green-500': type === 'success',
             'border-red-500': type === 'error',
             'border-blue-500': type === 'info'
         }">
        <div>
            <template x-if="type === 'success'">
                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </template>
            <template x-if="type === 'error'">
                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </template>
        </div>
        <div class="flex-1">
            <p class="font-semibold text-gray-900" x-text="title"></p>
            <p class="text-sm text-gray-600 mt-1" x-text="message"></p>
        </div>
        <button @click="hide()" class="text-gray-400 hover:text-gray-600 ml-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('snackbar', {
        isVisible: false,
        type: 'info',
        title: '',
        message: '',
        duration: 4000,
        timeout: null,

        show({ type = 'info', title = 'Info', message = '', duration = 4000 }) {
            this.type = type;
            this.title = title;
            this.message = message;
            this.duration = duration;
            this.isVisible = true;

            if (this.timeout) clearTimeout(this.timeout);
            this.timeout = setTimeout(() => this.hide(), duration);
        },

        hide() {
            this.isVisible = false;
            if (this.timeout) clearTimeout(this.timeout);
        }
    });

    Alpine.data('snackbarNotification', () => ({
        get isVisible() { return Alpine.store('snackbar').isVisible; },
        get type() { return Alpine.store('snackbar').type; },
        get title() { return Alpine.store('snackbar').title; },
        get message() { return Alpine.store('snackbar').message; },
        hide() { Alpine.store('snackbar').hide(); }
    }));
});
</script>