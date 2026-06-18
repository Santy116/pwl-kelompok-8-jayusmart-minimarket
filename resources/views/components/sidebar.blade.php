<aside class="hidden w-64 shrink-0 border-r border-slate-200 bg-slate-900 text-white lg:block">
    <div class="flex h-16 items-center border-b border-slate-800 px-6">
        <div>
            <h1 class="text-lg font-bold tracking-wide">Jayusmart</h1>
            <p class="text-xs text-slate-400">Monitoring Minimarket</p>
        </div>
    </div>

    <nav class="space-y-1 px-4 py-5 text-sm font-medium">
        <a href="{{ route('dashboard') }}"
           class="flex items-center rounded-lg px-4 py-2.5 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            Dashboard
        </a>

        @if (auth()->user()?->hasRole('owner'))
            <a href="{{ route('branches.index') }}"
               class="flex items-center rounded-lg px-4 py-2.5 {{ request()->routeIs('branches.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Cabang
            </a>
        @endif

        @if (auth()->user()?->hasAnyRole(['owner', 'manager', 'warehouse']))
            <a href="{{ route('products.index') }}"
               class="flex items-center rounded-lg px-4 py-2.5 {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Produk
            </a>
        @endif

        @if (auth()->user()?->hasAnyRole(['owner', 'manager', 'supervisor', 'warehouse']))
            <a href="{{ route('stocks.index') }}"
               class="flex items-center rounded-lg px-4 py-2.5 {{ request()->routeIs('stocks.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Stok Barang
            </a>
        @endif

        @if (auth()->user()?->hasAnyRole(['owner', 'supervisor', 'cashier']))
            <a href="{{ route('transactions.index') }}"
               class="flex items-center rounded-lg px-4 py-2.5 {{ request()->routeIs('transactions.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Transaksi
            </a>
        @endif

        @if (auth()->user()?->hasAnyRole(['owner', 'manager', 'supervisor']))
            <a href="{{ route('reports.transactions') }}"
               class="flex items-center rounded-lg px-4 py-2.5 {{ request()->routeIs('reports.transactions*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Laporan Transaksi
            </a>
        @endif

        @if (auth()->user()?->hasAnyRole(['owner', 'manager', 'supervisor', 'warehouse']))
            <a href="{{ route('reports.stocks') }}"
               class="flex items-center rounded-lg px-4 py-2.5 {{ request()->routeIs('reports.stocks*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Laporan Stok
            </a>
        @endif

        @if (auth()->user()?->hasAnyRole(['owner', 'manager']))
            <a href="{{ route('users.index') }}"
               class="flex items-center rounded-lg px-4 py-2.5 {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                User Management
            </a>
        @endif

        <form method="POST" action="{{ route('logout') }}" class="pt-4">
            @csrf

            <button type="submit"
                    class="flex w-full items-center rounded-lg px-4 py-2.5 text-left text-slate-300 hover:bg-red-600 hover:text-white">
                Logout
            </button>
        </form>
    </nav>
</aside>