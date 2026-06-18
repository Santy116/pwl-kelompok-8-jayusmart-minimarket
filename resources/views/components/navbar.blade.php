<header class="sticky top-0 z-20 border-b border-slate-200 bg-white">
    <div class="flex h-16 items-center justify-between px-6">
        <div>
            <h2 class="text-base font-semibold text-slate-800">
                Dashboard Jayusmart
            </h2>
        </div>

        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-sm font-semibold text-slate-800">
                    {{ auth()->user()->name ?? 'User' }}
                </p>

                <p class="text-xs text-slate-500">
                    {{ auth()->user()?->getRoleNames()->first() ? ucfirst(auth()->user()->getRoleNames()->first()) : 'Role' }}

                    @if (auth()->user()?->branch)
                        · {{ auth()->user()->branch->name }}
                    @endif
                </p>
            </div>

            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-sm font-bold text-white">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
        </div>
    </div>
</header>