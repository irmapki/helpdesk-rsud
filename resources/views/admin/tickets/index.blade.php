<x-app-layout>
    <div class="space-y-6" x-data="{ viewMode: '{{ request('view', 'table') }}' }">
        <!-- Top Title, View Switcher & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Manajemen Tiket Masuk</h1>
                <p class="text-xs text-slate-500 font-normal mt-1">Inbox keluhan masuk, validasi pengaduan, penyesuaian SLA, dan penugasan ke teknisi IT RSUD.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Toggle Mode: Tabel vs Kanban -->
                <div class="inline-flex p-1 bg-slate-100 rounded-xl border border-slate-200 shrink-0">
                    <button type="button" @click="viewMode = 'table'"
                        :class="viewMode === 'table' ? 'bg-[#0f333a] text-white shadow-xs font-black' : 'text-slate-600 hover:text-slate-900 font-bold'"
                        class="px-3.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        <span>Tabel List</span>
                    </button>
                    <button type="button" @click="viewMode = 'kanban'"
                        :class="viewMode === 'kanban' ? 'bg-[#0f333a] text-white shadow-xs font-black' : 'text-slate-600 hover:text-slate-900 font-bold'"
                        class="px-3.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                        <span>Kanban Board</span>
                    </button>
                </div>

                <a href="{{ route('guest.ticket.create') }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition hover:scale-[1.02] shrink-0">
                    <span class="text-sm font-bold">+</span>
                    <span>Buat Tiket Baru</span>
                </a>
            </div>
        </div>

        <!-- Filter & Search Card (Berlaku untuk Tabel & Kanban) -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <form method="GET" action="{{ route('admin.tickets.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
                <input type="hidden" name="tab" value="{{ request('tab', 'all') }}">
                <input type="hidden" name="view" :value="viewMode">

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
                    <a href="{{ route('admin.tickets.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 px-3 rounded-xl transition text-center flex items-center justify-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- MODE 1: KANBAN BOARD (TAMPILAN PAPAN KARTU) -->
        <!-- ========================================== -->
        <div x-show="viewMode === 'kanban'" x-cloak class="space-y-4">
            <div class="flex items-center justify-between text-xs text-slate-500 px-1">
                <span class="font-bold flex items-center gap-1.5 text-slate-700">
                    <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                    Papan Kanban Terpadu &bull; Alur Kerja Helpdesk RSUD
                </span>
                <span class="text-[11px] text-slate-400 hidden sm:inline">💡 Klik tombol Triage pada kartu untuk menugaskan teknisi</span>
            </div>

            <!-- 5 Kolom Kanban -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 overflow-x-auto pb-6 items-start min-w-[1100px] lg:min-w-0">
                @foreach ($kanbanColumns as $colKey => $col)
                    <div class="bg-slate-100/90 rounded-2xl p-3 border border-slate-200/80 flex flex-col max-h-[850px]">
                        <!-- Column Header -->
                        <div class="flex items-center justify-between pb-2.5 mb-2.5 border-b-2 {{ $col['borderColor'] }}">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full {{ $col['dotColor'] }} {{ $colKey === 'pending' || $colKey === 'in_progress' ? 'animate-pulse' : '' }}"></span>
                                <h3 class="font-black text-xs uppercase tracking-wider text-slate-800">{{ $col['title'] }}</h3>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-black border {{ $col['badgeClass'] }}">
                                {{ $col['tickets']->count() }}
                            </span>
                        </div>

                        <!-- Column Tickets List -->
                        <div class="space-y-3 overflow-y-auto pr-1 flex-grow scrollbar-thin max-h-[750px]">
                            @forelse ($col['tickets'] as $kTicket)
                                <div class="bg-white p-3.5 rounded-xl border border-slate-200/90 shadow-xs hover:shadow-md hover:border-teal-600/50 transition group">
                                    
                                    <!-- Ticket Header Badge & Priority -->
                                    <div class="flex items-center justify-between gap-1 mb-2">
                                        <a href="{{ route('admin.tickets.show', $kTicket) }}" class="font-mono text-[11px] font-black text-teal-800 bg-teal-50 hover:bg-teal-100 px-2 py-0.5 rounded-md border border-teal-200 transition">
                                            {{ $kTicket->ticket_number }}
                                        </a>
                                        <span class="text-[10px] font-black px-2 py-0.5 rounded-md {{ $kTicket->priority->badge_class }}">
                                            {{ $kTicket->priority->name }}
                                        </span>
                                    </div>

                                    <!-- Title & Description Snippet -->
                                    <a href="{{ route('admin.tickets.show', $kTicket) }}" class="block">
                                        <h4 class="font-bold text-xs text-slate-900 group-hover:text-teal-800 transition line-clamp-2 leading-snug">
                                            {{ $kTicket->title }}
                                        </h4>
                                    </a>

                                    <!-- Unit & Category -->
                                    <div class="mt-2.5 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                                        <span class="font-semibold text-slate-700 truncate max-w-[120px]" title="{{ $kTicket->unit->name ?? '-' }}">
                                            🏥 {{ $kTicket->unit->name ?? '-' }}
                                        </span>
                                        <span class="text-[10px] text-teal-800 font-bold bg-slate-100 px-1.5 py-0.5 rounded truncate max-w-[90px]">
                                            {{ $kTicket->category->name ?? '-' }}
                                        </span>
                                    </div>

                                    <!-- Reporter & Technician Footer -->
                                    <div class="mt-2.5 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            @if($kTicket->technician)
                                                <div class="w-5 h-5 rounded-full bg-teal-800 text-white text-[9px] font-black flex items-center justify-center shrink-0">
                                                    {{ substr($kTicket->technician->name, 0, 1) }}
                                                </div>
                                                <span class="text-[11px] font-bold text-slate-800 truncate" title="{{ $kTicket->technician->name }}">
                                                    {{ $kTicket->technician->name }}
                                                </span>
                                            @else
                                                <span class="text-[10px] text-amber-700 font-bold bg-amber-50 px-1.5 py-0.5 rounded">Belum ada teknisi</span>
                                            @endif
                                        </div>

                                        <a href="{{ route('admin.tickets.show', $kTicket) }}" class="inline-flex items-center gap-1 text-[10px] font-black text-teal-800 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 px-2 py-1 rounded-lg border border-teal-200 transition shrink-0">
                                            <span>Triage</span>
                                            <span>&rarr;</span>
                                        </a>
                                    </div>

                                    <!-- Rating if resolved -->
                                    @if($kTicket->rating)
                                        <div class="mt-2 pt-1.5 border-t border-slate-100 flex items-center justify-between text-[10px]">
                                            <span class="text-slate-400">Rating Pelapor:</span>
                                            <span class="text-amber-500 font-bold">
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $kTicket->rating ? '★' : '☆' }}
                                                @endfor
                                            </span>
                                        </div>
                                    @endif

                                </div>
                            @empty
                                <div class="p-6 text-center text-slate-400 text-xs bg-white/60 rounded-xl border border-dashed border-slate-200">
                                    Tidak ada tiket
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODE 2: TABEL LIST (TAMPILAN RESMI DEFAULT)-->
        <!-- ========================================== -->
        <div x-show="viewMode === 'table'" class="space-y-6">
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
                    <a href="{{ route('admin.tickets.index', array_merge(request()->except(['tab', 'page']), ['tab' => $key, 'view' => 'table'])) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs transition whitespace-nowrap {{ $currentTab === $key ? 'bg-sky-100 text-sky-900 font-bold' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200/90 shadow-xs font-medium' }}">
                        <span>{{ $data['label'] }}</span>
                        <span class="px-1.5 py-0.2 text-[10px] font-bold rounded-full {{ $currentTab === $key ? 'bg-sky-200 text-sky-900' : 'bg-slate-100 text-slate-600' }}">
                            {{ $data['count'] }}
                        </span>
                    </a>
                @endforeach
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
                                                <div class="w-6 h-6 rounded-full bg-teal-800 text-white font-bold flex items-center justify-center text-[10px]">
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

    </div>
</x-app-layout>