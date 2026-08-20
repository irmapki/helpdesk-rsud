<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tickets.index') }}" class="text-xs font-semibold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-xl transition">
                    &larr; Kembali
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-mono font-black text-xl text-teal-700 dark:text-teal-400">
                            {{ $ticket->ticket_number }}
                        </h2>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $ticket->status_badge_class }}">
                            {{ $ticket->status_label }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-0.5">Dilaporkan pada {{ $ticket->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>

            <!-- Quick Action Links -->
            <div class="flex items-center gap-2">
                @if ($ticket->status === 'resolved')
                    <form action="{{ route('admin.tickets.close', $ticket) }}" method="POST" onsubmit="return confirm('Tutup tiket ini secara resmi?')">
                        @csrf
                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-sm transition">
                            Tutup Tiket (Close)
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- SLA Alert Banner -->
            @php
                $slaStatus = $ticket->sla_status;
            @endphp
            @if ($slaStatus === 'breached')
                <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs flex items-center justify-between">
                    <div class="flex items-center gap-2 font-bold">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>PERINGATAN SLA: Tiket ini telah melewati batas SLA ({{ $ticket->priority->sla_hours }} Jam). Segera tindak lanjuti!</span>
                    </div>
                    <span class="font-mono font-bold text-red-700">Deadline: {{ $ticket->sla_deadline?->format('d/m/Y H:i') }}</span>
                </div>
            @elseif ($slaStatus === 'approaching')
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-center justify-between">
                    <div class="flex items-center gap-2 font-bold">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>PERHATIAN: Tiket mendekati batas waktu SLA (kurang dari 2 jam tersisa).</span>
                    </div>
                    <span class="font-mono font-bold text-amber-700">Deadline: {{ $ticket->sla_deadline?->format('d/m/Y H:i') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Details (2 cols) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Ticket Main Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6 space-y-5">
                        <div>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Judul Pengaduan</span>
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $ticket->title }}</h1>
                        </div>

                        <!-- Reporter Info Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-gray-50 dark:bg-gray-750 p-4 rounded-xl text-xs border border-gray-100 dark:border-gray-700">
                            <div>
                                <span class="text-gray-400 block mb-0.5 font-medium">Pelapor</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $ticket->reporter_name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block mb-0.5 font-medium">Unit / Ruangan</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $ticket->unit->name }}</span>
                                <span class="text-gray-400 text-[10px] block">{{ $ticket->unit->location }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block mb-0.5 font-medium">Kontak WhatsApp</span>
                                @if ($ticket->guest_phone || $ticket->creator?->phone)
                                    @php $phone = $ticket->guest_phone ?: $ticket->creator?->phone; @endphp
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phone) }}" target="_blank" class="font-bold text-emerald-600 hover:underline inline-flex items-center gap-1">
                                        <span>{{ $phone }}</span>
                                    </a>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider block mb-2">Deskripsi Lengkap Kendala</span>
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 text-xs sm:text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line leading-relaxed border border-gray-150 dark:border-gray-700">
                                {{ $ticket->description }}
                            </div>
                        </div>

                        <!-- Attachment -->
                        @if ($ticket->attachment)
                            <div>
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider block mb-2">Lampiran Bukti Foto</span>
                                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="inline-block group">
                                    <img src="{{ asset('storage/' . $ticket->attachment) }}" alt="Lampiran Bukti" class="h-48 rounded-xl border border-gray-200 object-cover group-hover:opacity-90 transition">
                                    <span class="text-[11px] text-teal-600 font-semibold mt-1 block">Buka ukuran penuh &rarr;</span>
                                </a>
                            </div>
                        @endif

                        <!-- Customer Feedback if any -->
                        @if ($ticket->rating)
                            <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider block mb-2">Penilaian Pelapor</span>
                                <div class="p-3.5 bg-amber-50 rounded-xl border border-amber-200 text-xs">
                                    <div class="flex items-center gap-1 text-amber-500 font-bold">
                                        <span>Rating: {{ $ticket->rating }} / 5 Bintang</span>
                                    </div>
                                    @if ($ticket->feedback)
                                        <p class="text-slate-700 mt-1 italic">"{{ $ticket->feedback }}"</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Internal Notes Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-sm text-gray-900 dark:text-white">Catatan Internal Helpdesk</h3>
                                <p class="text-xs text-gray-500">Catatan rahasia hanya terlihat oleh Tim IT & Admin</p>
                            </div>
                        </div>

                        <!-- Add Note Form -->
                        <form action="{{ route('admin.tickets.notes', $ticket) }}" method="POST" class="space-y-3">
                            @csrf
                            <textarea name="note" rows="2" required placeholder="Tuliskan catatan koordinasi internal..." class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500"></textarea>
                            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
                                Simpan Catatan Internal
                            </button>
                        </form>

                        <!-- Notes List -->
                        <div class="space-y-3 pt-2">
                            @forelse ($ticket->notes as $note)
                                <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-750 border border-gray-150 dark:border-gray-700 text-xs">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $note->user->name ?? 'Admin IT' }}</span>
                                        <span class="text-[10px] text-gray-400">{{ $note->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $note->note }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-2">Belum ada catatan internal.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Status History / Audit Logs Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6">
                        <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Histori Perubahan Status & Audit Log
                        </h3>

                        <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-gray-200 dark:before:bg-gray-700">
                            @forelse ($ticket->statusLogs as $log)
                                <div class="relative flex items-start gap-4">
                                    <div class="w-7 h-7 rounded-full bg-teal-600 text-white flex items-center justify-center text-xs font-bold z-10 shrink-0 shadow-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-750 rounded-xl p-3.5 flex-grow border border-gray-150 dark:border-gray-700 text-xs">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $log->status_label }}</span>
                                            <span class="text-[10px] text-gray-400">{{ $log->created_at->format('d/m/Y H:i') }} WIB</span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-300 mt-1">{{ $log->note }}</p>
                                        @if ($log->user)
                                            <span class="text-[10px] text-gray-400 mt-1 block">Oleh: {{ $log->user->name }} ({{ $log->user->role->label ?? $log->user->role->name }})</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-4">Belum ada riwayat status.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Action Panel (1 col) -->
                <div class="space-y-6">
                    <!-- 1. VALIDATION ACTION BOX -->
                    @if ($ticket->status === 'open' || $ticket->validation_status === 'pending')
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-amber-200 dark:border-amber-900 shadow-sm p-6 space-y-4 bg-gradient-to-br from-amber-50/40 to-white">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                                <h3 class="font-bold text-sm text-gray-900 dark:text-white">Validasi Pengaduan</h3>
                            </div>
                            <p class="text-xs text-gray-500">Periksa kebenaran tiket sebelum menugaskan ke teknisi.</p>

                            <!-- Form Approve Validation -->
                            <form action="{{ route('admin.tickets.validate', $ticket) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Validasi & Setujui Tiket
                                </button>
                            </form>

                            <!-- Form Reject -->
                            <div x-data="{ showReject: false }" class="pt-2 border-t border-amber-100 dark:border-gray-700">
                                <button @click="showReject = !showReject" type="button" class="w-full text-xs font-semibold text-red-600 hover:text-red-800 py-1.5 text-center">
                                    Tolak Pengaduan (Reject) &darr;
                                </button>

                                <form x-show="showReject" action="{{ route('admin.tickets.reject', $ticket) }}" method="POST" class="mt-3 space-y-3">
                                    @csrf
                                    <textarea name="rejection_reason" rows="2" required placeholder="Tuliskan alasan penolakan (misal: di luar wewenang IT / informasi keluhan tidak lengkap)..." class="w-full text-xs rounded-xl border-red-200 dark:border-red-800 focus:ring-red-500 focus:border-red-500"></textarea>
                                    <button type="submit" onclick="return confirm('Tolak tiket ini?')" class="w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 rounded-xl transition">
                                        Konfirmasi Penolakan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- 2. ASSIGN TECHNICIAN BOX -->
                    @if ($ticket->status !== 'rejected' && $ticket->status !== 'closed')
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6 space-y-4">
                            <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $ticket->technician ? 'Ubah Penugasan Teknisi' : 'Tugaskan ke Teknisi' }}
                            </h3>

                            @if ($ticket->technician)
                                <div class="p-3 bg-teal-50 dark:bg-teal-900/30 rounded-xl border border-teal-100 dark:border-teal-800 text-xs">
                                    <span class="text-[10px] text-teal-700 dark:text-teal-300 font-bold uppercase block">Teknisi Saat Ini:</span>
                                    <span class="font-bold text-gray-900 dark:text-white block text-sm">{{ $ticket->technician->name }}</span>
                                    <span class="text-gray-500 text-[11px]">Ditugaskan: {{ $ticket->assigned_at?->format('d/m/Y H:i') ?: '-' }}</span>
                                </div>
                            @endif

                            <form action="{{ route('admin.tickets.assign', $ticket) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="assigned_to" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">
                                        Pilih Teknisi IT <span class="text-red-500">*</span>
                                    </label>
                                    <select name="assigned_to" id="assigned_to" required class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
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
                                    <label for="assignment_note" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">
                                        Instruksi untuk Teknisi (Opsional)
                                    </label>
                                    <textarea name="assignment_note" id="assignment_note" rows="2" placeholder="Contoh: Bawa kabel LAN cadangan / cek switch lantai 2..." class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500"></textarea>
                                </div>

                                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition">
                                    {{ $ticket->technician ? 'Perbarui Penugasan' : 'Tugaskan Tiket Sekarang' }}
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- 3. TRIAGE CATEGORY & PRIORITY BOX -->
                    @if ($ticket->status !== 'closed' && $ticket->status !== 'rejected')
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6 space-y-4">
                            <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                Triage: Sesuaikan Kategori & SLA
                            </h3>

                            <form action="{{ route('admin.tickets.triage', $ticket) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="category_id" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Kategori Kendala</label>
                                    <select name="category_id" id="category_id" required class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $ticket->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="priority_id" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Tingkat Prioritas & SLA</label>
                                    <select name="priority_id" id="priority_id" required class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                                        @foreach ($priorities as $pri)
                                            <option value="{{ $pri->id }}" {{ $ticket->priority_id == $pri->id ? 'selected' : '' }}>
                                                {{ $pri->name }} (Target: {{ $pri->sla_hours }} Jam)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs py-2 px-4 rounded-xl transition">
                                    Simpan Perubahan Triage
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
