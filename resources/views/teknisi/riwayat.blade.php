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
                        <!-- Menu ke Dashboard / Tiket Saya -->
                        <a href="{{ route('teknisi.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-medium text-gray-400 hover:bg-slate-800 hover:text-gray-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"></path></svg>
                            <span>Tiket Saya</span>
                        </a>

                        <!-- Menu Aktif: Riwayat Penanganan -->
                        <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-xs font-medium bg-emerald-600 text-white shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Riwayat Penanganan</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Ringkasan Sidebar Bawah -->
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
                        <h2 class="text-2xl font-bold text-white">Arsip Riwayat Penanganan Tiket</h2>
                        <p class="text-xs text-gray-400">Teknisi > Riwayat Penanganan</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-950 text-emerald-400 border border-emerald-800">
                            <span class="w-2 h-2 mr-1.5 bg-emerald-400 rounded-full animate-pulse"></span> Sistem Normal
                        </span>
                        <div class="flex items-center space-x-2 bg-[#1e293b] px-3 py-1.5 rounded-xl border border-slate-800">
                            <div class="w-7 h-7 bg-amber-600 rounded-lg flex items-center justify-center text-white text-xs font-bold">BS</div>
                            <div class="text-left">
                                <span class="block text-xs font-bold text-white leading-tight">{{ auth()->user()->name }}</span>
                                <span class="block text-[10px] text-gray-400 leading-tight">Teknisi - Divisi IT</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Riwayat Penanganan -->
                <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-bold text-white text-sm">Daftar Tiket Selesai</h3>
                            <p class="text-[11px] text-gray-400">Seluruh riwayat penanganan tiket yang telah ditandai resolved oleh Anda.</p>
                        </div>
                        <div>
                            <input type="text" placeholder="Cari tiket..." class="text-xs bg-[#0f172a] text-gray-200 border-slate-700 rounded-xl px-3 py-1.5 focus:border-emerald-500">
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-300">
                            <thead class="bg-[#0f172a] text-gray-400 uppercase text-[10px]">
                                <tr>
                                    <th class="p-3 rounded-l-lg">ID Tiket</th>
                                    <th class="p-3">Judul Masalah & Unit</th>
                                    <th class="p-3">Kategori</th>
                                    <th class="p-3">Waktu Selesai</th>
                                    <th class="p-3 rounded-r-lg text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                <tr class="hover:bg-slate-800/50 transition">
                                    <td class="p-3 font-bold text-emerald-400">#TK-0219</td>
                                    <td class="p-3">
                                        <span class="block font-bold text-white">Printer label obat sering macet</span>
                                        <span class="text-[10px] text-gray-400">Instalasi Farmasi</span>
                                    </td>
                                    <td class="p-3">Hardware</td>
                                    <td class="p-3 text-gray-400">Kemarin, 14:30 WIB</td>
                                    <td class="p-3 text-right">
                                        <span class="px-2 py-0.5 text-[10px] bg-emerald-950 text-emerald-400 border border-emerald-800 rounded-full font-medium">Resolved</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-800/50 transition">
                                    <td class="p-3 font-bold text-emerald-400">#TK-0205</td>
                                    <td class="p-3">
                                        <span class="block font-bold text-white">Pergantian kabel LAN ruang pendaftaran</span>
                                        <span class="text-[10px] text-gray-400">Pendaftaran</span>
                                    </td>
                                    <td class="p-3">Jaringan</td>
                                    <td class="p-3 text-gray-400">18 Ags 2026, 11:15 WIB</td>
                                    <td class="p-3 text-right">
                                        <span class="px-2 py-0.5 text-[10px] bg-emerald-950 text-emerald-400 border border-emerald-800 rounded-full font-medium">Resolved</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

    </div>
</x-app-layout>