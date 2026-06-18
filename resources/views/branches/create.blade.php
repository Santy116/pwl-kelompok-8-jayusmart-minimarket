<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Cabang' => route('branches.index'),
                'Tambah Cabang' => null,
            ]" />

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Tambah Cabang
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Tambahkan data cabang baru untuk kebutuhan monitoring transaksi dan stok.
                </p>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('branches.store') }}" class="space-y-5">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <x-form.input
                        label="Nama Cabang"
                        name="name"
                        placeholder="Contoh: Jayusmart Bandung"
                    />

                    <x-form.input
                        label="Kota"
                        name="city"
                        placeholder="Contoh: Bandung"
                    />

                    <x-form.input
                        label="Telepon"
                        name="phone"
                        placeholder="Contoh: 0221234567"
                    />
                </div>

                <x-form.textarea
                    label="Alamat"
                    name="address"
                    placeholder="Masukkan alamat lengkap cabang"
                />

                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('branches.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Batal
                    </a>

                    <x-button-primary>
                        Simpan Cabang
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>