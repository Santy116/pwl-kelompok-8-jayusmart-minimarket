@props(['pageTitle' => null])

<header class="sticky top-0 z-20 border-b border-slate-200 bg-white">
    <div class="flex h-16 items-center justify-between px-6">

        {{-- Page title (dikirim dari tiap halaman lewat <x-slot:title>) --}}
        <div>
            <h2 class="text-xl font-bold text-slate-900">
                {{ $pageTitle ?? config('app.name', 'Jayusmart') }}
            </h2>
        </div>

        {{-- Profile Dropdown --}}
        <div class="relative" x-data="{ open: false }">

            {{-- Trigger --}}
            <button
                @click="open = !open"
                @keydown.escape.window="open = false"
                class="flex items-center gap-3 rounded-lg px-2 py-1.5 transition-colors hover:bg-slate-100 focus:outline-none">

                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-slate-800 leading-tight">
                        {{ auth()->user()->name ?? 'User' }}
                    </p>
                    <p class="text-xs text-slate-500 leading-tight">
                        {{ auth()->user()?->getRoleNames()->first() ? ucfirst(auth()->user()->getRoleNames()->first()) : 'Role' }}
                        @if (auth()->user()?->branch)
                            · {{ auth()->user()->branch->name }}
                        @endif
                    </p>
                </div>

                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-sm font-bold text-white shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>

                <svg class="h-4 w-4 text-slate-400 transition-transform duration-200"
                     :class="{ 'rotate-180': open }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                @click.outside="open = false"
                class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl border border-slate-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                style="display: none;">

                {{-- User Info Header --}}
                <div class="border-b border-slate-100 px-4 py-3">
                    <p class="text-sm font-semibold text-slate-800 truncate">
                        {{ auth()->user()->name ?? 'User' }}
                    </p>
                    <p class="text-xs text-slate-500 truncate">
                        {{ auth()->user()->email ?? '' }}
                    </p>
                </div>

                {{-- Menu Items --}}
                <div class="py-1">
                    {{-- Profil & Edit Profile (Breeze hanya punya 1 halaman: profile.edit) --}}
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil Saya
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Pengaturan Akun
                    </a>
                </div>

                {{-- Logout --}}
                <div class="border-t border-slate-100 py-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>