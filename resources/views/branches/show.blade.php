<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Cabang' => route('branches.index'),
                'Detail Cabang' => null,
            ]" />

            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail Cabang
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Informasi cabang dan ringkasan aktivitas operasional minimarket.
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('branches.edit', $branch) }}"
                       class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Edit Cabang
                    </a>

                    <a href="{{ route('branches.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-1">
                <h2 class="text-lg font-semibold text-slate-900">
                    Informasi Cabang
                </h2>

                <div class="mt-5 space-y-4 text-sm">
                    <div>
                        <p class="text-slate-500">Nama Cabang</p>
                        <p class="font-semibold text-slate-900">
                            {{ $branch->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Kota</p>
                        <p class="font-semibold text-slate-900">
                            {{ $branch->city }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Telepon</p>
                        <p class="font-semibold text-slate-900">
                            {{ $branch->phone ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Alamat</p>
                        <p class="font-medium text-slate-700">
                            {{ $branch->address }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="grid gap-4 md:grid-cols-2">
                    <x-stat-card
                        title="Total User"
                        :value="$branch->users_count ?? 0"
                        description="User pada cabang ini"
                    />

                    <x-stat-card
                        title="Data Stok"
                        :value="$branch->stocks_count ?? 0"
                        description="Produk memiliki data stok"
                    />

                    <x-stat-card
                        title="Total Transaksi"
                        :value="$branch->transactions_count ?? 0"
                        description="Transaksi cabang"
                    />

                    <x-stat-card
                        title="Pergerakan Stok"
                        :value="$branch->stock_movements_count ?? 0"
                        description="Histori stok cabang"
                    />
                </div>

                <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Status Cabang
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Cabang ini aktif digunakan dalam sistem monitoring transaksi dan stok Jayusmart.
                    </p>

                    <div class="mt-4">
                        <x-badge type="success">
                            Aktif
                        </x-badge>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>