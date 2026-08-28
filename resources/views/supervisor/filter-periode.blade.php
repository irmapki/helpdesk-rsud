<x-app-layout>
    <div class="space-y-4 sm:space-y-6 max-w-7xl mx-auto max-w-full overflow-x-hidden pb-10">
        <!-- Filter Form Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-4 sm:p-8 space-y-4 sm:space-y-6 min-w-0">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight break-words">Filter Periode Laporan Tiket</h1>
                <p class="text-xs text-slate-500 mt-1 break-words">Saring data tiket berdasarkan rentang tanggal mulai dan selesai.</p>
            </div>

            <form method="GET" action="{{ route('supervisor.filter-periode') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 sm:gap-4 items-end min-w-0">
                <div class="md:col-span-4 min-w-0">
                    <label for="start_date" class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-2 truncate">TANGGAL MULAI</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full text-xs font-semibold rounded-2xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 py-3 px-4 shadow-2xs">
                </div>

                <div class="md:col-span-4 min-w-0">
                    <label for="end_date" class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-2 truncate">TANGGAL SELESAI</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full text-xs font-semibold rounded-2xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 py-3 px-4 shadow-2xs">
                </div>

                <div class="md:col-span-4 flex items-center gap-2 min-w-0">
                    <button type="submit" class="flex-1 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs py-3 px-4 rounded-2xl transition shadow-xs flex items-center justify-center gap-2 truncate">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span class="truncate">Terapkan Filter</span>
                    </button>
                    <a href="{{ route('supervisor.filter-periode') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 px-4 rounded-2xl transition text-center shadow-2xs shrink-0">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Filtered Tickets Card Container -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-4 sm:p-8 space-y-4 min-w-0">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-slate-100 min-w-0">
                <h2 class="text-xs font-black text-slate-600 uppercase tracking-widest truncate">DAFTAR TIKET TERFILTER</h2>
                @if(request('start_date') || request('end_date'))
                    <span class="text-xs font-bold text-slate-500 shrink-0">
                        Total Ditemukan: <strong class="text-slate-900">{{ $totalFiltered }} Tiket</strong>
                    </span>
                @endif
            </div>

            <!-- DESKTOP VIEW: Tabel (Hidden di HP, Muncul di Layar md ke atas)[cite: 14] -->
            <div class="hidden md:block overflow-x-auto min-w-0">
                <table class="w-full text-left text-xs">
                    <thead class="text-slate-400 uppercase font-black text-[10px] tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-3">NO TIKET</th>
                            <th class="py-3 px-3">TANGGAL</th>
                            <th class="py-3 px-3">PELAPOR</th>
                            <th class="py-3 px-3">UNIT</th>
                            <th class="py-3 px-3">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @if($tickets instanceof \Illuminate\Support\Collection && $tickets->isEmpty() && !request('start_date') && !request('end_date'))
                            <tr>
                                <td colspan="5" class="text-center py-12 text-slate-400 text-xs">
                                    Silakan pilih rentang tanggal mulai dan selesai untuk menampilkan data tiket.[cite: 14]
                                </td>
                            </tr>
                        @else
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-3">
                                        <span class="font-mono font-bold text-emerald-800 block text-xs">{{ $ticket->ticket_number }}</span>
                                        <span class="font-bold text-slate-900 text-xs line-clamp-1 mt-0.5">{{ $ticket->title }}</span>
                                    </td>
                                    <td class="py-3.5 px-3 text-slate-500 font-mono text-xs">
                                        {{ $ticket->created_at->format('d/m/Y H:i') }} WIB[cite: 14]
                                    </td>
                                    <td class="py-3.5 px-3">
                                        <div class="font-bold text-slate-900 text-xs">{{ $ticket->reporter_name }}</div>
                                        <div class="text-slate-400 text-[11px] font-mono">{{ $ticket->reporter_contact }}</div>
                                    </td>
                                    <td class="py-3.5 px-3 text-slate-700 font-medium text-xs">
                                        {{ $ticket->unit->name ?? '-' }}
                                    </td>
                                    <td class="py-3.5 px-3">
                                        <span class="inline-block px-3 py-1 rounded-xl text-xs font-bold {{ $ticket->status_badge_class }}">
                                            {{ $ticket->status_label }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12 text-slate-400 text-xs">
                                        Tidak ada data tiket ditemukan pada rentang periode tersebut.[cite: 14]
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- MOBILE VIEW: List Card Vertikal (Muncul Khusus di HP, Hidden di md ke atas) -->
            <div class="block md:hidden space-y-3 min-w-0">
                @if($tickets instanceof \Illuminate\Support\Collection && $tickets->isEmpty() && !request('start_date') && !request('end_date'))
                    <div class="text-center py-8 text-slate-400 text-xs bg-slate-50 rounded-2xl border border-slate-200">
                        Silakan pilih rentang tanggal mulai dan selesai untuk menampilkan data tiket.[cite: 14]
                    </div>
                @else
                    @forelse($tickets as $ticket)
                        <div class="border border-slate-200 rounded-2xl p-4 bg-white shadow-xs space-y-3 min-w-0">
                            <!-- Baris Atas: Nomor Tiket & Status Badge -->
                            <div class="flex flex-wrap items-start justify-between gap-2 min-w-0">
                                <span class="font-mono font-bold text-xs text-emerald-800 shrink-0">{{ $ticket->ticket_number }}</span>
                                <span class="inline-block px-2.5 py-1 rounded-xl text-[10px] font-black {{ $ticket->status_badge_class }}">
                                    {{ $ticket->status_label }}
                                </span>
                            </div>

                            <!-- Judul Tiket -->
                            <div class="min-w-0">
                                <h3 class="font-bold text-slate-900 text-xs sm:text-sm break-words">{{ $ticket->title }}</h3>
                            </div>

                            <!-- Rincian Informasi Kartu -->
                            <div class="bg-slate-50 p-3 rounded-xl space-y-2 text-xs text-slate-600 border border-slate-100 min-w-0">
                                <div class="flex justify-between items-start gap-2 min-w-0">
                                    <span class="text-slate-400 shrink-0">Tanggal:</span>
                                    <span class="font-mono font-medium text-slate-800 text-right">{{ $ticket->created_at->format('d/m/Y H:i') }} WIB[cite: 14]</span>
                                </div>
                                <div class="flex justify-between items-start gap-2 min-w-0">
                                    <span class="text-slate-400 shrink-0">Pelapor:</span>
                                    <span class="font-semibold text-slate-900 text-right break-words">{{ $ticket->reporter_name }} <span class="font-mono text-[10px] text-slate-400">({{ $ticket->reporter_contact }})</span></span>
                                </div>
                                <div class="flex justify-between items-start gap-2 min-w-0">
                                    <span class="text-slate-400 shrink-0">Unit:</span>
                                    <span class="font-semibold text-slate-900 text-right break-words">{{ $ticket->unit->name ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs bg-slate-50 rounded-2xl border border-slate-200">
                            Tidak ada data tiket ditemukan pada rentang periode tersebut.[cite: 14]
                        </div>
                    @endforelse
                @endif
            </div>

            <!-- Pagination if applicable[cite: 14] -->
            @if($tickets instanceof \Illuminate\Pagination\LengthAwarePaginator && $tickets->hasPages())
                <div class="pt-4 border-t border-slate-100">
                    {{ $tickets->links() }}[cite: 14]
                </div>
            @endif
        </div>
    </div>
</x-app-layout>