<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Helpdesk IT RSUD - Layanan Pengaduan Cepat & Terpadu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Vite Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 selection:bg-teal-500 selection:text-white">
    <!-- Navbar Header -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-teal-700 to-teal-500 flex items-center justify-center text-white shadow-md shadow-teal-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <span class="text-lg font-black tracking-tight text-slate-900">HELPDESK RSUD <span class="text-teal-600"> RAA. SOEWONDO</span></span>
                    <p class="text-xs text-slate-500 font-medium">Instalasi TI & SIMRS</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('guest.ticket.track') }}" class="text-sm font-semibold text-slate-700 hover:text-teal-600 px-3.5 py-2 rounded-lg hover:bg-slate-100 transition">
                    Lacak Status Tiket
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 px-4 py-2 rounded-lg transition shadow-sm">
                        Masuk Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 px-4 py-2 rounded-lg transition">
                        Login Petugas
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden py-16 sm:py-24 bg-gradient-to-b from-teal-50/60 to-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-100 text-teal-800 text-xs font-semibold uppercase tracking-wider mb-6">
                <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                Layanan Cepat IT Support RSUD
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight max-w-3xl mx-auto">
                Pusat Bantuan & Pengaduan Layanan <span class="text-teal-600">IT RSUD</span>
            </h1>

            <p class="mt-5 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Laporkan kendala SIMRS, komputer, jaringan, printer, atau sistem rekam medis di unit Anda dengan cepat tanpa perlu login. Tim IT siap melayani 24/7.
            </p>

            <!-- Quick Action Cards -->
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-xl mx-auto">
                <a href="{{ route('guest.ticket.create') }}" class="flex flex-col items-center justify-center p-6 bg-teal-600 hover:bg-teal-700 text-white rounded-2xl shadow-lg shadow-teal-600/30 hover:scale-[1.02] transition duration-200 group text-center">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold">Buat Pengaduan Baru</span>
                    <span class="text-xs text-teal-100 mt-1">Isi form keluhan & dapatkan nomor tiket</span>
                </a>

                <a href="{{ route('guest.ticket.track') }}" class="flex flex-col items-center justify-center p-6 bg-white hover:bg-slate-100 text-slate-900 border border-slate-200 rounded-2xl shadow-sm hover:scale-[1.02] transition duration-200 group text-center">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold">Lacak Status Tiket</span>
                    <span class="text-xs text-slate-500 mt-1">Cek progress penanganan oleh Teknisi</span>
                </a>
            </div>

            <!-- Quick Track Input directly on Hero -->
            <div class="mt-8 max-w-lg mx-auto bg-white p-2.5 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-2">
                <input type="text" id="quickTrackInput" placeholder="Ketik Nomor Tiket (Contoh: HD-20260820-0001)..." class="flex-grow text-sm border-0 focus:ring-0 px-4 py-2 text-slate-800 placeholder-slate-400">
                <button onclick="quickTrack()" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition">
                    Lacak
                </button>
            </div>
            <script>
                function quickTrack() {
                    const input = document.getElementById('quickTrackInput').value.trim();
                    if (input) {
                        window.location.href = "{{ route('guest.ticket.track') }}?ticket_number=" + encodeURIComponent(input);
                    }
                }
            </script>
        </div>
    </section>

    <!-- Services / Categories Info Section -->
    <section class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Kategori Layanan IT RSUD</h2>
                <p class="text-sm text-slate-500 mt-2">Dukungan komprehensif untuk seluruh operasional rumah sakit.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Perangkat Keras (Hardware)</h3>
                    <p class="text-sm text-slate-600 mt-2">PC kasir/poli mati, printer resep/label barcode macet, scanner, monitor, barcode reader, dan perangkat medis terhubung.</p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">SIMRS & Aplikasi Medis</h3>
                    <p class="text-sm text-slate-600 mt-2">Error bridging BPJS/Vclaim, masalah input rekam medis elektronik (RME), bridging laboratorium (LIS), billing kasir, dan farmasi.</p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Jaringan & Internet RSUD</h3>
                    <p class="text-sm text-slate-600 mt-2">Koneksi LAN ruangan terputus, WiFi rumah sakit lambat/gangguan, konfigurasi IP, dan akses server lokal.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Workflow Steps -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Alur Penanganan Pengaduan</h2>
                <p class="text-sm text-slate-500 mt-2">Proses transparan dan terpantau dengan standar respon SLA.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 text-center">
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-teal-600 text-white font-bold flex items-center justify-center mx-auto mb-3">1</div>
                    <h4 class="font-bold text-slate-900 text-base">Buat Pengaduan</h4>
                    <p class="text-xs text-slate-500 mt-1">Isi form kendala, unit Anda, dan foto bukti masalah.</p>
                </div>
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-teal-600 text-white font-bold flex items-center justify-center mx-auto mb-3">2</div>
                    <h4 class="font-bold text-slate-900 text-base">Validasi & Triage</h4>
                    <p class="text-xs text-slate-500 mt-1">Admin IT memvalidasi dan menentukan prioritas SLA.</p>
                </div>
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-teal-600 text-white font-bold flex items-center justify-center mx-auto mb-3">3</div>
                    <h4 class="font-bold text-slate-900 text-base">Penanganan Teknisi</h4>
                    <p class="text-xs text-slate-500 mt-1">Teknisi ditugaskan dan langsung menuju lokasi unit.</p>
                </div>
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-teal-600 text-white font-bold flex items-center justify-center mx-auto mb-3">4</div>
                    <h4 class="font-bold text-slate-900 text-base">Selesai & Ulasan</h4>
                    <p class="text-xs text-slate-500 mt-1">Masalah terselesaikan dan Anda dapat memberi penilaian.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 text-center text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-md bg-teal-600 flex items-center justify-center text-white font-bold text-xs">IT</div>
                <span class="font-semibold text-slate-700">Instalasi Teknologi Informasi & Komunikasi RSUD</span>
            </div>
            <p>&copy; {{ date('Y') }} RSUD IT Helpdesk System. Layanan Cepat & Terpadu.</p>
        </div>
    </footer>
</body>
</html>
