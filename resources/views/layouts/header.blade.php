<div x-data="{}" class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
    <button
        @click="window.dispatchEvent(new CustomEvent('open-mobile-sidebar')); window.dispatchEvent(new CustomEvent('toggle-desktop-sidebar'))"
        class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    <div class="flex-1 px-4 flex justify-between items-center">
        <div class="flex-1 flex">
            <div class="w-full flex md:ml-0">
                <h1 class="text-2xl font-semibold text-gray-900">
                    @if (request()->routeIs('admin.*'))
                        Admin
                    @elseif(request()->routeIs('dokter.*'))
                        Dokter
                    @elseif(request()->routeIs('pasien.*'))
                        Pasien
                    @endif
                </h1>
            </div>
        </div>
        <div class="ml-4 flex items-center md:ml-6 space-x-3">
            <!-- Notification Bell -->
            <x-dropdown align="right" width="80" contentClasses="py-1 bg-white max-h-64 overflow-y-auto">
                <x-slot name="trigger">
                    <button type="button"
                        class="relative inline-flex items-center justify-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 rounded-md transition">
                        <!-- Bell Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        <!-- Badge -->
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-600 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-3 py-2 border-b border-gray-200">
                        <p class="text-sm font-semibold text-gray-900">Notifikasi</p>
                    </div>

                    @php
                        $recentNotifications = auth()->user()->notifications()->take(5)->get();
                    @endphp

                    @forelse($recentNotifications as $notification)
                        <a href="{{ route('notifications.mark-read', $notification->id) }}"
                            class="block px-3 py-2 hover:bg-gray-50 transition {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mr-2">
                                    @php
                                        $icon = match ($notification->data['icon'] ?? 'bell') {
                                            'check-circle' => '✓',
                                            'clock' => '⏱',
                                            'x-circle' => '✕',
                                            default => '🔔',
                                        };
                                        $bgColor = match ($notification->data['color'] ?? 'gray') {
                                            'green' => 'bg-green-100 text-green-600',
                                            'blue' => 'bg-blue-100 text-blue-600',
                                            'red' => 'bg-red-100 text-red-600',
                                            'yellow' => 'bg-yellow-100 text-yellow-600',
                                            default => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <div
                                        class="w-6 h-6 rounded-full {{ $bgColor }} flex items-center justify-center text-xs font-bold">
                                        {{ $icon }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $notification->data['title'] ?? 'Notifikasi' }}
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                                        {{ Str::limit($notification->data['message'] ?? '', 80) }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-6 text-center">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <p class="mt-2 text-xs text-gray-500">Tidak ada notifikasi</p>
                        </div>
                    @endforelse

                    @if ($recentNotifications->count() > 0)
                        <div class="border-t border-gray-200">
                            <a href="{{ route('notifications.index') }}"
                                class="block px-4 py-3 text-center text-xs font-semibold text-blue-600 hover:bg-gray-50 transition">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                    @endif
                </x-slot>
            </x-dropdown>

            <!-- Profile Dropdown -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition duration-150 ease-in-out">
                        <div class="flex items-center">
                            <div
                                class="h-8 w-8 rounded-full bg-blue-700 flex items-center justify-center text-white font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500">
                                    @if (auth()->user()->hasRole('Admin'))
                                        Administrator
                                    @elseif(auth()->user()->hasRole('Dokter'))
                                        Dokter
                                    @elseif(auth()->user()->hasRole('Pasien'))
                                        Pasien
                                    @endif
                                </div>
                            </div>
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        <svg class="mr-2 h-4 w-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg class="mr-2 h-4 w-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Log Out
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</div>
