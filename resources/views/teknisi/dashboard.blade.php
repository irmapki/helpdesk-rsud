<x-app-layout>
    <div class="flex min-h-screen bg-[#0f172a] text-gray-100">
        
        <!-- Sidebar Kiri -->
        <aside class="w-64 bg-[#0f172a] border-r border-slate-800 flex flex-col justify-between hidden md:flex">
            <div>
                <!-- Logo / Header Sidebar -->
                <div class="p-5 border-b border-slate-800">
                    <h1 class="text-sm font-bold text-white tracking-wider">RSUD RAA SOEWONDO PATI</h1>
                    <p class="text-[10px] text-gray-400">IT HELPDESK & TICKETING</p>
                </div>

                <!-- Menu Utama Teknisi -->
                <div class="p-4">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 px-3">Menu Utama</p>
                    <nav class="space-y-1">
                        <a href="{{ route('teknisi.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-medium bg-emerald-600 text-white shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"></path></svg>
                            <span>Tiket Saya</span>
                            <span class="ml-auto bg-emerald-800 text-[10px] px-1.5 py-0.5 rounded-full text-white">5</span>
                        </a>
                        <a href="{{ route('teknisi.riwayat') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-medium text-gray-400 hover:bg-slate-800 hover:text-gray-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Riwayat Penanganan</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Ringkasan Minggu Ini di Sidebar Bawah -->
            <div class="p-4 m-4 bg-[#1e293b] rounded-xl border border-slate-800">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Ringkasan Minggu Ini</p>
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between text-gray-300"><span>Tiket selesai</span><span class="font-bold text-white">11</span></div>
                    <div class="flex justify-between text-gray-300"><span>Rata-rata respons</span><span class="font-bold text-white">34 mnt</span></div>
                    <div class="flex justify-between text-gray-300"><span>SLA tercapai</span><span class="font-bold text-emerald-400">96%</span></div>
                </div>
            </div>
        </aside>

        <!-- Konten Utama Kanan -->
        <main class="flex-1 p-6 lg:p-8 overflow-y-auto">
            <div class="max-w-7xl mx-auto">
                
                <!-- Header & Status -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Tiket yang Ditugaskan kepada Saya</h2>
                        <p class="text-xs text-gray-400">Teknisi > Tiket yang Ditugaskan kepada Saya</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-950 text-emerald-400 border border-emerald-800">
                            <span class="w-2 h-2 mr-1.5 bg-emerald-400 rounded-full animate-pulse"></span> Sistem Normal
                        </span>
                        <!-- Profil di Pojok Kanan Atas -->
                        <div class="flex items-center space-x-2 bg-[#1e293b] px-3 py-1.5 rounded-xl border border-slate-800">
                            <div class="w-7 h-7 bg-amber-600 rounded-lg flex items-center justify-center text-white text-xs font-bold">BS</div>
                            <div class="text-left">
                                <span class="block text-xs font-bold text-white leading-tight">{{ auth()->user()->name }}</span>
                                <span class="block text-[10px] text-gray-400 leading-tight">Teknisi - Divisi IT</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-[#1e293b] p-4 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-gray-400 block mb-1">Baru Ditugaskan</span>
                        <h3 class="text-2xl font-bold text-white">2</h3>
                        <span class="text-[10px] text-red-400 font-medium">Belum dikerjakan</span>
                    </div>
                    <div class="bg-[#1e293b] p-4 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-gray-400 block mb-1">Sedang Dikerjakan</span>
                        <h3 class="text-2xl font-bold text-white">3</h3>
                        <span class="text-[10px] text-emerald-400 font-medium">In progress</span>
                    </div>
                    <div class="bg-[#1e293b] p-4 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-gray-400 block mb-1">Selesai Bulan Ini</span>
                        <h3 class="text-2xl font-bold text-white">27</h3>
                        <span class="text-[10px] text-emerald-400 font-medium">+5 dari bulan lalu</span>
                    </div>
                    <div class="bg-[#1e293b] p-4 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-gray-400 block mb-1">Mendekati SLA</span>
                        <h3 class="text-2xl font-bold text-white">1</h3>
                        <span class="text-[10px] text-amber-400 font-medium">Segera tangani</span>
                    </div>
                </div>

                <!-- Konten Grid: Daftar Tiket & Detail -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Kolom Kiri: Daftar Tiket -->
                    <div class="lg:col-span-2 bg-[#1e293b] rounded-xl border border-slate-800 p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-white text-sm">Daftar Tiket Ditugaskan</h3>
                            <span class="text-[10px] text-gray-400">Diurutkan berdasarkan prioritas & batas waktu SLA</span>
                        </div>

                        <!-- Filter Tab -->
                        <div class="flex space-x-2 mb-4">
                            <button class="px-3 py-1 text-xs bg-emerald-600 text-white rounded-lg shadow-sm">Semua (5)</button>
                            <button class="px-3 py-1 text-xs bg-[#0f172a] text-gray-300 rounded-lg hover:bg-slate-800 border border-slate-700">Assigned</button>
                            <button class="px-3 py-1 text-xs bg-[#0f172a] text-gray-300 rounded-lg hover:bg-slate-800 border border-slate-700">In Progress</button>
                            <button class="px-3 py-1 text-xs bg-[#0f172a] text-gray-300 rounded-lg hover:bg-slate-800 border border-slate-700">Resolved</button>
                        </div>

                        <!-- List Tiket -->
                        <div class="space-y-3">
                            <div class="border border-emerald-500/60 rounded-xl p-4 bg-emerald-950/20 cursor-pointer">
                                <div class="flex justify-between items-start mb-1">
                                    <div>
                                        <span class="text-xs font-bold text-emerald-400 mr-2">#TK-0231</span>
                                        <span class="px-2 py-0.5 text-[10px] bg-red-950 text-red-400 border border-red-800 rounded font-medium">Tinggi</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-amber-400 font-semibold block">3j 05m lagi</span>
                                        <span class="text-[10px] text-emerald-400 flex items-center justify-end"><span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1"></span> Assigned</span>
                                    </div>
                                </div>
                                <h4 class="font-bold text-white text-sm mb-1">Aplikasi SIMRS error saat input pasien</h4>
                                <p class="text-[11px] text-gray-400">Poli Rawat Jalan • Software • Ditugaskan 12 menit lalu</p>
                            </div>

                            <div class="border border-slate-700 rounded-xl p-4 bg-[#0f172a] hover:border-slate-500 cursor-pointer transition">
                                <div class="flex justify-between items-start mb-1">
                                    <div>
                                        <span class="text-xs font-bold text-emerald-400 mr-2">#TK-0229</span>
                                        <span class="px-2 py-0.5 text-[10px] bg-red-950 text-red-400 border border-red-800 rounded font-medium">Tinggi</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-amber-400 font-semibold block">1j 20m lagi</span>
                                        <span class="text-[10px] text-blue-400 flex items-center justify-end"><span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1"></span> In Progress</span>
                                    </div>
                                </div>
                                <h4 class="font-bold text-white text-sm mb-1">Koneksi internet lambat di ruang IGD</h4>
                                <p class="text-[11px] text-gray-400">IGD • Jaringan • Ditugaskan 1 jam lalu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Detail Tiket & Aksi Teknisi -->
                    <div class="space-y-6">
                        <!-- Detail Tiket & Ubah Status -->
                        <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-5">
                            <h3 class="font-bold text-white text-sm mb-0.5">Detail Tiket</h3>
                            <p class="text-[10px] text-gray-400 mb-3">#TK-0231 dipilih</p>

                            <h4 class="font-bold text-white text-xs mb-2">Aplikasi SIMRS error saat input pasien</h4>
                            <p class="text-[11px] text-gray-300 mb-3 bg-[#0f172a] p-2.5 rounded-xl border border-slate-800">
                                Saat menyimpan data pasien baru, muncul notifikasi "gagal terhubung ke server" secara berulang. Sudah dicoba refresh halaman namun masalah tetap muncul.
                            </p>

                            <div class="space-y-1.5 text-xs mb-4 border-b border-slate-800 pb-3">
                                <div class="flex justify-between"><span class="text-gray-400">Pelapor:</span> <span class="font-medium text-white">Siti Marfu'ah</span></div>
                                <div class="flex justify-between"><span class="text-gray-400">Unit:</span> <span class="font-medium text-white">Poli Rawat Jalan</span></div>
                                <div class="flex justify-between"><span class="text-gray-400">Kategori:</span> <span class="font-medium text-white">Software</span></div>
                                <div class="flex justify-between"><span class="text-gray-400">Prioritas:</span> <span class="text-red-400 font-medium">Tinggi • SLA 8 jam</span></div>
                                <div class="flex justify-between"><span class="text-gray-400">Batas Waktu:</span> <span class="font-medium text-amber-400">Hari ini, 18:42</span></div>
                            </div>

                            <!-- Form Aksi / Ubah Status & Catatan -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-300 mb-1 uppercase">Ubah Status</label>
                                <select class="w-full text-xs bg-[#0f172a] text-gray-200 border-slate-700 rounded-xl shadow-sm mb-2.5 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option>In Progress</option>
                                    <option>Assigned</option>
                                    <option>Resolved</option>
                                </select>

                                <label class="block text-[10px] font-bold text-gray-300 mb-1 uppercase">Catatan Penanganan</label>
                                <textarea class="w-full text-xs bg-[#0f172a] text-gray-200 border-slate-700 rounded-xl shadow-sm mb-2.5 focus:border-emerald-500 focus:ring-emerald-500" rows="2" placeholder="Tulis catatan progres perbaikan..."></textarea>
                                
                                <div class="flex space-x-2">
                                    <button class="w-1/2 py-2 text-xs border border-slate-700 rounded-xl text-gray-300 font-medium hover:bg-slate-800 transition">Simpan Catatan</button>
                                    <button class="w-1/2 py-2 text-xs bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition shadow-sm">Tandai Resolved</button>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Penanganan untuk Tiket Terpilih -->
                        <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-5">
                            <h3 class="font-bold text-white text-sm mb-1">Riwayat Penanganan</h3>
                            <p class="text-[10px] text-gray-400 mb-4">#TK-0231</p>

                            <div class="relative pl-4 space-y-4 before:content-[''] before:absolute before:left-1.5 before:top-1.5 before:bottom-1.5 before:w-0.5 before:bg-slate-700 text-xs">
                                <div class="relative">
                                    <span class="absolute -left-[21px] top-1 w-2.5 h-2.5 bg-amber-500 rounded-full border-2 border-[#1e293b]"></span>
                                    <span class="text-[10px] text-gray-400 block">10:42 • Hari ini</span>
                                    <p class="text-white font-medium">Ditugaskan oleh Admin (Rina Anggraini)</p>
                                </div>
                                <div class="relative">
                                    <span class="absolute -left-[21px] top-1 w-2.5 h-2.5 bg-blue-500 rounded-full border-2 border-[#1e293b]"></span>
                                    <span class="text-[10px] text-gray-400 block">11:05 • Hari ini</span>
                                    <p class="text-white font-medium mb-1">Status diubah menjadi In Progress</p>
                                    <p class="text-[11px] text-gray-300 bg-[#0f172a] p-2 rounded border border-slate-800">Sudah cek koneksi database server SIMRS, ditemukan timeout pada modul pasien baru.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>

    </div>
</x-app-layout>