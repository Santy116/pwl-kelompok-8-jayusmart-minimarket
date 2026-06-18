<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'User Management' => route('users.index'),
                'Tambah User' => null,
            ]" />

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Tambah User
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Tambahkan akun pengguna baru dan tentukan role serta cabang kerja.
                </p>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <x-form.input
                        label="Nama"
                        name="name"
                        placeholder="Masukkan nama user"
                    />

                    <x-form.input
                        label="Email"
                        name="email"
                        type="email"
                        placeholder="user@example.com"
                    />

                    <x-form.input
                        label="Password"
                        name="password"
                        type="password"
                        placeholder="Minimal 8 karakter"
                    />

                    <x-form.input
                        label="Konfirmasi Password"
                        name="password_confirmation"
                        type="password"
                        placeholder="Ulangi password"
                    />

                    <x-form.select
                        label="Role"
                        name="role"
                        :options="$roles->pluck('name', 'name')->map(fn ($role) => ucfirst($role))->toArray()"
                        placeholder="Pilih role"
                    />

                    <x-form.select
                        label="Cabang"
                        name="branch_id"
                        :options="$branches->pluck('name', 'id')->toArray()"
                        placeholder="Pilih cabang"
                    />
                </div>

                <div class="rounded-lg bg-slate-50 p-4 text-sm text-slate-600">
                    <p class="font-semibold text-slate-800">Catatan:</p>
                    <p class="mt-1">
                        Role owner boleh tidak memiliki cabang. Role manager, supervisor, cashier, dan warehouse sebaiknya memiliki cabang.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('users.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Batal
                    </a>

                    <x-button-primary>
                        Simpan User
                    </x-button-primary>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>