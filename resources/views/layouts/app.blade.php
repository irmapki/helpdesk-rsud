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

        <!-- Anti-FOUC & Anti-Flash Initialization -->
        <script>
            try {
                const savedSidebar = localStorage.getItem('sidebar_expanded');
                window.__sidebarExpanded = savedSidebar !== null ? (savedSidebar === 'true') : true;
                if (!window.__sidebarExpanded && window.innerWidth >= 1024) {
                    document.documentElement.classList.add('sidebar-collapsed-init');
                }
            } catch (e) {
                window.__sidebarExpanded = true;
            }
        </script>

        <style>
            [x-cloak] { display: none !important; }
            @media (min-width: 1024px) {
                html.sidebar-collapsed-init aside {
                    width: 5rem !important;
                }
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f8fafc] text-slate-800 h-full overflow-hidden">
        <!-- Alpine.js Responsive State & Real-time Live Notification Engine -->
        <div x-data="{
            isDesktop: window.innerWidth >= 1024,
            desktopExpanded: window.__sidebarExpanded !== undefined ? window.__sidebarExpanded : (localStorage.getItem('sidebar_expanded') !== 'false'),
            mobileOpen: false,
            hasLoaded: false,
            unreadCount: 0,
            pendingCount: {{ \App\Models\Ticket::where(fn($q) => $q->where('validation_status', 'pending')->orWhere('status', 'open')->orWhere('status', 'Menunggu Validasi'))->count() }},
            myActiveCount: {{ auth()->check() ? \App\Models\Ticket::where('assigned_to', auth()->id())->whereIn('status', ['assigned', 'in_progress'])->count() : 0 }},
            notifications: [],
            notificationOpen: false,
            dismissedIds: JSON.parse(localStorage.getItem('dismissed_ticket_notifs') || '[]'),
            lastSeenId: null,
            toastVisible: false,
            toastData: null,
            toastTimer: null,

            init() {
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.hasLoaded = true;
                    }, 100);
                });
                @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('teknisi')))
                this.fetchNotifications(true);
                setInterval(() => this.fetchNotifications(false), 5000);
                @endif
            },

            fetchNotifications(isInitial = false) {
                fetch('{{ route('tickets.live-check') }}', {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(data => {
                    if (!data) return;
                    
                    if (typeof data.pending_count !== 'undefined') {
                        this.pendingCount = data.pending_count;
                    }
                    if (typeof data.my_active_count !== 'undefined') {
                        this.myActiveCount = data.my_active_count;
                    }

                    const rawList = Array.isArray(data.notifications) ? data.notifications : [];
                    
                    // Filter notifikasi yang belum di-dismiss oleh user
                    const activeList = rawList.filter(item => !this.dismissedIds.includes(item.id));
                    this.notifications = activeList;
                    this.unreadCount = activeList.length;

                    const latestId = data.latest_id || (rawList[0] ? rawList[0].id : null);
                    if (latestId) {
                        if (isInitial || this.lastSeenId === null) {
                            this.lastSeenId = latestId;
                        } else if (latestId > this.lastSeenId) {
                            this.lastSeenId = latestId;
                            const latestItem = data.latest_ticket || rawList[0];
                            if (latestItem && !this.dismissedIds.includes(latestItem.id)) {
                                this.showToast(latestItem);
                                if (typeof playNotificationSound === 'function') {
                                    playNotificationSound();
                                }
                            }
                        }
                    }
                })
                .catch(e => {});
            },

            showToast(ticket) {
                this.toastData = ticket;
                this.toastVisible = true;
                if (this.toastTimer) clearTimeout(this.toastTimer);
                this.toastTimer = setTimeout(() => {
                    this.toastVisible = false;
                }, 12000);
            },

            dismissNotif(id) {
                if (!this.dismissedIds.includes(id)) {
                    this.dismissedIds.push(id);
                    if (this.dismissedIds.length > 100) this.dismissedIds.shift();
                    localStorage.setItem('dismissed_ticket_notifs', JSON.stringify(this.dismissedIds));
                }
                this.notifications = this.notifications.filter(n => n.id !== id);
                this.unreadCount = this.notifications.length;
                if (this.toastData && this.toastData.id === id) {
                    this.toastVisible = false;
                }
            },

            dismissAll() {
                this.notifications.forEach(n => {
                    if (!this.dismissedIds.includes(n.id)) {
                        this.dismissedIds.push(n.id);
                    }
                });
                localStorage.setItem('dismissed_ticket_notifs', JSON.stringify(this.dismissedIds));
                this.notifications = [];
                this.unreadCount = 0;
                this.toastVisible = false;
            },

            openTicket(url, id) {
                if (id) {
                    this.dismissNotif(id);
                }
                this.toastVisible = false;
                this.notificationOpen = false;
                window.location.href = url;
            },

            toggleSidebar() {
                if (this.isDesktop) {
                    this.desktopExpanded = !this.desktopExpanded;
                    localStorage.setItem('sidebar_expanded', this.desktopExpanded);
                    if (this.desktopExpanded) {
                        document.documentElement.classList.remove('sidebar-collapsed-init');
                    } else {
                        document.documentElement.classList.add('sidebar-collapsed-init');
                    }
                } else {
                    this.mobileOpen = !this.mobileOpen;
                }
            },
            closeMobile() {
                this.mobileOpen = false;
            }
        }" 
        @resize.window="isDesktop = window.innerWidth >= 1024"
        class="flex h-screen overflow-hidden relative w-full bg-[#f8fafc]">

            <!-- Mobile Backdrop -->
            <div x-show="mobileOpen" 
                x-cloak
                @click="closeMobile()"
                x-transition:enter="transition-opacity ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-950/60 z-40 lg:hidden backdrop-blur-xs">
            </div>

            <!-- SIDEBAR UTAMA -->
            <aside :class="{
                    'translate-x-0': mobileOpen,
                    '-translate-x-full lg:translate-x-0': !mobileOpen,
                    'w-64': desktopExpanded || !isDesktop,
                    'w-20': !desktopExpanded && isDesktop,
                    'transition-[width,transform] duration-300 ease-in-out': hasLoaded
                }"
                class="-translate-x-full lg:translate-x-0 w-64 fixed lg:static inset-y-0 left-0 z-50 flex flex-col justify-between flex-shrink-0 bg-gradient-to-b from-[#062420] via-[#09352e] to-[#041916] text-white shadow-2xl lg:shadow-none border-r border-emerald-900/40 select-none overflow-hidden">

                <div class="pointer-events-none absolute -top-16 -right-16 w-64 h-64 bg-teal-400/10 rounded-full blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-24 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl"></div>

                <div class="relative z-10 flex-1 flex flex-col min-h-0">
                    
                    <!-- Header Sidebar -->
                    <div class="h-16 sm:h-20 px-3.5 sm:px-4 border-b border-white/10 flex items-center justify-between shrink-0">
                        <div x-show="desktopExpanded || !isDesktop" class="flex items-center justify-between w-full min-w-0">
                            <div class="flex items-center space-x-2.5 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center p-1 shadow-md shadow-black/20 overflow-hidden shrink-0">
                                    <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-full h-full object-contain">
                                </div>
                                <div class="min-w-0">
                                    <h1 class="text-xs font-black text-white tracking-wider whitespace-nowrap">RSUD SOEWONDO</h1>
                                    <p class="text-[10px] text-teal-300 font-bold uppercase tracking-wider mt-0.5 whitespace-nowrap">IT HELPDESK</p>
                                </div>
                            </div>

                            <button @click="toggleSidebar()" 
                                class="text-emerald-200 hover:text-white p-1.5 rounded-xl bg-white/10 hover:bg-white/20 transition shrink-0 cursor-pointer border border-white/15 shadow-xs ml-1"
                                :title="isDesktop ? 'Ciutkan Sidebar' : 'Tutup Menu'">
                                <svg x-show="isDesktop" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                                </svg>
                                <svg x-show="!isDesktop" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div x-show="!desktopExpanded && isDesktop" class="flex items-center justify-center w-full">
                            <button @click="toggleSidebar()" 
                                class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center p-1 shadow-md shadow-black/20 overflow-hidden cursor-pointer hover:scale-105 active:scale-95 transition-transform" 
                                title="Klik untuk Perluas Sidebar">
                                <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-full h-full object-contain">
                            </button>
                        </div>
                    </div>

                    <!-- Area Navigasi Menu Berdasarkan Role -->
                    <div class="flex-1 overflow-y-auto overflow-x-hidden p-3 space-y-5 custom-scrollbar">

                        {{-- MENU SUPERADMIN --}}
                        @if(auth()->check() && (auth()->user()->hasRole('super_admin') || optional(auth()->user()->role)->name === 'super_admin'))
                            <div>
                                <div x-show="desktopExpanded || !isDesktop" class="px-3 mb-2">
                                    <p class="text-[10px] font-black text-teal-300/80 uppercase tracking-widest truncate">MENU SUPER ADMIN</p>
                                </div>
                                <div x-show="!desktopExpanded && isDesktop" class="my-2 border-t border-white/10 mx-2"></div>
                                
                                <nav class="space-y-1.5">
                                    <a href="{{ route('superadmin.dashboard') }}" @click="closeMobile()" title="Dashboard Super Admin"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('superadmin.dashboard') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.dashboard') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Dashboard Super Admin</span>
                                    </a>

                                    <a href="{{ route('superadmin.users.index') }}" @click="closeMobile()" title="Kelola User"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('superadmin.users.*') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.users.*') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Kelola User</span>
                                    </a>

                                    <a href="{{ route('superadmin.technicians.index') }}" @click="closeMobile()" title="Data Teknisi"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('superadmin.technicians.*') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.technicians.*') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Data Teknisi</span>
                                    </a>

                                    <a href="{{ route('superadmin.units.index') }}" @click="closeMobile()" title="Master Unit RSUD"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('superadmin.units.*') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.units.*') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Master Unit RSUD</span>
                                    </a>

                                    <a href="{{ route('superadmin.categories.index') }}" @click="closeMobile()" title="Master Kategori"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('superadmin.categories.*') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.categories.*') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Master Kategori</span>
                                    </a>

                                    <a href="{{ route('superadmin.priorities.index') }}" @click="closeMobile()" title="SLA & Prioritas"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('superadmin.priorities.*') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.priorities.*') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">SLA & Prioritas</span>
                                    </a>

                                    <a href="{{ route('superadmin.roles.index') }}" @click="closeMobile()" title="Kelola Role"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('superadmin.roles.*') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('superadmin.roles.*') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Kelola Role</span>
                                    </a>
                                </nav>
                            </div>
                        @endif

                        {{-- MENU ADMIN --}}
                        @if(auth()->check() && (auth()->user()->hasRole('admin') || optional(auth()->user()->role)->name === 'admin'))
                            <div>
                                <div x-show="desktopExpanded || !isDesktop" class="px-3 mb-2">
                                    <p class="text-[10px] font-black text-teal-300/80 uppercase tracking-widest truncate">MENU UTAMA ADMIN</p>
                                </div>
                                <div x-show="!desktopExpanded && isDesktop" class="my-2 border-t border-white/10 mx-2"></div>

                                <nav class="space-y-1.5">
                                    <a href="{{ route('admin.dashboard') }}" @click="closeMobile()" title="Dashboard Admin"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Dashboard Admin</span>
                                    </a>

                                    <a href="{{ route('admin.tickets.index') }}" @click="closeMobile()" title="Manajemen & Triage Tiket"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('admin.tickets.*') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        
                                        <div class="relative shrink-0 flex items-center justify-center">
                                            <svg class="w-5 h-5 {{ request()->routeIs('admin.tickets.*') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"></path>
                                            </svg>
                                            <template x-if="pendingCount > 0">
                                                <span class="absolute -top-1.5 -right-2 bg-amber-400 text-slate-950 font-black text-[9px] min-w-[16px] h-[16px] px-1 rounded-full flex items-center justify-center shadow-md border border-white animate-pulse" x-text="pendingCount"></span>
                                            </template>
                                        </div>

                                        <span class="truncate flex-1 flex items-center justify-between" x-show="desktopExpanded || !isDesktop">
                                            <span>Manajemen & Triage</span>
                                            <template x-if="pendingCount > 0">
                                                <span class="bg-amber-400 text-slate-950 font-black text-[10px] px-2 py-0.5 rounded-full shadow-xs ml-1" x-text="pendingCount"></span>
                                            </template>
                                        </span>
                                    </a>
                                </nav>
                            </div>
                        @endif

                        {{-- MENU TEKNISI --}}
                        @if(auth()->check() && (auth()->user()->hasRole('teknisi') || optional(auth()->user()->role)->name === 'teknisi'))
                            <div>
                                <div x-show="desktopExpanded || !isDesktop" class="px-3 mb-2">
                                    <p class="text-[10px] font-black text-teal-300/80 uppercase tracking-widest truncate">MENU UTAMA TEKNISI</p>
                                </div>
                                <div x-show="!desktopExpanded && isDesktop" class="my-2 border-t border-white/10 mx-2"></div>

                                <nav class="space-y-1.5">
                                    <a href="{{ route('teknisi.dashboard') }}" @click="closeMobile()" title="Tiket Saya & Workboard"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('teknisi.dashboard') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <div class="relative shrink-0 flex items-center justify-center">
                                            <svg class="w-5 h-5 {{ request()->routeIs('teknisi.dashboard') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"></path>
                                            </svg>
                                            <template x-if="myActiveCount > 0">
                                                <span class="absolute -top-1.5 -right-2 bg-emerald-400 text-slate-950 font-black text-[9px] min-w-[16px] h-[16px] px-1 rounded-full flex items-center justify-center shadow-md border border-white" x-text="myActiveCount"></span>
                                            </template>
                                        </div>
                                        <span class="truncate flex-1 flex items-center justify-between" x-show="desktopExpanded || !isDesktop">
                                            <span>Tiket Saya & Workboard</span>
                                            <template x-if="myActiveCount > 0">
                                                <span class="bg-emerald-400 text-slate-950 font-black text-[10px] px-2 py-0.5 rounded-full shadow-xs ml-1" x-text="myActiveCount"></span>
                                            </template>
                                        </span>
                                    </a>

                                    <a href="{{ route('teknisi.riwayat') }}" @click="closeMobile()" title="Riwayat Penanganan"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('teknisi.riwayat') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('teknisi.riwayat') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Riwayat Penanganan</span>
                                    </a>
                                </nav>
                            </div>
                        @endif

                        {{-- MENU SUPERVISOR --}}
                        @if(auth()->check() && (auth()->user()->hasRole('supervisor') || optional(auth()->user()->role)->name === 'supervisor'))
                            <div>
                                <div x-show="desktopExpanded || !isDesktop" class="px-3 mb-2">
                                    <p class="text-[10px] font-black text-teal-300/80 uppercase tracking-widest truncate">MENU UTAMA SUPERVISOR</p>
                                </div>
                                <div x-show="!desktopExpanded && isDesktop" class="my-2 border-t border-white/10 mx-2"></div>

                                <nav class="space-y-1.5">
                                    <a href="{{ route('supervisor.dashboard') }}" @click="closeMobile()" title="Dashboard Supervisor"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('supervisor.dashboard') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('supervisor.dashboard') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Dashboard Supervisor</span>
                                    </a>

                                    <a href="{{ route('supervisor.monitoring-sla') }}" @click="closeMobile()" title="Monitoring SLA"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('supervisor.monitoring-sla') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('supervisor.monitoring-sla') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Monitoring SLA</span>
                                    </a>

                                    <a href="{{ route('supervisor.laporan-tiket') }}" @click="closeMobile()" title="Laporan Tiket"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('supervisor.laporan-tiket') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('supervisor.laporan-tiket') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Laporan Tiket</span>
                                    </a>

                                    <a href="{{ route('supervisor.statistik') }}" @click="closeMobile()" title="Statistik Layanan"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('supervisor.statistik') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('supervisor.statistik') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Statistik</span>
                                    </a>

                                    <a href="{{ route('supervisor.filter-periode') }}" @click="closeMobile()" title="Filter Periode"
                                        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-bold transition-colors duration-150 {{ request()->routeIs('supervisor.filter-periode') ? 'bg-white text-emerald-950 shadow-md shadow-black/15 font-black' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}"
                                        :class="{ 'justify-center px-0': !desktopExpanded && isDesktop }">
                                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('supervisor.filter-periode') ? 'text-emerald-800' : 'text-teal-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="truncate" x-show="desktopExpanded || !isDesktop">Filter Periode</span>
                                    </a>
                                </nav>
                            </div>
                        @endif

                    </div>

                    <!-- Footer Sidebar -->
                    <div class="p-3 sm:p-4 border-t border-white/10 shrink-0">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Keluar dari Sistem"
                                class="group relative w-full py-2.5 px-3 text-xs font-bold text-white bg-white/10 hover:bg-rose-600/30 hover:border-rose-400/40 border border-white/15 rounded-2xl transition-colors duration-150 flex items-center justify-center gap-2.5 shadow-xs cursor-pointer"
                                :class="{ 'px-0': !desktopExpanded && isDesktop }">
                                <svg class="w-4 h-4 text-rose-300 group-hover:text-rose-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="truncate" x-show="desktopExpanded || !isDesktop">Keluar Sistem</span>
                            </button>
                        </form>
                    </div>

                </div>
            </aside>

            <!-- KONTEN UTAMA -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#f8fafc]">

                <!-- TOP NAVBAR -->
                <header class="bg-white shadow-xs z-20 flex items-center justify-between h-16 sm:h-20 px-4 sm:px-8 border-b border-slate-200/80 flex-shrink-0 gap-2">
                    <div class="flex items-center gap-2.5 sm:gap-4 min-w-0">
                        <button @click="toggleSidebar()" 
                            class="text-slate-700 hover:text-emerald-800 p-2 sm:p-2.5 rounded-2xl bg-slate-100 hover:bg-emerald-50 active:scale-95 transition-all duration-150 shrink-0 cursor-pointer border border-slate-200 shadow-xs flex items-center justify-center" 
                            :title="isDesktop ? (desktopExpanded ? 'Ciutkan Sidebar' : 'Lebarkan Sidebar') : (mobileOpen ? 'Tutup Menu' : 'Buka Menu')">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Vertical divider -->
                        <div class="hidden sm:block h-6 w-[1px] bg-slate-200 shrink-0"></div>

                        <!-- BREADCRUMB CONTEXT BAR (Ramping, Bersih & Modern) -->
                        <nav aria-label="Breadcrumb" class="min-w-0 flex items-center gap-1.5 sm:gap-2 text-xs">
                            @php
                                $roleLabel = 'Helpdesk';
                                if (request()->routeIs('superadmin.*')) {
                                    $roleLabel = 'Super Admin';
                                } elseif (request()->routeIs('admin.*')) {
                                    $roleLabel = 'Admin Helpdesk';
                                } elseif (request()->routeIs('teknisi.*')) {
                                    $roleLabel = 'Teknisi IT';
                                } elseif (request()->routeIs('supervisor.*')) {
                                    $roleLabel = 'Supervisor IT';
                                }

                                $pageName = 'Dashboard';
                                if (request()->routeIs('superadmin.dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('supervisor.dashboard')) {
                                    $pageName = 'Dashboard';
                                } elseif (request()->routeIs('superadmin.users.*')) {
                                    $pageName = 'Kelola User';
                                } elseif (request()->routeIs('superadmin.technicians.*')) {
                                    $pageName = 'Data Teknisi';
                                } elseif (request()->routeIs('superadmin.units.*')) {
                                    $pageName = 'Master Unit RSUD';
                                } elseif (request()->routeIs('superadmin.categories.*')) {
                                    $pageName = 'Master Kategori';
                                } elseif (request()->routeIs('superadmin.priorities.*')) {
                                    $pageName = 'SLA & Prioritas';
                                } elseif (request()->routeIs('superadmin.roles.*')) {
                                    $pageName = 'Kelola Role';
                                } elseif (request()->routeIs('admin.tickets.show')) {
                                    $pageName = 'Triage & Detail Tiket';
                                } elseif (request()->routeIs('admin.tickets.*')) {
                                    $pageName = 'Manajemen & Triage Tiket';
                                } elseif (request()->routeIs('teknisi.dashboard')) {
                                    $pageName = 'Workboard Penanganan';
                                } elseif (request()->routeIs('teknisi.riwayat')) {
                                    $pageName = 'Riwayat Tiket Selesai';
                                } elseif (request()->routeIs('supervisor.monitoring-sla')) {
                                    $pageName = 'Monitoring SLA';
                                } elseif (request()->routeIs('supervisor.laporan-tiket*') || request()->routeIs('supervisor.filter-periode*')) {
                                    $pageName = 'Laporan Tiket';
                                } elseif (request()->routeIs('supervisor.statistik*')) {
                                    $pageName = 'Statistik Kinerja IT';
                                } elseif (request()->routeIs('profile.*')) {
                                    $pageName = 'Profil Pengguna';
                                }
                            @endphp

                            <!-- Root / Home Icon -->
                            <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-emerald-800 transition flex items-center gap-1 font-semibold shrink-0" title="Kembali ke Beranda Utama">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span class="hidden md:inline text-[11px] text-slate-500 font-bold uppercase tracking-wider">Helpdesk</span>
                            </a>

                            <!-- Separator -->
                            <svg class="w-3 h-3 text-slate-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>

                            <!-- Role Scope -->
                            <span class="text-slate-400 font-semibold text-xs shrink-0 hidden sm:inline">{{ $roleLabel }}</span>

                            <!-- Separator -->
                            <svg class="w-3 h-3 text-slate-300 shrink-0 hidden sm:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>

                            <!-- Active Page Name Badge -->
                            <span class="text-slate-800 font-black text-xs sm:text-xs bg-slate-100 text-slate-800 px-2.5 py-1 rounded-xl border border-slate-200/90 shadow-xs truncate max-w-[180px] sm:max-w-[280px]">
                                {{ $pageName }}
                            </span>
                        </nav>
                    </div>

                    <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                        {{-- LONCENG NOTIFIKASI HANYA UNTUK OPERASIONAL TIKET (ADMIN & TEKNISI) --}}
                        @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('teknisi')))
                            <!-- DROPDOWN NOTIFIKASI LONCENG -->
                            <div class="relative">
                                <button @click="notificationOpen = !notificationOpen" title="Notifikasi Tiket Masuk" 
                                    class="relative p-2.5 rounded-2xl border border-slate-200 bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-900 active:scale-95 transition-all duration-150 flex items-center justify-center shadow-xs cursor-pointer">
                                    <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <template x-if="unreadCount > 0">
                                        <span class="absolute -top-1 -right-1 bg-red-600 text-white font-black text-[10px] min-w-[18px] h-[18px] px-1 rounded-full flex items-center justify-center shadow-md border border-white animate-pulse" x-text="unreadCount"></span>
                                    </template>
                                </button>

                                <!-- Panel Dropdown Notifikasi -->
                                <div x-show="notificationOpen" @click.away="notificationOpen = false" x-cloak
                                    class="absolute right-0 mt-2 w-80 sm:w-96 bg-white border border-slate-200/90 rounded-2xl shadow-2xl py-2 z-50 overflow-hidden">
                                    <div class="px-4 py-2.5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                                        <div class="flex items-center gap-2">
                                            <span class="font-black text-xs text-slate-800 uppercase tracking-wider">Notifikasi Tiket Masuk</span>
                                            <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full" x-text="unreadCount + ' Baru'"></span>
                                        </div>
                                        <template x-if="notifications.length > 0">
                                            <button @click="dismissAll()" class="text-[11px] text-slate-500 hover:text-rose-600 font-bold transition">
                                                Bersihkan
                                            </button>
                                        </template>
                                    </div>

                                    <div class="max-h-80 overflow-y-auto divide-y divide-slate-100 custom-scrollbar">
                                        <template x-for="notif in notifications" :key="notif.id">
                                            <div class="p-3.5 hover:bg-emerald-50/40 transition flex items-start justify-between gap-3 bg-white group cursor-pointer"
                                                 @click="openTicket(notif.url, notif.id)">
                                                <div class="flex-1 min-w-0 text-left">
                                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                                        <span class="font-mono font-black text-xs text-emerald-900 bg-emerald-100/90 px-2 py-0.5 rounded-md" x-text="notif.ticket_number"></span>
                                                        <span class="text-[10px] text-slate-400 font-medium ml-auto" x-text="notif.time"></span>
                                                    </div>
                                                    <p class="font-bold text-xs text-slate-900 line-clamp-1 group-hover:text-emerald-900 transition" x-text="notif.title"></p>
                                                    <p class="text-[11px] text-slate-500 font-medium mt-0.5 flex items-center gap-1 truncate">
                                                        <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                        <span class="truncate" x-text="notif.unit"></span>
                                                    </p>
                                                </div>

                                                <div class="flex flex-col items-center gap-1 shrink-0 pt-0.5">
                                                    <button @click.stop="dismissNotif(notif.id)" title="Hapus dari notifikasi"
                                                        class="text-slate-300 hover:text-rose-600 p-1.5 rounded-lg hover:bg-rose-50 transition cursor-pointer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2.000 2.000 0 0116.138 21H7.862a2.000 2.000 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="notifications.length === 0">
                                            <div class="p-8 text-center text-xs text-slate-400 font-semibold space-y-2">
                                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </div>
                                                <p>Semua notifikasi telah dibaca.</p>
                                            </div>
                                        </template>
                                    </div>

                                    @if(auth()->check() && auth()->user()->hasRole('admin'))
                                        <div class="px-4 py-2 border-t border-slate-100 bg-slate-50 text-center">
                                            <a href="{{ route('admin.tickets.index') }}" @click="notificationOpen = false" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 transition">
                                                Lihat Semua Tiket &rarr;
                                            </a>
                                        </div>
                                    @elseif(auth()->check() && auth()->user()->hasRole('teknisi'))
                                        <div class="px-4 py-2 border-t border-slate-100 bg-slate-50 text-center">
                                            <a href="{{ route('teknisi.dashboard') }}" @click="notificationOpen = false" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 transition">
                                                Buka Workboard Tiket &rarr;
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <span class="hidden sm:inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-xs shrink-0">
                            <span class="w-2 h-2 mr-2 bg-emerald-500 rounded-full animate-pulse shrink-0"></span>
                            Sistem Aktif
                        </span>

                        <a href="{{ route('profile.edit') }}" title="Lihat Profil Saya" class="flex items-center space-x-2 bg-slate-50 hover:bg-emerald-50/70 px-2.5 sm:px-3 py-1.5 sm:py-2 rounded-2xl border border-slate-200 hover:border-emerald-300 shadow-xs transition group">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 bg-emerald-800 group-hover:bg-emerald-700 text-white rounded-xl flex items-center justify-center text-xs font-black shadow-sm shrink-0 transition">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="text-left hidden md:block min-w-0">
                                <span class="block text-xs font-extrabold text-slate-900 leading-tight truncate max-w-[120px]">{{ Auth::user()->name ?? 'User' }}</span>
                                <span class="block text-[10px] text-slate-500 font-semibold leading-tight mt-0.5 truncate">
                                    @php
                                        $currentUser = Auth::user();
                                        $userRoles = collect();
                                        if ($currentUser && method_exists($currentUser, 'roles')) {
                                            try {
                                                $userRoles = $currentUser->roles->pluck('label')->filter();
                                                if ($userRoles->isEmpty()) {
                                                    $userRoles = $currentUser->roles->pluck('name');
                                                }
                                            } catch (\Throwable $e) {}
                                        }
                                        $roleText = $userRoles->isNotEmpty() ? $userRoles->join(', ') : optional($currentUser->role)->label ?? optional($currentUser->role)->name ?? 'Petugas';
                                    @endphp
                                    {{ $roleText }}
                                </span>
                            </div>
                        </a>
                    </div>
                </header>

                <!-- MAIN CONTENT AREA -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto p-3 sm:p-6 lg:p-8 bg-[#f8fafc]">
                    @if (session('success'))
                        <div class="mb-5 sm:mb-6 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl p-3.5 sm:p-4 flex items-center gap-3 shadow-xs text-xs font-bold">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="break-words">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-5 sm:mb-6 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl p-3.5 sm:p-4 flex items-center gap-3 shadow-xs text-xs font-bold">
                            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="break-words">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>

            @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('teknisi')))
            <!-- FLOATING LIVE TICKET TOAST POP-UP (MUNCUL OTOMATIS SAAT ADA TIKET MASUK REAL-TIME) -->
            <div x-show="toastVisible" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-y-[-20px] opacity-0 scale-95"
                 x-transition:enter-end="translate-y-0 opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="translate-y-[-10px] opacity-0 scale-95"
                 class="fixed top-5 right-5 z-50 max-w-sm sm:max-w-md w-full bg-white/95 backdrop-blur-md text-slate-900 rounded-3xl p-4 sm:p-5 shadow-2xl border border-emerald-300/80 shadow-emerald-950/15 ring-1 ring-slate-950/5 select-none">
                <div class="flex items-start gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-800 flex items-center justify-center text-white shrink-0 shadow-md shadow-emerald-800/30 animate-pulse">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-100/90 px-2.5 py-0.5 rounded-full border border-emerald-200 shadow-xs">
                                @if(auth()->check() && auth()->user()->hasRole('teknisi') && !auth()->user()->hasRole('admin'))
                                    Tugas Baru Diberikan
                                @else
                                    Tiket Baru Masuk
                                @endif
                            </span>
                            <span class="text-[11px] text-slate-400 font-medium ml-auto" x-text="toastData ? toastData.time : 'Baru saja'"></span>
                        </div>

                        <h4 class="font-black text-sm text-emerald-900 mt-1 font-mono tracking-wider" x-text="toastData ? toastData.ticket_number : ''"></h4>
                        <p class="font-bold text-xs text-slate-900 mt-0.5 line-clamp-1" x-text="toastData ? toastData.title : ''"></p>
                        
                        <p class="text-[11px] text-slate-600 font-semibold mt-1 flex items-center gap-1.5 truncate">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span class="truncate" x-text="toastData ? toastData.unit : ''"></span>
                        </p>

                        <div class="mt-3.5 flex items-center gap-2 pt-2.5 border-t border-slate-100">
                            <a :href="toastData ? toastData.url : '#'" 
                               @click="openTicket(toastData.url, toastData.id)"
                               class="bg-emerald-800 hover:bg-emerald-700 active:scale-95 text-white font-black text-xs px-4 py-2 rounded-xl transition shadow-sm shadow-emerald-900/20 flex items-center gap-1.5 cursor-pointer">
                                <span>Buka & Tindak Lanjuti</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                            <button @click="toastVisible = false" 
                                    class="text-xs font-bold text-slate-500 hover:text-slate-800 px-3 py-2 rounded-xl hover:bg-slate-100 transition cursor-pointer">
                                Tutup
                            </button>
                        </div>
                    </div>

                    <button @click="toastVisible = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            @endif

        </div>

        <script>
            function playNotificationSound() {
                try {
                    const AudioCtx = window.AudioContext || window.webkitAudioContext;
                    if (!AudioCtx) return;
                    const ctx = new AudioCtx();
                    
                    const osc1 = ctx.createOscillator();
                    const gain1 = ctx.createGain();
                    osc1.type = 'sine';
                    osc1.frequency.setValueAtTime(587.33, ctx.currentTime);
                    gain1.gain.setValueAtTime(0.35, ctx.currentTime);
                    gain1.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.6);
                    osc1.connect(gain1);
                    gain1.connect(ctx.destination);
                    osc1.start(ctx.currentTime);
                    osc1.stop(ctx.currentTime + 0.6);

                    const osc2 = ctx.createOscillator();
                    const gain2 = ctx.createGain();
                    osc2.type = 'sine';
                    osc2.frequency.setValueAtTime(880, ctx.currentTime + 0.15);
                    gain2.gain.setValueAtTime(0.4, ctx.currentTime + 0.15);
                    gain2.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.85);
                    osc2.connect(gain2);
                    gain2.connect(ctx.destination);
                    osc2.start(ctx.currentTime + 0.15);
                    osc2.stop(ctx.currentTime + 0.85);
                } catch(e) {
                    console.log('Audio error/prevented:', e);
                }
            }
        </script>
    </body>
</html>