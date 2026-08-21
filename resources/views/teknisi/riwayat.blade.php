<x-app-layout>
    <x-slot name="pageTitle">
        Arsip Riwayat Penanganan Tiket
    </x-slot>
    <x-slot name="breadcrumb">
        Teknisi &rsaquo; Riwayat Penanganan Selesai
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Riwayat Penanganan Tiket</h1>
                <p class="text-xs text-slate-500 mt-1">Seluruh arsip tiket yang telah Anda tangani dan selesaikan.</p>
            </div>
            <a href="{{ route('teknisi.dashboard') }}" class="text-xs font-bold text-slate-700 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-xl transition shadow-xs">
                &larr; Kembali ke Tiket Saya
            </a>
        </div>

        <!-- Tabel Riwayat Penanganan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="font-extrabold text-slate-900 text-sm">Daftar Tiket Selesai (Resolved)</h3>
                    <p class="text-xs text-slate-500">Histori penanganan teknis pada unit-unit RSUD</p>
                </div>
                <div>
                    <input type="text" placeholder="Cari ID tiket / unit..." class="text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500 px-3.5 py-2">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-400 uppercase font-bold text-[11px] border-b border-slate-100">
                        <tr>
                            <th class="p-3.5">ID Tiket</th>
                            <th class="p-3.5">Judul Masalah &amp; Unit</th>
                            <th class="p-3.5">Kategori</th>
                            <th class="p-3.5">Waktu Selesai</th>
                            <th class="p-3.5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5 font-mono font-black text-teal-700">#TK-0219</td>
                            <td class="p-3.5">
                                <span class="block font-bold text-slate-900">Printer label obat sering macet</span>
                                <span class="text-xs text-slate-500 font-medium">Instalasi Farmasi</span>
                            </td>
                            <td class="p-3.5 text-slate-700 font-medium">Hardware</td>
                            <td class="p-3.5 text-slate-400">Kemarin, 14:30 WIB</td>
                            <td class="p-3.5 text-right">
                                <span class="px-3 py-1 text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full font-bold">Resolved</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5 font-mono font-black text-teal-700">#TK-0205</td>
                            <td class="p-3.5">
                                <span class="block font-bold text-slate-900">Pergantian kabel LAN ruang pendaftaran</span>
                                <span class="text-xs text-slate-500 font-medium">Pendaftaran &amp; Rekam Medis</span>
                            </td>
                            <td class="p-3.5 text-slate-700 font-medium">Jaringan</td>
                            <td class="p-3.5 text-slate-400">18 Ags 2026, 11:15 WIB</td>
                            <td class="p-3.5 text-right">
                                <span class="px-3 py-1 text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full font-bold">Resolved</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>