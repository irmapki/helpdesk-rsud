<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Halaman -->
        <div class="flex justify-between items-center mb-2">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Tiket yang Ditugaskan kepada Saya</h2>
                <p class="text-xs text-gray-500">Teknisi &gt; Tiket yang Ditugaskan kepada Saya</p>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Baru Ditugaskan</span>
                <h3 class="text-2xl font-extrabold text-gray-900">2</h3>
                <span class="text-[11px] text-red-600 font-semibold">Belum dikerjakan</span>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Sedang Dikerjakan</span>
                <h3 class="text-2xl font-extrabold text-gray-900">3</h3>
                <span class="text-[11px] text-emerald-600 font-semibold">In progress</span>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Selesai Bulan Ini</span>
                <h3 class="text-2xl font-extrabold text-gray-900">27</h3>
                <span class="text-[11px] text-emerald-600 font-semibold">+5 dari bulan lalu</span>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Mendekati SLA</span>
                <h3 class="text-2xl font-extrabold text-gray-900">1</h3>
                <span class="text-[11px] text-amber-600 font-semibold">Segera tangani</span>
            </div>
        </div>

        <!-- Konten Grid: Daftar Tiket & Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kolom Kiri: Daftar Tiket -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-900 text-sm">Daftar Tiket Ditugaskan</h3>
                    <span class="text-[11px] text-gray-400">Diurutkan berdasarkan prioritas &amp; batas waktu SLA</span>
                </div>

                <!-- Filter Tab -->
                <div class="flex space-x-2 mb-4">
                    <button class="px-3.5 py-1.5 text-xs bg-emerald-600 text-white rounded-xl font-semibold shadow-sm shadow-emerald-600/20">Semua (5)</button>
                    <button class="px-3.5 py-1.5 text-xs bg-gray-50 text-gray-600 rounded-xl font-semibold hover:bg-gray-100 border border-gray-200">Assigned</button>
                    <button class="px-3.5 py-1.5 text-xs bg-gray-50 text-gray-600 rounded-xl font-semibold hover:bg-gray-100 border border-gray-200">In Progress</button>
                    <button class="px-3.5 py-1.5 text-xs bg-gray-50 text-gray-600 rounded-xl font-semibold hover:bg-gray-100 border border-gray-200">Resolved</button>
                </div>

                <!-- List Tiket -->
                <div class="space-y-3">
                    <div class="border border-emerald-500/50 rounded-xl p-4 bg-emerald-50/40 cursor-pointer shadow-sm">
                        <div class="flex justify-between items-start mb-1">
                            <div>
                                <span class="text-xs font-bold text-emerald-700 mr-2">#TK-0231</span>
                                <span class="px-2 py-0.5 text-[10px] bg-red-50 text-red-700 border border-red-200 rounded-md font-bold">Tinggi</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-amber-600 font-bold block">3j 05m lagi</span>
                                <span class="text-[10px] text-emerald-700 font-semibold flex items-center justify-end"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1"></span> Assigned</span>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Aplikasi SIMRS error saat input pasien</h4>
                        <p class="text-[11px] text-gray-500">Poli Rawat Jalan • Software • Ditugaskan 12 menit lalu</p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Detail Tiket -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="font-bold text-gray-900 text-sm mb-0.5">Detail Tiket</h3>
                    <p class="text-[11px] text-gray-400 mb-3">#TK-0231 dipilih</p>

                    <h4 class="font-bold text-gray-900 text-xs mb-2">Aplikasi SIMRS error saat input pasien</h4>
                    <p class="text-[11px] text-gray-600 mb-3 bg-gray-50 p-3 rounded-xl border border-gray-200 leading-relaxed">
                        Saat menyimpan data pasien baru, muncul notifikasi &quot;gagal terhubung ke server&quot; secara berulang.
                    </p>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>