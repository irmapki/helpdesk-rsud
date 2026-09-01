<x-app-layout>
    <div class="space-y-4 sm:space-y-6 max-w-full overflow-x-hidden pb-10">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 min-w-0">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight break-words">Monitoring Standar Layanan (SLA)</h1>
                <p class="text-xs text-slate-500 mt-1 break-words">Daftar pemantauan batas waktu penanganan tiket di seluruh unit RSUD.</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('supervisor.laporan-tiket.export', request()->all()) }}" class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-2xl shadow-xs transition">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Export Excel SLA</span>
                </a>
                <a href="{{ route('supervisor.dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-2xl transition shadow-xs text-center shrink-0">
                    &larr; Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Content Card -->
        <div class="bg-white overflow-hidden shadow-xs rounded-3xl border border-slate-200/80 p-4 sm:p-7 min-w-0">
            
            <!-- DESKTOP VIEW: Tabel (Hidden di HP, Muncul di layar md ke atas) -->
            <div class="hidden md:block overflow-x-auto min-w-0">
                <table class="min-w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-extrabold text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="px-4 py-3.5 rounded-l-xl">NO. TIKET &amp; JUDUL</th>
                            <th class="px-4 py-3.5">UNIT / KATEGORI</th>
                            <th class="px-4 py-3.5">TEKNISI BERTUGAS</th>
                            <th class="px-4 py-3.5">PRIORITAS &amp; TARGET SLA</th>
                            <th class="px-4 py-3.5">BATAS WAKTU</th>
                            <th class="px-4 py-3.5 rounded-r-xl text-right">STATUS SLA</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-4 py-3.5">
                                <span class="font-mono font-bold text-emerald-800 block">{{ $ticket->ticket_number }}</span>
                                <span class="font-bold text-slate-900">{{ $ticket->title }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-700">
                                <span class="block font-semibold text-slate-900">{{ $ticket->unit->name ?? '-' }}</span>
                                <span class="text-[11px] text-slate-400">{{ $ticket->category->name ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-700 font-medium">
                                {{ $ticket->technician->name ?? 'Belum Ditugaskan' }}
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black border {{ $ticket->priority->badge_class ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $ticket->priority->name ?? 'Normal' }} ({{ $ticket->priority->sla_hours ?? 24 }} Jam)
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600 font-mono">
                                {{ $ticket->sla_deadline ? $ticket->sla_deadline->format('d M Y, H:i') : '-' }} WIB
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                @php
                                    $slaStatus = $ticket->sla_status;
                                @endphp
                                @if($slaStatus === 'breached')
                                    <span class="px-3 py-1 bg-rose-50 text-rose-800 border border-rose-200 rounded-full text-[10px] font-black">Terlewati (Breached)</span>
                                @elseif($slaStatus === 'approaching')
                                    <span class="px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-full text-[10px] font-black">Mendekati Batas</span>
                                @elseif($slaStatus === 'completed_late')
                                    <span class="px-3 py-1 bg-orange-50 text-orange-800 border border-orange-200 rounded-full text-[10px] font-black">Selesai Telat</span>
                                @elseif($slaStatus === 'completed_on_time')
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full text-[10px] font-black">Tepat Waktu</span>
                                @else
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full text-[10px] font-black">Terjaga (On Track)</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400 text-xs">Belum ada data tiket.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- MOBILE VIEW: List Card Vertikal (Muncul khusus di HP/Tablet kecil, Hidden di md ke atas) -->
            <div class="block md:hidden space-y-3 min-w-0">
                @forelse($tickets as $ticket)
                    <div class="border border-slate-200 rounded-2xl p-4 bg-white shadow-xs space-y-3 min-w-0">
                        <!-- Baris Atas: Nomor Tiket & Status SLA -->
                        <div class="flex flex-wrap items-start justify-between gap-2 min-w-0">
                            <span class="font-mono font-bold text-xs text-emerald-800 shrink-0">{{ $ticket->ticket_number }}</span>
                            <div>
                                @php
                                    $slaStatus = $ticket->sla_status;
                                @endphp
                                @if($slaStatus === 'breached')
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-800 border border-rose-200 rounded-full text-[10px] font-black">Terlewati</span>
                                @elseif($slaStatus === 'approaching')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-full text-[10px] font-black">Mendekati</span>
                                @elseif($slaStatus === 'completed_late')
                                    <span class="px-2.5 py-1 bg-orange-50 text-orange-800 border border-orange-200 rounded-full text-[10px] font-black">Selesai Telat</span>
                                @elseif($slaStatus === 'completed_on_time')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full text-[10px] font-black">Tepat Waktu</span>
                                @else
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full text-[10px] font-black">Terjaga</span>
                                @endif
                            </div>
                        </div>

                        <!-- Judul Tiket -->
                        <div class="min-w-0">
                            <h3 class="font-bold text-slate-900 text-xs sm:text-sm break-words">{{ $ticket->title }}</h3>
                        </div>

                        <!-- Detail Informasi (Unit, Teknisi, Prioritas, Batas Waktu) -->
                        <div class="bg-slate-50 p-3 rounded-xl space-y-2 text-xs text-slate-600 border border-slate-100 min-w-0">
                            <div class="flex justify-between items-start gap-2 min-w-0">
                                <span class="text-slate-400 shrink-0">Unit / Kategori:</span>
                                <span class="font-semibold text-slate-900 text-right break-words">{{ $ticket->unit->name ?? '-' }} / {{ $ticket->category->name ?? '-' }}</span>
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
                            <div class="flex justify-between items-start gap-2 min-w-0">
                                <span class="text-slate-400 shrink-0">Batas Waktu:</span>
                                <span class="font-mono font-medium text-slate-800 text-right">{{ $ticket->sla_deadline ? $ticket->sla_deadline->format('d M Y, H:i') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-xs bg-slate-50 rounded-2xl border border-slate-200">
                        Belum ada data tiket.
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