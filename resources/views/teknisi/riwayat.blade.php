<x-app-layout>
    <div class="space-y-6">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Riwayat Penanganan Tiket Selesai</h1>
                <p class="text-xs text-slate-500 mt-1">Seluruh arsip tiket yang telah Anda tangani dan selesaikan.</p>
            </div>
            <a href="{{ route('teknisi.dashboard') }}" class="text-xs font-bold text-slate-700 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-xl transition shadow-xs">
                &larr; Kembali ke Tiket Saya
            </a>
        </div>

        <!-- Tabel Riwayat Penanganan -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 sm:p-7">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Daftar Tiket Selesai (Resolved / Closed)</h3>
                    <p class="text-xs text-slate-500">Histori penanganan teknis pada unit-unit RSUD</p>
                </div>
                <form action="{{ route('teknisi.riwayat') }}" method="GET">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID tiket / unit / judul..."
                        class="text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 px-3.5 py-2 font-medium">
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-400 uppercase font-bold text-[11px] border-b border-slate-100">
                        <tr>
                            <th class="px-4 py-3.5 rounded-l-xl">ID TIKET</th>
                            <th class="px-4 py-3.5">JUDUL MASALAH &amp; UNIT</th>
                            <th class="px-4 py-3.5">KATEGORI</th>
                            <th class="px-4 py-3.5">WAKTU SELESAI</th>
                            <th class="px-4 py-3.5">PENILAIAN GUEST</th>
                            <th class="px-4 py-3.5 rounded-r-xl text-right">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($tickets as $t)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-4 py-3.5 font-mono font-bold text-teal-800">{{ $t->ticket_number }}</td>
                                <td class="px-4 py-3.5">
                                    <span class="block font-bold text-slate-900">{{ $t->title }}</span>
                                    <span class="text-xs text-slate-500 font-medium">{{ $t->unit->name ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3.5 text-slate-700 font-medium">{{ $t->category->name ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-slate-500 font-mono">{{ $t->resolved_at ? $t->resolved_at->format('d M Y, H:i') : $t->updated_at->format('d M Y, H:i') }} WIB</td>
                                <td class="px-4 py-3.5">
                                    @if ($t->rating)
                                        <span class="font-bold text-amber-600">{{ $t->rating }} ★</span>
                                    @else
                                        <span class="text-slate-400 text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-right">
                                    <span class="inline-block px-3 py-1 rounded-xl text-xs font-bold bg-emerald-100 text-emerald-700">
                                        {{ $t->status_label }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400 text-xs">
                                    Belum ada riwayat tiket yang diselesaikan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($tickets->hasPages())
                <div class="mt-4 pt-4 border-t border-slate-100">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>