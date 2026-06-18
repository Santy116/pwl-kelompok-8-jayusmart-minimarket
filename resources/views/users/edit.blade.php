<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'User Management' => route('users.index'),
                'Edit User' => null,
            ]" />

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Edit User
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Perbarui akun pengguna, role, dan cabang kerja.
                </p>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-5 md:grid-cols-2">
                    <x-form.input
                        label="Nama"
                        name="name"
                        :value="$user->name"
                        placeholder="Masukkan nama user"
                    />

                    <x-form.input
                        label="Email"
                        name="email"
                        type="email"
                        :value="$user->email"
                        placeholder="user@example.com"
                    />

                    <x-form.input
                        label="Password Baru"
                        name="password"
                        type="password"
                        placeholder="Kosongkan jika tidak diubah"
                    />

                    <x-form.input
                        label="Konfirmasi Password Baru"
                        name="password_confirmation"
                        type="password"
                        placeholder="Ulangi password baru"
                    />

                    <x-form.select
                        label="Role"
                        name="role"
                        :options="$roles->pluck('name', 'name')->map(fn ($role) => ucfirst($role))->toArray()"
                        :selected="$user->roles->first()?->name"
                        placeholder="Pilih role"
                    />

                    <x-form.select
                        label="Cabang"
                        name="branch_id"
                        :options="$branches->pluck('name', 'id')->toArray()"
                        :selected="$user->branch_id"
                        placeholder="Pilih cabang"
                    />
                </div>

                <div class="rounded-lg bg-slate-50 p-4 text-sm text-slate-600">
                    <p class="font-semibold text-slate-800">Catatan:</p>
                    <p class="mt-1">
                        Kosongkan password jika tidak ingin mengubah password user.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('users.index') }}"
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