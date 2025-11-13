<div class="flex items-center gap-2">
    <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded bg-blue-600 text-white hover:bg-blue-700">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
        <span>Lihat</span>
    </a>

    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded bg-yellow-600 text-white hover:bg-yellow-700">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
        </svg>
        <span>Edit</span>
    </a>

    <!-- Delete -->
    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" data-delete class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded bg-red-600 text-white hover:bg-red-700">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a2 2 0 012-2h2a2 2 0 012 2m-6 0h6" />
            </svg>
            <span>Hapus</span>
        </button>
    </form>
</div>
