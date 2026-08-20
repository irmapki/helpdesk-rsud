<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard Super Admin') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Konfigurasi Master Data & Manajemen Hak Akses Sistem RSUD</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white px-3.5 py-2 rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah User Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Summary Stats Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- Card 1: Users -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs text-gray-400 font-medium uppercase">Total User</span>
                    <div class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $totalUsers }}</div>
                    <a href="{{ route('superadmin.users.index') }}" class="text-[11px] text-teal-600 dark:text-teal-400 font-semibold hover:underline mt-2 inline-block">Kelola User &rarr;</a>
                </div>

                <!-- Card 2: Technicians -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs text-gray-400 font-medium uppercase">Teknisi Aktif</span>
                    <div class="text-2xl font-black text-teal-600 dark:text-teal-400 mt-1">{{ $totalActiveTechnicians }} <span class="text-xs font-normal text-gray-400">/ {{ $totalTechnicians }}</span></div>
                    <a href="{{ route('superadmin.technicians.index') }}" class="text-[11px] text-teal-600 dark:text-teal-400 font-semibold hover:underline mt-2 inline-block">Beban Kerja &rarr;</a>
                </div>

                <!-- Card 3: Units -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs text-gray-400 font-medium uppercase">Unit / Bagian</span>
                    <div class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1">{{ $totalUnits }}</div>
                    <a href="{{ route('superadmin.units.index') }}" class="text-[11px] text-blue-600 dark:text-blue-400 font-semibold hover:underline mt-2 inline-block">Kelola Unit &rarr;</a>
                </div>

                <!-- Card 4: Categories -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs text-gray-400 font-medium uppercase">Kategori Tiket</span>
                    <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">{{ $totalCategories }}</div>
                    <a href="{{ route('superadmin.categories.index') }}" class="text-[11px] text-indigo-600 dark:text-indigo-400 font-semibold hover:underline mt-2 inline-block">Kelola Kategori &rarr;</a>
                </div>

                <!-- Card 5: Priorities -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs text-gray-400 font-medium uppercase">SLA & Prioritas</span>
                    <div class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1">{{ $totalPriorities }}</div>
                    <a href="{{ route('superadmin.priorities.index') }}" class="text-[11px] text-amber-600 dark:text-amber-400 font-semibold hover:underline mt-2 inline-block">Setting SLA &rarr;</a>
                </div>

                <!-- Card 6: Total Tickets -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs text-gray-400 font-medium uppercase">Total Tiket Masuk</span>
                    <div class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1">{{ $totalTickets }}</div>
                    <span class="text-[11px] text-gray-400 mt-2 block">{{ $resolvedTickets }} Tiket Selesai</span>
                </div>
            </div>

            <!-- Main Content 2 Columns -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Users Table (2 cols) -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-bold text-sm text-gray-900 dark:text-white">Pengguna Terbaru</h3>
                            <p class="text-xs text-gray-500">Daftar akun user dan role yang terdaftar</p>
                        </div>
                        <a href="{{ route('superadmin.users.index') }}" class="text-xs font-semibold text-teal-600 dark:text-teal-400 hover:underline">
                            Lihat Semua User &rarr;
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase tracking-wider font-semibold">
                                <tr>
                                    <th class="px-4 py-3 rounded-l-lg">Nama / Email</th>
                                    <th class="px-4 py-3">Role</th>
                                    <th class="px-4 py-3">Unit RSUD</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 rounded-r-lg text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($recentUsers as $u)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="font-bold text-gray-900 dark:text-white">{{ $u->name }}</div>
                                            <div class="text-gray-400 text-[11px]">{{ $u->email }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-50 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300">
                                                {{ $u->role->label ?? $u->role->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                            {{ $u->unit->name ?? 'Semua Unit' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $u->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                                {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ route('superadmin.users.edit', $u) }}" class="text-xs font-semibold text-teal-600 hover:text-teal-800">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-400">Belum ada user.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SLA & Priorities Card (1 col) -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-sm text-gray-900 dark:text-white">Konfigurasi SLA</h3>
                            <p class="text-xs text-gray-500">Target waktu penyelesaian tiket</p>
                        </div>
                        <a href="{{ route('superadmin.priorities.index') }}" class="text-xs font-semibold text-teal-600 dark:text-teal-400 hover:underline">
                            Atur &rarr;
                        </a>
                    </div>

                    <div class="space-y-3">
                        @foreach ($priorities as $p)
                            <div class="p-3.5 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 flex items-center justify-between text-xs">
                                <div>
                                    <span class="font-bold text-gray-900 dark:text-white block">{{ $p->name }}</span>
                                    <span class="text-[11px] text-gray-400">{{ $p->tickets_count }} Tiket Tercatat</span>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg font-bold border {{ $p->badge_class }}">
                                        {{ $p->sla_hours }} Jam Max
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Quick Links to other Super Admin tasks -->
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700 space-y-2">
                        <span class="text-[11px] uppercase font-bold text-gray-400 tracking-wider block">Menu Cepat Super Admin</span>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <a href="{{ route('superadmin.categories.index') }}" class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-teal-50 dark:hover:bg-teal-900/30 text-gray-700 dark:text-gray-200 font-semibold transition text-center">
                                Master Kategori
                            </a>
                            <a href="{{ route('superadmin.units.index') }}" class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-teal-50 dark:hover:bg-teal-900/30 text-gray-700 dark:text-gray-200 font-semibold transition text-center">
                                Master Unit RSUD
                            </a>
                            <a href="{{ route('superadmin.roles.index') }}" class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-teal-50 dark:hover:bg-teal-900/30 text-gray-700 dark:text-gray-200 font-semibold transition text-center">
                                Kelola Role
                            </a>
                            <a href="{{ route('superadmin.technicians.index') }}" class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-teal-50 dark:hover:bg-teal-900/30 text-gray-700 dark:text-gray-200 font-semibold transition text-center">
                                Data Teknisi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>