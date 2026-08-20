<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard Admin Helpdesk (Triage & Dispatch)') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Pengelolaan tiket masuk, validasi keluhan, penugasan teknisi, dan pemantauan SLA RSUD</p>
            </div>
            <a href="{{ route('admin.tickets.index', ['tab' => 'pending']) }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-amber-500 hover:bg-amber-600 text-white px-3.5 py-2 rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Tiket Perlu Validasi ({{ $pendingValidationCount }})
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Counters -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <!-- Pending Validation -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-amber-200/80 dark:border-amber-900/50 shadow-sm bg-gradient-to-br from-amber-50/50 to-white dark:from-gray-800">
                    <span class="text-xs text-amber-700 dark:text-amber-400 font-bold uppercase tracking-wider">Menunggu Validasi</span>
                    <div class="text-3xl font-black text-amber-600 dark:text-amber-400 mt-1">{{ $pendingValidationCount }}</div>
                    <a href="{{ route('admin.tickets.index', ['tab' => 'pending']) }}" class="text-[11px] text-amber-700 dark:text-amber-400 font-semibold hover:underline mt-2 inline-block">Validasi Sekarang &rarr;</a>
                </div>

                <!-- Assigned -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-blue-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-bold uppercase tracking-wider">Sudah Ditugaskan</span>
                    <div class="text-3xl font-black text-blue-600 dark:text-blue-400 mt-1">{{ $assignedCount }}</div>
                    <a href="{{ route('admin.tickets.index', ['tab' => 'assigned']) }}" class="text-[11px] text-blue-600 dark:text-blue-400 font-semibold hover:underline mt-2 inline-block">Lihat Tiket &rarr;</a>
                </div>

                <!-- In Progress -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-indigo-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs text-indigo-600 dark:text-indigo-400 font-bold uppercase tracking-wider">Sedang Dikerjakan</span>
                    <div class="text-3xl font-black text-indigo-600 dark:text-indigo-400 mt-1">{{ $inProgressCount }}</div>
                    <a href="{{ route('admin.tickets.index', ['tab' => 'in_progress']) }}" class="text-[11px] text-indigo-600 dark:text-indigo-400 font-semibold hover:underline mt-2 inline-block">Pantau Progress &rarr;</a>
                </div>

                <!-- Resolved -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-emerald-100 dark:border-gray-700 shadow-sm">
                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider">Selesai Ditangani</span>
                    <div class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $resolvedCount }}</div>
                    <span class="text-[11px] text-gray-400 mt-2 block">Total: {{ $totalTicketsCount }} Tiket</span>
                </div>
            </div>

            <!-- 2-Columns Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Incoming Tickets (2 cols) -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-bold text-sm text-gray-900 dark:text-white">Tiket Masuk Terbaru</h3>
                            <p class="text-xs text-gray-500">Pengaduan yang baru masuk dari unit RSUD</p>
                        </div>
                        <a href="{{ route('admin.tickets.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-800">
                            Buka Semua Tiket &rarr;
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100 dark:border-gray-700">
                                <tr>
                                    <th class="px-4 py-3">No. Tiket & Judul</th>
                                    <th class="px-4 py-3">Unit / Pelapor</th>
                                    <th class="px-4 py-3">Prioritas / SLA</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($recentTickets as $ticket)
                                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-750 transition">
                                        <td class="px-4 py-3">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="font-mono font-bold text-teal-700 dark:text-teal-400 hover:underline block">
                                                {{ $ticket->ticket_number }}
                                            </a>
                                            <span class="font-semibold text-gray-900 dark:text-white line-clamp-1">{{ $ticket->title }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="font-bold text-gray-800 dark:text-gray-200 block">{{ $ticket->unit->name }}</span>
                                            <span class="text-gray-400 text-[11px]">{{ $ticket->reporter_name }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border {{ $ticket->priority->badge_class }}">
                                                {{ $ticket->priority->name }} ({{ $ticket->priority->sla_hours }}j)
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $ticket->status_badge_class }}">
                                                {{ $ticket->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex items-center gap-1 text-xs font-bold text-teal-600 hover:text-teal-800 bg-teal-50 px-2.5 py-1.5 rounded-lg transition">
                                                Triage &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-gray-400">Belum ada tiket masuk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Active Technicians Workload (1 col) -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6 space-y-4">
                    <div>
                        <h3 class="font-bold text-sm text-gray-900 dark:text-white">Kesiapan & Beban Teknisi</h3>
                        <p class="text-xs text-gray-500">Gunakan untuk memilih teknisi saat penugasan tiket</p>
                    </div>

                    <div class="space-y-3">
                        @forelse ($technicians as $tech)
                            @php
                                $activeLoad = $tech->assignedTickets->count();
                            @endphp
                            <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 text-xs">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-teal-600 text-white font-bold flex items-center justify-center text-[10px]">
                                            {{ substr($tech->name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $tech->name }}</span>
                                    </div>
                                    <span class="font-bold {{ $activeLoad >= 5 ? 'text-red-500' : ($activeLoad >= 2 ? 'text-amber-600' : 'text-emerald-600') }}">
                                        {{ $activeLoad }} Tiket Aktif
                                    </span>
                                </div>
                                <div class="text-[11px] text-gray-400 pl-8">
                                    {{ $tech->specialization ?: 'Hardware & Jaringan' }}
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 py-3 text-center">Belum ada teknisi aktif.</p>
                        @endforelse
                    </div>

                    <div class="pt-2 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('admin.tickets.index') }}" class="block text-center text-xs font-bold text-teal-600 hover:text-teal-800 py-2">
                            Buka Manajemen Tiket & Penugasan &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>