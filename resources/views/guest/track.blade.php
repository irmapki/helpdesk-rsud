<x-guest-portal-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Lacak Status Pengaduan IT RSUD</h1>
                <p class="text-sm text-slate-500 mt-1.5">Masukkan nomor tiket pengaduan untuk memantau progress pengerjaan secara real-time.</p>

                <!-- Search Input Form -->
                <form action="{{ route('guest.ticket.track') }}" method="GET" class="mt-6 max-w-xl mx-auto flex items-center gap-2 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="ticket_number" value="{{ $searchNumber ?? '' }}" required
                            placeholder="Ketik Nomor Tiket (Contoh: HD-20260820-0001)..."
                            class="w-full pl-10 pr-4 py-2.5 text-sm border-0 focus:ring-0 text-slate-900 font-mono placeholder:font-sans placeholder-slate-400">
                    </div>
                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition shrink-0 shadow-sm shadow-teal-600/30">
                        Cari Tiket
                    </button>
                </form>
            </div>

            @if ($searchNumber && !$ticket)
                <!-- Not Found State -->
                <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center shadow-sm">
                    <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Nomor Tiket Tidak Ditemukan</h2>
                    <p class="text-xs text-slate-500 mt-1.5 max-w-md mx-auto">
                        Tiket dengan nomor <span class="font-mono font-bold text-slate-800">"{{ $searchNumber }}"</span> tidak ditemukan dalam database. Pastikan format nomor tiket sudah benar.
                    </p>
                    <a href="{{ route('guest.ticket.create') }}" class="mt-6 inline-flex items-center gap-1.5 text-xs font-bold text-teal-600 hover:text-teal-700 bg-teal-50 px-4 py-2 rounded-xl transition">
                        Buat Pengaduan Baru &rarr;
                    </a>
                </div>
            @elseif ($ticket)
                <!-- Ticket Detail Result Card -->
                <div class="space-y-6">
                    <!-- Top Status Card -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                            <div>
                                <div class="flex items-center gap-2.5">
                                    <span class="font-mono text-lg sm:text-xl font-black text-teal-700">{{ $ticket->ticket_number }}</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $ticket->status_badge_class }}">
                                        {{ $ticket->status_label }}
                                    </span>
                                </div>
                                <h2 class="text-lg sm:text-xl font-bold text-slate-900 mt-2">{{ $ticket->title }}</h2>
                                <p class="text-xs text-slate-500 mt-1">
                                    Dilaporkan oleh <span class="font-semibold text-slate-700">{{ $ticket->reporter_name }}</span> &bull;
                                    Unit <span class="font-semibold text-slate-700">{{ $ticket->unit->name }}</span> &bull;
                                    {{ $ticket->created_at->format('d M Y, H:i') }} WIB
                                </p>
                            </div>

                            <div class="flex flex-col sm:items-end">
                                <span class="text-[11px] text-slate-400 uppercase font-semibold">Kategori & Prioritas</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700">
                                        {{ $ticket->category->name }}
                                    </span>
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-lg border {{ $ticket->priority->badge_class }}">
                                        {{ $ticket->priority->name }} ({{ $ticket->priority->sla_hours }} Jam)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Step Bar -->
                        @php
                            $currentStatus = $ticket->status;
                            $valStatus = $ticket->validation_status;

                            $step = 1;
                            if ($currentStatus === 'rejected') {
                                $step = -1;
                            } elseif ($currentStatus === 'open' && $valStatus === 'validated') {
                                $step = 2;
                            } elseif ($currentStatus === 'assigned') {
                                $step = 3;
                            } elseif ($currentStatus === 'in_progress') {
                                $step = 4;
                            } elseif (in_array($currentStatus, ['resolved', 'closed'])) {
                                $step = 5;
                            }
                        @endphp

                        <div class="py-6">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-4">Tahapan Penanganan</span>

                            @if ($step === -1)
                                <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-red-800 text-xs">
                                    <span class="font-bold block mb-1">Tiket Ditolak</span>
                                    <p>Alasan: {{ $ticket->rejection_reason ?? 'Pengaduan tidak dapat diproses oleh IT RSUD.' }}</p>
                                </div>
                            @else
                                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                                    <!-- Step 1 -->
                                    <div class="p-3 rounded-xl border {{ $step >= 1 ? 'bg-teal-50 border-teal-200 text-teal-900' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 1 ? 'bg-teal-600 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-bold flex items-center justify-center">1</span>
                                            <span class="text-xs font-bold">Diajukan</span>
                                        </div>
                                        <p class="text-[10px] {{ $step >= 1 ? 'text-teal-700' : 'text-slate-400' }}">Tiket terdaftar di sistem</p>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="p-3 rounded-xl border {{ $step >= 2 ? 'bg-teal-50 border-teal-200 text-teal-900' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 2 ? 'bg-teal-600 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-bold flex items-center justify-center">2</span>
                                            <span class="text-xs font-bold">Validasi</span>
                                        </div>
                                        <p class="text-[10px] {{ $step >= 2 ? 'text-teal-700' : 'text-slate-400' }}">Diverifikasi Admin IT</p>
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="p-3 rounded-xl border {{ $step >= 3 ? 'bg-teal-50 border-teal-200 text-teal-900' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 3 ? 'bg-teal-600 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-bold flex items-center justify-center">3</span>
                                            <span class="text-xs font-bold">Ditugaskan</span>
                                        </div>
                                        <p class="text-[10px] {{ $step >= 3 ? 'text-teal-700' : 'text-slate-400' }}">
                                            {{ $ticket->technician ? $ticket->technician->name : 'Menunggu Teknisi' }}
                                        </p>
                                    </div>

                                    <!-- Step 4 -->
                                    <div class="p-3 rounded-xl border {{ $step >= 4 ? 'bg-teal-50 border-teal-200 text-teal-900' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 4 ? 'bg-teal-600 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-bold flex items-center justify-center">4</span>
                                            <span class="text-xs font-bold">Pengerjaan</span>
                                        </div>
                                        <p class="text-[10px] {{ $step >= 4 ? 'text-teal-700' : 'text-slate-400' }}">Teknisi menangani kendala</p>
                                    </div>

                                    <!-- Step 5 -->
                                    <div class="p-3 rounded-xl border {{ $step >= 5 ? 'bg-emerald-50 border-emerald-200 text-emerald-900' : 'bg-slate-50 border-slate-200 text-slate-400' }} col-span-2 sm:col-span-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 5 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-bold flex items-center justify-center">5</span>
                                            <span class="text-xs font-bold">Selesai</span>
                                        </div>
                                        <p class="text-[10px] {{ $step >= 5 ? 'text-emerald-700' : 'text-slate-400' }}">Solusi terselesaikan</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Technician Box if assigned -->
                        @if ($ticket->technician)
                            <div class="mt-4 p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-teal-600 text-white font-bold flex items-center justify-center text-sm">
                                        {{ substr($ticket->technician->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 uppercase font-semibold">Teknisi Penanggung Jawab</span>
                                        <h4 class="text-sm font-bold text-slate-900">{{ $ticket->technician->name }}</h4>
                                        <p class="text-xs text-slate-500">{{ $ticket->technician->phone ?: 'Tim IT Helpdesk' }}</p>
                                    </div>
                                </div>

                                @if ($ticket->technician->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ticket->technician->phone) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-3 py-1.5 rounded-lg transition">
                                        <span>Hubungi WA</span>
                                    </a>
                                @endif
                            </div>
                        @endif

                        <!-- Description & Attachment -->
                        <div class="mt-6 border-t border-slate-100 pt-6">
                            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Kendala</h3>
                            <div class="bg-slate-50 rounded-xl p-4 text-xs sm:text-sm text-slate-700 whitespace-pre-line leading-relaxed">
                                {{ $ticket->description }}
                            </div>

                            @if ($ticket->attachment)
                                <div class="mt-4">
                                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lampiran Bukti</h4>
                                    <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="inline-block group">
                                        <img src="{{ asset('storage/' . $ticket->attachment) }}" alt="Bukti Kendala" class="h-36 rounded-xl border border-slate-200 object-cover group-hover:opacity-90 transition">
                                        <span class="text-[11px] text-teal-600 font-semibold mt-1 block">Klik untuk memperbesar gambar &rarr;</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline Audit Log -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                        <h3 class="text-sm font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Riwayat Penanganan Tiket
                        </h3>

                        <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200">
                            @forelse ($ticket->statusLogs as $log)
                                <div class="relative flex items-start gap-4">
                                    <div class="w-7 h-7 rounded-full bg-teal-600 text-white flex items-center justify-center text-xs font-bold z-10 shrink-0 shadow-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="bg-slate-50 rounded-xl p-3.5 flex-grow border border-slate-200/70 text-xs">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="font-bold text-slate-900">{{ $log->status_label }}</span>
                                            <span class="text-[10px] text-slate-400">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                                        </div>
                                        <p class="text-slate-600 mt-1">{{ $log->note }}</p>
                                        @if ($log->user)
                                            <span class="text-[10px] text-slate-400 mt-1 block">Oleh: {{ $log->user->name }} ({{ $log->user->role->label ?? $log->user->role->name }})</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 text-center py-4">Belum ada riwayat pergerakan status.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Rating & Feedback Section (If Resolved / Closed) -->
                    @if (in_array($ticket->status, ['resolved', 'closed']))
                        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                            <h3 class="text-sm font-bold text-slate-900 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Kepuasan Layanan & Ulasan
                            </h3>

                            @if ($ticket->rating)
                                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-xs">
                                    <div class="flex items-center gap-1 text-amber-500 mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $ticket->rating ? 'fill-current' : 'text-slate-300' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                        <span class="font-bold text-amber-800 ml-1">Rating: {{ $ticket->rating }} / 5 Bintang</span>
                                    </div>
                                    @if ($ticket->feedback)
                                        <p class="text-slate-700 mt-1 italic">"{{ $ticket->feedback }}"</p>
                                    @endif
                                </div>
                            @else
                                <p class="text-xs text-slate-500 mb-4">Pengaduan Anda telah selesai. Berikan penilaian terhadap kecepatan dan kualitas pelayanan teknisi kami.</p>

                                <form action="{{ route('guest.ticket.feedback', ['ticket_number' => $ticket->ticket_number]) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-2">Beri Nilai Bintang (1 - 5):</label>
                                        <div class="flex items-center gap-4">
                                            @for ($i = 5; $i >= 1; $i--)
                                                <label class="flex items-center gap-1.5 text-xs font-bold text-slate-700 cursor-pointer">
                                                    <input type="radio" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-500">
                                                    <span>{{ $i }} ★</span>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>

                                    <div>
                                        <label for="feedback" class="block text-xs font-semibold text-slate-700 mb-1">Masukan / Saran (Opsional):</label>
                                        <textarea name="feedback" id="feedback" rows="2" placeholder="Tuliskan pengalaman atau apresiasi Anda terhadap teknisi..." class="w-full text-xs rounded-xl border-slate-200 focus:border-teal-500 focus:ring-teal-500"></textarea>
                                    </div>

                                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-sm">
                                        Kirim Penilaian Layanan
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-guest-portal-layout>
