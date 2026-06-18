<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Transaksi' => route('transactions.index'),
                'Tambah Transaksi' => null,
            ]" />

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Tambah Transaksi
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Input transaksi penjualan kasir dan item produk yang dibeli pelanggan.
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('transactions.store') }}" class="space-y-6">
            @csrf

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">
                    Informasi Transaksi
                </h2>

                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    <x-form.select
                        label="Cabang"
                        name="branch_id"
                        :options="$branches->pluck('name', 'id')->toArray()"
                        placeholder="Pilih cabang"
                    />

                    <x-form.input
                        label="Tanggal Transaksi"
                        name="transaction_date"
                        type="datetime-local"
                    />

                    <x-form.select
                        label="Metode Pembayaran"
                        name="payment_method"
                        :options="[
                            'cash' => 'Cash',
                            'transfer' => 'Transfer',
                            'qris' => 'QRIS',
                        ]"
                        placeholder="Pilih metode pembayaran"
                    />

                    <x-form.input
                        label="Uang Dibayar"
                        name="paid_amount"
                        type="number"
                        min="0"
                        placeholder="0"
                    />
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            Item Transaksi
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Tambahkan produk yang dibeli. Minimal satu item transaksi.
                        </p>
                    </div>

                    <button type="button"
                            onclick="addTransactionItem()"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Tambah Item
                    </button>
                </div>

                <div id="items-wrapper" class="mt-5 space-y-4">
                    <div class="transaction-item grid gap-4 rounded-lg border border-slate-200 bg-slate-50 p-4 md:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700">
                                Produk
                            </label>

                            <select name="items[0][product_id]"
                                    class="product-select block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                                    required>
                                <option value="">Pilih produk</option>

                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}">
                                        {{ $product->name }} - Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700">
                                Jumlah
                            </label>

                            <input name="items[0][quantity]"
                                   type="number"
                                   min="1"
                                   value="1"
                                   class="quantity-input block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                                   required>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700">
                                Harga
                            </label>

                            <input name="items[0][price]"
                                   type="number"
                                   min="0"
                                   value="0"
                                   class="price-input block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                                   required>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700">
                                Subtotal
                            </label>

                            <input type="text"
                                   value="0"
                                   class="subtotal-input block w-full rounded-lg border border-slate-300 bg-slate-100 px-3 py-2 text-sm text-slate-600"
                                   readonly>
                        </div>
                    </div>
                </div>

                @error('items')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                    <div>
                        <p class="text-sm text-slate-500">Estimasi Total Transaksi</p>
                        <p id="grand-total" class="mt-1 text-2xl font-bold text-slate-900">
                            Rp 0
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('transactions.index') }}"
                           class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                            Batal
                        </a>

                        <x-button-primary>
                            Simpan Transaksi
                        </x-button-primary>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let itemIndex = 1;

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        }

        function calculateTotals() {
            let total = 0;

            document.querySelectorAll('.transaction-item').forEach((item) => {
                const quantity = Number(item.querySelector('.quantity-input').value || 0);
                const price = Number(item.querySelector('.price-input').value || 0);
                const subtotal = quantity * price;

                item.querySelector('.subtotal-input').value = formatRupiah(subtotal);
                total += subtotal;
            });

            document.getElementById('grand-total').textContent = 'Rp ' + formatRupiah(total);
        }

        function bindItemEvents(item) {
            const productSelect = item.querySelector('.product-select');
            const quantityInput = item.querySelector('.quantity-input');
            const priceInput = item.querySelector('.price-input');

            productSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                priceInput.value = selectedOption.dataset.price || 0;
                calculateTotals();
            });

            quantityInput.addEventListener('input', calculateTotals);
            priceInput.addEventListener('input', calculateTotals);
        }

        function addTransactionItem() {
            const wrapper = document.getElementById('items-wrapper');
            const firstItem = wrapper.querySelector('.transaction-item');
            const newItem = firstItem.cloneNode(true);

            newItem.querySelectorAll('select, input').forEach((input) => {
                input.name = input.name.replace(/\[\d+\]/, '[' + itemIndex + ']');

                if (input.tagName === 'SELECT') {
                    input.value = '';
                } else if (input.classList.contains('quantity-input')) {
                    input.value = 1;
                } else {
                    input.value = 0;
                }
            });

            wrapper.appendChild(newItem);
            bindItemEvents(newItem);
            itemIndex++;
            calculateTotals();
        }

        document.querySelectorAll('.transaction-item').forEach(bindItemEvents);
        calculateTotals();
    </script>
</x-app-layout>