<header class="sticky top-0 z-20 border-b border-slate-200 bg-white">
    <div class="flex h-16 items-center justify-between px-6">
        <div>
            <p class="text-sm font-medium text-slate-500">Sistem Monitoring</p>
            <h2 class="text-lg font-semibold text-slate-800">Jayusmart Minimarket</h2>
        </div>

        <div class="flex items-center gap-4">
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

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
        </div>
    </div>
</header>