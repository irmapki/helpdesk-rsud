<x-app-layout>
    <div class="space-y-6">
        <!-- Top Title & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Manajemen Tiket Masuk</h1>
                <p class="text-xs text-slate-500 font-normal mt-1">Inbox keluhan masuk, validasi pengaduan, penyesuaian SLA, dan penugasan ke teknisi IT RSUD.</p>
            </div>
            <a href="{{ route('guest.ticket.create') }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition hover:scale-[1.02]">
                <span class="text-sm font-bold">+</span>
                <span>Buat Tiket Baru</span>
            </a>
        </div>

        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
            @php
                $currentTab = request('tab', 'all');
                $tabs = [
                    'all' => ['label' => 'Semua', 'count' => $counts['all']],
                    'pending' => ['label' => 'Menunggu Validasi', 'count' => $counts['pending']],
                    'assigned' => ['label' => 'Sudah Ditugaskan', 'count' => $counts['assigned']],
                    'in_progress' => ['label' => 'Sedang Dikerjakan', 'count' => $counts['in_progress']],
                    'resolved' => ['label' => 'Selesai', 'count' => $counts['resolved']],
                    'closed' => ['label' => 'Ditutup', 'count' => $counts['closed']],
                    'rejected' => ['label' => 'Ditolak', 'count' => $counts['rejected']],
                ];
            @endphp

            @foreach ($tabs as $key => $data)
                <a href="{{ route('admin.tickets.index', array_merge(request()->except(['tab', 'page']), ['tab' => $key])) }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs transition whitespace-nowrap {{ $currentTab === $key ? 'bg-sky-100 text-sky-900 font-bold' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200/90 shadow-xs font-medium' }}">
                    <span>{{ $data['label'] }}</span>
                    <span class="px-1.5 py-0.2 text-[10px] font-bold rounded-full {{ $currentTab === $key ? 'bg-sky-200 text-sky-900' : 'bg-slate-100 text-slate-600' }}">
                        {{ $data['count'] }}
                    </span>
                </a>
            @endforeach
        </div>

        <!-- Filter & Search Card -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <form method="GET" action="{{ route('admin.tickets.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
                <input type="hidden" name="tab" value="{{ $currentTab }}">

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Cari No. Tiket / Judul / Pelapor</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nomor tiket / nama..."
                        class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 font-medium">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Unit RSUD</label>
                    <select name="unit_id" class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                        <option value="">-- Semua Unit --</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->id }}" {{ request('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Kategori Kendala</label>
                    <select name="category_id" class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                        <option value="">-- Semua Kategori --</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full bg-[#0f333a] hover:bg-[#092227] text-white text-xs font-bold py-2.5 px-4 rounded-xl transition shadow-xs">
                        Filter Tiket
                    </button>
                    <a href="{{ route('admin.tickets.index', ['tab' => $currentTab]) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 px-3 rounded-xl transition text-center flex items-center justify-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Tickets Responsive Container (Card View on Mobile, Table View on Desktop) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 overflow-hidden">
            
            @forelse ($tickets as $ticket)
                <!-- MOBILE CARD VIEW (Tampil di layar kecil / HP) -->
                <div class="block sm:hidden bg-slate-50 border border-slate-200/80 rounded-2xl p-4 mb-3 space-y-3 shadow-xs">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="font-mono font-bold text-teal-800 text-xs hover:underline">
                                {{ $ticket->ticket_number }}
                            </a>
                            <span class="text-slate-400 text-[10px] block font-mono">{{ $ticket->created_at->format('d/m/Y H:i') }} WIB</span>
                        </div>
                        <span class="inline-block px-2.5 py-0.5 rounded-lg text-[10px] font-bold {{ $ticket->status_badge_class }}">
                            {{ $ticket->status_label }}
                        </span>
                    </div>

                    <div>
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="font-bold text-slate-900 text-xs hover:text-teal-800 line-clamp-2">
                            {{ $ticket->title }}
                        </a>
                        <span class="text-slate-500 text-[11px] block mt-0.5 font-medium">Unit: {{ $ticket->unit->name }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-200/60 text-[11px]">
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Pelapor</span>
                            <span class="font-bold text-slate-800 truncate block">{{ $ticket->reporter_name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Teknisi</span>
                            <span class="font-bold text-slate-800 truncate block">{{ $ticket->technician->name ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-slate-200/60">
                        <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold {{ $ticket->priority->badge_class }}">
                            {{ $ticket->priority->name }} ({{ $ticket->priority->sla_hours }}j)
                        </span>
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl border border-slate-300 text-slate-700 font-bold text-xs bg-white shadow-xs">
                            <span>Triage</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @empty
                <!-- Empty State for Mobile -->
                <div class="block sm:hidden text-center py-8 text-slate-400 text-xs">
                    Tidak ada tiket pada tab / filter ini.
                </div>
            @endforelse

            <!-- DESKTOP TABLE VIEW (Tampil di layar Tablet / Laptop ke atas) -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="text-slate-400 uppercase font-bold text-[11px] border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-2">NO. TIKET &amp; TANGGAL</th>
                            <th class="py-3 px-2">JUDUL MASALAH &amp; UNIT</th>
                            <th class="py-3 px-2">PELAPOR</th>
                            <th class="py-3 px-2">PRIORITAS</th>
                            <th class="py-3 px-2">TEKNISI</th>
                            <th class="py-3 px-2">STATUS</th>
                            <th class="py-3 px-2 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-2">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="font-mono font-bold text-teal-800 hover:underline block text-xs">
                                        {{ $ticket->ticket_number }}
                                    </a>
                                    <span class="text-slate-400 text-[11px] font-mono mt-0.5">{{ $ticket->created_at->format('d/m/Y H:i') }} WIB</span>
                                </td>
                                <td class="py-3.5 px-2 max-w-xs">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="font-bold text-slate-900 hover:text-teal-800 block line-clamp-1 text-xs">
                                        {{ $ticket->title }}
                                    </a>
                                    <span class="text-slate-400 text-[11px] font-medium block mt-0.5">Unit: {{ $ticket->unit->name }}</span>
                                </td>
                                <td class="py-3.5 px-2">
                                    <div class="font-bold text-slate-900">{{ $ticket->reporter_name }}</div>
                                    <div class="text-slate-400 text-[11px] font-mono">{{ $ticket->reporter_contact }}</div>
                                </td>
                                <td class="py-3.5 px-2">
                                    <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $ticket->priority->badge_class }}">
                                        {{ $ticket->priority->name }} ({{ $ticket->priority->sla_hours }}j)
                                    </span>
                                </td>
                                <td class="py-3.5 px-2">
                                    @if ($ticket->technician)
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-amber-700 text-white font-bold flex items-center justify-center text-[10px]">
                                                {{ substr($ticket->technician->name, 0, 1) }}
                                            </div>
                                            <span class="font-bold text-slate-900 text-xs">{{ $ticket->technician->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
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
                                <td colspan="7" class="text-center py-10 text-slate-400 text-xs">
                                    Tidak ada tiket pada tab / filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($tickets->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>