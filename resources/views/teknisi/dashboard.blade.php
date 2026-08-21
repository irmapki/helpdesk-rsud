<x-app-layout>
    <x-slot name="pageTitle">
        Tiket yang Ditugaskan kepada Saya
    </x-slot>
    <x-slot name="breadcrumb">
        Teknisi &rsaquo; Tiket yang Ditugaskan kepada Saya
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <!-- Statistik Cards Teknisi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <span class="text-xs font-semibold text-slate-500 block mb-1">Baru Ditugaskan</span>
                <div class="text-3xl font-black text-slate-900">2</div>
                <span class="text-[11px] font-bold text-rose-500 mt-1 inline-block">Belum dikerjakan</span>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <span class="text-xs font-semibold text-slate-500 block mb-1">Sedang Dikerjakan</span>
                <div class="text-3xl font-black text-indigo-600">3</div>
                <span class="text-[11px] font-bold text-indigo-600 mt-1 inline-block">In progress</span>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <span class="text-xs font-semibold text-slate-500 block mb-1">Selesai Bulan Ini</span>
                <div class="text-3xl font-black text-emerald-600">27</div>
                <span class="text-[11px] font-bold text-emerald-600 mt-1 inline-block">+5 dari bulan lalu</span>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <span class="text-xs font-semibold text-slate-500 block mb-1">Mendekati SLA</span>
                <div class="text-3xl font-black text-amber-500">1</div>
                <span class="text-[11px] font-bold text-amber-600 mt-1 inline-block">Segera tangani</span>
            </div>
        </div>

        <!-- Konten Grid: Daftar Tiket & Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Kolom Kiri: Daftar Tiket (7 cols) -->
            <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900">Daftar Tiket Ditugaskan</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Diurutkan berdasarkan prioritas &amp; batas waktu SLA</p>
                    </div>

                    <!-- Filter Tab -->
                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
                        <button class="px-3 py-1 text-xs font-bold bg-[#0a252a] text-white rounded-lg shadow-xs">Semua (5)</button>
                        <button class="px-3 py-1 text-xs font-bold text-slate-600 hover:text-slate-900 rounded-lg">Assigned</button>
                        <button class="px-3 py-1 text-xs font-bold text-slate-600 hover:text-slate-900 rounded-lg">In Progress</button>
                        <button class="px-3 py-1 text-xs font-bold text-slate-600 hover:text-slate-900 rounded-lg">Resolved</button>
                    </div>
                </div>

                <!-- List Tiket -->
                <div class="space-y-3">
                    <!-- Ticket Item 1 -->
                    <div class="border-2 border-emerald-500/80 rounded-2xl p-4 bg-emerald-50/30 cursor-pointer shadow-xs">
                        <div class="flex justify-between items-start mb-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-mono font-black text-emerald-800">#TK-0231</span>
                                <span class="px-2 py-0.5 text-[10px] bg-rose-100 text-rose-700 border border-rose-200 rounded-lg font-bold">Tinggi</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-amber-600 font-black block">3j 05m lagi</span>
                                <span class="text-[10px] text-emerald-700 font-bold flex items-center justify-end">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1"></span> Assigned
                                </span>
                            </div>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-sm mb-1">Aplikasi SIMRS error saat input pasien</h3>
                        <p class="text-xs text-slate-500 font-medium">Poli Rawat Jalan &bull; Software &bull; Ditugaskan 12 menit lalu</p>
                    </div>

                    <!-- Ticket Item 2 -->
                    <div class="border border-slate-200 rounded-2xl p-4 bg-white hover:border-teal-500 cursor-pointer transition shadow-xs">
                        <div class="flex justify-between items-start mb-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-mono font-black text-teal-700">#TK-0229</span>
                                <span class="px-2 py-0.5 text-[10px] bg-rose-100 text-rose-700 border border-rose-200 rounded-lg font-bold">Tinggi</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-amber-600 font-black block">1j 20m lagi</span>
                                <span class="text-[10px] text-blue-600 font-bold flex items-center justify-end">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1"></span> In Progress
                                </span>
                            </div>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-sm mb-1">Koneksi internet lambat di ruang IGD</h3>
                        <p class="text-xs text-slate-500 font-medium">IGD &bull; Jaringan &bull; Ditugaskan 1 jam lalu</p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Detail Tiket & Aksi Teknisi (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Detail Tiket & Ubah Status -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm">Detail Tiket Terpilih</h3>
                            <span class="text-[11px] font-mono text-teal-700 font-bold">#TK-0231 dipilih</span>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-black text-slate-900 text-sm mb-1.5">Aplikasi SIMRS error saat input pasien</h4>
                        <p class="text-xs text-slate-700 bg-slate-50 p-3.5 rounded-xl border border-slate-100 leading-relaxed">
                            Saat menyimpan data pasien baru, muncul notifikasi "gagal terhubung ke server" secara berulang. Sudah dicoba refresh halaman namun masalah tetap muncul.
                        </p>
                    </div>

                    <div class="space-y-2 text-xs bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                        <div class="flex justify-between"><span class="text-slate-400">Pelapor:</span> <span class="font-bold text-slate-800">Siti Marfu'ah</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Unit:</span> <span class="font-bold text-slate-800">Poli Rawat Jalan</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Kategori:</span> <span class="font-bold text-slate-800">Software</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Prioritas:</span> <span class="text-rose-600 font-bold">Tinggi &bull; SLA 8 jam</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Batas Waktu:</span> <span class="font-black text-amber-600">Hari ini, 18:42</span></div>
                    </div>

                    <!-- Form Aksi / Ubah Status & Catatan -->
                    <div class="space-y-3 pt-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ubah Status Tiket</label>
                            <select class="w-full text-xs rounded-xl border-slate-200 focus:border-teal-500 focus:ring-teal-500">
                                <option>In Progress (Sedang Dikerjakan)</option>
                                <option>Assigned (Sudah Ditugaskan)</option>
                                <option>Resolved (Selesai Penanganan)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Progres Penanganan</label>
                            <textarea class="w-full text-xs rounded-xl border-slate-200 focus:border-teal-500 focus:ring-teal-500" rows="2" placeholder="Tulis catatan progres perbaikan di lapangan..."></textarea>
                        </div>

                        <div class="flex gap-2 pt-1">
                            <button class="w-1/2 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-700 font-bold hover:bg-slate-50 transition">
                                Simpan Catatan
                            </button>
                            <button class="w-1/2 py-2.5 text-xs bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition shadow-xs">
                                Tandai Resolved
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Penanganan untuk Tiket Terpilih -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-sm">Riwayat Penanganan</h3>
                        <p class="text-[11px] text-slate-400 font-mono">#TK-0231</p>
                    </div>

                    <div class="relative pl-4 space-y-4 before:content-[''] before:absolute before:left-1.5 before:top-1.5 before:bottom-1.5 before:w-0.5 before:bg-slate-200 text-xs">
                        <div class="relative">
                            <span class="absolute -left-[21px] top-1 w-2.5 h-2.5 bg-amber-500 rounded-full border-2 border-white"></span>
                            <span class="text-[10px] text-slate-400 block font-medium">10:42 &bull; Hari ini</span>
                            <p class="text-slate-800 font-bold">Ditugaskan oleh Admin (Rina Anggraini)</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[21px] top-1 w-2.5 h-2.5 bg-blue-500 rounded-full border-2 border-white"></span>
                            <span class="text-[10px] text-slate-400 block font-medium">11:05 &bull; Hari ini</span>
                            <p class="text-slate-800 font-bold mb-1">Status diubah menjadi In Progress</p>
                            <p class="text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-100">Sudah cek koneksi database server SIMRS, ditemukan timeout pada modul pasien baru.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>