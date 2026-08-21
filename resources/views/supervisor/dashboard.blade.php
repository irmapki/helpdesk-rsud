<x-app-layout>
    <x-slot name="pageTitle">
        Dashboard Supervisor IT
    </x-slot>
    <x-slot name="breadcrumb">
        Supervisor IT &rsaquo; Monitoring Kinerja &amp; Evaluasi Layanan RSUD
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <!-- Statistik Cards Supervisor -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <span class="text-xs font-semibold text-slate-500 block mb-1">Total Tiket Bulan Ini</span>
                <div class="text-3xl font-black text-slate-900">42</div>
                <span class="text-[11px] font-bold text-emerald-600 mt-1 inline-block">+12% dari bulan lalu</span>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <span class="text-xs font-semibold text-slate-500 block mb-1">Tiket Pending / Kendala</span>
                <div class="text-3xl font-black text-amber-600">3</div>
                <span class="text-[11px] font-bold text-amber-600 mt-1 inline-block">Perlu perhatian khusus</span>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <span class="text-xs font-semibold text-slate-500 block mb-1">Penyelesaian Sesuai SLA</span>
                <div class="text-3xl font-black text-emerald-600">96.4%</div>
                <span class="text-[11px] font-bold text-emerald-600 mt-1 inline-block">Target &gt; 90% tercapai</span>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <span class="text-xs font-semibold text-slate-500 block mb-1">Teknisi Aktif Bertugas</span>
                <div class="text-3xl font-black text-blue-600">5 / 5</div>
                <span class="text-[11px] font-bold text-blue-600 mt-1 inline-block">Semua standby</span>
            </div>
        </div>

        <!-- Konten Utama: Daftar Eskalasi & Kinerja Teknisi -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Kolom Kiri: Monitoring Tiket Kritis (8 cols) -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900">Monitoring Eskalasi &amp; Tiket Kritis</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Ditinjau dan diawasi langsung oleh Supervisor IT</p>
                    </div>

                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
                        <button class="px-3 py-1 text-xs font-bold bg-[#0a252a] text-white rounded-lg shadow-xs">Semua (3)</button>
                        <button class="px-3 py-1 text-xs font-bold text-slate-600 hover:text-slate-900 rounded-lg">Mendekati SLA</button>
                        <button class="px-3 py-1 text-xs font-bold text-slate-600 hover:text-slate-900 rounded-lg">Pending</button>
                    </div>
                </div>

                <div class="space-y-3">
                    <!-- Item 1 -->
                    <div class="border border-slate-200 hover:border-teal-500 rounded-2xl p-4 bg-white transition shadow-xs">
                        <div class="flex justify-between items-start mb-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-mono font-black text-teal-700">#TK-0231</span>
                                <span class="px-2 py-0.5 text-[10px] bg-rose-100 text-rose-700 border border-rose-200 rounded-lg font-bold">Tinggi</span>
                            </div>
                            <span class="text-xs text-amber-600 font-black">3j 05m lagi (SLA)</span>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-sm mb-1">Aplikasi SIMRS error saat input pasien</h3>
                        <p class="text-xs text-slate-500 font-medium">Poli Rawat Jalan &bull; Ditugaskan ke: <span class="font-bold text-slate-700">Teknisi Rian</span> &bull; Status: In Progress</p>
                    </div>

                    <!-- Item 2 -->
                    <div class="border border-slate-200 hover:border-teal-500 rounded-2xl p-4 bg-white transition shadow-xs">
                        <div class="flex justify-between items-start mb-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-mono font-black text-teal-700">#TK-0225</span>
                                <span class="px-2 py-0.5 text-[10px] bg-amber-100 text-amber-700 border border-amber-200 rounded-lg font-bold">Sedang</span>
                            </div>
                            <span class="text-xs text-emerald-600 font-black">Aman Sesuai Target</span>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-sm mb-1">Printer Lab Patologi tidak bisa cetak label</h3>
                        <p class="text-xs text-slate-500 font-medium">Laboratorium &bull; Ditugaskan ke: <span class="font-bold text-slate-700">Teknisi Bayu</span> &bull; Status: Assigned</p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Ringkasan Performa Tim IT (4 cols) -->
            <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900">Performa Teknisi Bulan Ini</h3>
                    <p class="text-xs text-slate-500">Beban kerja &amp; penyelesaian tugas</p>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                        <div class="flex justify-between mb-1.5 font-bold">
                            <span class="text-slate-900">Rian (Hardware &amp; Jaringan)</span>
                            <span class="text-emerald-700 font-extrabold">15 Selesai</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2 mb-1.5">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: 90%"></div>
                        </div>
                        <span class="text-[10px] text-slate-400 font-medium">Beban kerja aktif: 2 tiket</span>
                    </div>

                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                        <div class="flex justify-between mb-1.5 font-bold">
                            <span class="text-slate-900">Bayu (SIMRS &amp; Software)</span>
                            <span class="text-emerald-700 font-extrabold">12 Selesai</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2 mb-1.5">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                        <span class="text-[10px] text-slate-400 font-medium">Beban kerja aktif: 1 tiket</span>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <button class="w-full py-2.5 text-xs bg-[#0a252a] hover:bg-[#0e353c] text-white rounded-xl font-bold transition shadow-xs">
                        Unduh Rekap Laporan SLA (PDF)
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>