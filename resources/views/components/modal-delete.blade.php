@props([
    'action',
    'title' => 'Hapus',
    'message' => 'Apakah Anda yakin ingin menghapus data ini?',
])

<form method="POST" action="{{ $action }}" class="inline">
    @csrf
    @method('DELETE')

    <button type="submit"
            onclick="return confirm('{{ $message }}')"
            class="text-sm font-medium text-red-600 hover:text-red-800">
        {{ $title }}
    </button>
</form>