<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Manajemen Tiket Masuk Helpdesk RSUD') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Inbox keluhan masuk, validasi pengaduan, penyesuaian SLA, dan penugasan ke teknisi</p>
            </div>
            <a href="{{ route('guest.ticket.create') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white px-4 py-2.5 rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Tiket Baru (Manual)
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Status Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2">
                @php
                    $currentTab = request('tab', 'all');
                    $tabs = [
                        'all' => ['label' => 'Semua Tiket', 'count' => $counts['all']],
                        'pending' => ['label' => 'Menunggu Validasi', 'count' => $counts['pending'], 'alert' => true],
                        'assigned' => ['label' => 'Sudah Ditugaskan', 'count' => $counts['assigned']],
                        'in_progress' => ['label' => 'Sedang Dikerjakan', 'count' => $counts['in_progress']],
                        'resolved' => ['label' => 'Selesai', 'count' => $counts['resolved']],
                        'closed' => ['label' => 'Ditutup', 'count' => $counts['closed']],
                        'rejected' => ['label' => 'Ditolak', 'count' => $counts['rejected']],
                    ];
                @endphp

                @foreach ($tabs as $key => $data)
                    <a href="{{ route('admin.tickets.index', array_merge(request()->except(['tab', 'page']), ['tab' => $key])) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $currentTab === $key ? 'bg-teal-600 text-white shadow-sm' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 border border-gray-150 dark:border-gray-700' }}">
                        <span>{{ $data['label'] }}</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] {{ $currentTab === $key ? 'bg-white/20 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200' }}">
                            {{ $data['count'] }}
                        </span>
                    </a>
                @endforeach
            </div>

            <!-- Filter & Search Card -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm">
                <form method="GET" action="{{ route('admin.tickets.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <input type="hidden" name="tab" value="{{ $currentTab }}">

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Cari No. Tiket / Judul / Pelapor</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nomor tiket / nama..." class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Unit / Ruangan RSUD</label>
                        <select name="unit_id" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">-- Semua Unit --</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->id }}" {{ request('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Kategori Kendala</label>
                        <select name="category_id" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">-- Semua Kategori --</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition">
                            Filter Tiket
                        </button>
                        <a href="{{ route('admin.tickets.index', ['tab' => $currentTab]) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold py-2.5 px-3 rounded-xl transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tickets Table Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="px-5 py-3.5">No. Tiket & Tanggal</th>
                                <th class="px-5 py-3.5">Judul Masalah & Unit</th>
                                <th class="px-5 py-3.5">Pelapor & Kontak</th>
                                <th class="px-5 py-3.5">Kategori / Prioritas</th>
                                <th class="px-5 py-3.5">Teknisi Penanggung Jawab</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($tickets as $ticket)
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-750 transition">
                                    <td class="px-5 py-3.5">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="font-mono font-bold text-teal-700 dark:text-teal-400 hover:underline block text-sm">
                                            {{ $ticket->ticket_number }}
                                        </a>
                                        <span class="text-gray-400 text-[11px]">{{ $ticket->created_at->format('d/m/Y H:i') }} WIB</span>
                                    </td>
                                    <td class="px-5 py-3.5 max-w-xs">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="font-bold text-gray-900 dark:text-white hover:text-teal-600 block line-clamp-1">
                                            {{ $ticket->title }}
                                        </a>
                                        <span class="text-gray-500 text-[11px] font-medium block">Unit: {{ $ticket->unit->name }}</span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $ticket->reporter_name }}</div>
                                        <div class="text-gray-400 text-[11px]">{{ $ticket->reporter_contact }}</div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="text-gray-700 dark:text-gray-300 font-medium mb-1">{{ $ticket->category->name }}</div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border {{ $ticket->priority->badge_class }}">
                                            {{ $ticket->priority->name }} ({{ $ticket->priority->sla_hours }}j)
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if ($ticket->technician)
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-teal-600 text-white font-bold flex items-center justify-center text-[10px]">
                                                    {{ substr($ticket->technician->name, 0, 1) }}
                                                </div>
                                                <span class="font-semibold text-gray-900 dark:text-white">{{ $ticket->technician->name }}</span>
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                Belum Ditugaskan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $ticket->status_badge_class }}">
                                            {{ $ticket->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex items-center gap-1 text-xs font-bold text-teal-600 hover:text-teal-800 bg-teal-50 px-3 py-1.5 rounded-xl transition">
                                            Detail & Triage &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-10 text-gray-400">
                                        Tidak ada tiket pada tab / filter ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($tickets->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
