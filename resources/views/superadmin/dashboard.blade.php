<x-app-layout>
    <x-slot name="pageTitle">
        Dashboard Super Admin
    </x-slot>
    <x-slot name="breadcrumb">
        Super Admin &rsaquo; Ringkasan Eksekutif &amp; Konfigurasi
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <!-- Page Title & Top Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Ringkasan Sistem</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Kontrol penuh atas user, role, kategori, prioritas, unit, dan konfigurasi SLA IT Helpdesk RSUD RAA Soewondo Pati.
                </p>
            </div>

            <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#0a252a] hover:bg-[#0e353c] text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition hover:scale-[1.02] shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ Tambah User</span>
            </a>
        </div>

        <!-- 4 Top Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Stat 1: Total User -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Total User Sistem</span>
                    <div class="text-2xl lg:text-3xl font-black text-slate-900 mt-1">{{ $totalUsers }}</div>
                    <span class="text-[11px] font-bold text-emerald-600 mt-1 inline-block">+3 bulan ini</span>
                </div>
            </div>

            <!-- Stat 2: Teknisi Aktif -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Teknisi Aktif</span>
                    <div class="text-2xl lg:text-3xl font-black text-slate-900 mt-1">{{ $totalActiveTechnicians }}</div>
                    <span class="text-[11px] font-semibold text-slate-400 mt-1 inline-block">2 unit cabang</span>
                </div>
            </div>

            <!-- Stat 3: Tiket Aktif -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Tiket Aktif Sistem</span>
                    <div class="text-2xl lg:text-3xl font-black text-slate-900 mt-1">{{ $openTickets + $assignedTickets + $inProgressTickets ?: 12 }}</div>
                    <span class="text-[11px] font-bold text-amber-600 mt-1 inline-block">18 mendekati SLA</span>
                </div>
            </div>

            <!-- Stat 4: SLA Compliance -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">SLA Compliance</span>
                    <div class="text-2xl lg:text-3xl font-black text-slate-900 mt-1">94%</div>
                    <span class="text-[11px] font-bold text-emerald-600 mt-1 inline-block">+1.4% vs bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Main 2-Columns Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Left Column: User Table (8 cols) -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
                <!-- Table Header & Filter Tabs -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900">Daftar Pengguna</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Seluruh akun aktif pada sistem IT Helpdesk</p>
                    </div>

                    <a href="{{ route('superadmin.users.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-800">
                        Buka Kelola User &rarr;
                    </a>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto mt-4">
                    <table class="w-full text-left text-xs">
                        <thead class="text-[11px] text-slate-400 uppercase font-bold tracking-wider">
                            <tr>
                                <th class="pb-3 pr-4">Nama Pengguna</th>
                                <th class="pb-3 px-4">Role</th>
                                <th class="pb-3 px-4">Unit</th>
                                <th class="pb-3 px-4">Status</th>
                                <th class="pb-3 pl-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentUsers as $u)
                                @php
                                    $roleName = $u->role->name ?? '';
                                    $roleBadge = match ($roleName) {
                                        'super_admin' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'admin' => 'bg-sky-100 text-sky-800 border-sky-200',
                                        'teknisi' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'supervisor' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                        default => 'bg-slate-100 text-slate-800 border-slate-200',
                                    };
                                    $avatarBg = match ($u->id % 5) {
                                        0 => 'bg-purple-700',
                                        1 => 'bg-teal-700',
                                        2 => 'bg-amber-600',
                                        3 => 'bg-indigo-700',
                                        default => 'bg-slate-700',
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 pr-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full {{ $avatarBg }} text-white font-bold flex items-center justify-center text-[11px] shrink-0 shadow-xs">
                                                {{ strtoupper(substr($u->name, 0, 2)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <span class="font-extrabold text-slate-900 block truncate">{{ $u->name }}</span>
                                                <span class="text-[11px] text-slate-400 font-medium truncate block">{{ $u->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold border {{ $roleBadge }}">
                                            {{ $u->role->label ?? $u->role->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-700 font-medium">
                                        {{ $u->unit->name ?? 'Divisi IT' }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if ($u->is_active)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400">
                                                <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 pl-4 text-right">
                                        <a href="{{ route('superadmin.users.edit', $u) }}" title="Edit User"
                                            class="w-7 h-7 rounded-lg border border-slate-200 hover:border-teal-500 hover:bg-teal-50 text-slate-500 hover:text-teal-700 inline-flex items-center justify-center transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-400">Tidak ada data pengguna.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Column: Master Data Cards (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Card 1: Konfigurasi Master Data -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900">Konfigurasi Master Data</h3>
                        <p class="text-[11px] text-slate-500">Dikelola oleh Super Admin</p>
                    </div>

                    <div class="space-y-2.5">
                        <a href="{{ route('superadmin.categories.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50/70 hover:bg-teal-50/70 border border-slate-100 hover:border-teal-200 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-slate-900 group-hover:text-teal-800 block">Kategori Tiket</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Hardware, Software, Jaringan, dll</span>
                                </div>
                            </div>
                            <span class="text-xs font-black text-slate-700 group-hover:text-teal-700">{{ $totalCategories }}</span>
                        </a>

                        <a href="{{ route('superadmin.priorities.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50/70 hover:bg-teal-50/70 border border-slate-100 hover:border-teal-200 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-slate-900 group-hover:text-teal-800 block">Prioritas Tiket</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Tinggi, Sedang, Rendah</span>
                                </div>
                            </div>
                            <span class="text-xs font-black text-slate-700 group-hover:text-teal-700">{{ $totalPriorities }}</span>
                        </a>

                        <a href="{{ route('superadmin.units.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50/70 hover:bg-teal-50/70 border border-slate-100 hover:border-teal-200 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-slate-900 group-hover:text-teal-800 block">Unit / Bagian</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Poli, IGD, Rekam Medis, dll</span>
                                </div>
                            </div>
                            <span class="text-xs font-black text-slate-700 group-hover:text-teal-700">{{ $totalUnits }}</span>
                        </a>

                        <a href="{{ route('superadmin.technicians.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50/70 hover:bg-teal-50/70 border border-slate-100 hover:border-teal-200 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-slate-900 group-hover:text-teal-800 block">Data Teknisi</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Sinkron dengan Kelola User</span>
                                </div>
                            </div>
                            <span class="text-xs font-black text-slate-700 group-hover:text-teal-700">{{ $totalActiveTechnicians }}</span>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Konfigurasi SLA -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Konfigurasi SLA</h3>
                            <p class="text-[11px] text-slate-500">Target waktu penyelesaian per prioritas</p>
                        </div>
                        <a href="{{ route('superadmin.priorities.index') }}" class="px-3 py-1 rounded-lg text-xs font-bold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition">
                            Atur
                        </a>
                    </div>

                    <div class="space-y-3 pt-1">
                        @foreach ($priorities as $pri)
                            @php
                                $dotColor = match (strtolower($pri->name)) {
                                    'high', 'tinggi', 'critical' => 'bg-rose-500',
                                    'medium', 'sedang' => 'bg-amber-500',
                                    'low', 'rendah' => 'bg-emerald-500',
                                    default => 'bg-slate-400',
                                };
                            @endphp
                            <div class="flex items-center justify-between text-xs py-1 border-b border-slate-50 last:border-0">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $dotColor }}"></span>
                                    <span class="font-bold text-slate-800">{{ $pri->name }}</span>
                                </div>
                                <span class="font-black text-slate-900 font-mono">{{ $pri->sla_hours }} JAM</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Preview Note -->
        <div class="text-center text-[11px] text-slate-400 pt-4">
            Preview tampilan Super Admin &mdash; Sistem Informasi IT Helpdesk &amp; Ticketing RSUD RAA Soewondo Pati
        </div>
    </div>
</x-app-layout>