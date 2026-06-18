<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Stok Barang' => null,
            ]" />

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Manajemen Stok Barang
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Pantau stok produk pada setiap cabang dan catat pergerakan stok masuk, keluar, atau adjustment.
                </p>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">
                Filter Data Stok
            </h2>

            <form method="GET" action="{{ route('stocks.index') }}" class="mt-4 grid gap-4 md:grid-cols-3">
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

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Filter
                    </button>

                    <a href="{{ route('stocks.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">
                Catat Pergerakan Stok
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Gunakan form ini untuk mencatat stok masuk, stok keluar, atau penyesuaian jumlah stok.
            </p>

            <form method="POST" action="{{ route('stocks.movement.store') }}" class="mt-5 space-y-5">
                @csrf

                <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    <x-form.select
                        label="Cabang"
                        name="branch_id"
                        :options="$branches->pluck('name', 'id')->toArray()"
                        placeholder="Pilih cabang"
                    />

                    <x-form.select
                        label="Produk"
                        name="product_id"
                        :options="$products->pluck('name', 'id')->toArray()"
                        placeholder="Pilih produk"
                    />

                    <x-form.select
                        label="Jenis Pergerakan"
                        name="type"
                        :options="[
                            'in' => 'Stok Masuk',
                            'out' => 'Stok Keluar',
                            'adjustment' => 'Adjustment Stok',
                        ]"
                        placeholder="Pilih jenis"
                    />

                    <x-form.input
                        label="Jumlah"
                        name="quantity"
                        type="number"
                        min="1"
                        placeholder="0"
                    />

                    <x-form.input
                        label="Tanggal Pergerakan"
                        name="movement_date"
                        type="datetime-local"
                    />

                    <x-form.textarea
                        label="Keterangan"
                        name="description"
                        placeholder="Keterangan stok opsional"
                        rows="3"
                    />
                </div>

                <div class="flex justify-end">
                    <x-button-primary>
                        Simpan Pergerakan Stok
                    </x-button-primary>
                </div>
            </form>
        </div>

        <div>
            <div class="mb-3">
                <h2 class="text-lg font-semibold text-slate-900">
                    Data Stok Barang
                </h2>

                <p class="text-sm text-slate-500">
                    Daftar stok produk berdasarkan cabang minimarket.
                </p>
            </div>

            <x-table :headers="['Cabang', 'Produk', 'Kategori', 'Jumlah Stok', 'Minimum Stok', 'Status']">
                @forelse ($stocks as $stock)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-slate-800">
                            {{ $stock->branch->name ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-sm text-slate-700">
                            {{ $stock->product->name ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ $stock->product->category->name ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-sm text-slate-600">
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
                            Belum ada data stok.
                        </td>
                    </tr>
                @endforelse
            </x-table>

            <div class="mt-4">
                {{ $stocks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>