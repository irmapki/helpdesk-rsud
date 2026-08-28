<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center min-w-0">
                <!-- Logo -->
                <div class="shrink-0 flex items-center min-w-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-bold text-gray-800 dark:text-gray-100 min-w-0">
                        <div class="h-9 w-9 rounded-lg bg-teal-600 flex items-center justify-center text-white shadow-md shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[11px] sm:text-sm font-extrabold tracking-tight text-teal-700 dark:text-teal-400 truncate">HELPDESK RSUD RAA. SOEWONDO</span>
                            <span class="text-[10px] text-gray-500 dark:text-gray-400 font-normal truncate">IT Support System</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links based on Role -->
                @auth
                    @php
                        $roleName = Auth::user()->role->name ?? '';
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

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-gray-200 dark:border-gray-700 text-sm leading-4 font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="flex flex-col text-right me-2">
                                <span class="font-semibold text-xs text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-teal-600 dark:text-teal-400 uppercase font-bold">{{ Auth::user()->role->label ?? Auth::user()->role->name ?? 'User' }}</span>
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
            @php $roleName = Auth::user()->role->name ?? ''; @endphp
            <div class="pt-2 pb-3 space-y-1">
                @if ($roleName === 'super_admin')
                    <x-responsive-nav-link :href="route('superadmin.dashboard')" :active="request()->routeIs('superadmin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('superadmin.users.index')" :active="request()->routeIs('superadmin.users.*')">
                        {{ __('Kelola User') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('superadmin.roles.index')" :active="request()->routeIs('superadmin.roles.*')">
                        {{ __('Role Pengguna') }}
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

                <!-- Link Cepat ke Portal Pengaduan di Mobile -->
                <x-responsive-nav-link :href="route('guest.landing')" target="_blank">
                    {{ __('Buka Portal Pengaduan') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50">
                <div class="px-4 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-sm text-gray-800 dark:text-gray-200 truncate">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                    </div>
                    <span class="text-[10px] bg-teal-100 text-teal-800 dark:bg-teal-900/50 dark:text-teal-300 px-2 py-0.5 rounded font-bold uppercase shrink-0">
                        {{ Auth::user()->role->label ?? Auth::user()->role->name ?? 'User' }}
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