<x-guest-portal-layout>
    <div class="py-12 sm:py-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden text-center p-8 sm:p-12">
                <!-- Check Icon -->
                <div class="w-16 h-16 rounded-3xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto mb-6 shadow-md shadow-emerald-600/10">
                    <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Pengaduan Berhasil Dikirim!</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-2 font-medium">Laporan kendala Anda telah tercatat pada sistem IT Helpdesk RSUD.</p>

                <!-- Ticket Number Card (Copyable) -->
                <div class="mt-8 p-6 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Nomor Tiket Anda</span>
                    <div class="text-2xl sm:text-3xl font-black font-mono text-emerald-800 tracking-wider select-all" id="ticketNumberText">
                        {{ $ticket->ticket_number }}
                    </div>

                    <button onclick="copyTicketNumber()" class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-white hover:bg-emerald-50 border border-slate-200 px-4 py-2 rounded-xl transition shadow-xs">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span id="copyBtnLabel">Salin Nomor Tiket</span>
                    </button>
                </div>

                <!-- Ticket Summary Info -->
                <div class="mt-6 text-left bg-slate-50/70 p-5 rounded-2xl border border-slate-100 text-xs space-y-2.5">
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-medium">Judul Masalah:</span>
                        <span class="font-bold text-slate-900 text-right">{{ $ticket->title }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-medium">Unit / Ruangan:</span>
                        <span class="font-bold text-slate-800">{{ $ticket->unit->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-medium">Kategori:</span>
                        <span class="font-bold text-slate-800">{{ $ticket->category->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-medium">Status Awal:</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                            Menunggu Validasi Admin
                        </span>
                    </div>
                </div>

                <!-- Navigation Actions -->
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('guest.ticket.track', ['ticket_number' => $ticket->ticket_number]) }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-800 hover:bg-emerald-900 text-white font-extrabold text-xs sm:text-sm px-6 py-3.5 rounded-2xl shadow-md transition hover:scale-[1.02]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Lacak Progres Tiket Ini</span>
                    </a>

                    <a href="{{ route('guest.landing') }}" class="w-full sm:w-auto text-xs sm:text-sm font-bold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl transition">
                        Kembali ke Beranda
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
            });
        }
    </script>
</x-guest-portal-layout>
