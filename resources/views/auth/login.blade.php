<x-guest-layout>
    <div
        class="min-h-screen bg-gradient-to-br from-emerald-600 via-emerald-500 to-emerald-700
                flex items-center justify-center p-6">
        <div class="flex flex-col items-center">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div
                    class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="text-yellow-300" width="40" height="40" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">{{ config('app.name', 'ZIS') }}</h1>
                <p class="text-emerald-100">Dashboard & Inventory Kedai Tehyan </p>
            </div>

            {{-- Login Card --}}
            <div class="bg-white rounded-3xl p-8 shadow-2xl w-full max-w-md">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Masuk') }}</h2>
                <p class="text-gray-600 mb-6">{{ __('Selamat datang kembali!') }}</p>

                {{-- Session Status --}}
                <x-auth-session-status
                    class="mb-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl text-sm"
                    :status="session('status')" />

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email Field --}}
                    <div>
                        <x-input-label for="email" :value="__('Email')"
                            class="block text-sm font-semibold text-gray-700 mb-2" />
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" width="20"
                                height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                                autofocus autocomplete="username" placeholder="nama@email.com"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-600/20 transition-all" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    {{-- Password Field --}}
                    <div x-data="{ showPassword: false }">
                        <x-input-label for="password" :value="__('Password')"
                            class="block text-sm font-semibold text-gray-700 mb-2" />
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" width="20"
                                height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <x-text-input id="password" x-bind:type="showPassword ? 'text' : 'password'"
                                name="password" required autocomplete="current-password" placeholder="••••••••"
                                class="w-full pl-12 pr-12 py-3 rounded-xl border-2 border-gray-200 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-600/20 transition-all" />

                            {{-- Toggle Password --}}
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                                <svg x-show="!showPassword" width="20" height="20" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" width="20" height="20" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>


                    {{-- Remember + Forgot --}}
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember"
                                {{ old('remember') ? 'checked' : '' }}
                                class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-600 focus:ring-2">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-emerald-600 font-semibold hover:text-emerald-700 transition-colors">
                                {{ __('Lupa password?') }}
                            </a>
                        @endif
                    </div>

                    {{-- Button --}}
                    <div class="mt-6">
                        <x-primary-button
                            class="w-full bg-emerald-600 hover:bg-emerald-700 focus:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            {{ __('Masuk') }}
                        </x-primary-button>
                    </div>
                </form>


            </div>

            {{-- Footer --}}
            <div class="text-center mt-6">
                <p class="text-xs text-emerald-100">
                    {{ __('Dengan masuk, Anda menyetujui') }}
                    @if (Route::has('terms'))
                        <a href="{{ route('terms') }}" class="underline hover:text-white transition-colors">
                            {{ __('syarat dan ketentuan') }}
                        </a>
                    @else
                        <span class="underline">{{ __('syarat dan ketentuan') }}</span>
                    @endif
                    {{ __('kami') }}
                </p>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll(
                    '[class*="bg-red-50"], [class*="bg-green-50"], [class*="bg-blue-50"]');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    }, 5000);
                });
            });
        </script>
    @endpush
</x-guest-layout>
