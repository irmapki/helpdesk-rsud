<x-guest-portal-layout>
    <div class="py-4 sm:py-16">
        <div class="max-w-xl mx-auto px-2.5 sm:px-6 lg:px-8 w-full min-w-0">
            <!-- Success Card -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden text-center p-3.5 sm:p-10 min-w-0">
                <!-- Check Icon -->
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl sm:rounded-3xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto mb-4 sm:mb-6 shadow-md shadow-emerald-600/10 shrink-0">
                    <svg class="w-7 h-7 sm:w-9 sm:h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h1 class="text-base sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-snug break-words">Pengaduan Berhasil Dikirim![cite: 13]</h1>
                <p class="text-[11px] sm:text-sm text-slate-500 mt-1.5 sm:mt-2 font-medium max-w-md mx-auto px-1">Laporan kendala Anda telah tercatat pada sistem IT Helpdesk RSUD.[cite: 13]</p>

                <!-- Ticket Number Card -->
                <div class="mt-5 sm:mt-8 p-3.5 sm:p-6 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 min-w-0">
                    <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Nomor Tiket Anda[cite: 13]</span>
                    <div class="text-base sm:text-2xl lg:text-3xl font-black font-mono text-emerald-800 tracking-wider select-all break-all" id="ticketNumberText">
                        {{ $ticket->ticket_number }}[cite: 13]
                    </div>

                    <button onclick="copyTicketNumber()" class="mt-3 inline-flex items-center justify-center gap-1.5 text-xs font-bold text-emerald-800 bg-white hover:bg-emerald-50 border border-slate-200 px-4 py-2.5 rounded-xl transition shadow-xs active:scale-95 w-full sm:w-auto">
                        <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span id="copyBtnLabel">Salin Nomor Tiket[cite: 13]</span>
                    </button>
                </div>

                <!-- Ticket Summary Info -->
                <div class="mt-5 sm:mt-6 text-left bg-slate-50/70 p-3.5 sm:p-5 rounded-2xl border border-slate-100 text-xs space-y-3 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:justify-between gap-0.5 sm:gap-2 min-w-0">
                        <span class="text-slate-400 font-medium shrink-0">Judul Masalah:[cite: 13]</span>
                        <span class="font-extrabold text-slate-900 sm:text-right break-words min-w-0">{{ $ticket->title }}[cite: 13]</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between gap-0.5 sm:gap-2 min-w-0">
                        <span class="text-slate-400 font-medium shrink-0">Unit / Ruangan:[cite: 13]</span>
                        <span class="font-bold text-slate-800 sm:text-right break-words min-w-0">{{ $ticket->unit->name }}[cite: 13]</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between gap-0.5 sm:gap-2 min-w-0">
                        <span class="text-slate-400 font-medium shrink-0">Kategori:[cite: 13]</span>
                        <span class="font-bold text-slate-800 sm:text-right break-words min-w-0">{{ $ticket->category->name }}[cite: 13]</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center gap-1 sm:gap-2 pt-1 border-t border-slate-200/60 min-w-0">
                        <span class="text-slate-400 font-medium shrink-0">Status Awal:[cite: 13]</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] sm:text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 shrink-0">
                            Menunggu Validasi Admin[cite: 13]
                        </span>
                    </div>
                </div>

                <!-- Navigation Actions -->
                <div class="mt-6 sm:mt-8 flex flex-col items-center justify-center gap-2.5 sm:gap-3 min-w-0">
                    <a href="{{ route('guest.ticket.track', ['ticket_number' => $ticket->ticket_number]) }}"
                        class="w-full inline-flex items-center justify-center gap-2 bg-emerald-800 hover:bg-emerald-900 text-white font-extrabold text-xs sm:text-sm px-6 py-3.5 rounded-xl shadow-md shadow-emerald-950/20 transition active:scale-95 text-center">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Lacak Progres Tiket Ini[cite: 13]</span>
                    </a>

                    <a href="{{ route('guest.landing') }}" class="w-full text-xs sm:text-sm font-bold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200/80 px-5 py-3.5 rounded-xl transition text-center">
                        Kembali ke Beranda[cite: 13]
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyTicketNumber() {
            const text = document.getElementById('ticketNumberText').innerText.trim();
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.getElementById('copyBtnLabel');
                btn.innerText = 'Tersalin!';
                setTimeout(() => btn.innerText = 'Salin Nomor Tiket', 2000);
            }).catch(err => {
                console.error('Gagal menyalin teks: ', err);
            });
        }
    </script>
</x-guest-portal-layout>