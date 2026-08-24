<x-guest-portal-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Lacak Status Pengaduan IT RSUD</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1.5 font-medium">Masukkan nomor tiket pengaduan untuk memantau progress pengerjaan secara real-time.</p>

                <!-- Search Input Form -->
                <form action="{{ route('guest.ticket.track') }}" method="GET" class="mt-6 max-w-xl mx-auto flex items-center gap-2 bg-white p-2 rounded-2xl border border-slate-200/90 shadow-md shadow-slate-200/50">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="ticket_number" value="{{ $searchNumber ?? '' }}" required
                            placeholder="Ketik Nomor Tiket (Contoh: HD-20260824-0001)..."
                            class="w-full pl-11 pr-4 py-2.5 text-xs sm:text-sm border-0 focus:ring-0 text-slate-900 font-mono placeholder:font-sans placeholder-slate-400 font-semibold">
                    </div>
                    <button type="submit" class="bg-emerald-800 hover:bg-emerald-900 text-white text-xs sm:text-sm font-extrabold px-6 py-2.5 rounded-xl transition shrink-0 shadow-md shadow-emerald-900/20">
                        Cari Tiket
                    </button>
                </form>
            </div>

            @if ($searchNumber && !$ticket)
                <!-- Not Found State -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-10 text-center shadow-md">
                    <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-amber-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-base sm:text-lg font-black text-slate-900">Nomor Tiket Tidak Ditemukan</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1.5 max-w-md mx-auto font-medium">
                        Tiket dengan nomor <span class="font-mono font-bold text-slate-800">"{{ $searchNumber }}"</span> tidak ditemukan dalam database. Pastikan format nomor tiket sudah benar.
                    </p>
                    <a href="{{ route('guest.ticket.create') }}" class="mt-6 inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-4 py-2.5 rounded-xl transition">
                        Buat Pengaduan Baru &rarr;
                    </a>
                </div>
            @elseif ($ticket)
                <!-- Ticket Detail Result Card -->
                <div class="space-y-6">
                    <!-- Top Status Card -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-md">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                            <div>
                                <div class="flex items-center gap-2.5">
                                    <span class="font-mono text-lg sm:text-xl font-black text-emerald-800">{{ $ticket->ticket_number }}</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $ticket->status_badge_class }}">
                                        {{ $ticket->status_label }}
                                    </span>
                                </div>
                                <h2 class="text-base sm:text-xl font-black text-slate-900 mt-2">{{ $ticket->title }}</h2>
                                <p class="text-xs text-slate-500 mt-1 font-medium">
                                    Dilaporkan oleh <span class="font-bold text-slate-700">{{ $ticket->reporter_name }}</span> &bull;
                                    Unit <span class="font-bold text-slate-700">{{ $ticket->unit->name }}</span> &bull;
                                    {{ $ticket->created_at->format('d M Y, H:i') }} WIB
                                </p>
                            </div>

                            <div class="flex flex-col sm:items-end">
                                <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Kategori &amp; Prioritas</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs font-bold px-3 py-1 rounded-xl bg-slate-100 text-slate-700">
                                        {{ $ticket->category->name }}
                                    </span>
                                    <span class="text-xs font-bold px-3 py-1 rounded-xl border {{ $ticket->priority->badge_class }}">
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
                            <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider block mb-4">Tahapan Penanganan Tiket</span>

                            @if ($step === -1)
                                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 text-rose-800 text-xs">
                                    <span class="font-bold block mb-1">Tiket Ditolak</span>
                                    <p>Alasan: {{ $ticket->rejection_reason ?? 'Pengaduan tidak dapat diproses oleh IT RSUD.' }}</p>
                                </div>
                            @else
                                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                                    <!-- Step 1 -->
                                    <div class="p-3.5 rounded-2xl border {{ $step >= 1 ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 1 ? 'bg-emerald-700 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-black flex items-center justify-center">1</span>
                                            <span class="text-xs font-extrabold">Diajukan</span>
                                        </div>
                                        <p class="text-[10px] font-medium {{ $step >= 1 ? 'text-emerald-800' : 'text-slate-400' }}">Tiket terdaftar di sistem</p>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="p-3.5 rounded-2xl border {{ $step >= 2 ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 2 ? 'bg-emerald-700 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-black flex items-center justify-center">2</span>
                                            <span class="text-xs font-extrabold">Validasi</span>
                                        </div>
                                        <p class="text-[10px] font-medium {{ $step >= 2 ? 'text-emerald-800' : 'text-slate-400' }}">Diverifikasi Admin IT</p>
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="p-3.5 rounded-2xl border {{ $step >= 3 ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 3 ? 'bg-emerald-700 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-black flex items-center justify-center">3</span>
                                            <span class="text-xs font-extrabold">Ditugaskan</span>
                                        </div>
                                        <p class="text-[10px] font-medium {{ $step >= 3 ? 'text-emerald-800' : 'text-slate-400' }} truncate">
                                            {{ $ticket->technician ? $ticket->technician->name : 'Menunggu Teknisi' }}
                                        </p>
                                    </div>

                                    <!-- Step 4 -->
                                    <div class="p-3.5 rounded-2xl border {{ $step >= 4 ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 4 ? 'bg-emerald-700 text-white' : 'bg-slate-200 text-slate-500' }} text-[10px] font-black flex items-center justify-center">4</span>
                                            <span class="text-xs font-extrabold">Pengerjaan</span>
                                        </div>
                                        <p class="text-[10px] font-medium {{ $step >= 4 ? 'text-emerald-800' : 'text-slate-400' }}">Teknisi di lokasi</p>
                                    </div>

                                    <!-- Step 5 -->
                                    <div class="p-3.5 rounded-2xl border {{ $step >= 5 ? 'bg-emerald-600 border-emerald-600 text-white' : 'bg-slate-50 border-slate-200 text-slate-400' }} col-span-2 sm:col-span-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="w-5 h-5 rounded-full {{ $step >= 5 ? 'bg-white text-emerald-800' : 'bg-slate-200 text-slate-500' }} text-[10px] font-black flex items-center justify-center">5</span>
                                            <span class="text-xs font-extrabold">Selesai</span>
                                        </div>
                                        <p class="text-[10px] font-medium {{ $step >= 5 ? 'text-emerald-100' : 'text-slate-400' }}">Solusi terselesaikan</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Technician Box if assigned -->
                        @if ($ticket->technician)
                            <div class="mt-4 p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-700 text-white font-bold flex items-center justify-center text-sm shadow-xs">
                                        {{ strtoupper(substr($ticket->technician->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Teknisi Penanggung Jawab</span>
                                        <h4 class="text-xs sm:text-sm font-extrabold text-slate-900">{{ $ticket->technician->name }}</h4>
                                        <p class="text-[11px] text-slate-500 font-medium">{{ $ticket->technician->phone ?: 'Divisi IT RSUD' }}</p>
                                    </div>
                                </div>

                                @if ($ticket->technician->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ticket->technician->phone) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-white hover:bg-emerald-100 border border-emerald-200 px-3.5 py-2 rounded-xl transition shadow-xs">
                                        <span>Hubungi WA</span>
                                    </a>
                                @endif
                            </div>
                        @endif

                        <!-- Description & Attachment -->
                        <div class="mt-6 border-t border-slate-100 pt-6">
                            <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Kendala</h3>
                            <div class="bg-slate-50 rounded-2xl p-4 text-xs sm:text-sm text-slate-700 whitespace-pre-line leading-relaxed border border-slate-100 font-medium">
                                {{ $ticket->description }}
                            </div>

                            @php
                                $attachments = $ticket->attachments_list;
                            @endphp

                            @if (!empty($attachments))
                                <div class="mt-6 border-t border-slate-100 pt-5">
                                    <h4 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                        <span>Berkas Bukti Kendala ({{ count($attachments) }} Lampiran)</span>
                                    </h4>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach ($attachments as $att)
                                            @php
                                                $isVideo = \App\Models\Ticket::isVideoFile($att);
                                            @endphp

                                            <div class="bg-slate-50 p-2.5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                                                @if ($isVideo)
                                                    <div>
                                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-purple-700 bg-purple-100 px-2 py-0.5 rounded-md mb-2">
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                            </svg>
                                                            Video Rekaman Kendala
                                                        </span>
                                                        <video controls preload="metadata" class="w-full h-40 rounded-xl bg-black object-cover">
                                                            <source src="{{ asset('storage/' . $att) }}">
                                                            Browser Anda tidak mendukung pemutar video.
                                                        </video>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $att) }}" target="_blank" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-800 mt-2 block text-center">
                                                        Buka Video di Tab Baru &rarr;
                                                    </a>
                                                @else
                                                    <div>
                                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-md mb-2">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            Foto / Screenshot
                                                        </span>
                                                        <a href="{{ asset('storage/' . $att) }}" target="_blank" class="block group">
                                                            <img src="{{ asset('storage/' . $att) }}" alt="Bukti Kendala" class="w-full h-40 rounded-xl border border-slate-200 object-cover group-hover:opacity-90 transition">
                                                        </a>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $att) }}" target="_blank" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-800 mt-2 block text-center">
                                                        Perbesar Foto &rarr;
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Form Tambah Bukti Kendala Tambahan (Foto/Video) -->
                            @if (!in_array($ticket->status, ['resolved', 'closed', 'rejected']))
                                <div class="mt-6 p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200/80">
                                    <h4 class="text-xs font-bold text-emerald-950 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span>Tambah Bukti Kendala Baru (Foto / Video)</span>
                                    </h4>
                                    <p class="text-[11px] text-slate-500 mb-3 font-medium">Jika ada foto/video tambahan untuk memperjelas kendala kepada teknisi:</p>

                                    <form action="{{ route('guest.ticket.attachment', ['ticket_number' => $ticket->ticket_number]) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-3">
                                        @csrf
                                        <input type="file" name="attachments[]" multiple accept="image/*,video/*" required
                                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-white file:text-emerald-800 hover:file:bg-emerald-100 border border-emerald-200 rounded-xl p-1 bg-white focus:outline-none">
                                        <button type="submit" class="w-full sm:w-auto shrink-0 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-xs">
                                            Unggah Bukti
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline Audit Log -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-md">
                        <h3 class="text-sm font-extrabold text-slate-900 mb-6 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Riwayat Penanganan Tiket</span>
                        </h3>

                        <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200">
                            @forelse ($ticket->statusLogs as $log)
                                <div class="relative flex items-start gap-4">
                                    <div class="w-7 h-7 rounded-full bg-emerald-700 text-white flex items-center justify-center text-xs font-bold z-10 shrink-0 shadow-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="bg-slate-50 rounded-2xl p-4 flex-grow border border-slate-100 text-xs">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="font-extrabold text-slate-900">{{ $log->status_label }}</span>
                                            <span class="text-[10px] text-slate-400 font-medium">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                                        </div>
                                        <p class="text-slate-600 mt-1 font-medium leading-relaxed">{{ $log->note }}</p>
                                        @if ($log->user)
                                            <span class="text-[10px] text-emerald-700 font-bold mt-1.5 block">Oleh: {{ $log->user->name }} ({{ $log->user->role->label ?? $log->user->role->name }})</span>
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
                        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-md">
                            <h3 class="text-sm font-extrabold text-slate-900 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span>Kepuasan Layanan &amp; Ulasan</span>
                            </h3>

                            @if ($ticket->rating)
                                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-xs">
                                    <div class="flex items-center gap-1 text-amber-500 mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $ticket->rating ? 'fill-current' : 'text-slate-300' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                        <span class="font-extrabold text-amber-800 ml-1.5">Rating: {{ $ticket->rating }} / 5 Bintang</span>
                                    </div>
                                    @if ($ticket->feedback)
                                        <p class="text-slate-700 mt-1 italic font-medium">"{{ $ticket->feedback }}"</p>
                                    @endif
                                </div>
                            @else
                                <p class="text-xs text-slate-500 mb-4 font-medium">Pengaduan Anda telah selesai. Berikan penilaian terhadap kecepatan dan kualitas pelayanan teknisi kami.</p>

                                <form action="{{ route('guest.ticket.feedback', ['ticket_number' => $ticket->ticket_number]) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-2">Beri Nilai Bintang (1 - 5):</label>
                                        <div class="flex items-center gap-4">
                                            @for ($i = 5; $i >= 1; $i--)
                                                <label class="flex items-center gap-1.5 text-xs font-extrabold text-slate-700 cursor-pointer">
                                                    <input type="radio" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-700">
                                                    <span>{{ $i }} ★</span>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>

                                    <div>
                                        <label for="feedback" class="block text-xs font-bold text-slate-700 mb-1">Masukan / Saran (Opsional):</label>
                                        <textarea name="feedback" id="feedback" rows="2" placeholder="Tuliskan pengalaman atau apresiasi Anda terhadap teknisi..." class="w-full text-xs rounded-xl border-slate-200 focus:border-emerald-600 focus:ring-emerald-600"></textarea>
                                    </div>

                                    <button type="submit" class="bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-sm">
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
