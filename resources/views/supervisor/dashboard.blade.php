<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header & Status Sistem -->
        <div class="flex justify-between items-center mb-2">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Dashboard Supervisor IT</h2>
                <p class="text-xs text-gray-500">Monitoring Kinerja, Eskalasi Masalah, &amp; Evaluasi Layanan RSUD</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                    <span class="w-2 h-2 mr-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Sistem Aktif
                </span>
            </div>
        </div>

        <!-- Statistik Cards Supervisor -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Card 1 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Total Tiket Bulan Ini</span>
                <h3 class="text-2xl font-extrabold text-gray-900">42</h3>
                <span class="text-[11px] text-emerald-600 font-semibold">+12% dari bulan lalu</span>
            </div>
            <!-- Card 2 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Tiket Pending / Kendala</span>
                <h3 class="text-2xl font-extrabold text-gray-900">3</h3>
                <span class="text-[11px] text-amber-600 font-semibold">Perlu perhatian khusus</span>
            </div>
            <!-- Card 3 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Penyelesaian Sesuai SLA</span>
                <h3 class="text-2xl font-extrabold text-gray-900">96.4%</h3>
                <span class="text-[11px] text-emerald-600 font-semibold">Target &gt; 90% tercapai</span>
            </div>
            <!-- Card 4 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Teknisi Aktif Bertugas</span>
                <h3 class="text-2xl font-extrabold text-gray-900">5/5</h3>
                <span class="text-[11px] text-blue-600 font-semibold">Semua standby</span>
            </div>
        </div>

        <!-- Konten Utama: Daftar Eskalasi & Kinerja Teknisi -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kolom Kiri: Daftar Eskalasi / Tiket Bermasalah -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-900 text-sm">Monitoring Eskalasi &amp; Tiket Kritis</h3>
                    <span class="text-[11px] text-gray-400">Ditinjau oleh Supervisor</span>
                </div>

                <!-- Filter Tab kecil -->
                <div class="flex space-x-2 mb-4">
                    <button class="px-3.5 py-1.5 text-xs bg-emerald-600 text-white rounded-xl font-semibold shadow-sm shadow-emerald-600/20">Semua (3)</button>
                    <button class="px-3.5 py-1.5 text-xs bg-gray-50 text-gray-600 rounded-xl font-semibold hover:bg-gray-100 border border-gray-200">Mendekati SLA</button>
                    <button class="px-3.5 py-1.5 text-xs bg-gray-50 text-gray-600 rounded-xl font-semibold hover:bg-gray-100 border border-gray-200">Pending</button>
                </div>

                <!-- List Tiket Eskalasi -->
                <div class="space-y-3">
                    <!-- Item Tiket 1 -->
                    <div class="border border-gray-200 rounded-xl p-4 hover:border-emerald-500 transition cursor-pointer bg-gray-50/50 shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="text-xs font-bold text-emerald-700 mr-2">#TK-0231</span>
                                <span class="px-2 py-0.5 text-[10px] bg-red-50 text-red-700 border border-red-200 rounded-md font-bold">Tinggi</span>
                            </div>
                            <span class="text-xs text-amber-600 font-bold">3j 05m lagi (SLA)</span>
                        </div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Aplikasi SIMRS error saat input pasien</h4>
                        <p class="text-[11px] text-gray-500">Poli Rawat Jalan • Ditugaskan ke: Teknisi A • Status: In Progress</p>
                    </div>

                    <!-- Item Tiket 2 -->
                    <div class="border border-gray-200 rounded-xl p-4 hover:border-emerald-500 transition cursor-pointer bg-gray-50/50 shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="text-xs font-bold text-emerald-700 mr-2">#TK-0225</span>
                                <span class="px-2 py-0.5 text-[10px] bg-amber-50 text-amber-700 border border-amber-200 rounded-md font-bold">Sedang</span>
                            </div>
                            <span class="text-xs text-emerald-700 font-bold">Aman</span>
                        </div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Printer Lab Patologi tidak bisa cetak label</h4>
                        <p class="text-[11px] text-gray-500">Laboratorium • Ditugaskan ke: Teknisi B • Status: Assigned</p>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Ringkasan Performa Tim IT -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <h3 class="font-bold text-gray-900 text-sm mb-0.5">Performa Teknisi Bulan Ini</h3>
                <p class="text-[11px] text-gray-400 mb-4">Beban kerja &amp; penyelesaian tugas</p>

                <div class="space-y-3.5 text-xs">
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-200">
                        <div class="flex justify-between mb-1.5">
                            <span class="font-bold text-gray-900">Teknisi A (Software)</span>
                            <span class="text-emerald-700 font-bold">12 Selesai</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1.5">
                            <div class="bg-emerald-600 h-1.5 rounded-full" style="width: 85%"></div>
                        </div>
                        <span class="text-[10px] text-gray-500">Beban kerja aktif: 2 tiket</span>
                    </div>

                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-200">
                        <div class="flex justify-between mb-1.5">
                            <span class="font-bold text-gray-900">Teknisi B (Hardware &amp; Jaringan)</span>
                            <span class="text-emerald-700 font-bold">15 Selesai</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1.5">
                            <div class="bg-emerald-600 h-1.5 rounded-full" style="width: 90%"></div>
                        </div>
                        <span class="text-[10px] text-gray-500">Beban kerja aktif: 1 tiket</span>
                    </div>

                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-200">
                        <div class="flex justify-between mb-1.5">
                            <span class="font-bold text-gray-900">Teknisi C (Infrastruktur)</span>
                            <span class="text-emerald-700 font-bold">10 Selesai</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1.5">
                            <div class="bg-emerald-600 h-1.5 rounded-full" style="width: 70%"></div>
                        </div>
                        <span class="text-[10px] text-gray-500">Beban kerja aktif: 0 tiket</span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button class="w-full py-2.5 text-xs bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl font-bold transition border border-gray-200 shadow-sm">
                        Unduh Laporan Bulanan (PDF)
                    </button>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>