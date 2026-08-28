<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Portal Layanan Pengaduan IT' }} - RSUD RAA Soewondo Pati</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f8fafc] text-slate-900 min-h-screen flex flex-col justify-between selection:bg-emerald-600 selection:text-white overflow-x-hidden">
    <!-- Navbar Header (Strictly 1 Single Row) -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 shadow-xs">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2 min-w-0">
            
            <!-- Brand Logo -->
            <a href="{{ route('guest.landing') }}" class="flex items-center gap-2.5 sm:gap-3.5 group min-w-0">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-white flex items-center justify-center p-1 border border-slate-200/80 shadow-xs group-hover:shadow-md transition overflow-hidden shrink-0">
                    <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-full h-full object-contain">
                </div>
                <div class="min-w-0">
                    <div class="text-xs sm:text-base font-black tracking-tight text-slate-900 leading-tight truncate">
                        HELPDESK RSUD <span class="text-emerald-700">RAA. SOEWONDO</span>
                    </div>
                    <p class="text-[10px] sm:text-xs text-slate-500 font-semibold tracking-wide truncate">Sistem Pengaduan &amp; Layanan IT</p>
                </div>
            </a>

            <!-- Nav Actions (Strictly 1 Row) -->
            <div class="flex items-center gap-1 sm:gap-2 shrink-0">
                <a href="{{ route('guest.ticket.track') }}" class="inline-flex items-center justify-center gap-1 text-[11px] sm:text-sm font-bold text-slate-700 hover:text-emerald-700 px-2 py-1.5 sm:px-3 sm:py-2 rounded-xl hover:bg-slate-100 transition whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Lacak</span>
                </a>

                <a href="{{ route('guest.ticket.create') }}" class="inline-flex items-center justify-center gap-1 text-[11px] sm:text-sm font-bold text-white bg-emerald-800 hover:bg-emerald-900 px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-xl shadow-xs transition whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Buat Tiket</span>
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-xl transition whitespace-nowrap">
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300/80 px-2 py-1.5 sm:px-3 sm:py-2 rounded-xl transition whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden sm:inline">Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @if (session('success'))
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl p-4 flex items-center gap-3 shadow-xs">
                    <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl p-4 flex items-center gap-3 shadow-xs">
                    <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-bold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer Berwarna Hijau Khas RSUD (Modern & Ringkas) -->
    <footer class="bg-gradient-to-br from-teal-950 via-emerald-950 to-slate-950 text-white border-t border-emerald-800/40 mt-16 overflow-hidden relative">
        <div class="pointer-events-none absolute -top-24 -right-24 w-72 h-72 bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-24 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 relative z-10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center p-1.5 shadow-md shrink-0">
                        <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-full h-full object-contain">
                    </div>
                    <div class="min-w-0 text-left">
                        <h4 class="text-xs sm:text-sm font-black text-white tracking-tight truncate">IT HELPDESK RSUD RAA. SOEWONDO</h4>
                        <p class="text-[10px] sm:text-xs text-teal-300 font-semibold truncate">Instalasi Teknologi Informasi &amp; Komunikasi (TIK)</p>
                    </div>
                </div>

                <div class="text-xs text-emerald-300/80 sm:text-right">
                    <p class="font-bold text-white">&copy; {{ date('Y') }} RSUD IT Helpdesk System</p>
                    <p class="text-[11px] text-emerald-300/60 mt-0.5">Jl. Dr. Susanto No. 114, Pati &bull; Layanan Pengaduan 24 Jam</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>