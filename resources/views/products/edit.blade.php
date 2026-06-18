<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Produk' => route('products.index'),
                'Edit Produk' => null,
            ]" />

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Edit Produk
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Perbarui data produk, kategori, satuan, harga beli, dan harga jual.
                </p>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-5 md:grid-cols-2">
                    <x-form.select
                        label="Kategori"
                        name="category_id"
                        :options="$categories->pluck('name', 'id')->toArray()"
                        :selected="$product->category_id"
                        placeholder="Pilih kategori"
                    />

                    <x-form.input
                        label="Kode Produk"
                        name="code"
                        :value="$product->code"
                        placeholder="Contoh: PRD001"
                    />

                    <x-form.input
                        label="Nama Produk"
                        name="name"
                        :value="$product->name"
                        placeholder="Contoh: Beras Ramos 5kg"
                    />

                    <x-form.input
                        label="Satuan"
                        name="unit"
                        :value="$product->unit"
                        placeholder="Contoh: pcs, kg, liter"
                    />

                    <x-form.input
                        label="Harga Beli"
                        name="purchase_price"
                        type="number"
                        :value="$product->purchase_price"
                        min="0"
                    />

                    <x-form.input
                        label="Harga Jual"
                        name="selling_price"
                        type="number"
                        :value="$product->selling_price"
                        min="0"
                    />
                </div>

                <x-form.textarea
                    label="Deskripsi"
                    name="description"
                    :value="$product->description"
                    placeholder="Deskripsi produk opsional"
                />

                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Batal
                    </a>

                    <x-button-primary>
                        Simpan Perubahan
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>