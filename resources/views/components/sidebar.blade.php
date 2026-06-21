<aside class="hidden w-64 shrink-0 border-r border-slate-800 bg-slate-900 text-white lg:block">
    <div class="flex h-16 items-center border-b border-slate-800 px-6">
        <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600">
                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h18M3 9h18M3 15h18M3 21h18" />
                </svg>
            </div>
            <div>
                <h1 class="text-base font-bold tracking-wide">Jayusmart</h1>
                <p class="text-xs text-slate-400">Admin Dashboard</p>
            </div>
        </div>
    </div>

    <nav class="space-y-0.5 px-3 py-4 text-sm font-medium">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        {{-- Cabang --}}
        @if (auth()->user()?->hasRole('owner'))
            <a href="{{ route('branches.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs('branches.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Cabang
            </a>
        @endif

        {{-- Produk --}}
        @if (auth()->user()?->hasAnyRole(['owner', 'manager', 'warehouse']))
            <a href="{{ route('products.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Produk
            </a>
        @endif

        {{-- Stok Barang --}}
        @if (auth()->user()?->hasAnyRole(['owner', 'manager', 'supervisor', 'warehouse']))
            <a href="{{ route('stocks.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs('stocks.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                Stok Barang
            </a>
        @endif

        {{-- Transaksi --}}
        @if (auth()->user()?->hasAnyRole(['owner', 'supervisor', 'cashier']))
            <a href="{{ route('transactions.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs('transactions.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Transaksi
            </a>
        @endif

        {{-- Laporan Transaksi --}}
        @if (auth()->user()?->hasAnyRole(['owner', 'manager', 'supervisor']))
            <a href="{{ route('reports.transactions') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs('reports.transactions*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan Transaksi
            </a>
        @endif

        {{-- Laporan Stok --}}
        @if (auth()->user()?->hasAnyRole(['owner', 'manager', 'supervisor', 'warehouse']))
            <a href="{{ route('reports.stocks') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs('reports.stocks*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan Stok
            </a>
        @endif

        {{-- User Management --}}
        @if (auth()->user()?->hasAnyRole(['owner', 'manager']))
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                User Management
            </a>
        @endif

        {{-- Audit Log --}}
        @if (auth()->user()?->hasRole('owner'))
            <a href="{{ route('audit-logs.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs('audit-logs.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14l-3-2-3 2-3-2-3 2V6a2 2 0 012-2z" />
                </svg>
                Audit Log
            </a>
        @endif

        {{-- Logout --}}
        <div class="pt-2 mt-2 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-slate-400 transition-colors hover:bg-red-600/20 hover:text-red-400">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </nav>
</aside>