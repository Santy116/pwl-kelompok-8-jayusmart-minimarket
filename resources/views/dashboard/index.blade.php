<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Dashboard' => null,
            ]" />

            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Dashboard
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Monitoring transaksi, stok barang, dan performa cabang Jayusmart.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('reports.transactions') }}"
                       class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Laporan Transaksi
                    </a>

                    <a href="{{ route('reports.stocks') }}"
                       class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Laporan Stok
                    </a>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            <x-stat-card
                title="Total Cabang"
                :value="$totalBranches ?? '-'"
                description="Cabang terdaftar"
            />

            <x-stat-card
                title="Transaksi Hari Ini"
                :value="$todayTransactions ?? 0"
                description="Jumlah transaksi"
            />

            <x-stat-card
                title="Total Pendapatan"
                value="Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}"
                description="Transaksi berstatus paid"
            />

            <x-stat-card
                title="Total Produk"
                :value="$totalProducts ?? 0"
                description="Produk tersedia"
            />

            <x-stat-card
                title="Stok Menipis"
                :value="$lowStocks ?? 0"
                description="Perlu pengecekan"
            />
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2">
                <div class="mb-3">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Ringkasan Cabang
                    </h2>
                    <p class="text-sm text-slate-500">
                        Data cabang dan aktivitas transaksi/stok.
                    </p>
                </div>

                <x-table :headers="['Cabang', 'Kota', 'Transaksi', 'Data Stok', 'Status']">
                    @forelse ($branches as $branch)
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-slate-800">
                                {{ $branch->name }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-600">
                                {{ $branch->city }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-600">
                                {{ $branch->transactions_count ?? $branch->transactions()->count() }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-600">
                                {{ $branch->stocks_count ?? $branch->stocks()->count() }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                <x-badge type="success">
                                    Aktif
                                </x-badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">
                                Belum ada data cabang.
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </div>

            <div>
                <div class="mb-3">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Transaksi Terbaru
                    </h2>
                    <p class="text-sm text-slate-500">
                        Aktivitas transaksi terakhir.
                    </p>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="divide-y divide-slate-100">
                        @forelse ($recentTransactions as $transaction)
                            <div class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">
                                            {{ $transaction->invoice_number }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $transaction->branch->name ?? '-' }}
                                            ·
                                            {{ $transaction->user->name ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ optional($transaction->transaction_date)->format('d M Y H:i') }}
                                        </p>
                                    </div>

                                    <div class="text-right">
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
                            <div class="p-6 text-center text-sm text-slate-500">
                                Belum ada transaksi terbaru.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>