<x-app-layout>
    <div class="space-y-4 sm:space-y-6 max-w-7xl mx-auto max-w-full overflow-x-hidden pb-10">
        <!-- Top Title & Quick Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 min-w-0">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight break-words">Laporan Tiket IT Helpdesk</h1>
                <p class="text-xs text-slate-500 mt-1 break-words">Rekapitulasi dan laporan seluruh riwayat pengaduan tiket di RSUD RAA Soewondo.</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button onclick="window.print()" type="button" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs px-4 py-2.5 rounded-2xl border border-slate-200 shadow-xs transition">
                    <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak Laporan</span>
                </button>
            </div>
        </div>

        <!-- 3 Summary Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 min-w-0">
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between min-w-0">
                <div class="min-w-0">
                    <span class="text-xs font-semibold text-slate-500 block truncate">Total Seluruh Tiket</span>
                    <div class="text-2xl font-black text-slate-900 mt-1">{{ $totalAll }}</div>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between min-w-0">
                <div class="min-w-0">
                    <span class="text-xs font-semibold text-slate-500 block truncate">Selesai / Closed</span>
                    <div class="text-2xl font-black text-emerald-700 mt-1">{{ $totalResolved }}</div>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between min-w-0">
                <div class="min-w-0">
                    <span class="text-xs font-semibold text-slate-500 block truncate">Antrean &amp; Dalam Proses</span>
                    <div class="text-2xl font-black text-amber-600 mt-1">{{ $totalPending }}</div>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/80 shadow-xs min-w-0">
            <form method="GET" action="{{ route('supervisor.laporan-tiket') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs min-w-0">
                <div class="min-w-0">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1 truncate">Cari Tiket / Pelapor</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..."
                        class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 font-medium">
                </div>

                <div class="min-w-0">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1 truncate">Unit RSUD</label>
                    <select name="unit_id" class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                        <option value="">-- Semua Unit --</option>
                        @foreach($units as $u)
                            <option value="{{ $u->id }}" {{ request('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-0">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1 truncate">Kategori</label>
                    <select name="category_id" class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2 min-w-0">
                    <button type="submit" class="w-full bg-[#0f333a] hover:bg-[#092227] text-white text-xs font-bold py-2.5 px-4 rounded-xl transition shadow-xs text-center truncate">
                        Filter Data
                    </button>
                    <a href="{{ route('supervisor.laporan-tiket') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 px-3 rounded-xl transition shrink-0 text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table / Card Container -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-4 sm:p-8 overflow-hidden min-w-0">
            
            <!-- DESKTOP VIEW: Tabel (Hidden di HP, Muncul di Layar md ke atas) -->
            <div class="hidden md:block overflow-x-auto min-w-0">
                <table class="w-full text-left text-xs">
                    <thead class="text-slate-400 uppercase font-black text-[10px] tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-3">NO TIKET &amp; JUDUL</th>
                            <th class="py-3 px-3">UNIT / KATEGORI</th>
                            <th class="py-3 px-3">PELAPOR</th>
                            <th class="py-3 px-3">TEKNISI</th>
                            <th class="py-3 px-3">PRIORITAS</th>
                            <th class="py-3 px-3">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-3">
                                    <span class="font-mono font-bold text-emerald-800 block text-xs">{{ $ticket->ticket_number }}</span>
                                    <span class="font-bold text-slate-900 text-xs line-clamp-1 mt-0.5">{{ $ticket->title }}</span>
                                </td>
                                <td class="py-3.5 px-3">
                                    <div class="font-bold text-slate-800">{{ $ticket->unit->name ?? '-' }}</div>
                                    <div class="text-slate-400 text-[11px]">{{ $ticket->category->name ?? '-' }}</div>
                                </td>
                                <td class="py-3.5 px-3">
                                    <div class="font-bold text-slate-900">{{ $ticket->reporter_name }}</div>
                                    <div class="text-slate-400 text-[11px] font-mono">{{ $ticket->reporter_contact }}</div>
                                </td>
                                <td class="py-3.5 px-3 text-slate-700 font-medium">
                                    {{ $ticket->technician->name ?? 'Belum Ditugaskan' }}
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $ticket->priority->badge_class ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $ticket->priority->name ?? 'Normal' }} ({{ $ticket->priority->sla_hours ?? 24 }}j)
                                    </span>
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="inline-block px-3 py-1 rounded-xl text-xs font-bold {{ $ticket->status_badge_class }}">
                                        {{ $ticket->status_label }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-slate-400 text-xs">
                                    Tidak ada data tiket pada filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- MOBILE VIEW: List Card Vertikal (Muncul Khusus di HP, Hidden di md ke atas) -->
            <div class="block md:hidden space-y-3 min-w-0">
                @forelse($tickets as $ticket)
                    <div class="border border-slate-200 rounded-2xl p-4 bg-white shadow-xs space-y-3 min-w-0">
                        <!-- Baris Atas: Nomor Tiket & Status Badge -->
                        <div class="flex flex-wrap items-start justify-between gap-2 min-w-0">
                            <span class="font-mono font-bold text-xs text-emerald-800 shrink-0">{{ $ticket->ticket_number }}</span>
                            <span class="inline-block px-2.5 py-1 rounded-xl text-[10px] font-black {{ $ticket->status_badge_class }}">
                                {{ $ticket->status_label }}
                            </span>
                        </div>

                        <!-- Judul Pengaduan -->
                        <div class="min-w-0">
                            <h3 class="font-bold text-slate-900 text-xs sm:text-sm break-words">{{ $ticket->title }}</h3>
                        </div>

                        <!-- Rincian Informasi Kartu -->
                        <div class="bg-slate-50 p-3 rounded-xl space-y-2 text-xs text-slate-600 border border-slate-100 min-w-0">
                            <div class="flex justify-between items-start gap-2 min-w-0">
                                <span class="text-slate-400 shrink-0">Unit / Kategori:</span>
                                <span class="font-semibold text-slate-900 text-right break-words">{{ $ticket->unit->name ?? '-' }} / {{ $ticket->category->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-start gap-2 min-w-0">
                                <span class="text-slate-400 shrink-0">Pelapor:</span>
                                <span class="font-semibold text-slate-900 text-right break-words">{{ $ticket->reporter_name }} <span class="font-mono text-[10px] text-slate-400">({{ $ticket->reporter_contact }})</span></span>
                            </div>
                            <div class="flex justify-between items-start gap-2 min-w-0">
                                <span class="text-slate-400 shrink-0">Teknisi:</span>
                                <span class="font-semibold text-slate-900 text-right break-words">{{ $ticket->technician->name ?? 'Belum Ditugaskan' }}</span>
                            </div>
                            <div class="flex justify-between items-start gap-2 min-w-0">
                                <span class="text-slate-400 shrink-0">Prioritas:</span>
                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-black border {{ $ticket->priority->badge_class ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $ticket->priority->name ?? 'Normal' }} ({{ $ticket->priority->sla_hours ?? 24 }}j)
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-xs bg-slate-50 rounded-2xl border border-slate-200">
                        Tidak ada data tiket pada filter ini.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($tickets->hasPages())
                <div class="mt-4 pt-4 border-t border-slate-100">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>