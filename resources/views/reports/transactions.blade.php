<x-app-layout>
    <x-slot:title>Laporan Transaksi</x-slot:title>

    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <p class="text-sm text-slate-500">
                Cetak dan pantau laporan transaksi berdasarkan cabang, tanggal, dan status pembayaran.
            </p>

            <a href="{{ route('reports.transactions.pdf', request()->query()) }}"
               class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                Cetak PDF
            </a>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">
                Filter Laporan
            </h2>

            <form method="GET" action="{{ route('reports.transactions') }}" class="mt-4 grid gap-4 md:grid-cols-5">
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

                <div>
                    <label for="status" class="mb-1 block text-sm font-medium text-slate-700">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                        <option value="">Semua Status</option>
                        <option value="paid" @selected(request('status') === 'paid')>Paid</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Filter
                    </button>

                    <a href="{{ route('reports.transactions') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <x-table :headers="['Invoice', 'Tanggal', 'Kasir', 'Cabang', 'Total', 'Status']">
            @forelse ($transactions as $transaction)
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-800">
                        {{ $transaction->invoice_number }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ optional($transaction->transaction_date)->format('d M Y H:i') }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $transaction->user->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $transaction->branch->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm font-semibold text-slate-800">
                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        @if ($transaction->status === 'paid')
                            <x-badge type="success">Paid</x-badge>
                        @else
                            <x-badge type="danger">Cancelled</x-badge>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada data laporan transaksi.
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div>
            {{ $transactions->links() }}
        </div>
    </div>
</x-app-layout>