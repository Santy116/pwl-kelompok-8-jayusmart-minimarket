@props([
    'items' => [],
])

<nav class="mb-4 text-sm text-slate-500">
    <ol class="flex items-center gap-2">
        <li>
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600">
                Dashboard
            </a>
        </li>

        @foreach ($items as $label => $url)
            <li>/</li>

            <li>
                @if ($url)
                    <a href="{{ $url }}" class="hover:text-blue-600">
                        {{ $label }}
                    </a>
                @else
                    <span class="font-medium text-slate-700">
                        {{ $label }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>