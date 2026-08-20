<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Kelola Data Teknisi & Beban Kerja') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Monitoring status penugasan, keahlian/spesialisasi, dan beban kerja aktif seluruh teknisi IT RSUD</p>
            </div>
            <a href="{{ route('superadmin.users.create') }}" class="text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white px-4 py-2.5 rounded-xl shadow-sm transition">
                + Tambah Teknisi Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Search & Workload Overview -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <form method="GET" action="{{ route('superadmin.technicians.index') }}" class="flex items-center gap-2 w-full sm:w-80">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / keahlian teknisi..." class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition">
                        Cari
                    </button>
                </form>

                <div class="flex items-center gap-6 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-gray-600 dark:text-gray-300">Tersedia (0-1 Tiket)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="text-gray-600 dark:text-gray-300">Sedang Menangani (2-4 Tiket)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="text-gray-600 dark:text-gray-300">Sibuk (5+ Tiket)</span>
                    </div>
                </div>
            </div>

            <!-- Technicians Grid / Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="px-5 py-3.5">Nama Teknisi</th>
                                <th class="px-5 py-3.5">Spesialisasi / Keahlian</th>
                                <th class="px-5 py-3.5">Kontak WhatsApp</th>
                                <th class="px-5 py-3.5 text-center">Tiket Sedang Ditangani</th>
                                <th class="px-5 py-3.5 text-center">Tiket Selesai</th>
                                <th class="px-5 py-3.5 text-center">Status Beban</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($technicians as $tech)
                                @php
                                    $active = $tech->active_tickets;
                                    $badge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    $label = 'Tersedia';
                                    if ($active >= 5) {
                                        $badge = 'bg-red-50 text-red-700 border-red-200';
                                        $label = 'Sangat Sibuk';
                                    } elseif ($active >= 2) {
                                        $badge = 'bg-amber-50 text-amber-700 border-amber-200';
                                        $label = 'Aktif Menangani';
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-750 transition">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-teal-600 text-white font-bold flex items-center justify-center text-xs">
                                                {{ substr($tech->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white">{{ $tech->name }}</div>
                                                <div class="text-gray-400 text-[11px]">{{ $tech->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold text-[11px]">
                                            {{ $tech->specialization ?: 'Hardware & Jaringan Umum' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if ($tech->phone)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tech->phone) }}" target="_blank" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-800 font-semibold">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z" />
                                                </svg>
                                                {{ $tech->phone }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span class="font-extrabold text-sm text-teal-600 dark:text-teal-400">
                                            {{ $active }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span class="font-bold text-gray-700 dark:text-gray-300">
                                            {{ $tech->resolved_tickets }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badge }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="{{ route('superadmin.technicians.edit', $tech) }}" class="text-xs font-bold text-teal-600 hover:text-teal-800">
                                            Edit Data &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8 text-gray-400">Belum ada akun teknisi yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
