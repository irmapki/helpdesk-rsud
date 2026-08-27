<x-app-layout>
    <div class="space-y-4 sm:space-y-6 max-w-7xl mx-auto max-w-full overflow-x-hidden pb-10">
        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 min-w-0">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight break-words">Statistik &amp; Analisis Kinerja</h1>
                <p class="text-xs text-slate-500 mt-1 break-words">Pemantauan visual sebaran kendala IT, performa teknisi, dan kepatuhan SLA RSUD.</p>
            </div>
            <a href="{{ route('supervisor.dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-2xl transition shadow-xs text-center shrink-0">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <!-- 4 Top KPI Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 min-w-0">
            <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/80 shadow-xs min-w-0">
                <span class="text-xs font-bold text-slate-400 block truncate">TOTAL PENGADUAN</span>
                <div class="text-2xl font-black text-slate-900 mt-1">{{ $totalTickets }}</div>
                <span class="text-[11px] text-slate-500 font-semibold mt-1 block truncate">Seluruh riwayat sistem</span>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/80 shadow-xs min-w-0">
                <span class="text-xs font-bold text-emerald-600 block truncate">SELESAI DITANGANI</span>
                <div class="text-2xl font-black text-emerald-700 mt-1">{{ $resolvedCount }}</div>
                <span class="text-[11px] text-emerald-600 font-semibold mt-1 block truncate">Tiket teratasi tuntas</span>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/80 shadow-xs min-w-0">
                <span class="text-xs font-bold text-indigo-600 block truncate">SEDANG DIKERJAKAN</span>
                <div class="text-2xl font-black text-indigo-600 mt-1">{{ $inProgressCount }}</div>
                <span class="text-[11px] text-indigo-500 font-semibold mt-1 block truncate">Pengerjaan di lokasi</span>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/80 shadow-xs min-w-0">
                <span class="text-xs font-bold text-teal-600 block truncate">KEPATUHAN SLA</span>
                <div class="text-2xl font-black text-teal-700 mt-1">{{ $slaRate }}%</div>
                <span class="text-[11px] text-teal-600 font-semibold mt-1 block truncate">Standar target waktu</span>
            </div>
        </div>

        <!-- 2 Columns Grid: Kategori & Prioritas Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 min-w-0">
            <!-- Breakdown Kategori Kendala -->
            <div class="bg-white p-4 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-4 min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2 min-w-0">
                    <div class="min-w-0">
                        <h2 class="text-sm font-extrabold text-slate-900 break-words">Sebaran Kategori Kendala</h2>
                        <p class="text-[11px] text-slate-400 break-words">Distribusi pengaduan berdasarkan jenis masalah</p>
                    </div>
                    <span class="text-xs font-bold text-slate-500 shrink-0">{{ $categories->count() }} Kategori</span>
                </div>

                <div class="space-y-3 min-w-0">
                    @foreach($categories as $cat)
                        @php
                            $pct = $totalTickets > 0 ? round(($cat->tickets_count / $totalTickets) * 100, 1) : 0;
                        @endphp
                        <div class="min-w-0">
                            <div class="flex items-center justify-between text-xs mb-1 gap-2 min-w-0">
                                <span class="font-bold text-slate-800 truncate">{{ $cat->name }}</span>
                                <span class="font-bold text-slate-600 shrink-0">{{ $cat->tickets_count }} Tiket ({{ $pct }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-emerald-600 h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Breakdown Prioritas SLA -->
            <div class="bg-white p-4 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-4 min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2 min-w-0">
                    <div class="min-w-0">
                        <h2 class="text-sm font-extrabold text-slate-900 break-words">Tingkat Prioritas &amp; SLA</h2>
                        <p class="text-[11px] text-slate-400 break-words">Komposisi urgensi penanganan kendala</p>
                    </div>
                    <span class="text-xs font-bold text-slate-500 shrink-0">{{ $priorities->count() }} Tingkatan</span>
                </div>

                <div class="space-y-3 min-w-0">
                    @foreach($priorities as $pri)
                        @php
                            $pct = $totalTickets > 0 ? round(($pri->tickets_count / $totalTickets) * 100, 1) : 0;
                        @endphp
                        <div class="min-w-0">
                            <div class="flex items-center justify-between text-xs mb-1 gap-2 min-w-0">
                                <span class="font-bold text-slate-800 truncate">{{ $pri->name }} (Target: {{ $pri->sla_hours }} Jam)</span>
                                <span class="font-bold text-slate-600 shrink-0">{{ $pri->tickets_count }} Tiket ({{ $pct }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-teal-700 h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 2 Columns Grid: Top Pelapor & Kinerja Teknisi -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 min-w-0">
            <!-- Unit Teraktif -->
            <div class="bg-white p-4 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-4 min-w-0">
                <div class="pb-3 border-b border-slate-100 min-w-0">
                    <h2 class="text-sm font-extrabold text-slate-900 break-words">Unit / Ruangan Terbanyak Melapor</h2>
                    <p class="text-[11px] text-slate-400 break-words">5 Unit dengan frekuensi pengaduan tertinggi</p>
                </div>

                <div class="space-y-3 text-xs min-w-0">
                    @forelse($topUnits as $unit)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 gap-2 min-w-0">
                            <div class="min-w-0">
                                <span class="font-extrabold text-slate-900 block truncate">{{ $unit->name }}</span>
                                <span class="text-[10px] text-slate-400 block truncate">{{ $unit->location }}</span>
                            </div>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-xl font-bold text-xs shrink-0">
                                {{ $unit->tickets_count }} Pengaduan
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada data unit.</p>
                    @endforelse
                </div>
            </div>

            <!-- Kinerja Teknisi -->
            <div class="bg-white p-4 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-4 min-w-0">
                <div class="pb-3 border-b border-slate-100 min-w-0">
                    <h2 class="text-sm font-extrabold text-slate-900 break-words">Performa &amp; Beban Kerja Teknisi</h2>
                    <p class="text-[11px] text-slate-400 break-words">Total penanganan dan tiket selesai per teknisi</p>
                </div>

                <div class="space-y-3 text-xs min-w-0">
                    @forelse($technicians as $tech)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 gap-3 min-w-0">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-xl bg-teal-800 text-white font-black text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($tech->name, 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <span class="font-extrabold text-slate-900 block truncate">{{ $tech->name }}</span>
                                    <span class="text-[10px] text-slate-400 block truncate">{{ $tech->specialization ?: 'Hardware & Jaringan' }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-200/60">
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-xl font-bold text-[11px]">
                                    {{ $tech->active_count }} Aktif
                                </span>
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl font-bold text-[11px]">
                                    {{ $tech->resolved_count }} Selesai
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada data teknisi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>