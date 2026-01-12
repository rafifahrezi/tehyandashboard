<!-- update-profile-information-form.blade.php -->
@if(!isset($hideHeader) || !$hideHeader)
<div class="mb-6">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Profile Information') }}
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __("Update your account's profile information and email address.") }}
    </p>
</div>
@endif

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('patch')

    <div class="space-y-2">
        <label for="name" class="block text-sm font-medium">
            {{ __('Name') }}
        </label>
        <input
            id="name"
            name="name"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
            value="{{ old('name', $user->name) }}"
            required
            autofocus
            autocomplete="name"
        />
        @error('name')
            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="email" class="block text-sm font-medium">
            {{ __('Email') }}
        </label>
        <input
            id="email"
            name="email"
            type="email"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
            value="{{ old('email', $user->email) }}"
            required
            autocomplete="username"
        />
        @error('email')
            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" class="ml-1 underline text-sm text-yellow-700 dark:text-yellow-300 hover:text-yellow-900 dark:hover:text-yellow-100">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="pt-4">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
            {{ __('Save') }}
        </button>

        @if (session('status') === 'profile-updated')
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
