<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="space-y-6">

        {{-- Header: tombol aksi saja, judul sudah ada di navbar --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('reports.transactions') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan Transaksi
            </a>

            <a href="{{ route('reports.stocks') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                Laporan Stok
            </a>
        </div>

        {{-- Stat Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <x-stat-card
                title="Total Cabang"
                :value="$totalBranches ?? '-'"
                icon="branch"
            />

            <x-stat-card
                title="Transaksi Hari Ini"
                :value="$todayTransactions ?? 0"
                icon="transaction"
            />

            <x-stat-card
                title="Total Pendapatan"
                value="Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}"
                icon="revenue"
            />

            <x-stat-card
                title="Total Produk"
                :value="$totalProducts ?? 0"
                icon="product"
            />

            <x-stat-card
                title="Stok Menipis"
                :value="$lowStocks ?? 0"
                icon="stock"
            />
        </div>

        {{-- Main Content: Stok per Cabang + Transaksi Terbaru --}}
        <div class="grid gap-6 xl:grid-cols-3">

            {{-- Stok per Cabang (fokus utama) --}}
            <div class="xl:col-span-2">
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-slate-900">Stok per Cabang</h2>
                    <a href="{{ route('stocks.index') }}"
                       class="text-xs font-medium text-blue-600 hover:underline">Lihat Semua →</a>
                </div>

                <x-table :headers="['Cabang', 'Kota', 'Total Produk', 'Stok Menipis', 'Status']">
                    @forelse ($branches as $branch)
                        @php
                            $lowStockCount = $branch->stocks()->where('quantity', '<=', 5)->count();
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 text-sm font-medium text-slate-800">
                                {{ $branch->name }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-500">
                                {{ $branch->city }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700 font-medium">
                                {{ $branch->stocks_count ?? $branch->stocks()->count() }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                @if ($lowStockCount > 0)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        {{ $lowStockCount }} item
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">Aman</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm">
                                <x-badge type="success">Aktif</x-badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-400">
                                Belum ada data cabang.
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </div>

            {{-- Transaksi Terbaru --}}
            <div>
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-slate-900">Transaksi Terbaru</h2>
                    <a href="{{ route('transactions.index') }}"
                       class="text-xs font-medium text-blue-600 hover:underline">Lihat Semua →</a>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="divide-y divide-slate-100">
                        @forelse ($recentTransactions as $transaction)
                            <div class="p-4 hover:bg-slate-50 transition-colors">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-slate-800 truncate">
                                            {{ $transaction->invoice_number }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-500 truncate">
                                            {{ $transaction->branch->name ?? '-' }}
                                            ·
                                            {{ $transaction->user->name ?? '-' }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-400">
                                            {{ optional($transaction->transaction_date)->format('d M Y H:i') }}
                                        </p>
                                    </div>

                                    <div class="shrink-0 text-right">
                                        <p class="text-sm font-semibold text-slate-900">
                                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                        </p>

                                        <x-badge :type="$transaction->status === 'paid' ? 'success' : 'danger'">
                                            {{ ucfirst($transaction->status) }}
                                        </x-badge>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-sm text-slate-400">
                                Belum ada transaksi.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>