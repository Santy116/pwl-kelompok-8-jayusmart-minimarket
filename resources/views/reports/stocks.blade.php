<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Laporan Stok' => null,
            ]" />

            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Laporan Stok
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Cetak dan pantau laporan stok barang berdasarkan cabang dan produk.
                    </p>
                </div>

                <a href="{{ route('reports.stocks.pdf', request()->query()) }}"
                   class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                    Cetak PDF
                </a>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">
                Filter Laporan
            </h2>

            <form method="GET" action="{{ route('reports.stocks') }}" class="mt-4 grid gap-4 md:grid-cols-4">
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
                    <label for="product_id" class="mb-1 block text-sm font-medium text-slate-700">
                        Produk
                    </label>

                    <select
                        id="product_id"
                        name="product_id"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                        <option value="">Semua Produk</option>

                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2 md:col-span-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Filter
                    </button>

                    <a href="{{ route('reports.stocks') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <x-table :headers="['Produk', 'Kategori', 'Cabang', 'Stok Akhir', 'Minimum Stok', 'Status']">
            @forelse ($stocks as $stock)
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-800">
                        {{ $stock->product->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $stock->product->category->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $stock->branch->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm font-semibold text-slate-800">
                        {{ $stock->quantity }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $stock->minimum_stock }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        @if ($stock->status === 'Aman')
                            <x-badge type="success">Aman</x-badge>
                        @elseif ($stock->status === 'Menipis')
                            <x-badge type="warning">Menipis</x-badge>
                        @else
                            <x-badge type="danger">Habis</x-badge>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada data laporan stok.
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div>
            {{ $stocks->links() }}
        </div>
    </div>
</x-app-layout>