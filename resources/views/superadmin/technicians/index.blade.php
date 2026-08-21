<x-app-layout>
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
        </div>
    </div>
</x-app-layout>
