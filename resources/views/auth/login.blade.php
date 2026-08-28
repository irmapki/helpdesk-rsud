@extends('layouts.auth')

@section('content')
<div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-0 bg-white/95 backdrop-blur-xl rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden border border-white/25 relative min-w-0">
    
    <!-- Left Column: Branding (Compact on Mobile, Rich on Desktop) -->
    <div class="lg:col-span-5 bg-gradient-to-br from-teal-700 via-emerald-800 to-slate-900 p-4 sm:p-6 lg:p-12 text-white flex flex-col justify-between relative overflow-hidden min-w-0">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="min-w-0">
            <!-- Header Bar (Logo + Kembali) -->
            <div class="flex items-center justify-between gap-2 mb-3 lg:mb-8 min-w-0">
                <div class="flex items-center space-x-2.5 sm:space-x-3 min-w-0">
                    <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-white flex items-center justify-center border border-white/30 shadow-md overflow-hidden shrink-0">
                        <img src="{{ asset('images/logo-rsud.png') }}" alt="Logo RSUD" class="w-full h-full object-contain p-1">
                    </div>
                    <div class="min-w-0">
                        <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-teal-300 block truncate">Sistem Informasi Helpdesk</span>
                        <h2 class="text-xs sm:text-base font-black tracking-tight text-white truncate">RSUD IT HELPDESK</h2>
                    </div>
                </div>

                <!-- Tombol Kembali ke Beranda -->
                <a href="{{ url('/') }}" class="inline-flex items-center space-x-1 px-2.5 py-1.5 rounded-xl text-[11px] font-bold bg-white/10 hover:bg-white/20 text-white transition-all border border-white/20 shadow-xs shrink-0 backdrop-blur-md">
                    <svg class="w-3.5 h-3.5 text-teal-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Beranda</span>
                </a>
            </div>

            <!-- Descriptive Text (Hidden on small mobile to give instant priority to form) -->
            <div class="hidden lg:block space-y-4 my-8 min-w-0">
                <h1 class="text-2xl lg:text-3xl font-extrabold text-white leading-tight break-words">
                    Pusat Layanan &amp; Penanganan Masalah TI RSUD
                </h1>
                <p class="text-teal-100/80 text-xs sm:text-sm leading-relaxed break-words">
                   Sistem terpadu untuk pengelolaan tiket insiden dan permintaan layanan teknis, pemantauan SLA, serta pelaporan kinerja layanan IT RSUD RAA. Soewondo.
                </p>
            </div>

            <!-- Bullet Points (Desktop Only) -->
            <div class="hidden lg:block space-y-3 pt-2 text-xs text-teal-100/90 font-medium min-w-0">
                <div class="flex items-center space-x-3 bg-white/5 backdrop-blur-sm p-2.5 rounded-xl border border-white/10 min-w-0">
                    <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-teal-500/30 flex items-center justify-center text-teal-300 text-xs font-bold">✓</span>
                    <span class="break-words">Multi-Role Access (Super Admin, Admin, Teknisi, Supervisor)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white/5 backdrop-blur-sm p-2.5 rounded-xl border border-white/10 min-w-0">
                    <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-teal-500/30 flex items-center justify-center text-teal-300 text-xs font-bold">✓</span>
                    <span class="break-words">Monitoring Target Waktu SLA &amp; Insiden Kritis RSUD</span>
                </div>
                <div class="flex items-center space-x-3 bg-white/5 backdrop-blur-sm p-2.5 rounded-xl border border-white/10 min-w-0">
                    <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-teal-500/30 flex items-center justify-center text-teal-300 text-xs font-bold">✓</span>
                    <span class="break-words">Distribusi &amp; Tracking Penugasan Teknisi Real-Time</span>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex mt-8 pt-6 border-t border-white/10 items-center justify-between text-xs text-teal-200/70 min-w-0">
            <span>Versi 1.0.0</span>
            <span>&copy; {{ date('Y') }} Tim IT RSUD</span>
        </div>
    </div>

    <!-- Right Column: Login Form -->
    <div class="lg:col-span-7 p-4 sm:p-8 lg:p-12 flex flex-col justify-between bg-white pt-5 sm:pt-8 lg:pt-12 min-w-0">
        <div class="min-w-0">
            <div class="flex items-center justify-between gap-2 mb-4 sm:mb-6 min-w-0">
                <div class="min-w-0">
                    <h3 class="text-lg sm:text-2xl font-extrabold text-slate-800 break-words">Masuk ke Sistem</h3>
                    <p class="text-[11px] sm:text-sm text-slate-500 mt-0.5 break-words">Silakan masukkan kredensial akun Anda</p>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200 shrink-0">
                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-teal-500 mr-1.5 animate-pulse shrink-0"></span> Sistem Aktif
                </span>
            </div>

            @if(session('status'))
                <div class="mb-4 sm:mb-5 p-3.5 sm:p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm break-words min-w-0">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 sm:mb-5 p-3.5 sm:p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm min-w-0">
                    <div class="font-bold flex items-center space-x-2 mb-1 break-words">
                        <span>Gagal Masuk:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 ml-1 min-w-0">
                        @foreach ($errors->all() as $error)
                            <li class="break-words">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-3.5 sm:space-y-4 min-w-0">
                @csrf
                <div class="min-w-0">
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2 break-words">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@rsud.go.id"
                        class="block w-full px-3.5 sm:px-4 py-2.5 sm:py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all font-medium min-w-0">
                </div>

                <div class="min-w-0">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2 break-words">Kata Sandi</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                        class="block w-full px-3.5 sm:px-4 py-2.5 sm:py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all font-medium min-w-0">
                </div>

                <div class="flex items-center justify-between pt-1 min-w-0">
                    <label class="flex items-center cursor-pointer min-w-0">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500 shrink-0">
                        <span class="ml-2 text-xs font-semibold text-slate-600 break-words">Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full mt-2 py-3 sm:py-3.5 px-4 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-teal-600/30 hover:shadow-xl hover:shadow-teal-600/40 transition-all transform active:scale-[0.99] flex items-center justify-center space-x-2 text-xs sm:text-sm text-center shrink-0">
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <!-- Demo credentials -->
            <div class="mt-6 sm:mt-8 pt-5 sm:pt-6 border-t border-slate-100 min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 sm:gap-2 mb-3 min-w-0">
                    <span class="text-[11px] sm:text-xs font-extrabold uppercase tracking-wider text-slate-500 break-words">⚡ Akun demo (klik untuk isi otomatis)</span>
                    <span class="text-[10px] sm:text-[11px] text-teal-600 font-semibold bg-teal-50 px-2 py-0.5 rounded-full shrink-0 self-start sm:self-auto">Password: password</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 min-w-0">
                    <button type="button" onclick="fillCredentials('superadmin@rsud.test', 'password')"
                        class="p-2.5 rounded-xl border border-purple-200 bg-purple-50/70 hover:bg-purple-100 hover:border-purple-300 text-left transition-all min-w-0">
                        <span class="text-xs font-bold text-purple-900 block break-words">👑 Super Admin</span>
                        <span class="text-[11px] text-purple-700/80 block mt-0.5 break-all">superadmin@rsud.test</span>
                    </button>

                    <button type="button" onclick="fillCredentials('admin@rsud.test', 'password')"
                        class="p-2.5 rounded-xl border border-blue-200 bg-blue-50/70 hover:bg-blue-100 hover:border-blue-300 text-left transition-all min-w-0">
                        <span class="text-xs font-bold text-blue-900 block break-words">📋 Admin</span>
                        <span class="text-[11px] text-blue-700/80 block mt-0.5 break-all">admin@rsud.test</span>
                    </button>

                    <button type="button" onclick="fillCredentials('teknisi@rsud.test', 'password')"
                        class="p-2.5 rounded-xl border border-emerald-200 bg-emerald-50/70 hover:bg-emerald-100 hover:border-emerald-300 text-left transition-all min-w-0">
                        <span class="text-xs font-bold text-emerald-900 block break-words">🔧 Teknisi</span>
                        <span class="text-[11px] text-emerald-700/80 block mt-0.5 break-all">teknisi@rsud.test</span>
                    </button>

                    <button type="button" onclick="fillCredentials('supervisor@rsud.test', 'password')"
                        class="p-2.5 rounded-xl border border-amber-200 bg-amber-50/70 hover:bg-amber-100 hover:border-amber-300 text-left transition-all min-w-0">
                        <span class="text-xs font-bold text-amber-900 block break-words">📊 Supervisor</span>
                        <span class="text-[11px] text-amber-700/80 block mt-0.5 break-all">supervisor@rsud.test</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center text-[11px] sm:text-xs text-slate-400 break-words">
            Sistem Informasi IT Helpdesk RSUD
        </div>
    </div>
</div>

<script>
    function fillCredentials(email, password) {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        emailInput.value = email;
        passwordInput.value = password || 'password';

        emailInput.dispatchEvent(new Event('input', { bubbles: true }));
        passwordInput.dispatchEvent(new Event('input', { bubbles: true }));

        emailInput.classList.add('ring-2', 'ring-teal-500');
        setTimeout(() => emailInput.classList.remove('ring-2', 'ring-teal-500'), 600);
    }
</script>
@endsection