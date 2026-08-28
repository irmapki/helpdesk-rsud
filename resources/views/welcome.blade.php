<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Helpdesk IT - RSUD RAA Soewondo Pati</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Vite Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f8fafc] text-slate-900 selection:bg-emerald-600 selection:text-white min-h-screen flex flex-col justify-between">
    <!-- Navbar Header (Strictly 1 Single Row on All Screen Sizes) -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 shadow-xs">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2 min-w-0">
            <!-- Logo & Title -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 sm:gap-3.5 group min-w-0">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white flex items-center justify-center p-1 border border-slate-200/80 shadow-xs group-hover:shadow-md transition overflow-hidden shrink-0">
                    <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD RAA Soewondo" class="w-full h-full object-contain">
                </div>
                <div class="min-w-0">
                    <span class="text-xs sm:text-lg font-black tracking-tight text-slate-900 block leading-tight truncate">
                        HELPDESK RSUD <span class="text-emerald-700">RAA. SOEWONDO</span>
                    </span>
                    <p class="text-[10px] sm:text-xs text-slate-500 font-semibold tracking-wide truncate">Instalasi TI &amp; SIMRS</p>
                </div>
            </a>

            <!-- Right Actions (Strictly 1 Row) -->
            <div class="flex items-center gap-1.5 sm:gap-3 shrink-0">
                <a href="{{ route('guest.ticket.track') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-sm font-bold text-slate-700 hover:text-emerald-700 px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-xl hover:bg-slate-100 transition shrink-0 whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="hidden sm:inline">Lacak Status Tiket</span>
                    <span class="sm:hidden">Lacak</span>
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 px-3 py-1.5 sm:px-4 sm:py-2.5 rounded-xl transition shadow-xs shrink-0 whitespace-nowrap">
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-sm font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300/80 px-2.5 py-1.5 sm:px-4 sm:py-2.5 rounded-xl transition shadow-xs shrink-0 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden sm:inline">Login Petugas</span>
                        <span class="sm:hidden">Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow">
        <section class="relative overflow-hidden py-14 sm:py-20 bg-gradient-to-b from-emerald-50/70 via-slate-50 to-[#f8fafc]">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <!-- Pill Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-100/80 border border-emerald-200 text-emerald-800 text-xs font-extrabold uppercase tracking-wider mb-6 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                    <span>Layanan Cepat IT Support RSUD</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-tight max-w-4xl mx-auto">
                    Pusat Bantuan &amp; Pengaduan Layanan <span class="text-emerald-700">IT RSUD RAA. SOEWONDO</span>
                </h1>

                <!-- Subtitle -->
                <p class="mt-4 text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed font-medium">
                    Selamat datang! Laporkan kendala SIMRS, komputer, jaringan, printer, atau sistem rekam medis di unit Anda dengan mudah. Tim IT kami siap membantu dan menindaklanjuti setiap kendala Anda.
                </p>

                <!-- Quick Action Cards Grid (Harmonized Colors) -->
                <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-5 max-w-2xl mx-auto">
                    <!-- Buat Pengaduan Card -->
                    <a href="{{ route('guest.ticket.create') }}"
                        class="flex flex-col items-center justify-center p-7 bg-gradient-to-br from-emerald-700 via-emerald-800 to-teal-900 text-white rounded-3xl shadow-xl shadow-emerald-800/25 hover:shadow-2xl hover:shadow-emerald-800/35 hover:scale-[1.02] transition duration-200 group text-center border border-emerald-600/30">
                        <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center mb-3.5 group-hover:scale-110 transition border border-white/20">
                            <svg class="w-7 h-7 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="text-lg sm:text-xl font-black">Buat Pengaduan Baru</span>
                        <span class="text-xs text-emerald-100/90 mt-1 font-medium">Isi form keluhan &amp; dapatkan nomor tiket</span>
                    </a>

                    <!-- Lacak Tiket Card -->
                    <a href="{{ route('guest.ticket.track') }}"
                        class="flex flex-col items-center justify-center p-7 bg-white hover:bg-slate-50 text-slate-900 border border-slate-200/90 rounded-3xl shadow-lg shadow-slate-200/50 hover:shadow-xl hover:scale-[1.02] transition duration-200 group text-center">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-3.5 group-hover:scale-110 transition border border-emerald-100">
                            <svg class="w-7 h-7 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <span class="text-lg sm:text-xl font-black">Lacak Status Tiket</span>
                        <span class="text-xs text-slate-500 mt-1 font-medium">Cek progress penanganan oleh Teknisi</span>
                    </a>
                </div>

                <!-- Quick Track Input Bar -->
                <form action="{{ route('guest.ticket.track') }}" method="GET" class="mt-8 max-w-xl mx-auto bg-white p-2 rounded-2xl shadow-md shadow-slate-200/60 border border-slate-200 flex items-center gap-2">
                    <div class="pl-3 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="ticket_number" required placeholder="Ketik Nomor Tiket (Contoh: HD-20260824-0001)..."
                        class="flex-grow text-xs sm:text-sm border-0 focus:ring-0 px-2 py-2.5 text-slate-800 placeholder-slate-400 font-medium">
                    <button type="submit" class="bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-bold px-5 py-3 rounded-xl transition shadow-xs">
                        Lacak
                    </button>
                </form>
            </div>
        </section>

        <!-- Services / Categories Info Section -->
        <section class="py-16 bg-white border-t border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Kategori Layanan IT RSUD RAA. SOEWONDO</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 font-medium">Dukungan komprehensif untuk seluruh operasional ruangan dan instalasi rumah sakit.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 hover:shadow-lg transition">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Perangkat Keras (Hardware)</h3>
                        <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">PC kasir/poli mati, printer cetak resep/label barcode macet, scanner, monitor, barcode reader, dan perangkat medis terhubung.</p>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 hover:shadow-lg transition">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900">SIMRS &amp; Aplikasi Medis</h3>
                        <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">Error bridging BPJS/Vclaim, masalah input rekam medis elektronik (RME), bridging laboratorium (LIS), billing kasir, dan farmasi.</p>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 hover:shadow-lg transition">
                        <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Jaringan &amp; Internet RSUD</h3>
                        <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">Koneksi LAN ruangan terputus, WiFi rumah sakit lambat/gangguan, konfigurasi IP, dan akses server lokal.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Workflow Steps Section -->
        <section class="py-16 bg-slate-50/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Alur Penanganan Pengaduan</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 font-medium">Proses transparan dan terpantau dengan standar respon SLA.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 text-center">
                    <div class="p-6 bg-white rounded-3xl border border-slate-200/80 shadow-xs">
                        <div class="w-11 h-11 rounded-2xl bg-emerald-700 text-white font-black text-sm flex items-center justify-center mx-auto mb-3 shadow-sm">1</div>
                        <h4 class="font-extrabold text-slate-900 text-sm">Buat Pengaduan</h4>
                        <p class="text-xs text-slate-500 mt-1">Isi form kendala, unit Anda, dan foto bukti masalah.</p>
                    </div>
                    <div class="p-6 bg-white rounded-3xl border border-slate-200/80 shadow-xs">
                        <div class="w-11 h-11 rounded-2xl bg-emerald-700 text-white font-black text-sm flex items-center justify-center mx-auto mb-3 shadow-sm">2</div>
                        <h4 class="font-extrabold text-slate-900 text-sm">Validasi &amp; Triage</h4>
                        <p class="text-xs text-slate-500 mt-1">Admin IT memvalidasi dan menentukan prioritas SLA.</p>
                    </div>
                    <div class="p-6 bg-white rounded-3xl border border-slate-200/80 shadow-xs">
                        <div class="w-11 h-11 rounded-2xl bg-emerald-700 text-white font-black text-sm flex items-center justify-center mx-auto mb-3 shadow-sm">3</div>
                        <h4 class="font-extrabold text-slate-900 text-sm">Penanganan Teknisi</h4>
                        <p class="text-xs text-slate-500 mt-1">Teknisi ditugaskan dan langsung menuju lokasi unit.</p>
                    </div>
                    <div class="p-6 bg-white rounded-3xl border border-slate-200/80 shadow-xs">
                        <div class="w-11 h-11 rounded-2xl bg-emerald-700 text-white font-black text-sm flex items-center justify-center mx-auto mb-3 shadow-sm">4</div>
                        <h4 class="font-extrabold text-slate-900 text-sm">Selesai &amp; Ulasan</h4>
                        <p class="text-xs text-slate-500 mt-1">Masalah terselesaikan dan Anda dapat memberi penilaian.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200/80 py-8 text-center text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white border border-slate-200 flex items-center justify-center p-0.5 overflow-hidden shadow-xs">
                    <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-full h-full object-contain">
                </div>
                <span class="font-bold text-slate-700">Instalasi Teknologi Informasi &amp; Komunikasi RSUD RAA Soewondo Pati</span>
            </div>
            <p class="text-slate-400 font-medium">&copy; {{ date('Y') }} RSUD IT Helpdesk System. Layanan Cepat &amp; Terpadu.</p>
        </div>
    </footer>
</body>
</html>