<!-- delete-user-form.blade.php -->
@if(!isset($hideHeader) || !$hideHeader)
<div class="mb-6">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Delete Account') }}
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>
</div>
@endif

<button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200"
>
    {{ __('Delete Account') }}
</button>

<!-- Modal -->
<div
    x-data="{ open: false }"
    x-show="open"
    x-on:open-modal.window="open = ($event.detail === 'confirm-user-deletion')"
    x-on:close.window="open = false"
    x-on:keydown.escape.window="open = false"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
            aria-hidden="true"
        ></div>

        <!-- Modal panel -->
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
        >
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <h3 class="text-lg font-medium mb-4">
                    {{ __('Are you sure you want to delete your account?') }}
                </h3>

                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium">
                        {{ __('Password') }}
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200"
                        placeholder="{{ __('Enter your password to confirm') }}"
                    />
                    @error('password', 'userDeletion')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button
                        type="button"
                        x-on:click="open = false"
                        class="font-medium py-2 px-4 rounded-lg transition duration-200"
                    >
                        {{ __('Cancel') }}
                    </button>

                    <button
                        type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200"
                    >
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
