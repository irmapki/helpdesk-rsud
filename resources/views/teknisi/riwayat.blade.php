<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Halaman -->
        <div class="flex justify-between items-center mb-2">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Arsip Riwayat Penanganan Tiket</h2>
                <p class="text-xs text-gray-500">Teknisi &gt; Riwayat Penanganan</p>
            </div>
        </div>

        <!-- Tabel Riwayat Penanganan -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Daftar Tiket Selesai</h3>
                    <p class="text-[11px] text-gray-500">Seluruh riwayat penanganan tiket yang telah ditandai resolved oleh Anda.</p>
                </div>
                <div>
                    <input type="text" placeholder="Cari tiket..." class="text-xs bg-gray-50 text-gray-800 border-gray-200 rounded-xl px-3.5 py-2 focus:border-emerald-600 focus:ring-emerald-600 shadow-sm">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-600">
                    <thead class="bg-gray-50 text-gray-400 uppercase text-[10px] border-b border-gray-200">
                        <tr>
                            <th class="p-3.5 rounded-l-xl font-bold">ID Tiket</th>
                            <th class="p-3.5 font-bold">Judul Masalah &amp; Unit</th>
                            <th class="p-3.5 font-bold">Kategori</th>
                            <th class="p-3.5 font-bold">Waktu Selesai</th>
                            <th class="p-3.5 rounded-r-xl text-right font-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="p-3.5 font-extrabold text-emerald-700">#TK-0219</td>
                            <td class="p-3.5">
                                <span class="block font-bold text-gray-900">Printer label obat sering macet</span>
                                <span class="text-[10px] text-gray-500">Instalasi Farmasi</span>
                            </td>
                            <td class="p-3.5">Hardware</td>
                            <td class="p-3.5 text-gray-500">Kemarin, 14:30 WIB</td>
                            <td class="p-3.5 text-right">
                                <span class="px-2.5 py-1 text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full font-bold">Resolved</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>