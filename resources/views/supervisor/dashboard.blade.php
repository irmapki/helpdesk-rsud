<x-app-layout>
    <div class="space-y-4 sm:space-y-6 max-w-full overflow-x-hidden pb-10">
        <!-- Header Halaman -->
        <div class="min-w-0">
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight break-words">
                Dashboard Supervisor IT
            </h1>
            <p class="text-xs text-slate-500 mt-1 break-words">Monitoring Kinerja &amp; Evaluasi Service Level Agreement (SLA) RSUD RAA Soewondo</p>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs sm:text-sm font-bold flex items-center gap-2 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Section Khusus: Review & Otorisasi Perbaikan Software (UAT) -->
        @if(isset($reviewTickets) && $reviewTickets->count() > 0)
            <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-xs border border-slate-200/90 relative overflow-hidden min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100 relative z-10 min-w-0">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping shrink-0"></span>
                            <h2 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight">Otorisasi &amp; Review Perbaikan Software ({{ $reviewTickets->count() }})</h2>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Perbaikan software/SIMRS oleh teknisi membutuhkan verifikasi &amp; uji fungsi dari Supervisor IT sebelum dinyatakan selesai.</p>
                    </div>
                </div>

                <div class="space-y-3.5 mt-4 relative z-10 min-w-0">
                    @foreach($reviewTickets as $rt)
                        <div class="bg-slate-50/80 border border-slate-200/90 rounded-2xl p-3.5 sm:p-4 text-slate-900 transition min-w-0" x-data="{ showRejectModal: false }">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 min-w-0">
                                <div class="space-y-1.5 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-mono text-xs font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-lg border border-emerald-200">{{ $rt->ticket_number }}</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 border border-emerald-200">{{ $rt->category->name ?? 'Software' }}</span>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md {{ $rt->priority->badge_class ?? 'bg-slate-100 text-slate-700' }}">{{ $rt->priority->name ?? 'Normal' }}</span>
                                    </div>
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900 break-words">{{ $rt->title }}</h3>
                                    <p class="text-xs text-slate-600 font-medium">
                                        Unit: <strong class="text-slate-900">{{ $rt->unit->name ?? '-' }}</strong> &bull; 
                                        Teknisi: <strong class="text-slate-900">{{ $rt->technician->name ?? 'Belum Ditugaskan' }}</strong>
                                    </p>
                                    @if($rt->resolution_notes)
                                        <div class="bg-white border border-slate-200 rounded-xl p-2.5 text-xs text-slate-700 mt-2 shadow-2xs">
                                            <span class="font-bold text-emerald-800 block mb-0.5">Catatan Solusi dari Teknisi:</span>
                                            {{ $rt->resolution_notes }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-2 shrink-0 pt-2 lg:pt-0">
                                    <!-- Form Setujui (Approve) -->
                                    <form method="POST" action="{{ route('supervisor.tickets.review', $rt->id) }}">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin menyetujui perbaikan software ini dan menyatakan tiket selesai?')"
                                            class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition hover:scale-[1.02]">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>Setujui &amp; Selesaikan</span>
                                        </button>
                                    </form>

                                    <!-- Tombol Minta Revisi (Tolak) -->
                                    <button @click="showRejectModal = true" type="button"
                                        class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 transition hover:scale-[1.02]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        <span>Minta Revisi</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Modal Minta Revisi (Netral/Gelap) -->
                            <div x-show="showRejectModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs">
                                <div @click.away="showRejectModal = false" class="bg-white rounded-3xl p-6 max-w-md w-full text-slate-900 shadow-2xl space-y-4">
                                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                        <h4 class="font-black text-sm text-slate-900">Minta Perbaikan Ulang Software</h4>
                                        <button @click="showRejectModal = false" class="text-slate-400 hover:text-slate-700 font-bold">&times;</button>
                                    </div>
                                    <p class="text-xs text-slate-600">Tiket <strong>{{ $rt->ticket_number }}</strong> akan dikembalikan ke status <em>Sedang Dikerjakan</em> oleh Teknisi.</p>
                                    <form method="POST" action="{{ route('supervisor.tickets.review', $rt->id) }}" class="space-y-3">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Bug / Alasan Revisi:</label>
                                            <textarea name="supervisor_notes" required rows="3" placeholder="Contoh: Modul cetak resep masih error saat diuji di poli..." class="w-full text-xs rounded-xl border-slate-200 text-slate-900 focus:ring-slate-900 focus:border-slate-900"></textarea>
                                        </div>
                                        <div class="flex justify-end gap-2 pt-2">
                                            <button @click="showRejectModal = false" type="button" class="text-xs font-bold px-3.5 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200">Batal</button>
                                            <button type="submit" class="text-xs font-bold px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white shadow-xs">Kembalikan ke Teknisi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 4 Statistik Cards Supervisor (Responsive Grid) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 min-w-0">
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <span class="text-xs font-semibold text-slate-500 block mb-1 truncate">Total Tiket Bulan Ini</span>
                <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ $totalTicketsMonth ?? 42 }}</div>
                <span class="text-[11px] font-bold text-emerald-600 mt-1 inline-block truncate">+12% dari bulan lalu</span>
            </div>

            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <span class="text-xs font-semibold text-slate-500 block mb-1 truncate">Tiket Pending / Kendala</span>
                <div class="text-2xl sm:text-3xl font-black text-amber-600">{{ $pendingTicketsCount ?? 3 }}</div>
                <span class="text-[11px] font-bold text-amber-600 mt-1 inline-block truncate">Perlu pengawasan</span>
            </div>

            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <span class="text-xs font-semibold text-slate-500 block mb-1 truncate">Penyelesaian Sesuai SLA</span>
                <div class="text-2xl sm:text-3xl font-black text-emerald-600">{{ $slaCompliance ?? 96.4 }}%</div>
                <span class="text-[11px] font-bold text-emerald-600 mt-1 inline-block truncate">Target &gt; 90% tercapai</span>
            </div>

            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <span class="text-xs font-semibold text-slate-500 block mb-1 truncate">Teknisi Aktif Bertugas</span>
                <div class="text-2xl sm:text-3xl font-black text-sky-700">{{ $activeTechCount ?? 5 }} / {{ $totalTechCount ?? 5 }}</div>
                <span class="text-[11px] font-bold text-sky-600 mt-1 inline-block truncate">Divisi IT Standby</span>
            </div>
        </div>

        <!-- Konten Utama: Monitoring & Kinerja Teknisi -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 items-start min-w-0">
            <!-- Kolom Kiri: Monitoring Tiket Kritis (8 cols) -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 space-y-4 min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100 min-w-0">
                    <div class="min-w-0">
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 break-words">Monitoring Eskalasi &amp; Tiket Kritis</h2>
                        <p class="text-xs text-slate-500 mt-0.5 break-words">Ditinjau dan diawasi langsung oleh Supervisor IT</p>
                    </div>

                    <a href="{{ route('supervisor.monitoring-sla') }}" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 bg-emerald-50 px-3.5 py-2.5 sm:py-2 rounded-xl border border-emerald-200 transition text-center shrink-0">
                        Buka Monitoring SLA &rarr;
                    </a>
                </div>

                <div class="space-y-3 min-w-0">
                    @forelse ($criticalTickets as $t)
                        <div class="border border-slate-200 hover:border-emerald-600 rounded-2xl p-3.5 sm:p-4 bg-white transition shadow-xs min-w-0">
                            <div class="flex flex-wrap justify-between items-start gap-2 mb-1.5 min-w-0">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="text-xs font-mono font-bold text-teal-800 shrink-0">{{ $t->ticket_number }}</span>
                                    <span class="px-2.5 py-0.5 text-[10px] rounded-lg font-bold truncate {{ $t->priority->badge_class ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $t->priority->name ?? 'Normal' }}
                                    </span>
                                </div>
                                <span class="text-xs font-bold shrink-0 {{ $t->sla_status === 'breached' ? 'text-rose-600' : ($t->sla_status === 'approaching' ? 'text-amber-600' : 'text-emerald-700') }}">
                                    {{ $t->status_label }}
                                </span>
                            </div>
                            <h3 class="font-bold text-slate-900 text-xs sm:text-sm mb-1 break-words">{{ $t->title }}</h3>
                            <p class="text-xs text-slate-500 font-medium break-words">
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

            <!-- Kolom Kanan: Ringkasan Performa Tim IT (4 cols) -->
            <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 space-y-4 min-w-0">
                <div class="min-w-0">
                    <h3 class="text-sm font-bold text-slate-900 truncate">Beban Kerja Teknisi</h3>
                    <p class="text-xs text-slate-500 truncate">Kapasitas penanganan kendala aktif</p>
                </div>

                <div class="space-y-3 text-xs min-w-0">
                    @forelse ($technicians as $tech)
                        @php
                            $activeCount = $tech->assignedTickets->count();
                            $percent = min(100, $activeCount * 25);
                        @endphp
                        <div class="bg-slate-50 p-3.5 sm:p-4 rounded-xl border border-slate-150 min-w-0">
                            <div class="flex justify-between items-center gap-2 mb-2 font-bold min-w-0">
                                <span class="text-slate-900 truncate">{{ $tech->name }}</span>
                                <span class="text-emerald-800 font-bold shrink-0">{{ $activeCount }} Tiket Aktif</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2 mb-2 overflow-hidden">
                                <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ max(10, $percent) }}%"></div>
                            </div>
                            <span class="text-[10px] text-slate-400 font-medium block truncate">Spesialisasi: {{ $tech->specialization ?? 'Hardware & Jaringan' }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400">Belum ada data teknisi.</p>
                    @endforelse
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <a href="{{ route('supervisor.monitoring-sla') }}" class="block w-full py-2.5 text-center text-xs bg-[#0f333a] hover:bg-[#092227] text-white rounded-xl font-bold transition shadow-xs">
                        Lihat Laporan SLA Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>