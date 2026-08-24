<x-app-layout>
<<<<<<< HEAD
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Role Pengguna</h1>
            <p class="text-xs text-slate-500 font-normal mt-1">Daftar peran akses dalam sistem Helpdesk IT RSUD RAA Soewondo beserta anggota user.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($roles as $role)
                @php
                    $rName = strtolower($role->name);
                    $badgeStyle = 'bg-slate-100 text-slate-700';
                    $dotColor = 'bg-slate-600';

                    if (str_contains($rName, 'superadmin')) {
                        $badgeStyle = 'bg-purple-100 text-purple-700';
                        $dotColor = 'bg-purple-700';
                    } elseif (str_contains($rName, 'admin')) {
                        $badgeStyle = 'bg-sky-100 text-sky-700';
                        $dotColor = 'bg-teal-700';
                    } elseif (str_contains($rName, 'teknisi') || str_contains($rName, 'technician')) {
                        $badgeStyle = 'bg-orange-100 text-orange-700';
                        $dotColor = 'bg-amber-700';
                    } elseif (str_contains($rName, 'supervisor')) {
                        $badgeStyle = 'bg-blue-100 text-blue-700';
                        $dotColor = 'bg-indigo-800';
                    }
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <span class="text-[10px] font-mono uppercase text-slate-400 font-bold">{{ $role->name }}</span>
                            <h3 class="text-base font-bold text-slate-900 mt-0.5">{{ $role->label }}</h3>
                        </div>
                        <span class="inline-block px-3 py-1 rounded-xl text-xs font-bold {{ $badgeStyle }}">
                            {{ $role->users_count }} Pengguna
                        </span>
                    </div>

                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2.5">
                            ANGGOTA DENGAN ROLE INI:
                        </span>

                        <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                            @forelse ($role->users as $u)
                                @php
                                    $words = explode(' ', trim($u->name));
                                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : substr($words[0], 1, 1)));
                                @endphp
                                <div class="flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 border border-slate-100 text-xs transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full {{ $dotColor }} text-white font-bold flex items-center justify-center text-xs shadow-xs">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900">{{ $u->name }}</div>
                                            <div class="text-slate-400 text-[11px] font-mono">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                    <span class="text-[11px] text-slate-600 font-medium">
                                        {{ $u->unit->name ?? 'Semua Unit' }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 py-4 text-center">Belum ada user yang memiliki role ini.</p>
                            @endforelse
=======
    <x-slot name="pageTitle">
        Kelola Role Pengguna
    </x-slot>
    <x-slot name="breadcrumb">
        Super Admin &rsaquo; Manajemen Role &amp; Hak Akses
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Role &amp; Hak Akses</h1>
            <p class="text-xs text-slate-500 mt-1">Struktur peran dan izin pengguna pada sistem Helpdesk RSUD.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($roles as $role)
                @php
                    $badgeStyle = match ($role->name) {
                        'super_admin' => 'bg-purple-50 text-purple-700 border-purple-200',
                        'admin' => 'bg-sky-50 text-sky-700 border-sky-200',
                        'teknisi' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'supervisor' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                    };
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border {{ $badgeStyle }}">
                                {{ $role->label }}
                            </span>
                            <span class="text-xs font-mono text-slate-400 font-semibold">{{ $role->name }}</span>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                        </div>
                        <h2 class="text-sm font-extrabold text-slate-900">{{ $role->label }}</h2>
                        <p class="text-xs text-slate-500 mt-1">
                            @if ($role->name === 'super_admin')
                                Konfigurasi master data, SLA, kategori, unit, user, dan role.
                            @elseif ($role->name === 'admin')
                                Menerima pengaduan, validasi tiket, assign teknisi, &amp; monitoring SLA.
                            @elseif ($role->name === 'teknisi')
                                Menangani kerusakan teknis, update progress, dan penyelesaian kendala.
                            @elseif ($role->name === 'supervisor')
                                Pengawasan performa teknisi, rekapitulasi laporan, &amp; eskalasi tiket.
                            @endif
                        </p>
                    </div>
<<<<<<< HEAD
=======

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Total Pengguna:</span>
                        <span class="font-black text-slate-900 text-sm">{{ $role->users->count() }} User</span>
                    </div>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
