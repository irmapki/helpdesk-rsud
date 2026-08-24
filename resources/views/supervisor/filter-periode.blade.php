<x-app-layout>
    <div class="space-y-6 max-w-7xl mx-auto">
        <!-- Filter Form Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Filter Periode Laporan Tiket</h1>
                <p class="text-xs text-slate-500 mt-1">Saring data tiket berdasarkan rentang tanggal mulai dan selesai.</p>
            </div>

            <form method="GET" action="{{ route('supervisor.filter-periode') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-4">
                    <label for="start_date" class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-2">TANGGAL MULAI</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full text-xs font-semibold rounded-2xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 py-3 px-4 shadow-2xs">
                </div>

                <div class="md:col-span-4">
                    <label for="end_date" class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-2">TANGGAL SELESAI</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full text-xs font-semibold rounded-2xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 py-3 px-4 shadow-2xs">
                </div>

                <div class="md:col-span-4 flex items-center gap-2">
                    <button type="submit" class="flex-1 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs py-3 px-5 rounded-2xl transition shadow-xs flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span>Terapkan Filter</span>
                    </button>
                    <a href="{{ route('supervisor.filter-periode') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 px-5 rounded-2xl transition text-center shadow-2xs">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Filtered Tickets Table Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-slate-100">
                <h2 class="text-xs font-black text-slate-600 uppercase tracking-widest">DAFTAR TIKET TERFILTER</h2>
                @if(request('start_date') || request('end_date'))
                    <span class="text-xs font-bold text-slate-500">
                        Total Ditemukan: <strong class="text-slate-900">{{ $totalFiltered }} Tiket</strong>
                    </span>
                @endif
            </div>

            <div class="overflow-x-auto">
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
                                    Silakan pilih rentang tanggal mulai dan selesai untuk menampilkan data tiket.
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
                                        {{ $ticket->created_at->format('d/m/Y H:i') }} WIB
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
                                        Tidak ada data tiket ditemukan pada rentang periode tersebut.
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination if applicable -->
            @if($tickets instanceof \Illuminate\Pagination\LengthAwarePaginator && $tickets->hasPages())
                <div class="pt-4 border-t border-slate-100">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
