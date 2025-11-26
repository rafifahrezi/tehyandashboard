<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-emerald-600 via-emerald-500 to-emerald-700 flex items-center justify-center p-6">

        <div class="w-full max-w-md">

            {{-- Header Branding --}}
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="text-yellow-300" width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">ZIS</h1>
                <p class="text-emerald-100">Zakat & Infaq System</p>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-3xl p-8 shadow-2xl">

                <h2 class="text-2xl font-bold text-gray-900 mb-2">Daftar</h2>
                <p class="text-gray-600 mb-6">Mulai berbagi kebaikan</p>

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

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    {{-- Full Name --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>

                        <div class="relative">
                            {{-- Icon --}}
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" width="20" height="20"
                                fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 10-6 0 3 3 0 006 0z"/>
                            </svg>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                placeholder="Ahmad Zaki"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200
                                       focus:border-emerald-600 focus:outline-none"
                            />
                        </div>

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>

                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" width="20" height="20"
                                fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12l-4-4-4 4m8 4l-4-4-4 4"/>
                            </svg>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="nama@email.com"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200
                                       focus:border-emerald-600 focus:outline-none"
                            />
                        </div>

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div x-data="{ show: false }">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>

                        <div class="relative">
                            {{-- Icon --}}
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                                width="20" height="20" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c1.5 0 3 .5 4.243 1.757C17.5 14 18 15.5 18 17s-.5 3-1.757 4.243C14.5 22.5 13 23 11.5 23S8 22.5 6.757 21.243C5.5 20 5 18.5 5 17s.5-3 1.757-4.243C8 11.5 9.5 11 11 11z"/>
                            </svg>

                            <input
                                id="password"
                                name="password"
                                x-bind:type="show ? 'text' : 'password'"
                                required
                                placeholder="Minimal 6 karakter"
                                class="w-full pl-12 pr-12 py-3 rounded-xl border-2 border-gray-200
                                       focus:border-emerald-600 focus:outline-none"
                            />

                            {{-- Toggle --}}
                            <button
                                type="button"
                                @click="show = !show"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            >
                                <template x-if="!show">
                                    <svg width="20" height="20" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </template>

                                <template x-if="show">
                                    <svg width="20" height="20" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18"/>
                                    </svg>
                                </template>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>

                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                                width="20" height="20" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c1.5 0 3 .5 4.243 1.757C17.5 14 18 15.5 18 17s-.5 3-1.757 4.243C14.5 22.5 13 23 11.5 23S8 22.5 6.757 21.243C5.5 20 5 18.5 5 17s.5-3 1.757-4.243C8 11.5 9.5 11 11 11z"/>
                            </svg>

                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                placeholder="Ulangi password"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200
                                       focus:border-emerald-600 focus:outline-none"
                            />
                        </div>

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    {{-- Button --}}
                    <button
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl
                               transition-colors shadow-lg"
                    >
                        Daftar
                    </button>
                </form>

                {{-- Login link --}}
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-emerald-600 font-semibold hover:text-emerald-700">
                            Masuk
                        </a>
                    </p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="text-center mt-6">
                <p class="text-xs text-emerald-100">
                    Dengan mendaftar, Anda menyetujui syarat dan ketentuan kami
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
