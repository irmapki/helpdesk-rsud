<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Portal Layanan Pengaduan IT' }} - Helpdesk RSUD RAA. SOEWONDO</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col selection:bg-emerald-600 selection:text-white">
    <!-- Navbar Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-3">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-3">
                
                <!-- Brand Logo -->
                <a href="{{ route('guest.landing') }}" class="flex items-center justify-between lg:justify-start gap-2.5 w-full lg:w-auto">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center shrink-0">
                            <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-9 h-9 sm:w-10 sm:h-10 object-contain">
                        </div>
                        <div class="min-w-0 text-left">
                            <div class="text-xs sm:text-sm font-black tracking-tight text-slate-900 flex items-center gap-1 flex-wrap">
                                <span>HELPDESK</span> <span class="text-emerald-700">RSUD RAA. SOEWONDO</span>
                            </div>
                            <p class="text-[10px] sm:text-xs text-slate-500 font-medium truncate">Sistem Pengaduan &amp; Layanan IT Rumah Sakit</p>
                        </div>
                    </div>
                </a>

                <!-- Nav Actions: Universal Mobile Flex Grid -->
                <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center justify-center lg:justify-end gap-2 w-full lg:w-auto pt-2 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                    <a href="{{ route('guest.ticket.track') }}" class="inline-flex items-center justify-center gap-1.5 text-xs font-bold text-slate-700 hover:text-emerald-800 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                        <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Lacak Tiket</span>
                    </a>

                    <a href="{{ route('guest.ticket.create') }}" class="inline-flex items-center justify-center gap-1.5 text-xs font-extrabold text-white bg-emerald-800 hover:bg-emerald-900 px-3.5 py-2 rounded-xl shadow-md shadow-emerald-900/20 transition active:scale-95">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Buat Pengaduan</span>
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="col-span-2 sm:col-span-auto inline-flex items-center justify-center gap-1.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-xl transition">
                            <span>Dashboard Staff</span>
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="col-span-2 sm:col-span-auto inline-flex items-center justify-center gap-1.5 text-xs font-bold text-slate-600 hover:text-slate-900 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                            <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Login Pegawai</span>
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @if (session('success'))
            <div class="max-w-4xl mx-auto px-3 sm:px-6 lg:px-8 mt-4">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl p-4 flex items-center gap-3 shadow-xs">
                    <svg class="w-5 h-5 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs sm:text-sm font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-4xl mx-auto px-3 sm:px-6 lg:px-8 mt-4">
                <div class="bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl p-4 flex items-center gap-3 shadow-xs">
                    <svg class="w-5 h-5 text-rose-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs sm:text-sm font-bold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-12 py-6 text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
            <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-2">
                <div class="w-6 h-6 rounded-lg bg-emerald-800 flex items-center justify-center text-white font-extrabold text-[10px] shrink-0">IT</div>
                <span class="font-bold text-slate-700 text-xs">Instalasi Teknologi Informasi &amp; Komunikasi RSUD RAA. Soewondo</span>
            </div>
            <p class="text-[11px] text-slate-400 font-medium">&copy; {{ date('Y') }} RSUD RAA. Soewondo IT Helpdesk System.</p>
        </div>
    </footer>
</body>
</html>