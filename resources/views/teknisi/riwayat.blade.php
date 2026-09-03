<x-app-layout>
    <div class="space-y-6 max-w-full overflow-x-hidden pb-10">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight break-words">Riwayat Penanganan Tiket Selesai</h1>
                <p class="text-xs text-slate-500 mt-1 break-words">Seluruh arsip tiket yang telah Anda tangani dan selesaikan.</p>
            </div>
            <a href="{{ route('teknisi.dashboard') }}" class="text-xs font-bold text-slate-700 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-xl transition shadow-xs shrink-0 self-start sm:self-auto text-center">
                &larr; Kembali ke Tiket Saya
            </a>
        </div>

        <!-- Konten Riwayat Penanganan -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-7 min-w-0">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 min-w-0">
                <div class="min-w-0">
                    <h3 class="font-bold text-slate-900 text-sm sm:text-base break-words">Daftar Tiket Selesai (Resolved / Closed)</h3>
                    <p class="text-xs text-slate-500 break-words">Histori penanganan teknis pada unit-unit RSUD</p>
                </div>
                <form action="{{ route('teknisi.riwayat') }}" method="GET" class="w-full sm:w-auto shrink-0">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID tiket / unit / judul..."
                        class="w-full sm:w-64 text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 px-3.5 py-2.5 sm:py-2 font-medium">
                </form>
            </div>

            <!-- TAMPILAN MOBILE: Berbentuk Card List (Hanya tampil di layar HP/sm ke bawah) -->
            <div class="block sm:hidden space-y-3">
                @forelse ($tickets as $t)
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-mono font-bold text-teal-800">{{ $t->ticket_number }}</span>
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                {{ $t->status_label }}
                            </span>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-2">{{ $t->title }}</h4>
                            <p class="text-[11px] text-slate-500 font-medium mt-0.5">Unit: <span class="text-slate-700 font-bold">{{ $t->unit->name ?? '-' }}</span></p>
                        </div>
                        <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-200/60 text-[11px]">
                            <div>
                                <span class="text-slate-400 block">Kategori:</span>
                                <span class="font-semibold text-slate-700">{{ $t->category->name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Penilaian:</span>
                                @if ($t->rating)
                                    <span class="font-bold text-amber-600 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-amber-500 fill-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        {{ $t->rating }}/5
                                    </span>
                                @else
                                    <span class="text-slate-400 font-bold">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-[10px] font-mono text-slate-400 pt-1">
                            Selesai: {{ $t->resolved_at ? $t->resolved_at->format('d M Y, H:i') : $t->updated_at->format('d M Y, H:i') }} WIB
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-xs">
                        Belum ada riwayat tiket yang diselesaikan.
                    </div>
                @endforelse
            </div>

            <!-- TAMPILAN DESKTOP: Berbentuk Tabel Rapi (Hanya tampil di layar tablet/laptop sm ke atas) -->
            <div class="hidden sm:block w-full overflow-x-auto">
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
                                <td class="px-4 py-3.5 font-mono font-bold text-teal-800 shrink-0">{{ $t->ticket_number }}</td>
                                <td class="px-4 py-3.5 max-w-xs">
                                    <span class="block font-bold text-slate-900 truncate">{{ $t->title }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium truncate block">{{ $t->unit->name ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3.5 text-slate-700 font-medium">{{ $t->category->name ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-slate-500 font-mono whitespace-nowrap">{{ $t->resolved_at ? $t->resolved_at->format('d M Y, H:i') : $t->updated_at->format('d M Y, H:i') }} WIB</td>
                                <td class="px-4 py-3.5">
                                    @if ($t->rating)
                                        <span class="font-bold text-amber-600 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-amber-500 fill-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            {{ $t->rating }}/5
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-1 rounded-xl text-[11px] font-bold bg-emerald-100 text-emerald-700">
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
                <div class="mt-4 pt-4 border-t border-slate-100 overflow-x-auto">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>