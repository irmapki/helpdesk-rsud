<x-app-layout>
    <div class="space-y-6">
        <!-- Top Title & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Ringkasan Sistem</h1>
                <p class="text-xs text-slate-500 font-normal mt-1">Kontrol penuh atas user, role, kategori, prioritas, unit, dan konfigurasi SLA IT Helpdesk RSUD RAA Soewondo Pati.</p>
            </div>
            <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center gap-1.5 bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition hover:scale-[1.02]">
                <span class="text-sm font-bold">+</span>
                <span>Tambah User</span>
            </a>
        </div>

        <!-- 4 Summary Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Total User Sistem -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="mt-3">
                    <span class="text-xs font-semibold text-slate-600 block">Total User Sistem</span>
                    <div class="text-3xl font-black text-slate-900 mt-1">{{ $totalUsers }}</div>
                    <span class="text-xs font-bold text-emerald-600 mt-2 inline-block">+3 bulan ini</span>
                </div>
            </div>

            <!-- Card 2: Teknisi Aktif -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div class="w-9 h-9 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </div>
                <div class="mt-3">
                    <span class="text-xs font-semibold text-slate-600 block">Teknisi Aktif</span>
                    <div class="text-3xl font-black text-slate-900 mt-1">{{ $totalActiveTechnicians }}</div>
                    <span class="text-xs font-medium text-slate-400 mt-2 inline-block">{{ $totalTechnicians }} terdaftar</span>
                </div>
            </div>

            <!-- Card 3: Tiket Aktif Sistem -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <div class="mt-3">
                    <span class="text-xs font-semibold text-slate-600 block">Tiket Aktif Sistem</span>
                    <div class="text-3xl font-black text-slate-900 mt-1">{{ $totalTickets }}</div>
                    <span class="text-xs font-bold text-amber-600 mt-2 inline-block">{{ $resolvedTickets }} tiket selesai</span>
                </div>
            </div>

            <!-- Card 4: SLA Compliance -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="mt-3">
                    <span class="text-xs font-semibold text-slate-600 block">SLA Compliance</span>
                    <div class="text-3xl font-black text-slate-900 mt-1">92%</div>
                    <span class="text-xs font-bold text-emerald-600 mt-2 inline-block">+1.4% vs bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- 2-Columns Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Kolom Kiri: Daftar Pengguna (8 cols) -->
            <div x-data="{ filterRole: 'all' }" class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Daftar Pengguna</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Seluruh akun aktif pada sistem IT Helpdesk</p>
                    </div>

                    <!-- Role Filter Tabs -->
                    <div class="flex items-center gap-1">
                        <button type="button" @click="filterRole = 'all'"
                            :class="filterRole === 'all' ? 'bg-sky-100 text-sky-900 font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-3 py-1 rounded-lg text-xs transition">
                            Semua
                        </button>
                        <button type="button" @click="filterRole = 'admin'"
                            :class="filterRole === 'admin' ? 'bg-sky-100 text-sky-900 font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-3 py-1 rounded-lg text-xs transition">
                            Admin
                        </button>
                        <button type="button" @click="filterRole = 'teknisi'"
                            :class="filterRole === 'teknisi' ? 'bg-sky-100 text-sky-900 font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-3 py-1 rounded-lg text-xs transition">
                            Teknisi
                        </button>
                        <button type="button" @click="filterRole = 'supervisor'"
                            :class="filterRole === 'supervisor' ? 'bg-sky-100 text-sky-900 font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-3 py-1 rounded-lg text-xs transition">
                            Supervisor
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="text-slate-400 uppercase font-bold text-[11px] border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-2">NAMA PENGGUNA</th>
                                <th class="py-3 px-2">ROLE</th>
                                <th class="py-3 px-2">UNIT</th>
                                <th class="py-3 px-2">STATUS</th>
                                <th class="py-3 px-2 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentUsers as $u)
                                @php
                                    $roleName = strtolower($u->role->name ?? '');
                                    $roleLabel = $u->role->label ?? $u->role->name ?? '-';

                                    // Avatar color mapping matching reference
                                    $avatarClass = 'bg-slate-600';
                                    $roleBadgeClass = 'bg-slate-100 text-slate-700';

                                    if (str_contains($roleName, 'superadmin')) {
                                        $avatarClass = 'bg-purple-700';
                                        $roleBadgeClass = 'bg-purple-100 text-purple-700';
                                    } elseif (str_contains($roleName, 'admin')) {
                                        $avatarClass = 'bg-teal-700';
                                        $roleBadgeClass = 'bg-sky-100 text-sky-700';
                                    } elseif (str_contains($roleName, 'teknisi') || str_contains($roleName, 'technician')) {
                                        $avatarClass = 'bg-amber-700';
                                        $roleBadgeClass = 'bg-orange-100 text-orange-700';
                                    } elseif (str_contains($roleName, 'supervisor')) {
                                        $avatarClass = 'bg-indigo-800';
                                        $roleBadgeClass = 'bg-blue-100 text-blue-700';
                                    }

                                    // Get 2 letter initials
                                    $words = explode(' ', trim($u->name));
                                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : substr($words[0], 1, 1)));
                                @endphp
                                <tr x-show="filterRole === 'all' || '{{ $roleName }}'.includes(filterRole)" class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full {{ $avatarClass }} text-white font-bold text-xs flex items-center justify-center shrink-0">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 text-sm">{{ $u->name }}</div>
                                                <div class="text-[11px] text-slate-400 font-mono">{{ $u->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-2">
                                        <span class="inline-block px-3 py-1 rounded-xl text-xs font-bold {{ $roleBadgeClass }}">
                                            {{ $roleLabel }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-2 text-slate-700 font-medium text-xs">
                                        {{ $u->unit->name ?? 'Divisi IT' }}
                                    </td>
                                    <td class="py-3.5 px-2">
                                        @if ($u->is_active)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-2 text-right">
                                        <div class="inline-flex items-center gap-1.5 justify-end">
                                            <!-- Edit Icon Button -->
                                            <a href="{{ route('superadmin.users.edit', $u) }}" class="p-1.5 rounded-lg border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-800 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            <!-- Delete Icon Button -->
                                            <form action="{{ route('superadmin.users.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun pengguna ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-rose-600 transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-slate-400">Belum ada user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kolom Kanan: Master Data & SLA (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Card 1: Konfigurasi Master Data -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Konfigurasi Master Data</h3>
                        <p class="text-[11px] text-slate-400">Dikelola oleh Super Admin</p>
                    </div>

                    <div class="space-y-3">
                        <!-- Kategori Tiket -->
                        <a href="{{ route('superadmin.categories.index') }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block group-hover:text-emerald-800">Kategori Tiket</span>
                                    <span class="text-[10px] text-slate-400 block">Hardware, Software, Jaringan, dll</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-800 text-xs">{{ $totalCategories }}</span>
                        </a>

                        <!-- Prioritas Tiket -->
                        <a href="{{ route('superadmin.priorities.index') }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block group-hover:text-emerald-800">Prioritas Tiket</span>
                                    <span class="text-[10px] text-slate-400 block">Tinggi, Sedang, Rendah</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-800 text-xs">{{ $totalPriorities }}</span>
                        </a>

                        <!-- Unit / Bagian -->
                        <a href="{{ route('superadmin.units.index') }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block group-hover:text-emerald-800">Unit / Bagian</span>
                                    <span class="text-[10px] text-slate-400 block">Poli, IGD, Rekam Medis, dll</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-800 text-xs">{{ $totalUnits }}</span>
                        </a>

                        <!-- Data Teknisi -->
                        <a href="{{ route('superadmin.technicians.index') }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block group-hover:text-emerald-800">Data Teknisi</span>
                                    <span class="text-[10px] text-slate-400 block">Sinkron dengan Kelola User</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-800 text-xs">{{ $totalTechnicians }}</span>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Konfigurasi SLA -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-sm text-slate-900">Konfigurasi SLA</h3>
                            <p class="text-[11px] text-slate-400">Target waktu penyelesaian per prioritas</p>
                        </div>
                        <a href="{{ route('superadmin.priorities.index') }}" class="text-xs font-bold text-slate-700 hover:text-slate-900 border border-slate-200 hover:border-slate-300 px-3 py-1 rounded-lg transition">
                            Atur
                        </a>
                    </div>

                    <div class="space-y-2.5 text-xs">
                        @foreach ($priorities as $p)
                            @php
                                $dotColor = 'bg-slate-400';
                                if (str_contains(strtolower($p->name), 'tinggi') || str_contains(strtolower($p->name), 'high') || str_contains(strtolower($p->name), 'critical')) {
                                    $dotColor = 'bg-rose-500';
                                } elseif (str_contains(strtolower($p->name), 'sedang') || str_contains(strtolower($p->name), 'medium')) {
                                    $dotColor = 'bg-amber-500';
                                } elseif (str_contains(strtolower($p->name), 'rendah') || str_contains(strtolower($p->name), 'low')) {
                                    $dotColor = 'bg-emerald-500';
                                }
                            @endphp
                            <div class="flex items-center justify-between py-1">
                                <div class="flex items-center gap-2 font-bold text-slate-800">
                                    <span class="w-2 h-2 rounded-full {{ $dotColor }}"></span>
                                    <span>{{ $p->name }}</span>
                                </div>
                                <span class="font-black text-slate-900">{{ $p->sla_hours }} <span class="text-[10px] text-slate-500">JAM</span></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>