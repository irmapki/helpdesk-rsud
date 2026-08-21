<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f4f7f8]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RSUD IT Helpdesk') }} - RSUD RAA Soewondo Pati</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full text-slate-800 bg-[#f4f7f8]">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/60 z-40 lg:hidden">
        </div>

        <!-- Left Sidebar (Dark Teal) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0a252a] text-slate-300 flex flex-col justify-between transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none lg:static lg:translate-x-0 border-r border-[#0e353c]">
            
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-6">
                <!-- Brand Header -->
                <div class="flex items-center gap-3 px-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center text-white font-black text-sm shadow-md shadow-amber-500/20 shrink-0">
                        RS
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-[13px] font-bold text-white tracking-tight leading-tight truncate">
                            RSUD RAA Soewondo Pati
                        </h1>
                        <p class="text-[10px] text-teal-400 font-semibold tracking-wider uppercase mt-0.5">
                            IT Helpdesk & Ticketing
                        </p>
                    </div>
                </div>

                @php
                    $role = Auth::user()->role->name ?? '';
                @endphp

                <!-- 1. Super Admin Menu -->
                @if ($role === 'super_admin')
                    <!-- Section: Menu Utama -->
                    <div class="space-y-1">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-teal-500/70 block mb-2">
                            Menu Utama
                        </span>

                        <a href="{{ route('superadmin.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('superadmin.users.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.users.*') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Kelola User</span>
                        </a>

                        <a href="{{ route('superadmin.roles.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.roles.*') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Kelola Role</span>
                        </a>

                        <a href="{{ route('superadmin.categories.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.categories.*') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            <span>Kategori Tiket</span>
                        </a>

                        <a href="{{ route('superadmin.priorities.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.priorities.*') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>Prioritas Tiket</span>
                        </a>

                        <a href="{{ route('superadmin.units.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.units.*') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Unit / Bagian</span>
                        </a>

                        <a href="{{ route('superadmin.technicians.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('superadmin.technicians.*') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Data Teknisi</span>
                        </a>
                    </div>

                    <!-- Section: Sistem -->
                    <div class="space-y-1 pt-4 border-t border-[#0e353c]">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-teal-500/70 block mb-2">
                            Sistem
                        </span>

                        <a href="{{ route('superadmin.priorities.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a] hover:text-white transition">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Konfigurasi SLA</span>
                        </a>

                        <a href="{{ route('guest.landing') }}" target="_blank"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a] hover:text-white transition">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <span>Portal Pengaduan</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a] hover:text-white transition">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Pengaturan Akun</span>
                        </a>
                    </div>

                <!-- 2. Admin Helpdesk Menu -->
                @elseif ($role === 'admin')
                    <div class="space-y-1">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-teal-500/70 block mb-2">
                            Menu Admin IT
                        </span>

                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('admin.tickets.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.tickets.*') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <span>Kelola Tiket Masuk</span>
                        </a>

                        <a href="{{ route('admin.tickets.index', ['tab' => 'pending']) }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a] hover:text-white transition">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>Validasi & Triage</span>
                        </a>
                    </div>

                    <div class="space-y-1 pt-4 border-t border-[#0e353c]">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-teal-500/70 block mb-2">
                            Sistem
                        </span>

                        <a href="{{ route('guest.landing') }}" target="_blank"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a] hover:text-white transition">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <span>Portal Pengaduan</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a] hover:text-white transition">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Pengaturan Akun</span>
                        </a>
                    </div>

                <!-- 3. Teknisi Menu -->
                @elseif ($role === 'teknisi')
                    <div class="space-y-1">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-teal-500/70 block mb-2">
                            Menu Utama
                        </span>

                        <a href="{{ route('teknisi.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('teknisi.dashboard') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4" />
                            </svg>
                            <span>Tiket Saya</span>
                            <span class="ml-auto bg-teal-800 text-[10px] font-bold px-2 py-0.5 rounded-full text-white">5</span>
                        </a>

                        <a href="{{ route('teknisi.riwayat') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('teknisi.riwayat') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Riwayat Penanganan</span>
                        </a>
                    </div>

                    <div class="space-y-1 pt-4 border-t border-[#0e353c]">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-teal-500/70 block mb-2">
                            Sistem
                        </span>

                        <a href="{{ route('guest.landing') }}" target="_blank"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a] hover:text-white transition">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <span>Portal Pengaduan</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a] hover:text-white transition">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Pengaturan Akun</span>
                        </a>
                    </div>

                <!-- 4. Supervisor Menu -->
                @elseif ($role === 'supervisor')
                    <div class="space-y-1">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-teal-500/70 block mb-2">
                            Menu Utama
                        </span>

                        <a href="{{ route('supervisor.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('supervisor.dashboard') ? 'bg-[#12424b] text-white shadow-sm border-l-4 border-teal-400' : 'text-slate-300 hover:bg-[#0e333a] hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Dashboard Supervisor</span>
                        </a>
                    </div>

                    <div class="space-y-1 pt-4 border-t border-[#0e353c]">
                        <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-teal-500/70 block mb-2">
                            Sistem
                        </span>

                        <a href="{{ route('guest.landing') }}" target="_blank"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a] hover:text-white transition">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <span>Portal Pengaduan</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a] hover:text-white transition">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Pengaturan Akun</span>
                        </a>
                    </div>

                @else
                    <!-- Fallback General Menu -->
                    <div class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-white bg-[#12424b]">
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#0e333a]">
                            <span>Profile</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar User Card Bottom -->
            <div class="p-4 border-t border-[#0e353c] bg-[#081f23]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-teal-600 text-white font-bold flex items-center justify-center text-xs shrink-0">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-teal-400 truncate">{{ Auth::user()->role->label ?? Auth::user()->role->name }}</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Log Out" class="p-1.5 text-slate-400 hover:text-rose-400 rounded-lg hover:bg-white/5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Right Main Workspace -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Navbar Header -->
            <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 shadow-xs">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <!-- Mobile Hamburger & Breadcrumb -->
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div>
                            <h2 class="text-sm sm:text-base font-extrabold text-slate-900 leading-tight">
                                {{ $pageTitle ?? ($header ?? 'Dashboard') }}
                            </h2>
                            <p class="text-[11px] text-slate-500 font-medium hidden sm:block">
                                {{ $breadcrumb ?? 'Super Admin > Manajemen Sistem Helpdesk RSUD' }}
                            </p>
                        </div>
                    </div>

                    <!-- Right Status Badge & User Profile -->
                    <div class="flex items-center gap-4">
                        <!-- Status Badge Pill -->
                        <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span>Sistem Normal</span>
                        </div>

                        <!-- User Profile Top Right -->
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-full bg-teal-700 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <div class="text-xs font-extrabold text-slate-900 leading-tight">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-slate-500 font-medium">{{ Auth::user()->role->label ?? Auth::user()->role->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Alerts Flash -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-3.5 flex items-center gap-3 shadow-xs text-xs font-semibold">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-xl p-3.5 flex items-center gap-3 shadow-xs text-xs font-semibold">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Main Dynamic Content -->
            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
