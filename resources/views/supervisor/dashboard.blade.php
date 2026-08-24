<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                Dashboard Supervisor IT
            </h1>
            <p class="text-xs text-slate-500 mt-1">Monitoring Kinerja &amp; Evaluasi Service Level Agreement (SLA) RSUD RAA Soewondo</p>
        </div>

        <!-- 4 Statistik Cards Supervisor (Light Mode) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider block mb-1">Total Tiket Bulan Ini</span>
                <div class="text-3xl font-black text-slate-900 mt-1">{{ $totalTicketsMonth ?? 0 }}</div>
                <span class="text-[11px] font-bold text-emerald-700 mt-2 inline-block">Pengaduan masuk</span>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider block mb-1">Tiket Pending / Kendala</span>
                <div class="text-3xl font-black text-amber-600 mt-1">{{ $pendingTicketsCount ?? 0 }}</div>
                <span class="text-[11px] font-bold text-amber-600 mt-2 inline-block">Perlu pengawasan</span>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider block mb-1">Penyelesaian Sesuai SLA</span>
                <div class="text-3xl font-black text-emerald-700 mt-1">{{ $slaCompliance ?? 96.4 }}%</div>
                <span class="text-[11px] font-bold text-emerald-600 mt-2 inline-block">Target &gt; 90% tercapai</span>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider block mb-1">Teknisi Aktif Bertugas</span>
                <div class="text-3xl font-black text-sky-700 mt-1">{{ $activeTechCount ?? 0 }} / {{ $totalTechCount ?? 0 }}</div>
                <span class="text-[11px] font-bold text-sky-600 mt-2 inline-block">Divisi IT Standby</span>
            </div>
        </div>

        <!-- Konten Utama: Daftar Eskalasi & Kinerja Teknisi -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Kolom Kiri: Monitoring Tiket Kritis (8 cols - Light Mode) -->
            <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-7 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-150">
                    <div>
                        <h2 class="text-base font-black text-slate-900">Monitoring Eskalasi &amp; Tiket Kritis</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Ditinjau dan diawasi langsung oleh Supervisor IT</p>
                    </div>

                    <a href="{{ route('supervisor.monitoring-sla') }}" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 bg-emerald-50 px-3.5 py-2 rounded-2xl border border-emerald-200 transition">
                        Buka Monitoring SLA &rarr;
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse ($criticalTickets as $t)
                        <div class="border border-slate-200 hover:border-emerald-600 rounded-2xl p-4 bg-white transition shadow-xs">
                            <div class="flex justify-between items-start mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-black text-emerald-800">{{ $t->ticket_number }}</span>
                                    <span class="px-2.5 py-0.5 text-[10px] rounded-lg font-black border {{ $t->priority->badge_class ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $t->priority->name ?? 'Normal' }}
                                    </span>
                                </div>
                                <span class="text-xs font-black {{ $t->sla_status === 'breached' ? 'text-rose-600' : ($t->sla_status === 'approaching' ? 'text-amber-600' : 'text-emerald-700') }}">
                                    {{ $t->status_label }}
                                </span>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm mb-1">{{ $t->title }}</h3>
                            <p class="text-xs text-slate-500 font-medium">
                                {{ $t->unit->name ?? '-' }} &bull; Ditugaskan ke: <span class="font-bold text-slate-800">{{ $t->technician->name ?? 'Belum Ditugaskan' }}</span> &bull; Status: {{ $t->status_label }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs bg-slate-50 rounded-2xl border border-slate-200">
                            Semua tiket dalam kondisi aman dan tertangani dengan baik.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Kanan: Ringkasan Performa Tim IT (4 cols - Light Mode) -->
            <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-7 space-y-4">
                <div>
                    <h3 class="text-sm font-black text-slate-900">Beban Kerja Teknisi</h3>
                    <p class="text-xs text-slate-500">Kapasitas penanganan kendala aktif</p>
                </div>

                <div class="space-y-3 text-xs">
                    @forelse ($technicians as $tech)
                        @php
                            $activeCount = $tech->assignedTickets->count();
                            $percent = min(100, $activeCount * 25);
                        @endphp
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-150">
                            <div class="flex justify-between mb-2 font-bold">
                                <span class="text-slate-900">{{ $tech->name }}</span>
                                <span class="text-emerald-800 font-black">{{ $activeCount }} Tiket Aktif</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2 mb-2 overflow-hidden">
                                <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ max(10, $percent) }}%"></div>
                            </div>
                            <span class="text-[10px] text-slate-400 font-medium">Spesialisasi: {{ $tech->specialization ?? 'Hardware & Jaringan' }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400">Belum ada data teknisi.</p>
                    @endforelse
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <a href="{{ route('supervisor.monitoring-sla') }}" class="block w-full py-2.5 text-center text-xs bg-emerald-800 hover:bg-emerald-900 text-white rounded-2xl font-bold transition shadow-xs">
                        Lihat Laporan SLA Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>