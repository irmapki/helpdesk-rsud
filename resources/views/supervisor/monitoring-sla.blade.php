<x-app-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Monitoring Standar Layanan (SLA)</h1>
                <p class="text-xs text-slate-500 mt-1">Daftar pemantauan batas waktu penanganan tiket di seluruh unit RSUD.</p>
            </div>
            <a href="{{ route('supervisor.dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-2xl transition shadow-xs">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <!-- Table Card (Light Mode) -->
        <div class="bg-white overflow-hidden shadow-xs rounded-3xl border border-slate-200/80 p-6 sm:p-7">
            <div class="overflow-x-auto">
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

            <!-- Pagination -->
            @if($tickets->hasPages())
                <div class="mt-4 pt-4 border-t border-slate-100">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>