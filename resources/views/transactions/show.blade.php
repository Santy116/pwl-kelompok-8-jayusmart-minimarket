<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Transaksi' => route('transactions.index'),
                'Detail Transaksi' => null,
            ]" />

            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail Transaksi
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Informasi lengkap transaksi penjualan dan item produk yang dibeli.
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('transactions.invoice', $transaction) }}"
                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Cetak Invoice
                    </a>

                    <a href="{{ route('transactions.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-1">
                <h2 class="text-lg font-semibold text-slate-900">
                    Informasi Transaksi
                </h2>

                <div class="mt-5 space-y-4 text-sm">
                    <div>
                        <p class="text-slate-500">Nomor Invoice</p>
                        <p class="font-semibold text-slate-900">
                            {{ $transaction->invoice_number }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Tanggal Transaksi</p>
                        <p class="font-semibold text-slate-900">
                            {{ optional($transaction->transaction_date)->format('d M Y H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Cabang</p>
                        <p class="font-semibold text-slate-900">
                            {{ $transaction->branch->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Kasir</p>
                        <p class="font-semibold text-slate-900">
                            {{ $transaction->user->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Metode Pembayaran</p>
                        <p class="font-semibold text-slate-900">
                            {{ strtoupper($transaction->payment_method) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Status</p>
                        <div class="mt-1">
                            @if ($transaction->status === 'paid')
                                <x-badge type="success">Paid</x-badge>
                            @else
                                <x-badge type="danger">Cancelled</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <h2 class="text-lg font-semibold text-slate-900">
                    Ringkasan Pembayaran
                </h2>

                <div class="mt-5 grid gap-4 md:grid-cols-3">
                    <div class="rounded-lg bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Total Transaksi</p>
                        <p class="mt-1 text-xl font-bold text-slate-900">
                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Uang Dibayar</p>
                        <p class="mt-1 text-xl font-bold text-slate-900">
                            Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Kembalian</p>
                        <p class="mt-1 text-xl font-bold text-slate-900">
                            Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="mb-3 text-base font-semibold text-slate-900">
                        Item Produk
                    </h3>

                    <x-table :headers="['Produk', 'Jumlah', 'Harga', 'Subtotal']">
                        @forelse ($transaction->transactionItems as $item)
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-slate-800">
                                    {{ $item->product->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-sm text-slate-600">
                                    {{ $item->quantity }}
                                </td>

                                <td class="px-4 py-3 text-sm text-slate-600">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-sm font-semibold text-slate-800">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">
                                    Belum ada item transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>