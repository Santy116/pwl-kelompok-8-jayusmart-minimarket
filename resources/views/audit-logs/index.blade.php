<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-semibold text-gray-900">Audit Log</h1>
            <p class="text-sm text-gray-500">
                Riwayat aktivitas pengguna pada sistem Jayusmart Minimarket.
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <form method="GET" class="grid gap-4 md:grid-cols-5">
                <div>
                    <label class="text-sm font-medium text-gray-700">Aksi</label>
                    <select name="action" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                        <option value="">Semua</option>
                        <option value="create" @selected(request('action') === 'create')>Create</option>
                        <option value="update" @selected(request('action') === 'update')>Update</option>
                        <option value="delete" @selected(request('action') === 'delete')>Delete</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Tabel</label>
                    <input
                        type="text"
                        name="table_name"
                        value="{{ request('table_name') }}"
                        class="mt-1 w-full rounded-lg border-gray-300 text-sm"
                        placeholder="transactions"
                    >
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Cabang</label>
                    <select name="branch_id" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                        <option value="">Semua</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(request('branch_id') == $branch->id)>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Tanggal Awal</label>
                    <input
                        type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        class="mt-1 w-full rounded-lg border-gray-300 text-sm"
                    >
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Tanggal Akhir</label>
                    <input
                        type="date"
                        name="end_date"
                        value="{{ request('end_date') }}"
                        class="mt-1 w-full rounded-lg border-gray-300 text-sm"
                    >
                </div>

                <div class="flex items-center gap-2 md:col-span-5">
                    <button
                        type="submit"
                        class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                    >
                        Filter
                    </button>

                    <a
                        href="{{ route('audit-logs.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Cabang</th>
                            <th class="px-4 py-3">Aksi</th>
                            <th class="px-4 py-3">Tabel</th>
                            <th class="px-4 py-3">Record</th>
                            <th class="px-4 py-3">IP Address</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($auditLogs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                    {{ $log->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $log->user?->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ ucfirst($log->role ?? '-') }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $log->branch?->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">
                                        {{ strtoupper($log->action) }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $log->table_name }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    #{{ $log->record_id ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $log->ip_address ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada data audit log.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $auditLogs->links() }}
        </div>
    </div>
</x-app-layout>
