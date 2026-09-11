<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links based on Role -->
                @auth
                    @php
                        $roleName = optional(Auth::user()->role)->name ?? '';
                    @endphp

                    <div class="hidden space-x-2 lg:space-x-4 sm:-my-px sm:ms-8 sm:flex">
                        @if ($roleName === 'super_admin')
                            <x-nav-link :href="route('superadmin.dashboard')" :active="request()->routeIs('superadmin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('superadmin.users.index')" :active="request()->routeIs('superadmin.users.*')">
                                {{ __('Kelola User') }}
                            </x-nav-link>
                            <x-nav-link :href="route('superadmin.roles.index')" :active="request()->routeIs('superadmin.roles.*')">
                                {{ __('Role') }}
                            </x-nav-link>
                            <x-nav-link :href="route('superadmin.categories.index')" :active="request()->routeIs('superadmin.categories.*')">
                                {{ __('Kategori Tiket') }}
                            </x-nav-link>
                            <x-nav-link :href="route('superadmin.priorities.index')" :active="request()->routeIs('superadmin.priorities.*')">
                                {{ __('Prioritas & SLA') }}
                            </x-nav-link>
                            <x-nav-link :href="route('superadmin.units.index')" :active="request()->routeIs('superadmin.units.*')">
                                {{ __('Unit / Bagian') }}
                            </x-nav-link>
                            <x-nav-link :href="route('superadmin.technicians.index')" :active="request()->routeIs('superadmin.technicians.*')">
                                {{ __('Data Teknisi') }}
                            </x-nav-link>
                        @elseif ($roleName === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.tickets.index')" :active="request()->routeIs('admin.tickets.*')">
                                {{ __('Tiket Masuk') }}
                            </x-nav-link>
                        @elseif ($roleName === 'teknisi')
                            <x-nav-link :href="route('teknisi.dashboard')" :active="request()->routeIs('teknisi.dashboard')">
                                {{ __('Dashboard Teknisi') }}
                            </x-nav-link>
                        @elseif ($roleName === 'supervisor')
                            <x-nav-link :href="route('supervisor.dashboard')" :active="request()->routeIs('supervisor.dashboard')">
                                {{ __('Dashboard Supervisor') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Settings & Quick Links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                <a href="{{ route('guest.landing') }}" target="_blank" class="inline-flex items-center text-xs text-gray-500 hover:text-teal-600 dark:text-gray-400 dark:hover:text-teal-300 font-medium px-2.5 py-1.5 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Portal Pengaduan
                </a>

                <!-- Dropdown Notifikasi Lonceng -->
                @auth
                <div class="relative" x-data="{ notificationOpen: false }">
                    <button @click="notificationOpen = !notificationOpen" class="relative p-2 text-gray-500 hover:text-teal-600 dark:text-gray-400 dark:hover:text-teal-300 focus:outline-none transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        
                        @if(method_exists(Auth::user(), 'unreadNotifications') && Auth::user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] text-white font-bold">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="notificationOpen" @click.away="notificationOpen = false" class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl py-2 z-50" style="display: none;">
                        <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <span class="font-bold text-xs text-gray-700 dark:text-gray-300 uppercase">Notifikasi Tiket Masuk</span>
                            <span class="text-[10px] text-teal-600 dark:text-teal-400 font-semibold">{{ method_exists(Auth::user(), 'unreadNotifications') ? Auth::user()->unreadNotifications->count() : 0 }} Baru</span>
                        </div>

                        <div class="max-h-72 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
                            @if(method_exists(Auth::user(), 'notifications'))
                                @forelse(Auth::user()->notifications as $notification)
                                    <div class="p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition flex items-start justify-between gap-2 {{ $notification->read_at ? 'opacity-60' : 'bg-teal-50/30 dark:bg-teal-900/10' }}">
                                        <a href="{{ $notification->data['url'] ?? '#' }}" 
                                           @click.prevent="window.location.href='{{ $notification->data['url'] ?? '#' }}'"
                                           class="flex-1 text-xs text-gray-800 dark:text-gray-200 cursor-pointer">
                                            <p class="font-bold text-teal-700 dark:text-teal-400">{{ $notification->data['ticket_number'] ?? 'Info' }}</p>
                                            <p>{{ $notification->data['message'] ?? 'Ada pembaruan tiket.' }}</p>
                                            <span class="text-[9px] text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                        </a>

                                        @if(Route::has('notifications.destroy'))
                                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 text-xs p-1" title="Hapus Notifikasi">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2.000 2.000 0 0116.138 21H7.862a2.000 2.000 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-xs text-gray-500 dark:text-gray-400">
                                        Tidak ada notifikasi baru.
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>
                @endauth

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-gray-200 dark:border-gray-700 text-sm leading-4 font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="flex flex-col text-right me-2">
                                <span class="font-semibold text-xs text-gray-900 dark:text-white">{{ Auth::user()->name ?? 'User' }}</span>
                                <span class="text-[10px] text-teal-600 dark:text-teal-400 uppercase font-bold">{{ optional(Auth::user()->role)->label ?? optional(Auth::user()->role)->name ?? 'User' }}</span>
                            </div>
                            <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile Saya') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('Keluar (Log Out)') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger for Mobile -->
            <div class="-me-1 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg">
        @auth
            @php $roleName = optional(Auth::user()->role)->name ?? ''; @endphp
            <div class="pt-2 pb-3 space-y-1">
                @if ($roleName === 'super_admin')
                    <x-responsive-nav-link :href="route('superadmin.dashboard')" :active="request()->routeIs('superadmin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('superadmin.users.index')" :active="request()->routeIs('superadmin.users.*')">
                        {{ __('Kelola User') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('superadmin.roles.index')" :active="request()->routeIs('superadmin.roles.*')">
                        {{ __('Role') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('superadmin.categories.index')" :active="request()->routeIs('superadmin.categories.*')">
                        {{ __('Kategori Tiket') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('superadmin.priorities.index')" :active="request()->routeIs('superadmin.priorities.*')">
                        {{ __('Prioritas & SLA') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('superadmin.units.index')" :active="request()->routeIs('superadmin.units.*')">
                        {{ __('Unit / Bagian') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('superadmin.technicians.index')" :active="request()->routeIs('superadmin.technicians.*')">
                        {{ __('Data Teknisi') }}
                    </x-responsive-nav-link>
                @elseif ($roleName === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.tickets.index')" :active="request()->routeIs('admin.tickets.*')">
                        {{ __('Tiket Masuk') }}
                    </x-responsive-nav-link>
                @elseif ($roleName === 'teknisi')
                    <x-responsive-nav-link :href="route('teknisi.dashboard')" :active="request()->routeIs('teknisi.dashboard')">
                        {{ __('Dashboard Teknisi') }}
                    </x-responsive-nav-link>
                @elseif ($roleName === 'supervisor')
                    <x-responsive-nav-link :href="route('supervisor.dashboard')" :active="request()->routeIs('supervisor.dashboard')">
                        {{ __('Dashboard Supervisor') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('guest.landing')" target="_blank">
                    {{ __('Buka Portal Pengaduan') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50">
                <div class="px-4 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-sm text-gray-800 dark:text-gray-200 truncate">{{ Auth::user()->name ?? 'User' }}</div>
                        <div class="font-medium text-xs text-gray-500 truncate">{{ Auth::user()->email ?? '-' }}</div>
                    </div>
                    <span class="text-[10px] bg-teal-100 text-teal-800 dark:bg-teal-900/50 dark:text-teal-300 px-2 py-0.5 rounded font-bold uppercase shrink-0">
                        {{ optional(Auth::user()->role)->label ?? optional(Auth::user()->role)->name ?? 'User' }}
                    </span>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile Saya') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Keluar (Log Out)') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>