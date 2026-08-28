<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($pageTitle) ? $pageTitle . ' - ' : '' }}{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f8fafc] text-slate-800 h-full overflow-x-hidden">
        <!-- Menggunakan Alpine.js untuk mengontrol state buka/tutup sidebar -->
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden relative w-full">

            <!-- Mobile Backdrop (Overlay gelap ketika sidebar muncul di HP/Tablet) -->
            <div x-show="sidebarOpen" 
                @click="sidebarOpen = false"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-900/60 z-40 md:hidden">
            </div>

            <!-- SIDEBAR UTAMA KIRI -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
                class="fixed inset-y-0 left-0 z-50 w-72 sm:w-64 flex flex-col justify-between flex-shrink-0 overflow-hidden bg-gradient-to-br from-teal-800 via-emerald-800 to-slate-950 text-white shadow-2xl transition-transform duration-300 ease-in-out md:static md:translate-x-0 border-r border-emerald-900/30">

                {{-- Dekorasi glow samar khas login --}}
                <div class="pointer-events-none absolute -top-16 -right-16 w-64 h-64 bg-teal-400/10 rounded-full blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-24 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl"></div>

                <div class="relative z-10 flex-1 overflow-y-auto overflow-x-hidden">
                    <!-- Logo / Header Sidebar -->
                    <div class="p-4 sm:p-5 border-b border-white/10 flex items-center justify-between min-w-0">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-white flex items-center justify-center p-1 shadow-md shadow-black/20 overflow-hidden shrink-0">
                                <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-full h-full object-contain">
                            </div>
                            <div class="min-w-0">
                                <h1 class="text-xs font-black text-white tracking-wider truncate">RSUD RAA SOEWONDO</h1>
                                <p class="text-[10px] text-teal-300 font-bold uppercase tracking-wider mt-0.5 truncate">IT HELPDESK &amp; TICKETING</p>
                            </div>
                        </div>
                        <!-- Tombol Close Sidebar Khusus Mobile di dalam panel -->
                        <button @click="sidebarOpen = false" class="md:hidden text-emerald-200 hover:text-white p-2 rounded-xl bg-white/10 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Menu Utama (Dinamis Berdasarkan Role) -->
                    <div class="p-3 sm:p-4 space-y-6 min-w-0">

                        {{-- MENU KHUSUS SUPERADMIN --}}
                        @if(request()->routeIs('superadmin.*'))
                            <div class="min-w-0">
                                <p class="text-[10px] font-black text-teal-300/80 uppercase tracking-widest mb-2.5 px-3 truncate">MENU SUPER ADMIN</p>
                                <nav class="space-y-1.5 min-w-0">
                                    <a href="{{ route('superadmin.dashboard') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('superadmin.dashboard') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('superadmin.dashboard') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        <span class="truncate">Dashboard Super Admin</span>
                                    </a>
                                    <a href="{{ route('superadmin.users.index') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('superadmin.users.*') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('superadmin.users.*') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <span class="truncate">Kelola User</span>
                                    </a>
                                    <a href="{{ route('superadmin.technicians.index') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('superadmin.technicians.*') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('superadmin.technicians.*') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                        <span class="truncate">Data Teknisi</span>
                                    </a>
                                    <a href="{{ route('superadmin.units.index') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('superadmin.units.*') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('superadmin.units.*') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <span class="truncate">Master Unit RSUD</span>
                                    </a>
                                    <a href="{{ route('superadmin.categories.index') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('superadmin.categories.*') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('superadmin.categories.*') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                        <span class="truncate">Master Kategori</span>
                                    </a>
                                    <a href="{{ route('superadmin.priorities.index') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('superadmin.priorities.*') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('superadmin.priorities.*') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="truncate">SLA &amp; Prioritas</span>
                                    </a>
                                    <a href="{{ route('superadmin.roles.index') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('superadmin.roles.*') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('superadmin.roles.*') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        <span class="truncate">Kelola Role</span>
                                    </a>
                                </nav>
                            </div>

                        {{-- MENU KHUSUS ADMIN (Triage & Dispatch) --}}
                        @elseif(request()->routeIs('admin.*'))
                            <div class="min-w-0">
                                <p class="text-[10px] font-black text-teal-300/80 uppercase tracking-widest mb-2.5 px-3 truncate">MENU UTAMA ADMIN</p>
                                <nav class="space-y-1.5 min-w-0">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('admin.dashboard') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        <span class="truncate">Dashboard Admin</span>
                                    </a>
                                    <a href="{{ route('admin.tickets.index') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('admin.tickets.*') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.tickets.*') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"></path></svg>
                                        <span class="truncate">Manajemen &amp; Triage Tiket</span>
                                    </a>
                                </nav>
                            </div>

                        {{-- MENU KHUSUS TEKNISI --}}
                        @elseif(request()->routeIs('teknisi.*'))
                            <div class="min-w-0">
                                <p class="text-[10px] font-black text-teal-300/80 uppercase tracking-widest mb-2.5 px-3 truncate">MENU UTAMA TEKNISI</p>
                                <nav class="space-y-1.5 min-w-0">
                                    <a href="{{ route('teknisi.dashboard') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('teknisi.dashboard') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('teknisi.dashboard') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"></path></svg>
                                        <span class="truncate">Tiket Saya</span>
                                    </a>
                                    <a href="{{ route('teknisi.riwayat') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('teknisi.riwayat') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('teknisi.riwayat') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="truncate">Riwayat Penanganan</span>
                                    </a>
                                </nav>
                            </div>

                        {{-- MENU KHUSUS SUPERVISOR --}}
                        @elseif(request()->routeIs('supervisor.*'))
                            <div class="min-w-0">
                                <p class="text-[10px] font-black text-teal-300/80 uppercase tracking-widest mb-2.5 px-3 truncate">MENU UTAMA SUPERVISOR</p>
                                <nav class="space-y-1.5 mb-6 min-w-0">
                                    <a href="{{ route('supervisor.dashboard') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('supervisor.dashboard') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('supervisor.dashboard') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        <span class="truncate">Dashboard</span>
                                    </a>

                                    <a href="{{ route('supervisor.monitoring-sla') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('supervisor.monitoring-sla') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('supervisor.monitoring-sla') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        <span class="truncate">Monitoring SLA</span>
                                    </a>

                                    <a href="{{ route('supervisor.laporan-tiket') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('supervisor.laporan-tiket') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('supervisor.laporan-tiket') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span class="truncate">Laporan Tiket</span>
                                    </a>

                                    <a href="{{ route('supervisor.statistik') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('supervisor.statistik') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('supervisor.statistik') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                                        <span class="truncate">Statistik</span>
                                    </a>

                                    <a href="{{ route('supervisor.filter-periode') }}"
                                        class="flex items-center space-x-3 px-3.5 sm:px-4 py-2.5 rounded-2xl text-xs font-bold transition min-w-0 {{ request()->routeIs('supervisor.filter-periode') ? 'bg-white text-emerald-900 shadow-md shadow-black/10' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('supervisor.filter-periode') ? 'text-emerald-700' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="truncate">Filter Periode</span>
                                    </a>
                                </nav>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Tombol Keluar di Bawah (Pill Translucent) -->
                <div class="relative z-10 p-4 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2.5 px-4 text-xs font-bold text-white bg-white/10 hover:bg-white/20 border border-white/15 rounded-2xl transition flex items-center justify-center space-x-2 shadow-xs min-w-0">
                            <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span class="truncate">Keluar Sistem</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- KONTEN UTAMA DI KANAN (Light Mode Bersih & Modern) -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#f8fafc]">

                <!-- TOP HEADER -->
                <header class="bg-white shadow-xs z-20 flex items-center justify-between h-16 sm:h-20 px-4 sm:px-8 border-b border-slate-200/80 flex-shrink-0 min-w-0 gap-2">
                    <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                        <!-- Tombol Hamburger (Hanya muncul di Mobile/Tablet < 768px) -->
                        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 transition shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <h2 class="text-xs sm:text-base font-black text-slate-900 truncate">
                            @if(request()->routeIs('admin.*'))
                                Dashboard Admin RSUD (Triage &amp; Dispatch)
                            @elseif(request()->routeIs('superadmin.*'))
                                Dashboard Super Admin RSUD
                            @elseif(request()->routeIs('supervisor.*'))
                                Dashboard Supervisor IT
                            @else
                                Dashboard Petugas Helpdesk
                            @endif
                        </h2>
                    </div>

                    <div class="flex items-center space-x-2 sm:space-x-4 shrink-0 min-w-0">
                        <!-- Status Badge Pill -->
                        <span class="hidden sm:inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-xs shrink-0">
                            <span class="w-2 h-2 mr-2 bg-emerald-500 rounded-full animate-pulse shrink-0"></span>
                            Sistem Aktif
                        </span>

                        <!-- Profil User Top Right -->
                        <div class="flex items-center space-x-2 bg-slate-50 px-2.5 sm:px-3 py-1.5 sm:py-2 rounded-2xl border border-slate-200 shadow-xs min-w-0">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 bg-emerald-800 text-white rounded-xl flex items-center justify-center text-xs font-black shadow-sm shrink-0">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="text-left hidden md:block min-w-0">
                                <span class="block text-xs font-extrabold text-slate-900 leading-tight truncate max-w-[120px]">{{ Auth::user()->name ?? 'User' }}</span>
                                <span class="block text-[10px] text-slate-500 font-semibold leading-tight mt-0.5 truncate">
                                    {{ Auth::user()->role->label ?? Auth::user()->role->name ?? 'Petugas' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- MAIN CONTENT AREA -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto p-3 sm:p-6 lg:p-8 bg-[#f8fafc] min-w-0">
                    @if (session('success'))
                        <div class="mb-5 sm:mb-6 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl p-3.5 sm:p-4 flex items-center gap-3 shadow-xs text-xs font-bold min-w-0">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="break-words">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-5 sm:mb-6 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl p-3.5 sm:p-4 flex items-center gap-3 shadow-xs text-xs font-bold min-w-0">
                            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="break-words">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>

        </div>
        <!-- Listener WebSocket Reverb untuk Notifikasi Real-Time -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.Echo) {
            console.log('✅ Laravel Echo Reverb siap mendengarkan tickets-channel');

            const handleNewTicket = (data) => {
                console.log('🔔 Ada Tiket Baru Masuk:', data);

                // 1. Tampilkan notifikasi pop-up di layar
                alert('🔔 PENGADUAN IT BARU MASUK!\n\n' +
                      '• No. Tiket: ' + data.ticket_number + '\n' +
                      '• Masalah: ' + data.title + '\n' +
                      '• Unit: ' + data.unit + '\n' +
                      '• Pelapor: ' + data.reporter);

                // 2. Refresh halaman otomatis jika sedang berada di dashboard admin
                if (window.location.pathname.includes('/admin')) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            };

            window.Echo.channel('tickets-channel')
                .listen('.ticket.created', handleNewTicket)
                .listen('TicketCreatedEvent', handleNewTicket);
        } else {
            console.warn('⚠️ window.Echo belum terdeteksi.');
        }
    });
</script>
    </body>
</html>