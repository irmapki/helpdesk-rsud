<x-app-layout>
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

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Total Pengguna:</span>
                        <span class="font-black text-slate-900 text-sm">{{ $role->users->count() }} User</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
