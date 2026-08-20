@extends('layouts.auth')

@section('content')
<div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 gap-0 bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/20">
    <!-- Left Column: Branding -->
    <div class="lg:col-span-5 bg-gradient-to-br from-teal-700 via-emerald-800 to-slate-900 p-8 lg:p-12 text-white flex flex-col justify-between relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div>
            <div class="flex items-center space-x-3 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 shadow-inner">
                    <svg class="w-7 h-7 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-teal-300 block">Sistem Informasi PKL</span>
                    <h2 class="text-xl font-bold tracking-tight text-white">RSUD IT HELPDESK</h2>
                </div>
            </div>

            <div class="space-y-4 my-8">
                <h1 class="text-2xl lg:text-3xl font-extrabold text-white leading-tight">
                    Pusat Layanan & Penanganan Masalah TI RSUD
                </h1>
                <p class="text-teal-100/80 text-sm leading-relaxed">
                    Sistem terpadu pengelolaan tiket insiden, permintaan layanan teknis, monitoring SLA, dan pelaporan performa divisi IT Rumah Sakit Umum Daerah.
                </p>
            </div>

            <div class="space-y-3 pt-2 text-xs text-teal-100/90 font-medium">
                <div class="flex items-center space-x-3 bg-white/5 backdrop-blur-sm p-2.5 rounded-xl border border-white/10">
                    <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-teal-500/30 flex items-center justify-center text-teal-300">✓</span>
                    <span>Multi-Role Access (Super Admin, Admin, Teknisi, Supervisor)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white/5 backdrop-blur-sm p-2.5 rounded-xl border border-white/10">
                    <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-teal-500/30 flex items-center justify-center text-teal-300">✓</span>
                    <span>Monitoring Target Waktu SLA & Insiden Kritis RSUD</span>
                </div>
                <div class="flex items-center space-x-3 bg-white/5 backdrop-blur-sm p-2.5 rounded-xl border border-white/10">
                    <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-teal-500/30 flex items-center justify-center text-teal-300">✓</span>
                    <span>Distribusi & Tracking Penugasan Teknisi Real-Time</span>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-teal-200/70">
            <span>Versi 1.0.0 (PKL Project)</span>
            <span>&copy; {{ date('Y') }} Tim IT RSUD</span>
        </div>
    </div>

    <!-- Right Column: Login Form -->
    <div class="lg:col-span-7 p-8 lg:p-12 flex flex-col justify-between bg-white">
        <div>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800">Masuk ke Sistem</h3>
                    <p class="text-sm text-slate-500 mt-1">Silakan masukkan kredensial akun Anda</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200">
                    <span class="w-2 h-2 rounded-full bg-teal-500 mr-2 animate-pulse"></span> Sistem Aktif
                </span>
            </div>

            @if(session('status'))
                <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                    <div class="font-bold flex items-center space-x-2 mb-1">
                        <span>Gagal Masuk:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 ml-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@rsud.go.id"
                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all font-medium">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all font-medium">
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span class="ml-2 text-xs font-semibold text-slate-600">Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full mt-2 py-3.5 px-4 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-teal-600/30 hover:shadow-xl hover:shadow-teal-600/40 transition-all transform active:scale-[0.99] flex items-center justify-center space-x-2 text-sm">
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <!-- Demo credentials -->
            <div class="mt-8 pt-6 border-t border-slate-100">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">⚡ Akun demo (klik untuk isi otomatis)</span>
                    <span class="text-[11px] text-teal-600 font-semibold bg-teal-50 px-2 py-0.5 rounded-full">Password: password</span>
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    <div class="grid grid-cols-2 gap-2.5">
    <button type="button" onclick="fillCredentials('superadmin@rsud.test')"
        class="p-2.5 rounded-xl border border-purple-200 bg-purple-50/70 hover:bg-purple-100 hover:border-purple-300 text-left transition-all">
        <span class="text-xs font-bold text-purple-900 block">👑 Super Admin</span>
        <span class="text-[11px] text-purple-700/80 truncate block mt-0.5">superadmin@rsud.test</span>
    </button>

    <button type="button" onclick="fillCredentials('admin@rsud.test')"
        class="p-2.5 rounded-xl border border-blue-200 bg-blue-50/70 hover:bg-blue-100 hover:border-blue-300 text-left transition-all">
        <span class="text-xs font-bold text-blue-900 block">📋 Admin</span>
        <span class="text-[11px] text-blue-700/80 truncate block mt-0.5">admin@rsud.test</span>
    </button>

    <button type="button" onclick="fillCredentials('teknisi@rsud.test')"
        class="p-2.5 rounded-xl border border-emerald-200 bg-emerald-50/70 hover:bg-emerald-100 hover:border-emerald-300 text-left transition-all">
        <span class="text-xs font-bold text-emerald-900 block">🔧 Teknisi</span>
        <span class="text-[11px] text-emerald-700/80 truncate block mt-0.5">teknisi@rsud.test</span>
    </button>

    <button type="button" onclick="fillCredentials('supervisor@rsud.test')"
        class="p-2.5 rounded-xl border border-amber-200 bg-amber-50/70 hover:bg-amber-100 hover:border-amber-300 text-left transition-all">
        <span class="text-xs font-bold text-amber-900 block">📊 Supervisor</span>
        <span class="text-[11px] text-amber-700/80 truncate block mt-0.5">supervisor@rsud.test</span>
    </button>
</div>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center text-xs text-slate-400">
            Aplikasi Praktik Kerja Lapangan (PKL) &bull; Sistem Informasi IT Helpdesk RSUD
        </div>
    </div>
</div>

<script>
    function fillCredentials(email) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = 'password';
        const emailInput = document.getElementById('email');
        emailInput.classList.add('ring-2', 'ring-teal-500');
        setTimeout(() => emailInput.classList.remove('ring-2', 'ring-teal-500'), 600);
    }
</script>
@endsection