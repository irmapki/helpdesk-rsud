<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RSUD RAA Soewondo Pati') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800">
        <div class="flex h-screen overflow-hidden">
            
            <!-- SIDEBAR UTAMA KIRI -->
            <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between flex-shrink-0 shadow-sm">
                <div>
                    <!-- Logo / Header Sidebar -->
                    <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-700 flex items-center justify-center text-white shadow-md shadow-emerald-600/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-xs font-bold text-gray-900 tracking-wider">RSUD RAA SOEWONDO</h1>
                            <p class="text-[10px] text-emerald-600 font-semibold">IT HELPDESK &amp; TICKETING</p>
                        </div>
                    </div>

                    <!-- Menu Utama (Dinamis Berdasarkan Role) -->
                    <div class="p-4 space-y-6">
                        
                        {{-- MENU KHUSUS ADMIN (Triage & Dispatch) --}}
                        @if(request()->routeIs('admin.*'))
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 px-3">Menu Utama Admin</p>
                                <nav class="space-y-1.5">
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        <span>Dashboard Admin</span>
                                    </a>
                                    <a href="{{ route('admin.tickets.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.tickets.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"></path></svg>
                                        <span>Manajemen &amp; Triage Tiket</span>
                                    </a>
                                </nav>
                            </div>

                        {{-- MENU KHUSUS SUPERADMIN --}}
                        @elseif(request()->routeIs('superadmin.*'))
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 px-3">Menu Super Admin</p>
                                <nav class="space-y-1.5">
                                    <a href="{{ route('superadmin.dashboard') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        <span>Dashboard Super Admin</span>
                                    </a>
                                    <a href="{{ route('superadmin.users.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.users.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <span>Kelola User</span>
                                    </a>
                                    <a href="{{ route('superadmin.technicians.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.technicians.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                        <span>Data Teknisi</span>
                                    </a>
                                    <a href="{{ route('superadmin.units.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.units.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <span>Master Unit RSUD</span>
                                    </a>
                                    <a href="{{ route('superadmin.categories.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.categories.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                        <span>Master Kategori</span>
                                    </a>
                                    <a href="{{ route('superadmin.priorities.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.priorities.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>SLA &amp; Prioritas</span>
                                    </a>
                                    <a href="{{ route('superadmin.roles.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.roles.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        <span>Kelola Role</span>
                                    </a>
                                </nav>
                            </div>

                        {{-- MENU KHUSUS TEKNISI --}}
                        @elseif(request()->routeIs('teknisi.*'))
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 px-3">Menu Utama</p>
                                <nav class="space-y-1.5">
                                    <a href="{{ route('teknisi.dashboard') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('teknisi.dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"></path></svg>
                                        <span>Tiket Saya</span>
                                    </a>
                                    <a href="{{ route('teknisi.riwayat') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('teknisi.riwayat') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>Riwayat Penanganan</span>
                                    </a>
                                </nav>
                            </div>

                        {{-- MENU KHUSUS SUPERVISOR --}}
                        @elseif(request()->routeIs('supervisor.*'))
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 px-3">Menu Utama</p>
                                <nav class="space-y-1.5">
                                    <a href="{{ route('supervisor.dashboard') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('supervisor.dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        <span>Dashboard</span>
                                    </a>
                                    <a href="#" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-50 hover:text-emerald-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        <span>Monitoring SLA</span>
                                    </a>
                                    <a href="#" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-50 hover:text-emerald-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span>Laporan Tiket</span>
                                    </a>
                                </nav>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Tombol Keluar di Bawah -->
                <div class="p-4 border-t border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2.5 px-3 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Keluar Sistem</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- KONTEN UTAMA DI KANAN -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                
                <!-- TOP HEADER -->
                <header class="bg-white shadow-sm z-10 flex items-center justify-between h-20 px-8 border-b border-gray-200 flex-shrink-0">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            @if(request()->routeIs('admin.*'))
                                Dashboard Admin (Triage &amp; Dispatch)
                            @elseif(request()->routeIs('superadmin.*'))
                                Dashboard Super Admin RSUD
                            @elseif(request()->routeIs('supervisor.*'))
                                Dashboard Supervisor IT
                            @else
                                Dashboard Sistem
                            @endif
                        </h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                            <span class="w-2 h-2 mr-1.5 bg-emerald-500 rounded-full animate-pulse"></span> 
                            {{ request()->routeIs('supervisor.*') ? 'SLA Terjaga' : 'Sistem Aktif' }}
                        </span>

                        <!-- Profil User -->
                        <div class="flex items-center space-x-2.5 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-200 shadow-sm">
                            <div class="w-7 h-7 bg-emerald-600 rounded-lg flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="text-left">
                                <span class="block text-xs font-bold text-gray-800 leading-tight">{{ Auth::user()->name ?? 'User' }}</span>
                                <span class="block text-[10px] text-gray-500 leading-tight">
                                    @if(request()->routeIs('admin.*')) Admin IT
                                    @elseif(request()->routeIs('superadmin.*')) Super Admin
                                    @elseif(request()->routeIs('supervisor.*')) Supervisor IT
                                    @else Teknisi - Divisi IT
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- MAIN CONTENT AREA -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-8 bg-gray-50">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>