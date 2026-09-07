<x-guest-portal-layout>
    <div class="py-4 sm:py-10 min-w-0">
        <div class="max-w-4xl mx-auto px-2.5 sm:px-6 lg:px-8 w-full min-w-0">
            
            <!-- Tombol Kembali ke Welcome / Dashboard -->
            <div class="mb-4 min-w-0">
                <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-slate-600 hover:text-emerald-800 bg-white hover:bg-emerald-50 border border-slate-200 px-3.5 py-2 rounded-xl transition shadow-xs">
                    <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

            <!-- Search Header -->
            <div class="text-center mb-6 sm:mb-8 px-1 min-w-0">
                <h1 class="text-base sm:text-3xl font-black text-slate-900 tracking-tight leading-snug break-words">Lacak Status Pengaduan IT RSUD</h1>
                <p class="text-[11px] sm:text-sm text-slate-500 mt-1.5 font-medium max-w-lg mx-auto">Masukkan nomor tiket pengaduan untuk memantau progress pengerjaan secara real-time.</p>

                <!-- Search Input Form -->
                <form action="{{ route('guest.ticket.track') }}" method="GET" class="mt-4 sm:mt-5 max-w-xl mx-auto flex flex-col sm:flex-row items-center gap-2.5 bg-white p-2.5 sm:p-2 rounded-2xl border border-slate-200/90 shadow-md shadow-slate-200/50 min-w-0">
                    <div class="relative w-full flex-grow min-w-0">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="ticket_number" value="{{ $searchNumber ?? '' }}" required
                            placeholder="Ketik Nomor Tiket (Contoh: HD-...)"
                            class="w-full pl-11 pr-4 py-2.5 text-xs sm:text-sm border-0 focus:ring-0 text-slate-900 font-mono placeholder:font-sans placeholder-slate-400 font-semibold bg-transparent min-w-0">
                    </div>
                    <button type="submit" class="w-full sm:w-auto bg-emerald-800 hover:bg-emerald-900 text-white text-xs sm:text-sm font-extrabold px-6 py-3 sm:py-2.5 rounded-xl transition shrink-0 shadow-md shadow-emerald-900/20 active:scale-95 text-center">
                        Cari Tiket
                    </button>
                </form>
            </div>

            @if ($searchNumber && !$ticket)
                <!-- Not Found State -->
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-10 text-center shadow-md min-w-0">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-amber-50 text-amber-600 rounded-2xl sm:rounded-3xl flex items-center justify-center mx-auto mb-4 border border-amber-100 shrink-0">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-sm sm:text-lg font-black text-slate-900 break-words">Nomor Tiket Tidak Ditemukan</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1.5 max-w-md mx-auto font-medium break-words">
                        Tiket dengan nomor <span class="font-mono font-bold text-slate-800 break-all">"{{ $searchNumber }}"</span> tidak ditemukan dalam database. Pastikan format nomor tiket sudah benar.
                    </p>
                    <a href="{{ route('guest.ticket.create') }}" class="mt-5 inline-flex items-center justify-center gap-1.5 text-xs font-bold text-emerald-800 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-4 py-3 sm:py-2.5 rounded-xl transition w-full sm:w-auto text-center">
                        Buat Pengaduan Baru &rarr;
                    </a>
                </div>
            @elseif ($ticket)
                <!-- Ticket Detail Result Card -->
                <div class="space-y-4 sm:space-y-6 min-w-0">
                    <!-- Top Status Card -->
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-3.5 sm:p-8 shadow-md min-w-0">
                        <div class="flex flex-col gap-4 border-b border-slate-100 pb-5 sm:pb-6 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 min-w-0">
                                <div class="space-y-1.5 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 min-w-0">
                                        <span class="font-mono text-xs sm:text-xl font-black text-emerald-800 break-all">{{ $ticket->ticket_number }}</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold border {{ $ticket->status_badge_class }} shrink-0">
                                            {{ $ticket->status_label }}
                                        </span>
                                    </div>
                                    <h2 class="text-sm sm:text-xl font-black text-slate-900 leading-snug break-words">{{ $ticket->title }}</h2>
                                </div>

                                <div class="flex flex-col sm:items-end bg-slate-50 sm:bg-transparent p-3 sm:p-0 rounded-xl shrink-0 min-w-0">
                                    <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Kategori &amp; Prioritas</span>
                                    <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 mt-1 min-w-0">
                                        <span class="text-[11px] sm:text-xs font-bold px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 break-words">
                                            {{ $ticket->category->name }}
                                        </span>
                                        <span class="text-[11px] sm:text-xs font-bold px-2.5 py-1 rounded-xl border {{ $ticket->priority->badge_class }} break-words">
                                            {{ $ticket->priority->name }} ({{ $ticket->priority->sla_hours }} Jam)
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium leading-relaxed break-words">
                                Dilaporkan oleh <span class="font-bold text-slate-700">{{ $ticket->reporter_name }}</span> &bull;
                                Unit <span class="font-bold text-slate-700">{{ $ticket->unit->name }}</span> &bull;
                                {{ $ticket->created_at->format('d M Y, H:i') }} WIB
                            </p>
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
                            } elseif ($currentStatus === 'pending_review') {
                                $step = 4;
                            } elseif (in_array($currentStatus, ['resolved', 'closed'])) {
                                $step = 5;
                            }
                        @endphp

                        <div class="py-5 sm:py-6 min-w-0">
                            <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider block mb-3 sm:mb-4">Tahapan Penanganan Tiket</span>

                            @if ($step === -1)
                                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 text-rose-800 text-xs min-w-0">
                                    <span class="font-bold block mb-1">Tiket Ditolak</span>
                                    <p class="break-words">Alasan: {{ $ticket->rejection_reason ?? 'Pengaduan tidak dapat diproses oleh IT RSUD.' }}</p>
                                </div>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-5 gap-2.5 sm:gap-3 min-w-0">
                                    <!-- Step 1 -->
                                    <div class="p-3 rounded-2xl border {{ $step >= 1 ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : 'bg-slate-50 border-slate-200 text-slate-400' }} min-w-0">
                                        <div class="flex items-center gap-2 mb-0.5 sm:mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 1 ? 'bg-emerald-700 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-black flex items-center justify-center shrink-0">1</span>
                                            <span class="text-xs font-extrabold break-words">Diajukan</span>
                                        </div>
                                        <p class="text-[10px] font-medium {{ $step >= 1 ? 'text-emerald-800' : 'text-slate-400' }} break-words">Tiket terdaftar di sistem</p>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="p-3 rounded-2xl border {{ $step >= 2 ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : 'bg-slate-50 border-slate-200 text-slate-400' }} min-w-0">
                                        <div class="flex items-center gap-2 mb-0.5 sm:mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 2 ? 'bg-emerald-700 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-black flex items-center justify-center shrink-0">2</span>
                                            <span class="text-xs font-extrabold break-words">Validasi</span>
                                        </div>
                                        <p class="text-[10px] font-medium {{ $step >= 2 ? 'text-emerald-800' : 'text-slate-400' }} break-words">Diverifikasi Admin IT</p>
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="p-3 rounded-2xl border {{ $step >= 3 ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : 'bg-slate-50 border-slate-200 text-slate-400' }} min-w-0">
                                        <div class="flex items-center gap-2 mb-0.5 sm:mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 3 ? 'bg-emerald-700 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-black flex items-center justify-center shrink-0">3</span>
                                            <span class="text-xs font-extrabold break-words">Ditugaskan</span>
                                        </div>
                                        <p class="text-[10px] font-medium {{ $step >= 3 ? 'text-emerald-800' : 'text-slate-400' }} truncate">
                                            {{ $ticket->technician ? $ticket->technician->name : 'Menunggu Teknisi' }}
                                        </p>
                                    </div>

                                    <!-- Step 4 -->
                                    <div class="p-3 rounded-2xl border {{ $step >= 4 ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : 'bg-slate-50 border-slate-200 text-slate-400' }} min-w-0">
                                        <div class="flex items-center gap-2 mb-0.5 sm:mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 4 ? 'bg-emerald-700 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-black flex items-center justify-center shrink-0">4</span>
                                            <span class="text-xs font-extrabold break-words">
                                                {{ $currentStatus === 'pending_review' ? 'Review UAT' : 'Pengerjaan' }}
                                            </span>
                                        </div>
                                        <p class="text-[10px] font-medium {{ $step >= 4 ? 'text-emerald-800' : 'text-slate-400' }} break-words">
                                            {{ $currentStatus === 'pending_review' ? 'Uji fungsi Supervisor' : 'Teknisi di lokasi' }}
                                        </p>
                                    </div>

                                    <!-- Step 5 -->
                                    <div class="p-3 rounded-2xl border {{ $step >= 5 ? 'bg-emerald-600 border-emerald-600 text-white' : 'bg-slate-50 border-slate-200 text-slate-400' }} min-w-0">
                                        <div class="flex items-center gap-2 mb-0.5 sm:mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 5 ? 'bg-white text-emerald-800' : 'bg-slate-200 text-slate-500' }} text-[10px] font-black flex items-center justify-center shrink-0">5</span>
                                            <span class="text-xs font-extrabold break-words">Selesai</span>
                                        </div>
                                        <p class="text-[10px] font-medium {{ $step >= 5 ? 'text-emerald-100' : 'text-slate-400' }} break-words">Solusi terselesaikan</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Technician Box -->
                        @if ($ticket->technician)
                            <div class="mt-4 p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 min-w-0">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-700 text-white font-bold flex items-center justify-center text-sm shadow-xs shrink-0">
                                        {{ strtoupper(substr($ticket->technician->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider block">Teknisi Penanggung Jawab</span>
                                        <h4 class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">{{ $ticket->technician->name }}</h4>
                                        <p class="text-[11px] text-slate-500 font-medium truncate">{{ $ticket->technician->phone ?: 'Divisi IT RSUD' }}</p>
                                    </div>
                                </div>

                                @if ($ticket->technician->phone)
                                    @php
                                        $rawPhone = preg_replace('/[^0-9]/', '', $ticket->technician->phone);
                                        if (str_starts_with($rawPhone, '0')) {
                                            $cleanPhone = '62' . substr($rawPhone, 1);
                                        } elseif (str_starts_with($rawPhone, '62')) {
                                            $cleanPhone = $rawPhone;
                                        } else {
                                            $cleanPhone = '62' . $rawPhone;
                                        }
                                        $waMessage = urlencode("Halo {$ticket->technician->name}, saya {$ticket->reporter_name} dari Unit {$ticket->unit->name} RSUD Soewondo terkait Tiket {$ticket->ticket_number} ({$ticket->title}). Mohon bantuan konfirmasi penanganannya. Terima kasih.");
                                    @endphp
                                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMessage }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 text-xs font-bold text-emerald-800 bg-white hover:bg-emerald-100 border border-emerald-300 px-4 py-3 sm:py-2.5 rounded-xl transition shadow-xs text-center shrink-0">
                                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        <span>Hubungi Teknisi via WA</span>
                                    </a>
                                @endif
                            </div>

                            @if ($ticket->collaborators && $ticket->collaborators->isNotEmpty())
                                <div class="mt-2.5 pt-2 border-t border-slate-100 flex items-center gap-1.5 text-[11px] text-slate-600">
                                    <svg class="w-3.5 h-3.5 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span><strong>Tim Pendamping:</strong> {{ $ticket->collaborators->pluck('name')->join(', ') }}</span>
                                </div>
                            @endif
                        @elseif ($ticket->validation_status === 'validated' && !$ticket->technician && $ticket->status !== 'rejected')
                            <div class="mt-4 p-4 rounded-2xl bg-amber-50/70 border border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 min-w-0">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 font-bold flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-amber-800 uppercase font-bold tracking-wider block">Status Penanganan</span>
                                        <h4 class="text-xs sm:text-sm font-extrabold text-slate-900">Menunggu Diambil oleh Tim Teknisi</h4>
                                        <p class="text-[11px] text-slate-600 font-medium">Pengaduan telah disetujui Admin dan siap dikerjakan oleh Tim Teknisi IT.</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-xl bg-amber-100 text-amber-800 text-[11px] font-bold shrink-0 self-start sm:self-auto border border-amber-300">
                                    Antrean Terbuka
                                </span>
                            </div>
                        @endif

                        <!-- Description & Attachments -->
                        <div class="mt-5 sm:mt-6 border-t border-slate-100 pt-5 sm:pt-6 min-w-0">
                            <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Kendala</h3>
                            <div class="bg-slate-50 rounded-2xl p-4 text-xs sm:text-sm text-slate-700 whitespace-pre-line leading-relaxed border border-slate-100 font-medium break-words min-w-0">
                                {{ $ticket->description }}
                            </div>

                            @php $attachments = $ticket->attachments_list; @endphp
                            @if (!empty($attachments))
                                <div class="mt-5 sm:mt-6 border-t border-slate-100 pt-5 min-w-0">
                                    <h4 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2 break-words">
                                        <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        <span>Berkas Bukti Kendala ({{ count($attachments) }} Lampiran)</span>
                                    </h4>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 min-w-0">
                                        @foreach ($attachments as $att)
                                            @php $isVideo = \App\Models\Ticket::isVideoFile($att); @endphp
                                            <div class="bg-slate-50 p-2.5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between min-w-0">
                                                @if ($isVideo)
                                                    <div class="min-w-0">
                                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-purple-700 bg-purple-100 px-2 py-0.5 rounded-md mb-2">Video Rekaman Kendala</span>
                                                        <video controls preload="metadata" class="w-full h-40 rounded-xl bg-black object-cover">
                                                            <source src="{{ asset('storage/' . $att) }}" type="{{ \App\Models\Ticket::getVideoMimeType($att) }}">
                                                        </video>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $att) }}" target="_blank" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-800 mt-2 block text-center py-1">Buka Video di Tab Baru &rarr;</a>
                                                @elseif (\App\Models\Ticket::isHeicFile($att))
                                                    <div class="min-w-0">
                                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-md mb-2">Foto iPhone (HEIC)</span>
                                                        <div class="w-full h-40 bg-amber-50/70 border border-amber-200 rounded-xl flex flex-col items-center justify-center p-3 text-center">
                                                            <svg class="w-8 h-8 text-amber-600 mb-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                            <span class="text-[11px] font-bold text-slate-800">Format HEIC</span>
                                                        </div>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $att) }}" download class="text-[11px] font-bold text-emerald-700 hover:text-emerald-800 mt-2 block text-center py-1">Unduh Foto &rarr;</a>
                                                @else
                                                    <div class="min-w-0">
                                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-md mb-2">Foto / Screenshot</span>
                                                        <a href="{{ asset('storage/' . $att) }}" target="_blank" class="block group">
                                                            <img src="{{ asset('storage/' . $att) }}" alt="Bukti" class="w-full h-40 rounded-xl border border-slate-200 object-cover group-hover:opacity-90 transition">
                                                        </a>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $att) }}" target="_blank" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-800 mt-2 block text-center py-1">Perbesar Foto &rarr;</a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Upload Tambahan Bukti -->
                            @if (!in_array($ticket->status, ['resolved', 'closed', 'rejected']))
                                <div class="mt-5 p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 min-w-0">
                                    <h4 class="text-xs font-bold text-emerald-950 uppercase tracking-wider mb-1 flex items-center gap-1.5 break-words">
                                        <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        <span>Tambah Bukti Kendala Baru (Foto / Video)</span>
                                    </h4>
                                    <p class="text-[11px] text-slate-500 mb-3 font-medium break-words">Jika ada foto/video tambahan untuk memperjelas kendala kepada teknisi:</p>

                                    <form action="{{ route('guest.ticket.attachment', ['ticket_number' => $ticket->ticket_number]) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-3 min-w-0">
                                        @csrf
                                        <input type="file" name="attachments[]" multiple accept="image/*,video/*,.heic,.heif" required
                                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-white file:text-emerald-800 hover:file:bg-emerald-100 border border-emerald-200 rounded-xl p-1 bg-white focus:outline-none min-w-0">
                                        <button type="submit" class="w-full sm:w-auto shrink-0 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs px-5 py-3 sm:py-2.5 rounded-xl transition shadow-xs text-center">
                                            Unggah Bukti
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline Audit Log -->
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-3.5 sm:p-8 shadow-md min-w-0">
                        <h3 class="text-xs sm:text-sm font-extrabold text-slate-900 mb-5 flex items-center gap-2 break-words">
                            <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Riwayat Penanganan Tiket</span>
                        </h3>

                        <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200 min-w-0">
                            @forelse ($ticket->statusLogs as $log)
                                <div class="relative flex items-start gap-3 sm:gap-4 min-w-0">
                                    <div class="w-7 h-7 rounded-full bg-emerald-700 text-white flex items-center justify-center text-xs font-bold z-10 shrink-0 shadow-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="bg-slate-50 rounded-2xl p-3.5 sm:p-4 flex-grow border border-slate-100 text-xs min-w-0">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 sm:gap-2 min-w-0">
                                            <span class="font-extrabold text-slate-900 break-words">{{ $log->status_label }}</span>
                                            <span class="text-[10px] text-slate-400 font-medium shrink-0">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                                        </div>
                                        <p class="text-slate-600 mt-1 font-medium leading-relaxed break-words">{{ $log->note }}</p>
                                        @if ($log->user)
                                            <span class="text-[10px] text-emerald-700 font-bold mt-1.5 block break-words">Oleh: {{ $log->user->name }} ({{ $log->user->role->label ?? $log->user->role->name }})</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 text-center py-4">Belum ada riwayat pergerakan status.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Rating & Feedback Section -->
                    @if (in_array($ticket->status, ['resolved', 'closed']))
                        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-3.5 sm:p-8 shadow-md min-w-0">
                            <h3 class="text-xs sm:text-sm font-extrabold text-slate-900 mb-2 flex items-center gap-2 break-words">
                                <svg class="w-5 h-5 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span>Kepuasan Layanan &amp; Ulasan</span>
                            </h3>

                            @if ($ticket->rating)
                                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-xs min-w-0">
                                    <div class="flex items-center gap-1 text-amber-500 mb-1 flex-wrap">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $ticket->rating ? 'fill-current' : 'text-slate-300' }} shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                        <span class="font-extrabold text-amber-800 ml-1.5 break-words">Rating: {{ $ticket->rating }} / 5 Bintang</span>
                                    </div>
                                    @if ($ticket->feedback)
                                        <p class="text-slate-700 mt-1 italic font-medium break-words">"{{ $ticket->feedback }}"</p>
                                    @endif
                                </div>
                            @else
                                <p class="text-xs text-slate-500 mb-4 font-medium break-words">Pengaduan Anda telah selesai. Berikan penilaian terhadap kecepatan dan kualitas pelayanan teknisi kami.</p>

                                <form action="{{ route('guest.ticket.feedback', ['ticket_number' => $ticket->ticket_number]) }}" method="POST" class="space-y-4 min-w-0">
                                    @csrf
                                    <div class="min-w-0">
                                        <label class="block text-xs font-bold text-slate-700 mb-2">Beri Nilai Bintang (1 - 5):</label>
                                        <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 sm:gap-3 min-w-0">
                                            @for ($i = 5; $i >= 1; $i--)
                                                <label class="flex items-center justify-center sm:justify-start gap-1.5 text-xs font-extrabold text-slate-700 cursor-pointer bg-slate-50 px-3 py-2.5 rounded-xl border border-slate-200 min-w-0">
                                                    <input type="radio" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-700 shrink-0">
                                                    <span class="break-words">{{ $i }} ★</span>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="min-w-0">
                                        <label for="feedback" class="block text-xs font-bold text-slate-700 mb-1">Masukan / Saran (Opsional):</label>
                                        <textarea name="feedback" id="feedback" rows="3" placeholder="Tuliskan pengalaman atau apresiasi Anda..." class="w-full text-xs rounded-xl border-slate-200 focus:border-emerald-600 focus:ring-emerald-600 min-w-0"></textarea>
                                    </div>

                                    <button type="submit" class="w-full sm:w-auto bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-bold px-6 py-3 sm:py-2.5 rounded-xl transition shadow-sm text-center">
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