<div class="flex items-center gap-2">
    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded bg-blue-600 text-white hover:bg-blue-700">
        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
        </svg>
        Edit
    </a>

    <!-- Delete -->
    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" data-delete class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded bg-red-600 text-white hover:bg-red-700">
            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a2 2 0 012-2h2a2 2 0 012 2m-6 0h6" />
            </svg>
            Hapus
        </button>
    </form>
</div>


