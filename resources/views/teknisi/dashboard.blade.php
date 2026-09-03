<x-app-layout>
    <div class="space-y-6 max-w-full overflow-x-hidden pb-10">
        <!-- Top Title & Identitas Teknisi -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 min-w-0">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight break-words">
                    Dashboard Penanganan Kendala IT
                </h1>
                <p class="text-xs text-slate-500 font-normal mt-1 break-words">
                    Selamat bertugas, <strong class="text-slate-800">{{ Auth::user()->name }}</strong> &bull; Spesialisasi: <span class="text-teal-700 font-bold">{{ Auth::user()->specialization ?: 'Hardware & Jaringan' }}</span>
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <span class="text-xs font-bold px-3 py-1.5 rounded-xl bg-teal-50 text-teal-900 border border-teal-200">
                    🟢 Status: Siap Bertugas
                </span>
            </div>
        </div>

        <!-- 4 Statistik Cards Teknisi Model 1 -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Card 1: Tiket Aktif Saya -->
            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="mt-3 min-w-0">
                    <span class="text-[11px] sm:text-xs font-semibold text-slate-600 block truncate">Tiket Aktif Saya</span>
                    <div class="text-xl sm:text-3xl font-black text-teal-900 mt-0.5 sm:mt-1">{{ $myActiveCount ?? 0 }}</div>
                    <span class="text-[10px] sm:text-xs font-bold text-teal-700 mt-1 sm:mt-2 inline-block">Tanggung jawab saya</span>
                </div>
            </div>

            <!-- Card 2: Sedang Dikerjakan -->
            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <div class="mt-3 min-w-0">
                    <span class="text-[11px] sm:text-xs font-semibold text-slate-600 block truncate">Sedang Dikerjakan</span>
                    <div class="text-xl sm:text-3xl font-black text-sky-700 mt-0.5 sm:mt-1">{{ $myInProgressCount ?? 0 }}</div>
                    <span class="text-[10px] sm:text-xs font-bold text-sky-600 mt-1 sm:mt-2 inline-block">Dalam proses</span>
                </div>
            </div>

            <!-- Card 3: Belum Diambil Siapa Pun -->
            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="mt-3 min-w-0">
                    <span class="text-[11px] sm:text-xs font-semibold text-slate-600 block truncate">Tiket Belum Diambil</span>
                    <div class="text-xl sm:text-3xl font-black text-amber-600 mt-0.5 sm:mt-1">{{ $availableCount ?? 0 }}</div>
                    <span class="text-[10px] sm:text-xs font-bold text-amber-600 mt-1 sm:mt-2 inline-block">Siap Anda ambil</span>
                </div>
            </div>

            <!-- Card 4: Selesai Bulan Ini -->
            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between min-w-0">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="mt-3 min-w-0">
                    <span class="text-[11px] sm:text-xs font-semibold text-slate-600 block truncate">Selesai Bulan Ini</span>
                    <div class="text-xl sm:text-3xl font-black text-emerald-600 mt-0.5 sm:mt-1">{{ $resolvedThisMonth ?? 0 }}</div>
                    <span class="text-[10px] sm:text-xs font-bold text-emerald-600 mt-1 sm:mt-2 inline-block">Kinerja pribadi</span>
                </div>
            </div>
        </div>

        <!-- Konten Grid: Daftar Tiket & Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start min-w-0">
            <!-- Kolom Kiri: Daftar Tiket (7 cols) -->
            <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 space-y-4 min-w-0">
                
                <!-- Main Scope Switcher (Tiket Saya / Belum Diambil / Tiket Tim) -->
                <div class="flex flex-wrap items-center gap-2 pb-3 border-b border-slate-100">
                    <a href="{{ route('teknisi.dashboard', ['scope' => 'my']) }}"
                        class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ ($scope ?? 'my') === 'my' ? 'bg-[#0f333a] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <span>📌 Tiket Saya</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ ($scope ?? 'my') === 'my' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-800' }}">
                            {{ $myActiveCount ?? 0 }}
                        </span>
                    </a>

                    <a href="{{ route('teknisi.dashboard', ['scope' => 'available']) }}"
                        class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ ($scope ?? '') === 'available' ? 'bg-[#0f333a] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <span>📥 Belum Diambil</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ ($scope ?? '') === 'available' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-900' }}">
                            {{ $availableCount ?? 0 }}
                        </span>
                    </a>

                    <a href="{{ route('teknisi.dashboard', ['scope' => 'all']) }}"
                        class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ ($scope ?? '') === 'all' ? 'bg-[#0f333a] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <span>👥 Tiket Tim Lain</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ ($scope ?? '') === 'all' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-800' }}">
                            {{ $teamTicketsCount ?? 0 }}
                        </span>
                    </a>
                </div>

                @if(($scope ?? 'my') === 'my')
                    <!-- Sub-Filter Khusus Tiket Saya -->
                    <div class="flex items-center justify-between gap-2 pt-1 pb-2">
                        <span class="text-xs font-bold text-slate-700">Filter Status:</span>
                        <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
                            <a href="{{ route('teknisi.dashboard', ['scope' => 'my', 'tab' => 'all']) }}"
                                class="px-2.5 py-1 text-[11px] font-bold rounded-lg transition {{ ($tab ?? 'all') === 'all' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                                Semua ({{ $totalMyTickets ?? 0 }})
                            </a>
                            <a href="{{ route('teknisi.dashboard', ['scope' => 'my', 'tab' => 'assigned']) }}"
                                class="px-2.5 py-1 text-[11px] font-bold rounded-lg transition {{ ($tab ?? '') === 'assigned' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                                Assigned ({{ $myAssignedCount ?? 0 }})
                            </a>
                            <a href="{{ route('teknisi.dashboard', ['scope' => 'my', 'tab' => 'in_progress']) }}"
                                class="px-2.5 py-1 text-[11px] font-bold rounded-lg transition {{ ($tab ?? '') === 'in_progress' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                                In Progress ({{ $myInProgressCount ?? 0 }})
                            </a>
                        </div>
                    </div>
                @endif

                <!-- List Tiket Dinamis -->
                <div class="space-y-3 min-w-0">
                    @forelse ($tickets as $t)
                        @php
                            $isSelected = isset($selectedTicket) && $selectedTicket->id === $t->id;
                        @endphp
                        <a href="{{ route('teknisi.dashboard', ['ticket_id' => $t->id, 'scope' => $scope ?? 'my', 'tab' => $tab ?? 'all']) }}"
                            class="block border-2 rounded-2xl p-4 transition shadow-xs min-w-0 {{ $isSelected ? 'border-teal-700 bg-teal-50/30' : 'border-slate-200 bg-white hover:border-slate-300' }}">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-1.5 min-w-0">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="text-xs font-mono font-bold text-teal-800 shrink-0">{{ $t->ticket_number }}</span>
                                    <span class="px-2.5 py-0.5 text-[10px] rounded-lg font-bold shrink-0 {{ $t->priority->badge_class ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $t->priority->name ?? 'Normal' }}
                                    </span>
                                </div>
                                <div class="text-left sm:text-right shrink-0">
                                    <span class="text-[11px] font-bold flex items-center {{ $t->status === 'in_progress' ? 'text-sky-600' : ($t->status === 'resolved' ? 'text-emerald-600' : 'text-amber-600') }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 shrink-0 {{ $t->status === 'in_progress' ? 'bg-sky-500' : ($t->status === 'resolved' ? 'bg-emerald-500' : 'bg-amber-500') }}"></span>
                                        {{ $t->status_label }}
                                    </span>
                                </div>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm mb-1 line-clamp-1 break-words">{{ $t->title }}</h3>
                            <div class="flex flex-wrap items-center justify-between text-xs text-slate-500 font-medium gap-1">
                                <span>📍 {{ $t->unit->name ?? 'Unit Umum' }} &bull; {{ $t->category->name ?? 'Kategori' }}</span>
                                <span class="text-[11px] text-slate-400">
                                    @if($t->technician)
                                        👤 Teknisi: <strong class="text-slate-700">{{ $t->technician->name }}</strong>
                                    @else
                                        <span class="text-amber-600 font-bold">⚠️ Belum Ada Teknisi</span>
                                    @endif
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center mx-auto mb-3 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-700 px-4">
                                @if(($scope ?? 'my') === 'available')
                                    Tidak ada tiket yang menunggu penanganan saat ini.
                                @elseif(($scope ?? 'my') === 'all')
                                    Tidak ada tiket tim lainnya yang sedang aktif.
                                @else
                                    Tidak ada tiket penanganan pada tab ini.
                                @endif
                            </p>
                            <p class="text-[11px] text-slate-400 mt-0.5 px-4">
                                @if(($scope ?? 'my') === 'available')
                                    Semua tiket baru sudah dialokasikan ke teknisi.
                                @else
                                    Tiket yang ditugaskan kepada Anda akan muncul di sini.
                                @endif
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Kanan: Detail Tiket & Form Aksi Teknisi (5 cols) -->
            <div class="lg:col-span-5 space-y-6 min-w-0">
                @if ($selectedTicket)
                    <!-- Detail Tiket & Ubah Status -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 space-y-4 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100 min-w-0">
                            <div class="min-w-0">
                                <h3 class="font-bold text-slate-900 text-sm break-words">Detail Tiket Terpilih</h3>
                                <span class="text-[11px] font-mono text-teal-800 font-bold block truncate">{{ $selectedTicket->ticket_number }}</span>
                            </div>
                            <span class="px-3 py-1 rounded-xl text-xs font-bold shrink-0 self-start sm:self-auto {{ $selectedTicket->status_badge_class }}">
                                {{ $selectedTicket->status_label }}
                            </span>
                        </div>

                        <div class="min-w-0">
                            <h4 class="font-bold text-slate-900 text-sm mb-1.5 break-words">{{ $selectedTicket->title }}</h4>
                            <p class="text-xs text-slate-700 bg-slate-50 p-3.5 rounded-xl border border-slate-100 leading-relaxed font-medium break-words">
                                {{ $selectedTicket->description }}
                            </p>

                            @php
                                $selectedAttachments = $selectedTicket->attachments_list;
                            @endphp
                            @if (!empty($selectedAttachments))
                                <div class="mt-3 min-w-0">
                                    <span class="text-[10px] text-slate-500 font-bold uppercase block mb-1.5">
                                        Lampiran Bukti Kendala ({{ count($selectedAttachments) }} Berkas)
                                    </span>
                                    <div class="grid grid-cols-2 gap-2 min-w-0">
                                        @foreach ($selectedAttachments as $att)
                                            @php
                                                $isVideo = \App\Models\Ticket::isVideoFile($att);
                                            @endphp
                                            <div class="bg-slate-50 p-2 rounded-xl border border-slate-200 min-w-0">
                                                @if ($isVideo)
                                                    <video controls preload="metadata" class="w-full h-24 rounded-lg bg-black object-cover">
                                                        <source src="{{ asset('storage/' . $att) }}">
                                                    </video>
                                                    <a href="{{ asset('storage/' . $att) }}" target="_blank" class="text-[10px] font-bold text-teal-700 block text-center mt-1 truncate">
                                                        Buka Video &rarr;
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $att) }}" target="_blank" class="block group">
                                                        <img src="{{ asset('storage/' . $att) }}" alt="Bukti" class="w-full h-24 rounded-lg border border-slate-200 object-cover group-hover:opacity-90">
                                                    </a>
                                                    <a href="{{ asset('storage/' . $att) }}" target="_blank" class="text-[10px] font-bold text-teal-700 block text-center mt-1 truncate">
                                                        Perbesar &rarr;
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-2 text-xs bg-slate-50 p-4 rounded-xl border border-slate-100 min-w-0">
                            <div class="flex justify-between gap-2"><span class="text-slate-500 font-medium shrink-0">Pelapor:</span> <span class="font-bold text-slate-900 text-right truncate">{{ $selectedTicket->reporter_name }}</span></div>
                            <div class="flex justify-between gap-2"><span class="text-slate-500 font-medium shrink-0">Kontak HP/WA:</span> <span class="font-bold text-emerald-700 text-right truncate">{{ $selectedTicket->reporter_contact }}</span></div>
                            <div class="flex justify-between gap-2"><span class="text-slate-500 font-medium shrink-0">Unit RSUD:</span> <span class="font-bold text-slate-900 text-right truncate">{{ $selectedTicket->unit->name ?? '-' }}</span></div>
                            <div class="flex justify-between gap-2"><span class="text-slate-500 font-medium shrink-0">Kategori:</span> <span class="font-bold text-slate-900 text-right truncate">{{ $selectedTicket->category->name ?? '-' }}</span></div>
                            <div class="flex justify-between gap-2"><span class="text-slate-500 font-medium shrink-0">Prioritas:</span> <span class="font-bold text-rose-600 text-right">{{ $selectedTicket->priority->name ?? 'Normal' }} (SLA: {{ $selectedTicket->priority->sla_hours ?? '-' }} jam)</span></div>
                            <div class="flex justify-between gap-2"><span class="text-slate-500 font-medium shrink-0">Teknisi Bertugas:</span> <span class="font-bold text-teal-800 text-right">{{ $selectedTicket->technician->name ?? 'Belum Ditugaskan' }}</span></div>
                        </div>

                        @if ($selectedTicket->rating)
                            <div class="p-3.5 bg-amber-50 rounded-xl border border-amber-200 text-xs min-w-0">
                                <span class="text-[10px] text-amber-800 font-bold uppercase tracking-wider block mb-1">Penilaian dari Pelapor / Ruangan</span>
                                <div class="flex items-center gap-1 text-amber-600 font-bold text-sm">
                                    <span>{{ $selectedTicket->rating }} ★</span>
                                    <span class="text-xs text-amber-800 font-medium">({{ $selectedTicket->rating }} dari 5 Bintang)</span>
                                </div>
                                @if ($selectedTicket->feedback)
                                    <p class="text-slate-700 mt-1 italic font-medium break-words">"{{ $selectedTicket->feedback }}"</p>
                                @endif
                            </div>
                        @endif

                        @php
                            $latestRevisionLog = $selectedTicket->statusLogs->where('status', 'in_progress')->sortByDesc('created_at')->first();
                        @endphp
                        @if($selectedTicket->status === 'in_progress' && $latestRevisionLog && str_contains($latestRevisionLog->note, 'Supervisor meminta perbaikan'))
                            <div class="p-3.5 bg-rose-50 rounded-xl border border-rose-200 text-xs text-rose-900 font-medium">
                                <span class="text-[10px] text-rose-800 font-bold uppercase tracking-wider block mb-1">⚠️ Perlu Revisi / Perbaikan Ulang Software</span>
                                <p class="text-rose-950 font-bold leading-relaxed">{{ $latestRevisionLog->note }}</p>
                            </div>
                        @endif

                        @if ($selectedTicket->status === 'pending_review')
                            <div class="p-3.5 bg-purple-50 rounded-xl border border-purple-200 text-xs text-purple-900 font-medium">
                                <span class="text-[10px] text-purple-800 font-bold uppercase tracking-wider block mb-1">Status: Menunggu Review Supervisor</span>
                                <p class="text-purple-950 font-semibold">Perbaikan software telah diajukan dan saat ini sedang menunggu review / verifikasi fungsi dari Supervisor IT.</p>
                            </div>
                        @endif

                        <!-- Aksi Teknisi: Ambil Tiket ATAU Update Status -->
                        @if ($selectedTicket->assigned_to !== Auth::id())
                            <!-- Jika tiket belum di-assign atau milik orang lain dan ingin diambil -->
                            <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 space-y-2.5">
                                <span class="text-xs font-black text-emerald-900 block">Tiket ini belum berada di bawah tanggung jawab Anda.</span>
                                <p class="text-[11px] text-emerald-700">Anda dapat mengambil tiket ini untuk mulai mengerjakannya dan memasukkannya ke daftar Tiket Saya.</p>
                                <form action="{{ route('teknisi.tickets.claim', $selectedTicket->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs py-3 px-4 rounded-xl shadow-xs transition flex items-center justify-center gap-2">
                                        <span>🚀</span>
                                        <span>Ambil &amp; Kerjakan Tiket Ini</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Jika tiket ditugaskan ke saya: Form Ubah Status -->
                            <form action="{{ route('teknisi.status.update', $selectedTicket->id) }}" method="POST" class="space-y-3 pt-2 min-w-0">
                                @csrf
                                <div class="min-w-0">
                                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Update Status Penanganan
                                    </label>
                                    <select name="status" id="status" required class="w-full rounded-xl border-slate-200 bg-white text-slate-800 text-xs font-bold focus:border-teal-700 focus:ring-teal-700">
                                        <option value="in_progress" {{ in_array($selectedTicket->status, ['assigned', 'in_progress']) ? 'selected' : '' }}>
                                            Sedang Dikerjakan (In Progress)
                                        </option>
                                        <option value="resolved" {{ in_array($selectedTicket->status, ['resolved', 'pending_review']) ? 'selected' : '' }}>
                                            @if($selectedTicket->requiresReview())
                                                Selesai Dikerjakan (Ajukan Review ke Supervisor)
                                            @else
                                                Selesai Ditangani (Resolved)
                                            @endif
                                        </option>
                                    </select>
                                </div>

                                <div class="min-w-0">
                                    <label for="resolution_notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Catatan / Solusi Teknis Perbaikan
                                    </label>
                                    <textarea name="resolution_notes" id="resolution_notes" rows="3" required
                                        placeholder="Jelaskan tindakan yang dilakukan (misal: penggantian kabel LAN, konfigurasi IP, perbaikan printer)..."
                                        class="w-full rounded-xl border-slate-200 bg-white text-slate-800 text-xs font-medium focus:border-teal-700 focus:ring-teal-700 placeholder-slate-400">{{ old('resolution_notes', $selectedTicket->resolution_notes) }}</textarea>
                                </div>

                                <button type="submit" class="w-full bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs py-3 px-4 rounded-xl shadow-xs transition">
                                    Simpan Update Tiket
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($selectedTicket->assigned_to === Auth::id())
                        <!-- Log Aktivitas & Catatan Tambahan -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 space-y-4 min-w-0">
                            <h3 class="font-bold text-sm text-slate-900 break-words">Catatan Tambahan Teknisi</h3>

                            <form action="{{ route('teknisi.notes.store', $selectedTicket->id) }}" method="POST" class="space-y-2 min-w-0">
                                @csrf
                                <textarea name="note" rows="2" required placeholder="Tulis progres atau kendala teknis tambahan..."
                                    class="w-full rounded-xl border-slate-200 bg-white text-slate-800 text-xs font-medium focus:border-teal-700 focus:ring-teal-700 placeholder-slate-400"></textarea>
                                <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs py-2 rounded-xl transition">
                                    Tambah Catatan
                                </button>
                            </form>

                            <div class="space-y-2 pt-2 border-t border-slate-100 min-w-0">
                                @forelse ($selectedTicket->notes as $note)
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs min-w-0">
                                        <div class="flex justify-between items-center text-[10px] text-slate-400 mb-1 gap-2 min-w-0">
                                            <span class="font-bold text-slate-800 truncate">{{ $note->user->name ?? 'Teknisi' }}</span>
                                            <span class="shrink-0">{{ $note->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <p class="text-slate-700 break-words">{{ $note->note }}</p>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 text-center py-2">Belum ada catatan aktivitas.</p>
                                @endforelse
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-8 sm:p-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                        </svg>
                        <p class="text-xs font-bold text-slate-700 px-2">Pilih salah satu tiket di sebelah kiri</p>
                        <p class="text-[11px] text-slate-400 mt-0.5 px-2">Untuk melihat detail lengkap dan mengambil / memperbarui status tiket.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>