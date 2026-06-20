@props([
    'title',
    'value',
    'icon' => 'default', {{-- options: branch, transaction, revenue, product, stock --}}
])

@php
    $icons = [
        'branch' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />',
        'transaction' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />',
        'revenue' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'product' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />',
        'stock' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />',
        'default' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
    ];

    $iconColors = [
        'branch'      => 'bg-indigo-50 text-indigo-600',
        'transaction' => 'bg-blue-50 text-blue-600',
        'revenue'     => 'bg-emerald-50 text-emerald-600',
        'product'     => 'bg-violet-50 text-violet-600',
        'stock'       => 'bg-amber-50 text-amber-600',
        'default'     => 'bg-slate-50 text-slate-600',
    ];

    $svgPath  = $icons[$icon]  ?? $icons['default'];
    $colorClass = $iconColors[$icon] ?? $iconColors['default'];
@endphp

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
    <div class="flex items-start justify-between">
        <div class="min-w-0">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                {{ $title }}
            </p>

            <h3 class="mt-2 text-2xl font-bold text-slate-900 truncate">
                {{ $value }}
            </h3>
        </div>

        <div class="ml-3 flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $colorClass }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $svgPath !!}
            </svg>
        </div>
    </div>
</div>