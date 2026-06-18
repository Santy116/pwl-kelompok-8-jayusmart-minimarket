@props([
    'title',
    'value',
    'description' => null,
])

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500">
                {{ $title }}
            </p>

            <h3 class="mt-2 text-2xl font-bold text-slate-900">
                {{ $value }}
            </h3>

            @if ($description)
                <p class="mt-1 text-xs text-slate-500">
                    {{ $description }}
                </p>
            @endif
        </div>

        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
            <span class="text-sm font-bold">JS</span>
        </div>
    </div>
</div>