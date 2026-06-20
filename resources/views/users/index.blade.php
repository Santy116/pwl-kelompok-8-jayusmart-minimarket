<x-app-layout>
    <x-slot:title>User Management</x-slot:title>

    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <p class="text-sm text-slate-500">
                Kelola akun pengguna, role, dan cabang kerja pada sistem Jayusmart.
            </p>

            <a href="{{ route('users.create') }}"
               class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                Tambah User
            </a>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">
                Filter User
            </h2>

            <form method="GET" action="{{ route('users.index') }}" class="mt-4 grid gap-4 md:grid-cols-4">
                <div>
                    <label for="search" class="mb-1 block text-sm font-medium text-slate-700">
                        Cari User
                    </label>

                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ request('search') }}"
                        placeholder="Nama atau email"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                </div>

                <div>
                    <label for="role" class="mb-1 block text-sm font-medium text-slate-700">
                        Role
                    </label>

                    <select
                        id="role"
                        name="role"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                        <option value="">Semua Role</option>

                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @selected(request('role') === $role->name)>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="branch_id" class="mb-1 block text-sm font-medium text-slate-700">
                        Cabang
                    </label>

                    <select
                        id="branch_id"
                        name="branch_id"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                        <option value="">Semua Cabang</option>

                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(request('branch_id') == $branch->id)>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Filter
                    </button>

                    <a href="{{ route('users.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <x-table :headers="['Nama', 'Email', 'Role', 'Cabang', 'Status', 'Aksi']">
            @forelse ($users as $user)
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-800">
                        {{ $user->name }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $user->email }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        @forelse ($user->roles as $role)
                            <x-badge type="info">
                                {{ ucfirst($role->name) }}
                            </x-badge>
                        @empty
                            <x-badge>
                                Belum ada role
                            </x-badge>
                        @endforelse
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $user->branch->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        <x-badge type="success">
                            Aktif
                        </x-badge>
                    </td>

                    <td class="px-4 py-3 text-sm">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('users.edit', $user) }}"
                               class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                Edit
                            </a>

                            <x-modal-delete
                                :action="route('users.destroy', $user)"
                                title="Hapus"
                                message="Apakah Anda yakin ingin menghapus user ini?"
                            />
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada data user.
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div>
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>