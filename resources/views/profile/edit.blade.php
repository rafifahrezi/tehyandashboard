@extends('layouts.master')

@section('title', 'Profile Settings')

@section('content')
    <div class="space-y-8">
        <!-- Card 1: Update Profile -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold mb-0">
                    {{ __('Profile Information') }}
                </h2>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Update your account profile information') }}
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                @include('profile.partials.update-profile-information-form', ['hideHeader' => true])
            </div>
        </div>

        <!-- Card 2: Update Password -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold mb-0">
                    {{ __('Update Password') }}
                </h2>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Ensure your account is using a secure password') }}
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                @include('profile.partials.update-password-form', ['hideHeader' => true])
            </div>
        </div>

        <!-- Card 3: Delete Account -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-red-100 dark:border-red-900">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-0">
                    {{ __('Delete Account') }}
                </h2>
                <div class="text-sm text-red-500 dark:text-red-400 font-medium">
                    {{ __('Permanent action - cannot be undone') }}
                </div>
            </div>

            <div class="border-t border-red-100 dark:border-red-900 pt-6 mt-6">
                @include('profile.partials.delete-user-form', ['hideHeader' => true])
            </div>
        </div>
    </div>
@endsection
