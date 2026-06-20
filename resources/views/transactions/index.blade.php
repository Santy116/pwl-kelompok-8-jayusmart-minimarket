<x-app-layout>
    <x-slot:title>Transaksi</x-slot:title>

    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <p class="text-sm text-slate-500">
                Kelola dan pantau transaksi penjualan pada setiap cabang Jayusmart.
            </p>

            <a href="{{ route('transactions.create') }}"
               class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                Tambah Transaksi
            </a>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">
                Filter Transaksi
            </h2>

            <form method="GET" action="{{ route('transactions.index') }}" class="mt-4 grid gap-4 md:grid-cols-4">
                <div>
                    <label for="branch_id" class="mb-1 block text-sm font-medium text-slate-700">
                        Cabang
                    </label>

                    <select
                        id="branch_id"
                        name="branch_id"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                        <option value="">Semua Cabang</option>

                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(request('branch_id') == $branch->id)>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="start_date" class="mb-1 block text-sm font-medium text-slate-700">
                        Tanggal Mulai
                    </label>

                    <input
                        id="start_date"
                        name="start_date"
                        type="date"
                        value="{{ request('start_date') }}"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                </div>

                <div>
                    <label for="end_date" class="mb-1 block text-sm font-medium text-slate-700">
                        Tanggal Akhir
                    </label>

                    <input
                        id="end_date"
                        name="end_date"
                        type="date"
                        value="{{ request('end_date') }}"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Filter
                    </button>

                    <a href="{{ route('transactions.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <x-table :headers="['Invoice', 'Tanggal', 'Cabang', 'Kasir', 'Total', 'Metode', 'Status', 'Aksi']">
            @forelse ($transactions as $transaction)
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-800">
                        {{ $transaction->invoice_number }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ optional($transaction->transaction_date)->format('d M Y H:i') }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $transaction->branch->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $transaction->user->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm font-semibold text-slate-800">
                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ strtoupper($transaction->payment_method) }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        @if ($transaction->status === 'paid')
                            <x-badge type="success">Paid</x-badge>
                        @else
                            <x-badge type="danger">Cancelled</x-badge>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-sm">
                        <a href="{{ route('transactions.show', $transaction) }}"
                           class="font-medium text-blue-600 hover:text-blue-800">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada data transaksi.
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div>
            {{ $transactions->links() }}
        </div>
    </div>
</x-app-layout>