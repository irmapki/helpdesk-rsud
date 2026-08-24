<x-app-layout>
<<<<<<< HEAD
    <div class="space-y-6">
        <!-- Top Header & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tickets.index') }}" class="p-2 rounded-xl border border-slate-200 hover:border-slate-300 text-slate-600 hover:text-slate-900 bg-white transition shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="font-mono font-bold text-xl sm:text-2xl text-teal-900">
                            {{ $ticket->ticket_number }}
                        </h1>
                        <span class="inline-block px-3 py-1 rounded-xl text-xs font-bold {{ $ticket->status_badge_class }}">
                            {{ $ticket->status_label }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Dilaporkan pada {{ $ticket->created_at->format('d F Y, H:i') }} WIB</p>
=======
    <x-slot name="pageTitle">
        Detail &amp; Triage Tiket
    </x-slot>
    <x-slot name="breadcrumb">
        Admin &rsaquo; Manajemen Tiket &rsaquo; {{ $ticket->ticket_number }}
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <!-- Top Action Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tickets.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200 px-3.5 py-2 rounded-xl transition">
                    &larr; Kembali ke Inbox
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-mono font-black text-xl text-teal-700">
                            {{ $ticket->ticket_number }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $ticket->status_badge_class }}">
                            {{ $ticket->status_label }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Dilaporkan pada {{ $ticket->created_at->format('d F Y, H:i') }} WIB</p>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                </div>
            </div>

            <!-- Quick Action Links -->
            <div class="flex items-center gap-2">
                @if ($ticket->status === 'resolved')
                    <form action="{{ route('admin.tickets.close', $ticket) }}" method="POST" onsubmit="return confirm('Tutup tiket ini secara resmi?')">
                        @csrf
<<<<<<< HEAD
                        <button type="submit" class="bg-[#0f333a] hover:bg-[#092227] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-xs transition">
                            Tutup Tiket (Close)
=======
                        <button type="submit" class="bg-[#0a252a] hover:bg-[#0e353c] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-xs transition">
                            Tutup Tiket Resmi (Close)
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- SLA Alert Banner -->
<<<<<<< HEAD
        @php
            $slaStatus = $ticket->sla_status;
        @endphp
        @if ($slaStatus === 'breached')
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-2 shadow-xs">
=======
        @php $slaStatus = $ticket->sla_status; @endphp
        @if ($slaStatus === 'breached')
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center justify-between shadow-xs">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                <div class="flex items-center gap-2 font-bold">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
<<<<<<< HEAD
                    <span>PERINGATAN SLA: Tiket ini telah melewati batas SLA ({{ $ticket->priority->sla_hours }} Jam). Segera tindak lanjuti!</span>
                </div>
                <span class="font-mono font-bold text-rose-700">Deadline: {{ $ticket->sla_deadline?->format('d/m/Y H:i') }}</span>
            </div>
        @elseif ($slaStatus === 'approaching')
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-2 shadow-xs">
=======
                    <span>PERINGATAN SLA: Tiket ini telah melewati batas waktu SLA ({{ $ticket->priority->sla_hours }} Jam). Segera tindak lanjuti!</span>
                </div>
                <span class="font-mono font-bold text-rose-700 shrink-0">Batas SLA: {{ $ticket->sla_deadline?->format('d/m/Y H:i') }}</span>
            </div>
        @elseif ($slaStatus === 'approaching')
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-center justify-between shadow-xs">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                <div class="flex items-center gap-2 font-bold">
                    <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>PERHATIAN: Tiket mendekati batas waktu SLA (kurang dari 2 jam tersisa).</span>
                </div>
<<<<<<< HEAD
                <span class="font-mono font-bold text-amber-700">Deadline: {{ $ticket->sla_deadline?->format('d/m/Y H:i') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Details (2 cols) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Ticket Main Info Card -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-5">
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Judul Pengaduan</span>
                        <h2 class="text-xl font-bold text-slate-900">{{ $ticket->title }}</h2>
=======
                <span class="font-mono font-bold text-amber-700 shrink-0">Batas SLA: {{ $ticket->sla_deadline?->format('d/m/Y H:i') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Left Details (8 cols) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Ticket Main Info Card -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-5">
                    <div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Judul Pengaduan</span>
                        <h1 class="text-xl font-extrabold text-slate-900">{{ $ticket->title }}</h1>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                    </div>

                    <!-- Reporter Info Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-xl text-xs border border-slate-100">
                        <div>
<<<<<<< HEAD
                            <span class="text-slate-400 block mb-0.5 font-bold uppercase text-[10px]">Pelapor</span>
                            <span class="font-bold text-slate-900 text-sm">{{ $ticket->reporter_name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5 font-bold uppercase text-[10px]">Unit / Ruangan</span>
                            <span class="font-bold text-slate-900">{{ $ticket->unit->name }}</span>
                            <span class="text-slate-400 text-[10px] block mt-0.5">{{ $ticket->unit->location }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5 font-bold uppercase text-[10px]">Kontak WhatsApp</span>
                            @if ($ticket->guest_phone || $ticket->creator?->phone)
                                @php $phone = $ticket->guest_phone ?: $ticket->creator?->phone; @endphp
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phone) }}" target="_blank" class="font-bold text-teal-800 hover:underline inline-flex items-center gap-1">
                                    <span>{{ $phone }}</span>
                                </a>
                            @else
                                <span class="text-slate-400">-</span>
=======
                            <span class="text-slate-400 block mb-0.5 font-medium">Pelapor</span>
                            <span class="font-extrabold text-slate-900">{{ $ticket->reporter_name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5 font-medium">Unit / Ruangan</span>
                            <span class="font-extrabold text-slate-900">{{ $ticket->unit->name }}</span>
                            <span class="text-slate-400 text-[10px] block">{{ $ticket->unit->location }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5 font-medium">Kontak WhatsApp</span>
                            @if ($ticket->guest_phone || $ticket->creator?->phone)
                                @php $phone = $ticket->guest_phone ?: $ticket->creator?->phone; @endphp
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phone) }}" target="_blank" class="font-bold text-emerald-600 hover:underline inline-flex items-center gap-1">
                                    <span>{{ $phone }}</span>
                                </a>
                            @else
                                <span class="text-slate-500">-</span>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-2">Deskripsi Lengkap Kendala</span>
<<<<<<< HEAD
                        <div class="bg-slate-50 rounded-xl p-4 text-xs sm:text-sm text-slate-800 whitespace-pre-line leading-relaxed border border-slate-100 font-medium">
=======
                        <div class="bg-slate-50 rounded-xl p-4 text-xs sm:text-sm text-slate-800 whitespace-pre-line leading-relaxed border border-slate-100">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                            {{ $ticket->description }}
                        </div>
                    </div>

<<<<<<< HEAD
                    <!-- Attachments (Multiple Photos & Videos) -->
                    @php
                        $attachments = $ticket->attachments_list;
                    @endphp
                    @if (!empty($attachments))
                        <div class="pt-2">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-2.5">
                                Berkas Lampiran Bukti Kendala ({{ count($attachments) }} File)
                            </span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($attachments as $att)
                                    @php
                                        $isVideo = \App\Models\Ticket::isVideoFile($att);
                                    @endphp
                                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 shadow-xs">
                                        @if ($isVideo)
                                            <div class="mb-1.5">
                                                <span class="inline-block text-[10px] font-bold text-purple-700 bg-purple-100 px-2 py-0.5 rounded">
                                                    Video Kendala
                                                </span>
                                            </div>
                                            <video controls preload="metadata" class="w-full h-44 rounded-lg bg-black object-cover">
                                                <source src="{{ asset('storage/' . $att) }}">
                                                Browser tidak mendukung video.
                                            </video>
                                            <a href="{{ asset('storage/' . $att) }}" target="_blank" class="text-[11px] text-teal-800 font-bold mt-2 block text-center hover:underline">
                                                Buka Video di Tab Baru &rarr;
                                            </a>
                                        @else
                                            <div class="mb-1.5">
                                                <span class="inline-block text-[10px] font-bold text-sky-700 bg-sky-100 px-2 py-0.5 rounded">
                                                    Foto Bukti
                                                </span>
                                            </div>
                                            <a href="{{ asset('storage/' . $att) }}" target="_blank" class="block group">
                                                <img src="{{ asset('storage/' . $att) }}" alt="Bukti" class="w-full h-44 rounded-lg border border-slate-200 object-cover group-hover:opacity-90 transition">
                                            </a>
                                            <a href="{{ asset('storage/' . $att) }}" target="_blank" class="text-[11px] text-teal-800 font-bold mt-2 block text-center hover:underline">
                                                Perbesar Foto &rarr;
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
=======
                    <!-- Attachment -->
                    @if ($ticket->attachment)
                        <div>
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-2">Lampiran Bukti Foto</span>
                            <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="inline-block group">
                                <img src="{{ asset('storage/' . $ticket->attachment) }}" alt="Lampiran Bukti" class="h-48 rounded-xl border border-slate-200 object-cover group-hover:opacity-90 transition">
                                <span class="text-[11px] text-teal-600 font-semibold mt-1 block">Buka ukuran penuh &rarr;</span>
                            </a>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                        </div>
                    @endif

                    <!-- Customer Feedback if any -->
                    @if ($ticket->rating)
                        <div class="border-t border-slate-100 pt-4">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-2">Penilaian Pelapor</span>
<<<<<<< HEAD
                            <div class="p-4 bg-amber-50 rounded-xl border border-amber-200 text-xs">
                                <div class="flex items-center gap-1 text-amber-700 font-bold">
                                    <span>Rating: {{ $ticket->rating }} / 5 Bintang</span>
                                </div>
                                @if ($ticket->feedback)
                                    <p class="text-slate-700 mt-1 italic font-medium">"{{ $ticket->feedback }}"</p>
=======
                            <div class="p-3.5 bg-amber-50 rounded-xl border border-amber-200 text-xs">
                                <div class="flex items-center gap-1 text-amber-600 font-bold">
                                    <span>Rating: {{ $ticket->rating }} / 5 Bintang</span>
                                </div>
                                @if ($ticket->feedback)
                                    <p class="text-slate-700 mt-1 italic">"{{ $ticket->feedback }}"</p>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Internal Notes Card -->
<<<<<<< HEAD
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Catatan Internal Helpdesk</h3>
                        <p class="text-xs text-slate-400">Catatan koordinasi hanya terlihat oleh Tim IT &amp; Admin</p>
=======
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div>
                        <h3 class="font-extrabold text-sm text-slate-900">Catatan Internal Helpdesk</h3>
                        <p class="text-xs text-slate-500">Koordinasi rahasia internal tim IT</p>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                    </div>

                    <!-- Add Note Form -->
                    <form action="{{ route('admin.tickets.notes', $ticket) }}" method="POST" class="space-y-3">
                        @csrf
<<<<<<< HEAD
                        <textarea name="note" rows="2" required placeholder="Tuliskan catatan koordinasi internal..."
                            class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 font-medium"></textarea>
                        <button type="submit" class="bg-[#0f333a] hover:bg-[#092227] text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-xs">
                            Simpan Catatan Internal
=======
                        <textarea name="note" rows="2" required placeholder="Tuliskan catatan koordinasi internal..." class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500"></textarea>
                        <button type="submit" class="bg-[#0a252a] hover:bg-[#0e353c] text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-xs">
                            Simpan Catatan
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                        </button>
                    </form>

                    <!-- Notes List -->
                    <div class="space-y-3 pt-2">
                        @forelse ($ticket->notes as $note)
<<<<<<< HEAD
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-slate-900">{{ $note->user->name ?? 'Admin IT' }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $note->created_at->format('d/m/Y H:i') }}</span>
=======
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-slate-900">{{ $note->user->name ?? 'Admin IT' }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $note->created_at->format('d/m/Y H:i') }}</span>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                                </div>
                                <p class="text-slate-700">{{ $note->note }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-2">Belum ada catatan internal.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Status History / Audit Logs Card -->
<<<<<<< HEAD
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6">
                    <h3 class="font-bold text-sm text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Histori Perubahan Status &amp; Audit Log</span>
=======
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
                    <h3 class="font-extrabold text-sm text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Histori Perubahan Status &amp; Audit Log
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                    </h3>

                    <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200">
                        @forelse ($ticket->statusLogs as $log)
                            <div class="relative flex items-start gap-4">
<<<<<<< HEAD
                                <div class="w-7 h-7 rounded-full bg-[#0f333a] text-white flex items-center justify-center text-xs font-bold z-10 shrink-0 shadow-xs">
=======
                                <div class="w-7 h-7 rounded-full bg-[#0a252a] text-white flex items-center justify-center text-xs font-bold z-10 shrink-0 shadow-xs">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
<<<<<<< HEAD
                                <div class="bg-slate-50 rounded-xl p-4 flex-grow border border-slate-100 text-xs">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="font-bold text-slate-900">{{ $log->status_label }}</span>
                                        <span class="text-[10px] text-slate-400 font-mono">{{ $log->created_at->format('d/m/Y H:i') }} WIB</span>
=======
                                <div class="bg-slate-50 rounded-xl p-3.5 flex-grow border border-slate-100 text-xs">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="font-bold text-slate-900">{{ $log->status_label }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $log->created_at->format('d/m/Y H:i') }} WIB</span>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                                    </div>
                                    <p class="text-slate-600 mt-1">{{ $log->note }}</p>
                                    @if ($log->user)
                                        <span class="text-[10px] text-slate-400 mt-1 block">Oleh: {{ $log->user->name }} ({{ $log->user->role->label ?? $log->user->role->name }})</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-4">Belum ada riwayat status.</p>
                        @endforelse
                    </div>
                </div>
            </div>

<<<<<<< HEAD
            <!-- Right Action Panel (1 col) -->
            <div class="space-y-6">
=======
            <!-- Right Action Panel (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                <!-- 1. VALIDATION ACTION BOX -->
                @if ($ticket->status === 'open' || $ticket->validation_status === 'pending')
                    <div class="bg-white rounded-2xl border border-amber-200 shadow-xs p-6 space-y-4 bg-gradient-to-br from-amber-50/40 to-white">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
<<<<<<< HEAD
                            <h3 class="font-bold text-sm text-slate-900">Validasi Pengaduan</h3>
                        </div>
                        <p class="text-xs text-slate-500">Periksa kebenaran tiket sebelum menugaskan ke teknisi.</p>
=======
                            <h3 class="font-extrabold text-sm text-slate-900">Validasi Pengaduan</h3>
                        </div>
                        <p class="text-xs text-slate-500">Periksa keabsahan tiket sebelum diteruskan ke teknisi.</p>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4

                        <!-- Form Approve Validation -->
                        <form action="{{ route('admin.tickets.validate', $ticket) }}" method="POST">
                            @csrf
<<<<<<< HEAD
                            <button type="submit" class="w-full bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs py-3 px-4 rounded-xl shadow-xs transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Validasi &amp; Setujui Tiket</span>
=======
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-xs transition flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                Validasi &amp; Setujui Tiket
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                            </button>
                        </form>

                        <!-- Form Reject -->
<<<<<<< HEAD
                        <div x-data="{ showReject: false }" class="pt-2 border-t border-slate-100">
                            <button @click="showReject = !showReject" type="button" class="w-full text-xs font-bold text-rose-600 hover:text-rose-800 py-1.5 text-center">
=======
                        <div x-data="{ showReject: false }" class="pt-2 border-t border-amber-100">
                            <button @click="showReject = !showReject" type="button" class="w-full text-xs font-semibold text-rose-600 hover:text-rose-800 py-1.5 text-center">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                                Tolak Pengaduan (Reject) &darr;
                            </button>

                            <form x-show="showReject" action="{{ route('admin.tickets.reject', $ticket) }}" method="POST" class="mt-3 space-y-3">
                                @csrf
<<<<<<< HEAD
                                <textarea name="rejection_reason" rows="2" required placeholder="Tuliskan alasan penolakan (misal: di luar wewenang IT / informasi tidak lengkap)..."
                                    class="w-full text-xs rounded-xl border-rose-200 bg-white text-slate-800 focus:ring-rose-500 focus:border-rose-500 placeholder-slate-400 font-medium"></textarea>
                                <button type="submit" onclick="return confirm('Tolak tiket ini?')" class="w-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold py-2.5 rounded-xl transition">
=======
                                <textarea name="rejection_reason" rows="2" required placeholder="Tuliskan alasan penolakan..." class="w-full text-xs rounded-xl border-rose-200 focus:ring-rose-500 focus:border-rose-500"></textarea>
                                <button type="submit" onclick="return confirm('Tolak tiket ini?')" class="w-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold py-2 rounded-xl transition">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                                    Konfirmasi Penolakan
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- 2. ASSIGN TECHNICIAN BOX -->
                @if ($ticket->status !== 'rejected' && $ticket->status !== 'closed')
<<<<<<< HEAD
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
                        <h3 class="font-bold text-sm text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>{{ $ticket->technician ? 'Ubah Penugasan Teknisi' : 'Tugaskan ke Teknisi' }}</span>
                        </h3>

                        @if ($ticket->technician)
                            <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200 text-xs">
                                <span class="text-[10px] text-emerald-800 font-bold uppercase block">Teknisi Saat Ini:</span>
                                <span class="font-bold text-slate-900 block text-sm mt-0.5">{{ $ticket->technician->name }}</span>
                                <span class="text-slate-400 text-[11px] mt-0.5 block">Ditugaskan: {{ $ticket->assigned_at?->format('d/m/Y H:i') ?: '-' }}</span>
=======
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $ticket->technician ? 'Ubah Penugasan Teknisi' : 'Tugaskan ke Teknisi' }}
                        </h3>

                        @if ($ticket->technician)
                            <div class="p-3 bg-teal-50 rounded-xl border border-teal-100 text-xs">
                                <span class="text-[10px] text-teal-700 font-bold uppercase block">Teknisi Saat Ini:</span>
                                <span class="font-extrabold text-slate-900 block text-sm">{{ $ticket->technician->name }}</span>
                                <span class="text-slate-500 text-[11px]">Ditugaskan: {{ $ticket->assigned_at?->format('d/m/Y H:i') ?: '-' }}</span>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                            </div>
                        @endif

                        <form action="{{ route('admin.tickets.assign', $ticket) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
<<<<<<< HEAD
                                <label for="assigned_to" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Pilih Teknisi IT <span class="text-rose-500">*</span>
                                </label>
                                <select name="assigned_to" id="assigned_to" required
                                    class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
=======
                                <label for="assigned_to" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                    Pilih Teknisi IT <span class="text-red-500">*</span>
                                </label>
                                <select name="assigned_to" id="assigned_to" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                                    <option value="">-- Pilih Teknisi Tersedia --</option>
                                    @foreach ($technicians as $tech)
                                        @php $load = $tech->assignedTickets->count(); @endphp
                                        <option value="{{ $tech->id }}" {{ $ticket->assigned_to == $tech->id ? 'selected' : '' }}>
                                            {{ $tech->name }} (Beban: {{ $load }} Tiket) - {{ $tech->specialization ?: 'Umum' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
<<<<<<< HEAD
                                <label for="assignment_note" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Instruksi untuk Teknisi (Opsional)
                                </label>
                                <textarea name="assignment_note" id="assignment_note" rows="2" placeholder="Contoh: Bawa kabel LAN cadangan / cek switch lantai 2..."
                                    class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 font-medium"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs py-3 px-4 rounded-xl shadow-xs transition">
=======
                                <label for="assignment_note" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                    Instruksi Tambahan (Opsional)
                                </label>
                                <textarea name="assignment_note" id="assignment_note" rows="2" placeholder="Catatan instruksi untuk teknisi..." class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-[#0a252a] hover:bg-[#0e353c] text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-xs transition">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                                {{ $ticket->technician ? 'Perbarui Penugasan' : 'Tugaskan Tiket Sekarang' }}
                            </button>
                        </form>
                    </div>
                @endif

                <!-- 3. TRIAGE CATEGORY & PRIORITY BOX -->
                @if ($ticket->status !== 'closed' && $ticket->status !== 'rejected')
<<<<<<< HEAD
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
                        <h3 class="font-bold text-sm text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            <span>Triage: Sesuaikan Kategori &amp; SLA</span>
=======
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Triage: Sesuaikan Kategori &amp; SLA
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                        </h3>

                        <form action="{{ route('admin.tickets.triage', $ticket) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
<<<<<<< HEAD
                                <label for="category_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Kendala</label>
                                <select name="category_id" id="category_id" required
                                    class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
=======
                                <label for="category_id" class="block text-xs font-bold text-slate-700 uppercase mb-1">Kategori Kendala</label>
                                <select name="category_id" id="category_id" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $ticket->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
<<<<<<< HEAD
                                <label for="priority_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tingkat Prioritas &amp; SLA</label>
                                <select name="priority_id" id="priority_id" required
                                    class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
=======
                                <label for="priority_id" class="block text-xs font-bold text-slate-700 uppercase mb-1">Tingkat Prioritas &amp; Batas SLA</label>
                                <select name="priority_id" id="priority_id" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                                    @foreach ($priorities as $pri)
                                        <option value="{{ $pri->id }}" {{ $ticket->priority_id == $pri->id ? 'selected' : '' }}>
                                            {{ $pri->name }} (Target: {{ $pri->sla_hours }} Jam)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

<<<<<<< HEAD
                            <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs py-2.5 px-4 rounded-xl transition">
                                Simpan Perubahan Triage
=======
                            <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs py-2 px-4 rounded-xl transition">
                                Simpan Penyesuaian Triage
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
