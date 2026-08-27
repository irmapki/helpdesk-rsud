<x-app-layout>
    <div class="space-y-6 px-3 sm:px-0">
        <!-- Top Title & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Data Teknisi IT</h1>
                <p class="text-xs text-slate-500 font-normal mt-1">Monitoring status penugasan, keahlian, dan beban kerja aktif seluruh teknisi IT RSUD.</p>
            </div>
            <a href="{{ route('superadmin.users.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition hover:scale-[1.02] shrink-0">
                <span class="text-sm font-bold">+</span>
                <span>Tambah Teknisi Baru</span>
            </a>
        </div>

        <!-- Search & Workload Overview -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col gap-4">
            <form method="GET" action="{{ route('superadmin.technicians.index') }}" class="flex flex-col sm:flex-row items-center gap-2 w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / keahlian teknisi..."
                    class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 font-medium">
                <button type="submit" class="w-full sm:w-auto bg-[#0f333a] hover:bg-[#092227] text-white text-xs font-bold py-2.5 px-4 rounded-xl transition shadow-xs shrink-0">
                    Cari
                </button>
            </form>

            <!-- Legend Status: Flexible wrap for mobile -->
            <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-[11px] sm:text-xs font-bold pt-1 border-t border-slate-100 sm:border-t-0 sm:pt-0">
                <div class="flex items-center gap-1.5 bg-emerald-50 text-emerald-800 px-2.5 py-1 rounded-xl border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                    <span>Tersedia (0-1)</span>
                </div>
                <div class="flex items-center gap-1.5 bg-orange-50 text-orange-800 px-2.5 py-1 rounded-xl border border-orange-200">
                    <span class="w-2 h-2 rounded-full bg-orange-500 shrink-0"></span>
                    <span>Aktif (2-4)</span>
                </div>
                <div class="flex items-center gap-1.5 bg-rose-50 text-rose-800 px-2.5 py-1 rounded-xl border border-rose-200">
                    <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0"></span>
                    <span>Sibuk (5+)</span>
                </div>
            </div>
        </div>

        <!-- Technicians Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 overflow-hidden">
            <div class="overflow-x-auto -mx-4 sm:mx-0 px-4 sm:px-0">
                <table class="w-full text-left text-xs min-w-[700px]">
                    <thead class="text-slate-400 uppercase font-bold text-[11px] border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-2">NAMA TEKNISI</th>
                            <th class="py-3 px-2">SPESIALISASI</th>
                            <th class="py-3 px-2">KONTAK WHATSAPP</th>
                            <th class="py-3 px-2 text-center">TIKET AKTIF</th>
                            <th class="py-3 px-2 text-center">SELESAI</th>
                            <th class="py-3 px-2 text-center">STATUS BEBAN</th>
                            <th class="py-3 px-2 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($technicians as $tech)
                            @php
                                $active = $tech->assignedTickets ? $tech->assignedTickets->whereIn('status', ['assigned', 'in_progress'])->count() : ($tech->active_tickets ?? 0);
                                $resolved = $tech->assignedTickets ? $tech->assignedTickets->whereIn('status', ['resolved', 'closed'])->count() : ($tech->resolved_tickets ?? 0);
                                $badge = 'bg-emerald-100 text-emerald-700';
                                $label = 'Tersedia';
                                if ($active >= 5) {
                                    $badge = 'bg-rose-100 text-rose-700';
                                    $label = 'Sangat Sibuk';
                                } elseif ($active >= 2) {
                                    $badge = 'bg-orange-100 text-orange-700';
                                    $label = 'Aktif Menangani';
                                }

                                $words = explode(' ', trim($tech->name));
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : substr($words[0], 1, 1)));
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-2">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-amber-700 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                            {{ $initials }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-900 text-xs sm:text-sm truncate max-w-[150px] sm:max-w-none">{{ $tech->name }}</div>
                                            <div class="text-[10px] sm:text-[11px] text-slate-400 font-mono truncate max-w-[150px] sm:max-w-none">{{ $tech->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-2 whitespace-nowrap">
                                    <span class="text-xs text-slate-700 font-medium">
                                        {{ $tech->specialization ?: 'Hardware & Jaringan' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-2 whitespace-nowrap">
                                    @if ($tech->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tech->phone) }}" target="_blank" class="text-emerald-700 hover:text-emerald-900 font-bold inline-flex items-center gap-1">
                                            <span>{{ $tech->phone }}</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-2 text-center whitespace-nowrap">
                                    <span class="font-black text-sm text-slate-900">
                                        {{ $active }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-2 text-center whitespace-nowrap">
                                    <span class="font-bold text-slate-600">
                                        {{ $resolved }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-2 text-center whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-1 rounded-xl text-[10px] sm:text-xs font-bold {{ $badge }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-2 text-right whitespace-nowrap">
                                    <a href="{{ route('superadmin.technicians.edit', $tech) }}" class="p-1.5 rounded-lg border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-800 transition inline-flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-slate-400 text-xs">Belum ada akun teknisi yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-[10px] text-slate-400 text-center sm:hidden italic pt-3">
                ← Geser tabel ke samping untuk melihat detail lengkap →
            </div>
        </div>
    </div>
</x-app-layout>