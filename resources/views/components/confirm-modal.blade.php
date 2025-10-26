<div x-data="confirmModal()" 
     x-show="isOpen" 
     x-cloak 
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="close()"></div>

    <!-- Modal -->
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
             @click.stop
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <!-- Modal Content -->
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <!-- Icon Warning -->
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    
                    <!-- Text Content -->
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900" x-text="title"></h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" x-text="message"></p>
                            
                            <!-- Additional Info -->
                            <template x-if="additionalInfo">
                                <div class="mt-3 p-3 bg-yellow-50 rounded-md border border-yellow-200">
                                    <p class="text-sm text-yellow-800" x-text="additionalInfo"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="button" 
                        @click="confirm()" 
                        :disabled="isLoading"
                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 disabled:opacity-50 disabled:cursor-not-allowed sm:ml-3 sm:w-auto transition-colors duration-200">
                    <span x-show="!isLoading">Hapus</span>
                    <span x-show="isLoading" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menghapus...
                    </span>
                </button>
                <button type="button" 
                        @click="close()" 
                        :disabled="isLoading"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0 sm:mt-0 sm:w-auto transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        // Buat global store untuk confirm modal
        Alpine.store('confirmModal', {
            isOpen: false,
            title: '',
            message: '',
            additionalInfo: '',
            isLoading: false,
            onConfirm: null,
            
            open(detail) {
                this.title = detail.title || 'Konfirmasi Hapus';
                this.message = detail.message || 'Apakah Anda yakin ingin menghapus item ini?';
                this.additionalInfo = detail.additionalInfo || '';
                this.onConfirm = detail.onConfirm;
                this.isOpen = true;
                this.isLoading = false;
            },
            
            close() {
                if (!this.isLoading) {
                    this.isOpen = false;
                    this.reset();
                }
            },
            
            async confirm() {
                if (this.onConfirm && !this.isLoading) {
                    this.isLoading = true;
                    try {
                        await this.onConfirm();
                        this.close();
                    } catch (error) {
                        console.error('Error during confirmation:', error);
                        this.isLoading = false;
                    }
                }
            },
            
            reset() {
                this.title = '';
                this.message = '';
                this.additionalInfo = '';
                this.onConfirm = null;
                this.isLoading = false;
            }
        });

        // Data untuk component
        Alpine.data('confirmModal', () => ({
            // Gunakan store untuk state management
            get isOpen() {
                return Alpine.store('confirmModal').isOpen;
            },
            get title() {
                return Alpine.store('confirmModal').title;
            },
            get message() {
                return Alpine.store('confirmModal').message;
            },
            get additionalInfo() {
                return Alpine.store('confirmModal').additionalInfo;
            },
            get isLoading() {
                return Alpine.store('confirmModal').isLoading;
            },
            
            close() {
                Alpine.store('confirmModal').close();
            },
            
            confirm() {
                Alpine.store('confirmModal').confirm();
            }
        }));
    });
</script>