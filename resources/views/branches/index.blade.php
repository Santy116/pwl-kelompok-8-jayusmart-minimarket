<x-app-layout>
    <div class="space-y-6">
        <div>
            <x-breadcrumb :items="[
                'Cabang' => null,
            ]" />

            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Manajemen Cabang
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Kelola data cabang minimarket Jayusmart di beberapa kota berbeda.
                    </p>
                </div>

                <a href="{{ route('branches.create') }}"
                   class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                    Tambah Cabang
                </a>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('branches.index') }}" class="grid gap-4 md:grid-cols-3">
                <div class="md:col-span-2">
                    <label for="search" class="mb-1 block text-sm font-medium text-slate-700">
                        Cari Cabang
                    </label>

                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama cabang atau kota"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        Filter
                    </button>

                    <a href="{{ route('branches.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <x-table :headers="['Nama Cabang', 'Kota', 'Alamat', 'Telepon', 'Aksi']">
            @forelse ($branches as $branch)
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-800">
                        {{ $branch->name }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $branch->city }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $branch->address }}
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        {{ $branch->phone ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('branches.show', $branch) }}"
                               class="text-sm font-medium text-slate-600 hover:text-slate-900">
                                Detail
                            </a>

                            <a href="{{ route('branches.edit', $branch) }}"
                               class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                Edit
                            </a>

                            <x-modal-delete
                                :action="route('branches.destroy', $branch)"
                                title="Hapus"
                                message="Apakah Anda yakin ingin menghapus cabang ini?"
                            />
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada data cabang.
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div>
            {{ $branches->links() }}
        </div>
    </div>
</x-app-layout>