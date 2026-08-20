<x-app-layout>
    <div class="py-6 bg-[#0f172a] min-h-screen text-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header & Status Sistem -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-white">Dashboard Supervisor IT</h2>
                    <p class="text-sm text-gray-400">Monitoring Kinerja, Eskalasi Masalah, & Evaluasi Layanan RSUD</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-900/50 text-emerald-400 border border-emerald-700/50">
                        <span class="w-2 h-2 mr-1.5 bg-emerald-400 rounded-full"></span> Sistem Normal
                    </span>
                    <div class="text-right">
                        <span class="block text-sm font-bold text-white">{{ auth()->user()->name }}</span>
                        <span class="block text-xs text-gray-400">Supervisor IT - Divisi Infrastruktur</span>
                    </div>
                </div>
            </div>

            <!-- Statistik Cards Supervisor -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Card 1 -->
                <div class="bg-[#1e293b] p-5 rounded-xl shadow-sm border border-slate-800 relative">
                    <span class="text-xs text-gray-400 block mb-1">Total Tiket Bulan Ini</span>
                    <h3 class="text-3xl font-bold text-white">42</h3>
                    <span class="text-xs text-emerald-400 font-medium">+12% dari bulan lalu</span>
                </div>
                <!-- Card 2 -->
                <div class="bg-[#1e293b] p-5 rounded-xl shadow-sm border border-slate-800">
                    <span class="text-xs text-gray-400 block mb-1">Tiket Pending / Kendala</span>
                    <h3 class="text-3xl font-bold text-white">3</h3>
                    <span class="text-xs text-amber-400 font-medium">Perlu perhatian khusus</span>
                </div>
                <!-- Card 3 -->
                <div class="bg-[#1e293b] p-5 rounded-xl shadow-sm border border-slate-800">
                    <span class="text-xs text-gray-400 block mb-1">Penyelesaian Sesuai SLA</span>
                    <h3 class="text-3xl font-bold text-white">96.4%</h3>
                    <span class="text-xs text-emerald-400 font-medium">Target > 90% tercapai</span>
                </div>
                <!-- Card 4 -->
                <div class="bg-[#1e293b] p-5 rounded-xl shadow-sm border border-slate-800">
                    <span class="text-xs text-gray-400 block mb-1">Teknisi Aktif Bertugas</span>
                    <h3 class="text-3xl font-bold text-white">5/5</h3>
                    <span class="text-xs text-blue-400 font-medium">Semua standby</span>
                </div>
            </div>

            <!-- Konten Utama: Daftar Eskalasi & Kinerja Teknisi -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Kolom Kiri: Daftar Eskalasi / Tiket Bermasalah -->
                <div class="lg:col-span-2 bg-[#1e293b] rounded-xl shadow-sm border border-slate-800 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-white">Monitoring Eskalasi & Tiket Kritis</h3>
                        <span class="text-xs text-gray-400">Ditinjau oleh Supervisor</span>
                    </div>

                    <!-- Filter Tab kecil -->
                    <div class="flex space-x-2 mb-4">
                        <button class="px-3 py-1 text-xs bg-emerald-600 text-white rounded-lg shadow-sm">Semua (3)</button>
                        <button class="px-3 py-1 text-xs bg-[#0f172a] text-gray-300 rounded-lg hover:bg-slate-800 border border-slate-700">Mendekati SLA</button>
                        <button class="px-3 py-1 text-xs bg-[#0f172a] text-gray-300 rounded-lg hover:bg-slate-800 border border-slate-700">Pending</button>
                    </div>

                    <!-- Item Tiket 1 -->
                    <div class="border border-slate-700 rounded-xl p-4 mb-3 hover:border-emerald-600 transition cursor-pointer bg-[#0f172a]">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="text-xs font-bold text-emerald-400 mr-2">#TK-0231</span>
                                <span class="px-2 py-0.5 text-xs bg-red-950/60 text-red-400 border border-red-800/50 rounded-md font-medium">Tinggi</span>
                            </div>
                            <span class="text-xs text-amber-400 font-semibold">3j 05m lagi (SLA)</span>
                        </div>
                        <h4 class="font-bold text-white text-sm mb-1">Aplikasi SIMRS error saat input pasien</h4>
                        <p class="text-xs text-gray-400">Poli Rawat Jalan • Ditugaskan ke: Teknisi A • Status: In Progress</p>
                    </div>

                    <!-- Item Tiket 2 -->
                    <div class="border border-slate-700 rounded-xl p-4 mb-3 hover:border-emerald-600 transition cursor-pointer bg-[#0f172a]">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="text-xs font-bold text-emerald-400 mr-2">#TK-0225</span>
                                <span class="px-2 py-0.5 text-xs bg-amber-950/60 text-amber-400 border border-amber-800/50 rounded-md font-medium">Sedang</span>
                            </div>
                            <span class="text-xs text-emerald-400 font-semibold">Aman</span>
                        </div>
                        <h4 class="font-bold text-white text-sm mb-1">Printer Lab Patologi tidak bisa cetak label</h4>
                        <p class="text-xs text-gray-400">Laboratorium • Ditugaskan ke: Teknisi B • Status: Assigned</p>
                    </div>

                </div>

                <!-- Kolom Kanan: Ringkasan Performa Tim IT -->
                <div class="bg-[#1e293b] rounded-xl shadow-sm border border-slate-800 p-5">
                    <h3 class="font-bold text-white mb-1">Performa Teknisi Bulan Ini</h3>
                    <p class="text-xs text-gray-400 mb-4">Beban kerja & penyelesaian tugas</p>

                    <div class="space-y-4 text-xs">
                        <div class="bg-[#0f172a] p-3 rounded-xl border border-slate-800">
                            <div class="flex justify-between mb-1">
                                <span class="font-medium text-white">Teknisi A (Software)</span>
                                <span class="text-emerald-400">12 Selesai</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-1.5 mb-1">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 85%"></div>
                            </div>
                            <span class="text-[10px] text-gray-400">Beban kerja aktif: 2 tiket</span>
                        </div>

                        <div class="bg-[#0f172a] p-3 rounded-xl border border-slate-800">
                            <div class="flex justify-between mb-1">
                                <span class="font-medium text-white">Teknisi B (Hardware & Jaringan)</span>
                                <span class="text-emerald-400">15 Selesai</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-1.5 mb-1">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 90%"></div>
                            </div>
                            <span class="text-[10px] text-gray-400">Beban kerja aktif: 1 tiket</span>
                        </div>

                        <div class="bg-[#0f172a] p-3 rounded-xl border border-slate-800">
                            <div class="flex justify-between mb-1">
                                <span class="font-medium text-white">Teknisi C (Infrastruktur)</span>
                                <span class="text-emerald-400">10 Selesai</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-1.5 mb-1">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 70%"></div>
                            </div>
                            <span class="text-[10px] text-gray-400">Beban kerja aktif: 0 tiket</span>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-800">
                        <button class="w-full py-2 text-xs bg-slate-800 hover:bg-slate-700 text-gray-200 rounded-xl font-medium transition border border-slate-700">
                            Unduh Laporan Bulanan (PDF)
                        </button>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>