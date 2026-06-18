<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Cabang' => route('branches.index'),
                'Edit Cabang' => null,
            ]" />

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Edit Cabang
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Perbarui data cabang minimarket Jayusmart.
                </p>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('branches.update', $branch) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-5 md:grid-cols-2">
                    <x-form.input
                        label="Nama Cabang"
                        name="name"
                        :value="$branch->name"
                        placeholder="Contoh: Jayusmart Bandung"
                    />

                    <x-form.input
                        label="Kota"
                        name="city"
                        :value="$branch->city"
                        placeholder="Contoh: Bandung"
                    />

                    <x-form.input
                        label="Telepon"
                        name="phone"
                        :value="$branch->phone"
                        placeholder="Contoh: 0221234567"
                    />
                </div>

                <x-form.textarea
                    label="Alamat"
                    name="address"
                    :value="$branch->address"
                    placeholder="Masukkan alamat lengkap cabang"
                />

                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('branches.index') }}"
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