<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Produk' => route('products.index'),
                'Detail Produk' => null,
            ]" />

            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail Produk
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Informasi lengkap produk dan ketersediaan stok pada setiap cabang.
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('products.edit', $product) }}"
                       class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Edit Produk
                    </a>

                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-1">
                <h2 class="text-lg font-semibold text-slate-900">
                    Informasi Produk
                </h2>

                <div class="mt-5 space-y-4 text-sm">
                    <div>
                        <p class="text-slate-500">Kode Produk</p>
                        <p class="font-semibold text-slate-900">{{ $product->code }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Nama Produk</p>
                        <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Kategori</p>
                        <p class="font-semibold text-slate-900">{{ $product->category->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Satuan</p>
                        <p class="font-semibold text-slate-900">{{ $product->unit }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Harga Beli</p>
                        <p class="font-semibold text-slate-900">
                            Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Harga Jual</p>
                        <p class="font-semibold text-slate-900">
                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Deskripsi</p>
                        <p class="font-medium text-slate-700">
                            {{ $product->description ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="mb-3">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Stok Produk per Cabang
                    </h2>
                    <p class="text-sm text-slate-500">
                        Menampilkan jumlah stok produk pada setiap cabang minimarket.
                    </p>
                </div>

                <x-table :headers="['Cabang', 'Kota', 'Jumlah Stok', 'Minimum Stok', 'Status']">
                    @forelse ($product->stocks as $stock)
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-slate-800">
                                {{ $stock->branch->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-600">
                                {{ $stock->branch->city ?? '-' }}
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
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">
                                Belum ada data stok untuk produk ini.
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </div>
        </div>
    </div>
</x-app-layout>