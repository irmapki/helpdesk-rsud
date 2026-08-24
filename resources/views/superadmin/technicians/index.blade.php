<x-app-layout>
<<<<<<< HEAD
    <div class="space-y-6">
        <!-- Top Title & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Data Teknisi IT</h1>
                <p class="text-xs text-slate-500 font-normal mt-1">Monitoring status penugasan, keahlian, dan beban kerja aktif seluruh teknisi IT RSUD.</p>
            </div>
            <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center gap-1.5 bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition hover:scale-[1.02]">
                <span class="text-sm font-bold">+</span>
                <span>Tambah Teknisi Baru</span>
            </a>
        </div>

        <!-- Search & Workload Overview -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('superadmin.technicians.index') }}" class="flex items-center gap-2 w-full sm:w-80">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / keahlian teknisi..."
                    class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 font-medium">
                <button type="submit" class="bg-[#0f333a] hover:bg-[#092227] text-white text-xs font-bold py-2.5 px-4 rounded-xl transition shadow-xs">
                    Cari
                </button>
            </form>

            <div class="flex items-center gap-4 text-xs font-bold">
                <div class="flex items-center gap-1.5 bg-emerald-50 text-emerald-800 px-3 py-1 rounded-xl border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Tersedia (0-1)</span>
                </div>
                <div class="flex items-center gap-1.5 bg-orange-50 text-orange-800 px-3 py-1 rounded-xl border border-orange-200">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    <span>Aktif Menangani (2-4)</span>
                </div>
                <div class="flex items-center gap-1.5 bg-rose-50 text-rose-800 px-3 py-1 rounded-xl border border-rose-200">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span>Sibuk (5+)</span>
                </div>
            </div>
        </div>

        <!-- Technicians Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
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
                                $active = $tech->active_tickets;
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
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-amber-700 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm">{{ $tech->name }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono">{{ $tech->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-2">
                                    <span class="text-xs text-slate-700 font-medium">
                                        {{ $tech->specialization ?: 'Hardware & Jaringan' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-2">
                                    @if ($tech->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tech->phone) }}" target="_blank" class="text-emerald-700 hover:text-emerald-900 font-bold">
                                            <span>{{ $tech->phone }}</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-2 text-center">
                                    <span class="font-black text-sm text-slate-900">
                                        {{ $active }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-2 text-center">
                                    <span class="font-bold text-slate-600">
                                        {{ $tech->resolved_tickets }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-2 text-center">
                                    <span class="inline-block px-3 py-1 rounded-xl text-xs font-bold {{ $badge }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-2 text-right">
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
=======
    <x-slot name="pageTitle">
        Data &amp; Beban Kerja Teknisi
    </x-slot>
    <x-slot name="breadcrumb">
        Super Admin &rsaquo; Manajemen Staf &rsaquo; Data Teknisi
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Data &amp; Beban Kerja Teknisi</h1>
                <p class="text-xs text-slate-500 mt-1">Monitoring status penugasan aktif, kontak WhatsApp, dan keahlian teknisi IT rumah sakit.</p>
            </div>
            <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#0a252a] hover:bg-[#0e353c] text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition shrink-0">
                + Tambah Teknisi Baru
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($technicians as $tech)
                @php
                    $load = $tech->assignedTickets->count();
                    $badgeLoad = $load >= 5 ? 'bg-rose-50 text-rose-700 border-rose-200' : ($load >= 2 ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200');
                    $statusLoad = $load >= 5 ? 'Beban Tinggi / Sangat Sibuk' : ($load >= 2 ? 'Sedang Menangani Tiket' : 'Tersedia / Siap Ditugaskan');
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-teal-700 text-white font-bold flex items-center justify-center text-sm shadow-xs">
                                    {{ strtoupper(substr($tech->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h2 class="font-black text-slate-900 text-sm leading-tight">{{ $tech->name }}</h2>
                                    <span class="text-slate-400 text-xs font-medium">{{ $tech->email }}</span>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badgeLoad }}">
                                {{ $load }} Tiket Aktif
                            </span>
                        </div>

                        <div class="space-y-2 bg-slate-50 p-3.5 rounded-xl border border-slate-100 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Keahlian:</span>
                                <span class="font-extrabold text-slate-800">{{ $tech->specialization ?: 'Hardware & Jaringan' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Kontak WhatsApp:</span>
                                @if ($tech->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tech->phone) }}" target="_blank" class="font-bold text-emerald-600 hover:underline">
                                        {{ $tech->phone }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Kesiapan:</span>
                                <span class="font-bold text-slate-700">{{ $statusLoad }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-medium text-slate-400">Unit: {{ $tech->unit->name ?? 'Divisi IT RSUD' }}</span>
                        <a href="{{ route('superadmin.technicians.edit', $tech) }}" class="text-xs font-bold text-teal-700 hover:text-teal-900 bg-teal-50 px-3.5 py-1.5 rounded-xl transition">
                            Edit Profil &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
        </div>
    </div>
</x-app-layout>
