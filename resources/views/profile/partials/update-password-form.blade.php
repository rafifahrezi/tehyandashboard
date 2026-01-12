<!-- update-password-form.blade.php -->
@if(!isset($hideHeader) || !$hideHeader)
<div class="mb-6">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Update Password') }}
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>
</div>
@endif

<form method="post" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    @method('put')

    <div class="space-y-2">
        <label for="update_password_current_password" class="block text-sm font-medium">
            {{ __('Current Password') }}
        </label>
        <input
            id="update_password_current_password"
            name="current_password"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
            autocomplete="current-password"
        />
        @error('current_password', 'updatePassword')
            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="update_password_password" class="block text-sm font-medium">
            {{ __('New Password') }}
        </label>
        <input
            id="update_password_password"
            name="password"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
            autocomplete="new-password"
        />
        @error('password', 'updatePassword')
            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="update_password_password_confirmation" class="block text-sm font-medium">
            {{ __('Confirm Password') }}
        </label>
        <input
            id="update_password_password_confirmation"
            name="password_confirmation"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
            autocomplete="new-password"
        />
        @error('password_confirmation', 'updatePassword')
            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="pt-4">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
            {{ __('Save') }}
        </button>

        @if (session('status') === 'password-updated')
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="ml-4 inline-flex items-center text-sm text-green-600 dark:text-green-400"
            >
                <i class="fas fa-check-circle mr-1"></i>
                {{ __('Saved.') }}
            </div>
        @endif
    </div>
</form>
