<x-guest-portal-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-lg p-6 sm:p-10 text-center relative overflow-hidden">
                <!-- Decorative Background Element -->
                <div class="absolute -top-12 -right-12 w-36 h-36 bg-teal-100/50 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-12 -left-12 w-36 h-36 bg-blue-100/50 rounded-full blur-2xl"></div>

                <!-- Success Icon -->
                <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-md shadow-emerald-500/20">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-2">
                    Pengaduan Berhasil Dikirim
                </span>

                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Terima Kasih, Pengaduan Anda Diterima!</h1>
                <p class="text-sm text-slate-500 mt-2 max-w-md mx-auto">
                    Simpan nomor tiket di bawah ini untuk memantau progress pengerjaan teknisi IT secara berkala.
                </p>

                <!-- Ticket Number Card -->
                <div x-data="{ copied: false }" class="mt-8 p-6 bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl text-white shadow-xl relative">
                    <span class="text-xs text-slate-400 font-medium uppercase tracking-wider block mb-1">Nomor Tiket Anda</span>
                    <div class="text-2xl sm:text-3xl font-mono font-extrabold tracking-widest text-teal-400 my-1 select-all">
                        {{ $ticket->ticket_number }}
                    </div>

                    <button @click="navigator.clipboard.writeText('{{ $ticket->ticket_number }}'); copied = true; setTimeout(() => copied = false, 2500)"
                        class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold bg-white/10 hover:bg-white/20 text-white px-3.5 py-1.5 rounded-lg transition backdrop-blur-xs">
                        <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <svg x-show="copied" class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span x-text="copied ? 'Tersalin!' : 'Salin Nomor Tiket'"></span>
                    </button>
                </div>

                <!-- Ticket Details Overview -->
                <div class="mt-6 bg-slate-50 rounded-2xl p-5 border border-slate-200/80 text-left text-xs space-y-2.5">
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span class="text-slate-500 font-medium">Pelapor</span>
                        <span class="font-bold text-slate-900">{{ $ticket->guest_name }} ({{ $ticket->guest_phone }})</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span class="text-slate-500 font-medium">Unit / Ruangan</span>
                        <span class="font-bold text-slate-900">{{ $ticket->unit->name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span class="text-slate-500 font-medium">Kategori</span>
                        <span class="font-bold text-slate-900">{{ $ticket->category->name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span class="text-slate-500 font-medium">Judul Keluhan</span>
                        <span class="font-bold text-slate-900 text-right">{{ $ticket->title }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500 font-medium">Estimasi Waktu Respon SLA</span>
                        <span class="font-bold text-teal-700">{{ $ticket->priority->sla_hours ?? 8 }} Jam Kerja</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('guest.ticket.track', ['ticket_number' => $ticket->ticket_number]) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md shadow-teal-600/30 transition hover:scale-[1.02]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Lacak Status Tiket Sekarang
                    </a>

                    <a href="{{ route('guest.landing') }}" class="w-full sm:w-auto inline-flex items-center justify-center text-sm font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-5 py-3 rounded-xl transition">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-portal-layout>
