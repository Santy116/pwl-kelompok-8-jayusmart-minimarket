<x-app-layout>
    <x-slot:title>Produk</x-slot:title>

    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <p class="text-sm text-slate-500">
                Kelola data produk minimarket, kategori, satuan, harga beli, dan harga jual.
            </p>

            <a href="{{ route('products.create') }}"
               class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                Tambah Produk
            </a>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <form method="GET" action="{{ route('products.index') }}" class="grid gap-4 md:grid-cols-3">
                <div>
                    <label for="search" class="mb-1 block text-sm font-medium text-slate-700">
                        Cari Produk
                    </label>

                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ request('search') }}"
                        placeholder="Kode atau nama produk"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                </div>

                <div>
                    <label for="category_id" class="mb-1 block text-sm font-medium text-slate-700">
                        Kategori
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                        <option value="">Semua Kategori</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Filter
                    </button>

                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <x-table :headers="['Kode', 'Nama Produk', 'Kategori', 'Satuan', 'Harga Beli', 'Harga Jual', 'Aksi']">
            @forelse ($products as $product)
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-800">
                        {{ $product->code }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-700">
                        {{ $product->name }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $product->category->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $product->unit }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('products.show', $product) }}"
                               class="text-sm font-medium text-slate-600 hover:text-slate-900">
                                Detail
                            </a>

                            <a href="{{ route('products.edit', $product) }}"
                               class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                Edit
                            </a>

                            <x-modal-delete
                                :action="route('products.destroy', $product)"
                                title="Hapus"
                                message="Apakah Anda yakin ingin menghapus produk ini?"
                            />
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada data produk.
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div>
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>