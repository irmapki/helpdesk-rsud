<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                Tiket Penanganan Kendala (Teknisi IT)
            </h1>
            <p class="text-xs text-slate-500 mt-1">Daftar tiket pengaduan aktif yang ditugaskan kepada Anda oleh Tim Dispatch Helpdesk</p>
        </div>

        <!-- 4 Statistik Cards Teknisi (Light Mode) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider block mb-1">Baru Ditugaskan</span>
                <div class="text-3xl font-black text-slate-900 mt-1">{{ $assignedCount ?? 0 }}</div>
                <span class="text-[11px] font-bold text-rose-600 mt-2 inline-block">Belum dikerjakan</span>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider block mb-1">Sedang Dikerjakan</span>
                <div class="text-3xl font-black text-sky-700 mt-1">{{ $inProgressCount ?? 0 }}</div>
                <span class="text-[11px] font-bold text-sky-600 mt-2 inline-block">In progress di lokasi</span>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider block mb-1">Selesai Bulan Ini</span>
                <div class="text-3xl font-black text-emerald-700 mt-1">{{ $resolvedThisMonth ?? 0 }}</div>
                <span class="text-[11px] font-bold text-emerald-600 mt-2 inline-block">Tiket tuntas</span>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <span class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider block mb-1">Mendekati SLA</span>
                <div class="text-3xl font-black text-amber-600 mt-1">{{ $approachingSlaCount ?? 0 }}</div>
                <span class="text-[11px] font-bold text-amber-600 mt-2 inline-block">Prioritas penanganan</span>
            </div>
        </div>

        <!-- Konten Grid: Daftar Tiket & Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Kolom Kiri: Daftar Tiket (7 cols - Light Mode) -->
            <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-7 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-black text-slate-900">Daftar Tiket Ditugaskan</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Tiket kendala yang dialokasikan Admin kepada Anda</p>
                    </div>

                    <!-- Filter Tab -->
                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-2xl">
                        <a href="{{ route('teknisi.dashboard', ['tab' => 'all']) }}"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ ($tab ?? 'all') === 'all' ? 'bg-emerald-800 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                            Semua ({{ $totalMyTickets ?? 0 }})
                        </a>
                        <a href="{{ route('teknisi.dashboard', ['tab' => 'assigned']) }}"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ ($tab ?? '') === 'assigned' ? 'bg-emerald-800 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                            Assigned ({{ $assignedCount ?? 0 }})
                        </a>
                        <a href="{{ route('teknisi.dashboard', ['tab' => 'in_progress']) }}"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl transition {{ ($tab ?? '') === 'in_progress' ? 'bg-emerald-800 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                            In Progress ({{ $inProgressCount ?? 0 }})
                        </a>
                    </div>
                </div>

                <!-- List Tiket Dinamis -->
                <div class="space-y-3">
                    @forelse ($tickets as $t)
                        @php
                            $isSelected = isset($selectedTicket) && $selectedTicket->id === $t->id;
                        @endphp
                        <a href="{{ route('teknisi.dashboard', ['ticket_id' => $t->id, 'tab' => $tab ?? 'all']) }}"
                            class="block border-2 rounded-2xl p-4 transition shadow-xs {{ $isSelected ? 'border-emerald-600 bg-emerald-50/40' : 'border-slate-200 bg-white hover:border-slate-300' }}">
                            <div class="flex justify-between items-start mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-black text-emerald-800">{{ $t->ticket_number }}</span>
                                    <span class="px-2.5 py-0.5 text-[10px] rounded-lg font-black border {{ $t->priority->badge_class ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $t->priority->name ?? 'Normal' }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[11px] font-bold flex items-center justify-end {{ $t->status === 'in_progress' ? 'text-sky-600' : ($t->status === 'resolved' ? 'text-emerald-600' : 'text-amber-600') }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $t->status === 'in_progress' ? 'bg-sky-500' : ($t->status === 'resolved' ? 'bg-emerald-500' : 'bg-amber-500') }}"></span>
                                        {{ $t->status_label }}
                                    </span>
                                </div>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm mb-1 line-clamp-1">{{ $t->title }}</h3>
                            <p class="text-xs text-slate-500 font-medium">
                                {{ $t->unit->name ?? 'Unit Umum' }} &bull; {{ $t->category->name ?? 'Kategori' }} &bull; {{ $t->created_at->diffForHumans() }}
                            </p>
                        </a>
                    @empty
                        <div class="text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-700">Tidak ada tiket penanganan pada tab ini.</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tiket yang ditugaskan oleh Admin akan muncul di sini secara otomatis.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Kanan: Detail Tiket & Form Aksi Teknisi (5 cols - Light Mode) -->
            <div class="lg:col-span-5 space-y-6">
                @if ($selectedTicket)
                    <!-- Detail Tiket & Ubah Status -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-7 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 class="font-black text-slate-900 text-sm">Detail Tiket Terpilih</h3>
                                <span class="text-[11px] font-mono text-emerald-800 font-bold">{{ $selectedTicket->ticket_number }}</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black border {{ $selectedTicket->status_badge_class }}">
                                {{ $selectedTicket->status_label }}
                            </span>
                        </div>

                        <div>
                            <h4 class="font-black text-slate-900 text-sm mb-1.5">{{ $selectedTicket->title }}</h4>
                            <p class="text-xs text-slate-700 bg-slate-50 p-3.5 rounded-2xl border border-slate-100 leading-relaxed font-medium">
                                {{ $selectedTicket->description }}
                            </p>

                            @php
                                $selectedAttachments = $selectedTicket->attachments_list;
                            @endphp
                            @if (!empty($selectedAttachments))
                                <div class="mt-3">
                                    <span class="text-[10px] text-slate-500 font-extrabold uppercase block mb-1.5">
                                        Lampiran Bukti Kendala ({{ count($selectedAttachments) }} Berkas)
                                    </span>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach ($selectedAttachments as $att)
                                            @php
                                                $isVideo = \App\Models\Ticket::isVideoFile($att);
                                            @endphp
                                            <div class="bg-slate-50 p-2 rounded-xl border border-slate-200">
                                                @if ($isVideo)
                                                    <video controls preload="metadata" class="w-full h-24 rounded-lg bg-black object-cover">
                                                        <source src="{{ asset('storage/' . $att) }}">
                                                    </video>
                                                    <a href="{{ asset('storage/' . $att) }}" target="_blank" class="text-[10px] font-bold text-emerald-700 block text-center mt-1">
                                                        Buka Video &rarr;
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $att) }}" target="_blank" class="block group">
                                                        <img src="{{ asset('storage/' . $att) }}" alt="Bukti" class="w-full h-24 rounded-lg border border-slate-200 object-cover group-hover:opacity-90">
                                                    </a>
                                                    <a href="{{ asset('storage/' . $att) }}" target="_blank" class="text-[10px] font-bold text-emerald-700 block text-center mt-1">
                                                        Perbesar &rarr;
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-2 text-xs bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="flex justify-between"><span class="text-slate-500 font-medium">Pelapor:</span> <span class="font-bold text-slate-900">{{ $selectedTicket->reporter_name }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500 font-medium">Kontak HP/WA:</span> <span class="font-bold text-emerald-700">{{ $selectedTicket->reporter_contact }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500 font-medium">Unit:</span> <span class="font-bold text-slate-900">{{ $selectedTicket->unit->name ?? '-' }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500 font-medium">Kategori:</span> <span class="font-bold text-slate-900">{{ $selectedTicket->category->name ?? '-' }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500 font-medium">Prioritas:</span> <span class="font-bold text-rose-600">{{ $selectedTicket->priority->name ?? 'Normal' }} (SLA: {{ $selectedTicket->priority->sla_hours ?? '-' }} jam)</span></div>
                        </div>

                        <!-- Form Aksi / Ubah Status & Catatan -->
                        <form action="{{ route('teknisi.status.update', $selectedTicket->id) }}" method="POST" class="space-y-3 pt-2">
                            @csrf
                            <div>
                                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                    Update Status Penanganan
                                </label>
                                <select name="status" id="status" required class="w-full rounded-xl border-slate-200 bg-white text-slate-800 text-xs font-bold focus:border-emerald-600 focus:ring-emerald-600">
                                    <option value="in_progress" {{ $selectedTicket->status === 'in_progress' ? 'selected' : '' }}>
                                        Sedang Dikerjakan (In Progress)
                                    </option>
                                    <option value="resolved" {{ $selectedTicket->status === 'resolved' ? 'selected' : '' }}>
                                        Selesai Ditangani (Resolved)
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label for="resolution_notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                    Catatan / Solusi Teknis Perbaikan
                                </label>
                                <textarea name="resolution_notes" id="resolution_notes" rows="3" required
                                    placeholder="Jelaskan tindakan yang dilakukan (misal: penggantian kabel LAN, konfigurasi IP, perbaikan printer)..."
                                    class="w-full rounded-xl border-slate-200 bg-white text-slate-800 text-xs font-medium focus:border-emerald-600 focus:ring-emerald-600 placeholder-slate-400">{{ old('resolution_notes', $selectedTicket->resolution_notes) }}</textarea>
                            </div>

                            <button type="submit" class="w-full bg-emerald-800 hover:bg-emerald-900 text-white font-extrabold text-xs py-3 px-4 rounded-xl shadow-xs transition">
                                Simpan Update Tiket
                            </button>
                        </form>
                    </div>

                    <!-- Log Aktivitas & Catatan Tambahan -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                        <h3 class="font-black text-sm text-slate-900">Catatan Tambahan Teknisi</h3>

                        <form action="{{ route('teknisi.notes.store', $selectedTicket->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <textarea name="note" rows="2" required placeholder="Tulis progres atau kendala teknis tambahan..."
                                class="w-full rounded-xl border-slate-200 bg-white text-slate-800 text-xs font-medium focus:border-emerald-600 focus:ring-emerald-600 placeholder-slate-400"></textarea>
                            <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs py-2 rounded-xl transition">
                                Tambah Catatan
                            </button>
                        </form>

                        <div class="space-y-2 pt-2 border-t border-slate-100">
                            @forelse ($selectedTicket->notes as $note)
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                                    <div class="flex justify-between items-center text-[10px] text-slate-400 mb-1">
                                        <span class="font-bold text-slate-800">{{ $note->user->name ?? 'Teknisi' }}</span>
                                        <span>{{ $note->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="text-slate-700">{{ $note->note }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 text-center py-2">Belum ada catatan aktivitas.</p>
                            @endforelse
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-3xl border border-dashed border-slate-200 p-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                        </svg>
                        <p class="text-xs font-bold text-slate-700">Pilih salah satu tiket di sebelah kiri</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Untuk melihat detail lengkap dan mengubah status penanganan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>