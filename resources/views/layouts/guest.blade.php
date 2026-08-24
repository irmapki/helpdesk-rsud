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
<body class="font-sans antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col selection:bg-teal-500 selection:text-white">
    <!-- Navbar Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('guest.landing') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 flex items-center justify-center">
                    <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-11 h-11 object-contain">
                </div>
                <div>
                    <div class="text-base sm:text-lg font-black tracking-tight text-slate-900 flex items-center gap-1.5">
                        HELPDESK <span class="text-teal-600">RSUD RAA. SOEWONDO</span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium">Sistem Pengaduan & Layanan IT Rumah Sakit</p>
                </div>
            </a>

            <!-- Nav Actions -->
            <div class="flex items-center gap-3">
                <a href="{{ route('guest.ticket.track') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-700 hover:text-teal-600 px-3.5 py-2 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Lacak Tiket</span>
                </a>

                <a href="{{ route('guest.ticket.create') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 px-4 py-2 rounded-lg shadow-sm shadow-teal-600/30 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden sm:inline">Buat Pengaduan</span>
                    <span class="sm:hidden">Buat</span>
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-lg transition ms-1">
                        <span>Dashboard Staff</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-500 hover:text-slate-900 px-2.5 py-2 rounded-lg hover:bg-slate-100 transition ms-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span>Login Pegawai</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 flex items-center gap-3 shadow-xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 flex items-center gap-3 shadow-xs">
                    <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-16 py-8 text-center text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-md bg-teal-600 flex items-center justify-center text-white font-bold text-xs">IT</div>
                <span class="font-semibold text-slate-700">Instalasi Teknologi Informasi & Komunikasi RSUD RAA. Soewondo</span>
            </div>
            <p>&copy; {{ date('Y') }} RSUD RAA. Soewondo IT Helpdesk System. Layanan Cepat & Terpadu.</p>
        </div>
    </footer>
</body>
</html>