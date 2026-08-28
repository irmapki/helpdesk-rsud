<x-app-layout>
    <div class="space-y-4 sm:space-y-6 max-w-full overflow-x-hidden pb-10">
        <!-- Top Title & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 min-w-0">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight break-words">Dashboard Admin Helpdesk</h1>
                <p class="text-xs text-slate-500 font-normal mt-1 break-words">Triage pengaduan, validasi keluhan, dan penugasan teknisi IT Helpdesk RSUD RAA Soewondo.</p>
            </div>
            <a href="{{ route('guest.ticket.create') }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition hover:scale-[1.02] shrink-0">
                <span class="text-sm font-bold">+</span>
                <span>Buat Tiket Baru</span>
            </a>
        </div>

        <!-- 4 Summary Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 min-w-0">
            <!-- Card 1: Menunggu Validasi -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="mt-3 min-w-0">
                    <span class="text-xs font-semibold text-slate-600 block truncate">Menunggu Validasi</span>
                    <div class="text-2xl sm:text-3xl font-black text-amber-600 mt-1">{{ $pendingValidationCount }}</div>
                    <span class="text-xs font-bold text-amber-600 mt-2 inline-block truncate">Perlu tindakan admin</span>
                </div>
            </div>

            <!-- Card 2: Sudah Ditugaskan -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="mt-3 min-w-0">
                    <span class="text-xs font-semibold text-slate-600 block truncate">Sudah Ditugaskan</span>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">{{ $assignedCount }}</div>
                    <span class="text-xs font-medium text-slate-400 mt-2 inline-block truncate">Dalam antrean teknisi</span>
                </div>
            </div>

            <!-- Card 3: Sedang Dikerjakan -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <div class="mt-3 min-w-0">
                    <span class="text-xs font-semibold text-slate-600 block truncate">Sedang Dikerjakan</span>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">{{ $inProgressCount }}</div>
                    <span class="text-xs font-bold text-sky-600 mt-2 inline-block truncate">In progress di lokasi</span>
                </div>
            </div>

            <!-- Card 4: Selesai Ditangani -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="mt-3 min-w-0">
                    <span class="text-xs font-semibold text-slate-600 block truncate">Selesai Ditangani</span>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">{{ $resolvedCount }}</div>
                    <span class="text-xs font-bold text-emerald-600 mt-2 inline-block truncate">Dari {{ $totalTicketsCount }} total tiket</span>
                </div>
            </div>
        </div>

        <!-- 2-Columns Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 items-start min-w-0">
            <!-- Kolom Kiri: Tiket Masuk Terbaru (8 cols) -->
            <div x-data="{ ticketTab: 'all' }" class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 space-y-4 min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-slate-100 min-w-0">
                    <div class="min-w-0">
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 break-words">Tiket Masuk Terbaru</h2>
                        <p class="text-xs text-slate-400 mt-0.5 break-words">Pengaduan yang baru masuk dari unit RSUD</p>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="flex flex-wrap items-center gap-1 min-w-0">
                        <button type="button" @click="ticketTab = 'all'"
                            :class="ticketTab === 'all' ? 'bg-sky-100 text-sky-900 font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-2.5 py-1 rounded-lg text-[11px] transition">
                            Semua
                        </button>
                        <button type="button" @click="ticketTab = 'open'"
                            :class="ticketTab === 'open' ? 'bg-sky-100 text-sky-900 font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-2.5 py-1 rounded-lg text-[11px] transition">
                            Pending
                        </button>
                        <button type="button" @click="ticketTab = 'assigned'"
                            :class="ticketTab === 'assigned' ? 'bg-sky-100 text-sky-900 font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-2.5 py-1 rounded-lg text-[11px] transition">
                            Assigned
                        </button>
                        <button type="button" @click="ticketTab = 'in_progress'"
                            :class="ticketTab === 'in_progress' ? 'bg-sky-100 text-sky-900 font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-2.5 py-1 rounded-lg text-[11px] transition">
                            In Progress
                        </button>
                    </div>
                </div>

                <!-- DESKTOP VIEW: Tabel (Hidden di HP, Muncul di Layar md ke atas) -->
                <div class="hidden md:block overflow-x-auto min-w-0">
                    <table class="w-full text-left text-xs">
                        <thead class="text-slate-400 uppercase font-bold text-[11px] border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-2">NO. TIKET &amp; JUDUL</th>
                                <th class="py-3 px-2">UNIT / PELAPOR</th>
                                <th class="py-3 px-2">PRIORITAS</th>
                                <th class="py-3 px-2">STATUS</th>
                                <th class="py-3 px-2 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentTickets as $ticket)
                                <tr x-show="ticketTab === 'all' || '{{ $ticket->status }}' === ticketTab" class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-2">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="font-mono font-bold text-teal-800 hover:underline block text-xs">
                                            {{ $ticket->ticket_number }}
                                        </a>
                                        <span class="font-bold text-slate-900 line-clamp-1 mt-0.5 text-xs">{{ $ticket->title }}</span>
                                    </td>
                                    <td class="py-3.5 px-2">
                                        <span class="font-bold text-slate-800 block text-xs">{{ $ticket->unit->name }}</span>
                                        <span class="text-slate-400 text-[11px] font-medium">{{ $ticket->reporter_name }}</span>
                                    </td>
                                    <td class="py-3.5 px-2">
                                        <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $ticket->priority->badge_class }}">
                                            {{ $ticket->priority->name }} ({{ $ticket->priority->sla_hours }}j)
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-2">
                                        <span class="inline-block px-3 py-1 rounded-xl text-xs font-bold {{ $ticket->status_badge_class }}">
                                            {{ $ticket->status_label }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-2 text-right">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-slate-300 text-slate-700 hover:text-slate-900 font-bold text-xs bg-white shadow-xs transition">
                                            <span>Triage</span>
                                            <span>&rarr;</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-slate-400">Belum ada tiket masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- MOBILE VIEW: List Card Vertikal (Muncul Khusus di HP, Hidden di md ke atas) -->
                <div class="block md:hidden space-y-3 min-w-0">
                    @forelse ($recentTickets as $ticket)
                        <div x-show="ticketTab === 'all' || '{{ $ticket->status }}' === ticketTab" class="border border-slate-200 rounded-2xl p-3.5 bg-white shadow-xs space-y-3 min-w-0">
                            <div class="flex flex-wrap items-start justify-between gap-2 min-w-0">
                                <a href="{{ route('admin.tickets.show', $ticket) }}" class="font-mono font-bold text-xs text-teal-800 hover:underline shrink-0">
                                    {{ $ticket->ticket_number }}
                                </a>
                                <span class="inline-block px-2.5 py-1 rounded-xl text-[10px] font-bold {{ $ticket->status_badge_class }}">
                                    {{ $ticket->status_label }}
                                </span>
                            </div>

                            <div class="min-w-0">
                                <h3 class="font-bold text-slate-900 text-xs sm:text-sm break-words">{{ $ticket->title }}</h3>
                            </div>

                            <div class="bg-slate-50 p-3 rounded-xl space-y-2 text-xs text-slate-600 border border-slate-100 min-w-0">
                                <div class="flex justify-between items-start gap-2 min-w-0">
                                    <span class="text-slate-400 shrink-0">Unit / Pelapor:</span>
                                    <span class="font-semibold text-slate-900 text-right break-words">{{ $ticket->unit->name }} <span class="text-slate-400 text-[10px]">({{ $ticket->reporter_name }})</span></span>
                                </div>
                                <div class="flex justify-between items-start gap-2 min-w-0">
                                    <span class="text-slate-400 shrink-0">Prioritas (SLA):</span>
                                    <span class="font-semibold text-slate-800 text-right">{{ $ticket->priority->name }} ({{ $ticket->priority->sla_hours }}j)</span>
                                </div>
                            </div>

                            <div class="pt-1 flex justify-end">
                                <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex items-center justify-center gap-1 w-full px-3 py-2 rounded-xl border border-slate-200 hover:border-slate-300 text-slate-700 hover:text-slate-900 font-bold text-xs bg-slate-50 shadow-xs transition">
                                    <span>Triage Tiket</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs bg-slate-50 rounded-2xl border border-slate-200">
                            Belum ada tiket masuk.
                        </div>
                    @endforelse
                </div>

                <div class="pt-3 border-t border-slate-100 text-right">
                    <a href="{{ route('admin.tickets.index') }}" class="text-xs font-bold text-teal-800 hover:text-teal-950">
                        Buka Semua Tiket di Manajemen &rarr;
                    </a>
                </div>
            </div>

            <!-- Kolom Kanan: Kesiapan Teknisi & SLA (4 cols) -->
            <div class="lg:col-span-4 space-y-4 sm:space-y-6 min-w-0">
                <!-- Card 1: Kesiapan Teknisi IT -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 space-y-4 min-w-0">
                    <div class="min-w-0">
                        <h3 class="font-bold text-sm text-slate-900 truncate">Kesiapan Teknisi IT</h3>
                        <p class="text-[11px] text-slate-400 truncate">Monitoring beban kerja aktif teknisi</p>
                    </div>

                    <div class="space-y-3 text-xs min-w-0">
                        @forelse ($technicians as $tech)
                            @php
                                $load = $tech->assignedTickets->count();
                                $initials = strtoupper(substr($tech->name, 0, 2));
                            @endphp
                            <div class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition gap-2 min-w-0">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-full bg-amber-700 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ $initials }}
                                    </div>
                                    <div class="min-w-0">
                                        <span class="font-bold text-slate-900 block truncate">{{ $tech->name }}</span>
                                        <span class="text-[10px] text-slate-400 block truncate">{{ $tech->specialization ?: 'Hardware & Jaringan' }}</span>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-xl text-xs font-bold shrink-0 {{ $load >= 5 ? 'bg-rose-100 text-rose-700' : ($load >= 2 ? 'bg-orange-100 text-orange-700' : 'bg-emerald-100 text-emerald-700') }}">
                                    {{ $load }} Aktif
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-2">Belum ada data teknisi.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Card 2: Akses Cepat Admin -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 space-y-3 min-w-0">
                    <h3 class="font-bold text-sm text-slate-900 truncate">Menu Cepat Admin</h3>
                    <div class="space-y-2 min-w-0">
                        <a href="{{ route('admin.tickets.index', ['tab' => 'pending']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 font-bold text-xs transition gap-2">
                            <span class="truncate">Validasi Pengaduan Baru</span>
                            <span class="bg-amber-200 px-2 py-0.5 rounded-full text-[10px] shrink-0">{{ $pendingValidationCount }}</span>
                        </a>
                        <a href="{{ route('admin.tickets.index', ['tab' => 'assigned']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-900 font-bold text-xs transition gap-2">
                            <span class="truncate">Daftar Tiket Ditugaskan</span>
                            <span class="bg-sky-200 px-2 py-0.5 rounded-full text-[10px] shrink-0">{{ $assignedCount }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>