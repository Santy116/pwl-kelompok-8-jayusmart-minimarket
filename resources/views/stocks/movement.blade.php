<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Stok Barang' => route('stocks.index'),
                'Pergerakan Stok' => null,
            ]" />

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Pergerakan Stok
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Halaman ini disiapkan untuk pengembangan fitur riwayat stok masuk, stok keluar, dan adjustment.
                </p>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 text-sm text-slate-600 shadow-sm">
            Fitur pergerakan stok saat ini sudah tersedia pada halaman Manajemen Stok Barang.
        </div>

        <a href="{{ route('stocks.index') }}"
           class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
            Kembali ke Stok Barang
        </a>
    </div>
</x-app-layout>