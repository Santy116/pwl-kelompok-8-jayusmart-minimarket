<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jayusmart') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">
    <div class="min-h-screen">
        <div class="flex min-h-screen">
            <x-sidebar />

            <div class="flex min-h-screen flex-1 flex-col">
                <x-navbar :pageTitle="$title ?? null" />

                <main class="flex-1 px-6 py-6">
                    @if (session('success'))
                        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{ $slot ?? '' }}

                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>