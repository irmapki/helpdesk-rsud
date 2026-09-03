<x-app-layout>
    <div class="space-y-6 px-3 sm:px-0" x-data="{ showAddModal: false }">
        <!-- Top Title & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Data Teknisi IT</h1>
                <p class="text-xs text-slate-500 font-normal mt-1">Monitoring status penugasan, nomor WhatsApp, keahlian, dan beban kerja aktif teknisi RSUD.</p>
            </div>
            <button @click="showAddModal = true" type="button" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition hover:scale-[1.02] shrink-0">
                <span class="text-sm font-bold">+</span>
                <span>Tambah Teknisi Baru</span>
            </button>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs sm:text-sm font-bold flex items-center gap-2 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs sm:text-sm font-bold flex items-center gap-2 shadow-xs">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

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
                                        <div class="w-8 h-8 rounded-full bg-teal-800 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                            {{ $initials }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-900 text-xs sm:text-sm truncate max-w-[180px] sm:max-w-none">{{ $tech->name }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono truncate">{{ $tech->email }}</div>
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
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tech->phone) }}" target="_blank" class="text-emerald-700 hover:text-emerald-900 font-bold inline-flex items-center gap-1.5 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
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
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('superadmin.technicians.edit', $tech) }}" title="Edit Teknisi" class="p-1.5 rounded-lg border border-slate-200 hover:border-slate-300 text-slate-600 hover:text-slate-900 transition inline-flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('superadmin.technicians.destroy', $tech) }}" method="POST" onsubmit="return confirm('Hapus data akun teknisi {{ $tech->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Teknisi" class="p-1.5 rounded-lg border border-rose-200 hover:bg-rose-50 text-rose-600 hover:text-rose-800 transition inline-flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
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

        <!-- Modal Tambah Akun Teknisi Baru (Model 1) -->
        <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
            <div @click.away="showAddModal = false" class="bg-white rounded-3xl p-6 max-w-lg w-full text-slate-900 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="font-black text-sm text-slate-900">Tambah Akun Teknisi IT Baru</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Daftarkan akun login dan nomor WhatsApp personil teknisi IT RSUD.</p>
                    </div>
                    <button @click="showAddModal = false" type="button" class="text-slate-400 hover:text-slate-700 font-bold text-lg">&times;</button>
                </div>

                <form method="POST" action="{{ route('superadmin.technicians.store') }}" class="space-y-3.5">
                    @csrf
                    <div>
                        <label for="new_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Nama Lengkap Teknisi <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" id="new_name" required placeholder="Contoh: Budi Santoso"
                            class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-700 focus:border-teal-700 font-medium">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="new_email" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Email Login <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" id="new_email" required placeholder="budi@rsud.test"
                                class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-700 focus:border-teal-700 font-medium">
                        </div>

                        <div>
                            <label for="new_password" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Password Awal
                            </label>
                            <input type="password" name="password" id="new_password" placeholder="Default: password"
                                class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-700 focus:border-teal-700 font-medium">
                        </div>
                    </div>

                    <div>
                        <label for="new_phone" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Nomor WhatsApp Teknisi <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="phone" id="new_phone" required placeholder="Contoh: 081234567890"
                            class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-700 focus:border-teal-700 font-medium">
                        <span class="text-[10px] text-slate-400 mt-0.5 block">Nomor ini yang akan dihubungi oleh pelapor/ruangan RSUD via WhatsApp.</span>
                    </div>

                    <div>
                        <label for="new_specialization" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Fokus Spesialisasi / Keahlian <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="specialization" id="new_specialization" required placeholder="Contoh: Hardware, Printer &amp; Jaringan LAN"
                            class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-700 focus:border-teal-700 font-medium">
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                        <button @click="showAddModal = false" type="button" class="text-xs font-bold px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition">Batal</button>
                        <button type="submit" class="text-xs font-bold px-5 py-2.5 rounded-xl bg-[#0f333a] hover:bg-[#092227] text-white shadow-xs transition">Simpan &amp; Buat Akun Teknisi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>