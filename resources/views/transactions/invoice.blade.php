<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Transaksi' => route('transactions.index'),
                'Detail Transaksi' => route('transactions.show', $transaction),
                'Invoice' => null,
            ]" />

            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Invoice Transaksi
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Bukti transaksi penjualan Jayusmart Minimarket.
                    </p>
                </div>

                <div class="flex gap-2">
                    <button onclick="window.print()"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Cetak Invoice
                    </button>

                    <a href="{{ route('transactions.show', $transaction) }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-4xl rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col justify-between gap-4 border-b border-slate-200 pb-6 md:flex-row">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">
                        Jayusmart
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Sistem Monitoring Transaksi dan Stok Minimarket
                    </p>

                    <p class="mt-3 text-sm text-slate-600">
                        {{ $transaction->branch->name ?? '-' }}
                    </p>

                    <p class="text-sm text-slate-600">
                        {{ $transaction->branch->address ?? '-' }}
                    </p>
                </div>

                <div class="text-left md:text-right">
                    <p class="text-sm text-slate-500">Nomor Invoice</p>
                    <p class="text-lg font-bold text-slate-900">
                        {{ $transaction->invoice_number }}
                    </p>

                    <p class="mt-3 text-sm text-slate-500">Tanggal</p>
                    <p class="font-semibold text-slate-800">
                        {{ optional($transaction->transaction_date)->format('d M Y H:i') }}
                    </p>
                </div>
            </div>

            <div class="grid gap-6 border-b border-slate-200 py-6 md:grid-cols-2">
                <div>
                    <p class="text-sm text-slate-500">Kasir</p>
                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $transaction->user->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Metode Pembayaran</p>
                    <p class="mt-1 font-semibold text-slate-900">
                        {{ strtoupper($transaction->payment_method) }}
                    </p>
                </div>
            </div>

            <div class="py-6">
                <x-table :headers="['Produk', 'Jumlah', 'Harga', 'Subtotal']">
                    @foreach ($transaction->transactionItems as $item)
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
                    @endforeach
                </x-table>
            </div>

            <div class="flex justify-end border-t border-slate-200 pt-6">
                <div class="w-full max-w-sm space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Total</span>
                        <span class="font-semibold text-slate-900">
                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Uang Dibayar</span>
                        <span class="font-semibold text-slate-900">
                            Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between border-t border-slate-200 pt-3 text-base">
                        <span class="font-semibold text-slate-700">Kembalian</span>
                        <span class="font-bold text-slate-900">
                            Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center text-sm text-slate-500">
                Terima kasih telah berbelanja di Jayusmart.
            </div>
        </div>
    </div>
</x-app-layout>