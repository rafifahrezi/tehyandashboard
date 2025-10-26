<div x-data="toastComponent()" x-show="isVisible" x-cloak x-transition:enter="transition transform ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2" @toast.window="show($event.detail)"
    class="fixed right-4 bottom-4 w-96 max-w-full z-50" aria-live="assertive">
    <div :class="containerClass" class="rounded-lg shadow-lg overflow-hidden border">
        <div class="flex p-3">
            <div class="flex items-center justify-center w-12">
                <!-- simple icon set -->
                <template x-if="type === 'success'">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </template>
                <template x-if="type === 'error'">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </template>
                <template x-if="type === 'info'">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                </template>
                <template x-if="type === 'warning'">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.29 3.86L1.82 18a1 1 0 00.86 1.5h18.64a1 1 0 00.86-1.5L13.71 3.86a1 1 0 00-1.72 0zM12 9v4M12 17h.01" />
                    </svg>
                </template>
            </div>

            <div class="flex-1 pl-3">
                <div class="font-semibold text-sm" x-text="title"></div>
                <div class="text-sm text-gray-600" x-text="message"></div>
            </div>

            <div class="pl-3 flex items-start">
                <button @click="hide()" class="text-gray-400 hover:text-gray-600 focus:outline-none" aria-label="Close">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function toastComponent() {
        return {
            isVisible: false,
            type: 'success',
            title: '',
            message: '',
            duration: 4000,
            timeoutId: null,

            get containerClass() {
                // map type ke style container (tailwind classes)
                switch (this.type) {
                    case 'error':
                        return 'bg-white border-red-200';
                    case 'warning':
                        return 'bg-white border-yellow-200';
                    case 'info':
                        return 'bg-white border-blue-200';
                    default:
                        return 'bg-white border-green-200';
                }
            },

            show(payload = {}) {
                // payload: { type, title, message, duration }
                this.type = payload.type || 'success';
                this.title = payload.title || (this.type === 'success' ? 'Sukses' : 'Info');
                this.message = payload.message || '';
                this.duration = payload.duration || 4000;

                // clear previous timeout jika ada
                if (this.timeoutId) {
                    clearTimeout(this.timeoutId);
                    this.timeoutId = null;
                }

                this.isVisible = true;

                this.timeoutId = setTimeout(() => {
                    this.hide();
                }, this.duration);
            },

            hide() {
                this.isVisible = false;
                if (this.timeoutId) {
                    clearTimeout(this.timeoutId);
                    this.timeoutId = null;
                }
            }
        }
    }
</script>
