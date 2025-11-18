<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Notifikasi</h2>
                <p class="mt-1 text-sm text-gray-500">Semua pemberitahuan untuk Anda</p>
            </div>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium text-green-800">{{ $message }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            @forelse ($notifications as $notification)
                <a href="{{ route('notifications.mark-read', $notification->id) }}" 
                   class="block border-b border-gray-200 hover:bg-gray-50 transition {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @php
                                    $icon = match($notification->data['icon'] ?? 'bell') {
                                        'check-circle' => '✓',
                                        'clock' => '⏱',
                                        'x-circle' => '✕',
                                        default => '🔔',
                                    };
                                    $bgColor = match($notification->data['color'] ?? 'gray') {
                                        'green' => 'bg-green-100 text-green-600',
                                        'blue' => 'bg-blue-100 text-blue-600',
                                        'red' => 'bg-red-100 text-red-600',
                                        'yellow' => 'bg-yellow-100 text-yellow-600',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <div class="w-12 h-12 rounded-full {{ $bgColor }} flex items-center justify-center text-xl font-bold">
                                    {{ $icon }}
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-gray-900">
                                        {{ $notification->data['title'] ?? 'Notifikasi' }}
                                    </h3>
                                    @if(!$notification->read_at)
                                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Baru
                                        </span>
                                    @endif
                                </div>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <p class="mt-2 text-xs text-gray-400">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda belum memiliki notifikasi apapun</p>
                </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
