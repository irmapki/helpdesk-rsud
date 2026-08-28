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
    <!-- Navbar Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-40 shadow-xs">
        <!-- Menggunakan padding responsif dan flex-col agar otomatis menyesuaikan di HP kecil -->
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-3.5 sm:py-4 flex flex-col sm:flex-row items-center justify-between gap-3.5">
            
            <!-- Brand Logo -->
            <a href="{{ route('guest.landing') }}" class="flex items-center gap-3 group w-full sm:w-auto justify-between sm:justify-start min-w-0">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-white flex items-center justify-center p-1 border border-slate-200/80 shadow-sm group-hover:shadow-md transition overflow-hidden shrink-0">
                        <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-full h-full object-contain">
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs sm:text-base font-black tracking-tight text-slate-900 leading-tight truncate">
                            HELPDESK RSUD <span class="text-emerald-700">RAA. SOEWONDO</span>
                        </div>
                        <p class="text-[10px] sm:text-xs text-slate-500 font-medium tracking-wide truncate">Sistem Pengaduan &amp; Layanan IT Rumah Sakit</p>
                    </div>
                </div>
            </a>

            <!-- Nav Actions (Responsive auto-wrap grid/flex for mobile devices) -->
            <div class="flex items-center justify-end flex-wrap sm:flex-nowrap gap-1.5 sm:gap-2.5 w-full sm:w-auto pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                <a href="{{ route('guest.ticket.track') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1 text-[11px] sm:text-sm font-bold text-slate-700 hover:text-emerald-700 px-3 py-2 rounded-xl hover:bg-slate-100 transition whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Lacak</span>
                </a>

                <a href="{{ route('guest.ticket.create') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1 text-[11px] sm:text-sm font-bold text-white bg-emerald-800 hover:bg-emerald-900 px-3.5 py-2 sm:py-2.5 rounded-xl shadow-md shadow-emerald-900/20 transition hover:scale-[1.02] whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Buat Tiket</span>
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 px-3 py-2.5 rounded-xl transition whitespace-nowrap">
                        <span>Dashboard</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300/80 px-3 py-2 rounded-xl transition whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span>Login</span>
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

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200/80 mt-16 py-6 text-center text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div class="flex items-center justify-center sm:justify-start gap-2.5">
                <div class="w-6 h-6 rounded-lg bg-white border border-slate-200 flex items-center justify-center p-0.5 overflow-hidden shadow-xs shrink-0">
                    <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-full h-full object-contain">
                </div>
                <span class="font-bold text-slate-700 text-[11px] sm:text-xs">Instalasi Teknologi Informasi &amp; Komunikasi RSUD RAA Soewondo Pati</span>
            </div>
            <p class="text-slate-400 font-medium text-[11px] sm:text-xs">&copy; {{ date('Y') }} RSUD IT Helpdesk System. Layanan Cepat &amp; Terpadu.</p>
        </div>
    </footer>
</body>
</html>