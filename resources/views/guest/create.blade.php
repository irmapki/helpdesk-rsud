<x-guest-portal-layout>
    <div class="py-4 sm:py-10">
        <div class="max-w-3xl mx-auto px-2.5 sm:px-6 lg:px-8 w-full min-w-0">
            <!-- Header Card -->
            <div class="mb-6 sm:mb-8 text-center px-1 sm:px-2 min-w-0">
                <div class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-100 mb-3 shadow-xs shrink-0">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h1 class="text-base sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-snug break-words">Formulir Pengaduan Layanan IT RSUD RAA. SOEWONDO</h1>
                <p class="text-[11px] sm:text-sm text-slate-500 mt-2 font-medium max-w-xl mx-auto px-1">Sampaikan kendala teknis Anda. Tim Helpdesk IT RSUD akan segera memverifikasi dan menugaskan teknisi.</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-md p-3.5 sm:p-9 min-w-0 overflow-hidden">
                <form action="{{ route('guest.ticket.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 sm:space-y-7 min-w-0">
                    @csrf

                    <!-- Section 1: Data Pelapor -->
                    <div class="border-b border-slate-100 pb-6 sm:pb-7 min-w-0">
                        <h2 class="text-xs sm:text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-emerald-100 text-emerald-800 text-[11px] sm:text-xs flex items-center justify-center font-black shrink-0">1</span>
                            Data Identitas Pelapor
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 min-w-0">
                            <div class="min-w-0">
                                <label for="guest_name" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 truncate">
                                    Nama Lengkap Pelapor <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name') }}" required
                                    placeholder="Contoh: dr. Ahmad / Ns. Siti"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 focus:bg-white transition @error('guest_name') border-rose-500 @enderror">
                                @error('guest_name')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="min-w-0">
                                <label for="guest_phone" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 truncate">
                                    No. WhatsApp / HP Aktif <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="guest_phone" id="guest_phone" value="{{ old('guest_phone') }}" required
                                    inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    placeholder="Contoh: 081234567890"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 focus:bg-white transition @error('guest_phone') border-rose-500 @enderror">
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">*Hanya boleh diisi angka (tanpa spasi, plus, atau simbol).</p>
                                @error('guest_phone')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2 min-w-0">
                                <label for="guest_email" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 truncate">
                                    Email (Opsional)
                                </label>
                                <input type="email" name="guest_email" id="guest_email" value="{{ old('guest_email') }}"
                                    placeholder="nama@rsud.go.id / email aktif"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 focus:bg-white transition @error('guest_email') border-rose-500 @enderror">
                                @error('guest_email')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Lokasi & Kategori -->
                    <div class="border-b border-slate-100 pb-6 sm:pb-7 min-w-0">
                        <h2 class="text-xs sm:text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-emerald-100 text-emerald-800 text-[11px] sm:text-xs flex items-center justify-center font-black shrink-0">2</span>
                            Lokasi &amp; Kategori Kendala
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 min-w-0">
                            <div class="sm:col-span-1 min-w-0">
                                <label for="unit_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 truncate">
                                    Unit / Instalasi / Ruangan <span class="text-rose-500">*</span>
                                </label>
                                <select name="unit_id" id="unit_id" required onchange="toggleCustomUnitInput(this.value)"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 focus:bg-white transition @error('unit_id') border-rose-500 @enderror truncate">
                                    <option value="">-- Pilih Unit / Ruangan RSUD --</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }} {{ $unit->location ? "({$unit->location})" : '' }}
                                        </option>
                                    @endforeach
                                    <option value="other" {{ old('unit_id') == 'other' || old('custom_unit_name') ? 'selected' : '' }} class="font-bold text-emerald-800 bg-emerald-50">
                                        + Ruangan Tidak Ada di Pilihan (Ketik Manual)
                                    </option>
                                </select>
                                @error('unit_id')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror

                                <!-- Input Box Ketik Ruangan Manual -->
                                <div id="custom_unit_wrapper" class="{{ old('unit_id') == 'other' || old('custom_unit_name') ? '' : 'hidden' }} mt-3 p-3 bg-emerald-50/80 border border-emerald-200 rounded-2xl min-w-0">
                                    <label for="custom_unit_name" class="block text-[11px] sm:text-xs font-bold text-emerald-950 uppercase tracking-wider mb-1 truncate">
                                        Ketik Nama Ruangan / Unit Anda <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="custom_unit_name" id="custom_unit_name" value="{{ old('custom_unit_name') }}"
                                        placeholder="Contoh: Poli Eksekutif / Ruang ICU 2"
                                        class="w-full rounded-xl border-slate-200 bg-white/90 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 @error('custom_unit_name') border-rose-500 @enderror">
                                    <p class="text-[10px] text-emerald-700 font-medium mt-1">Nama ruangan ini akan otomatis didaftarkan dan disimpan ke sistem.</p>
                                    @error('custom_unit_name')
                                        <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="min-w-0">
                                <label for="category_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 truncate">
                                    Kategori Masalah <span class="text-rose-500">*</span>
                                </label>
                                <select name="category_id" id="category_id" required
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 focus:bg-white transition @error('category_id') border-rose-500 @enderror truncate">
                                    <option value="">-- Pilih Kategori Kendala --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2 min-w-0">
                                <label for="priority_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 truncate">
                                    Perkiraan Tingkat Urgensi
                                </label>
                                <select name="priority_id" id="priority_id"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 focus:bg-white transition truncate">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}" {{ old('priority_id', 2) == $priority->id ? 'selected' : '' }}>
                                            {{ $priority->name }} (Target SLA: {{ $priority->sla_hours }} Jam)
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[10px] sm:text-[11px] text-slate-400 mt-1 font-medium">*Admin IT akan memvalidasi kembali tingkat prioritas akhir saat triage tiket.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Rincian Kendala -->
                    <div class="pb-2 min-w-0">
                        <h2 class="text-xs sm:text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-emerald-100 text-emerald-800 text-[11px] sm:text-xs flex items-center justify-center font-black shrink-0">3</span>
                            Rincian Pengaduan &amp; Lampiran
                        </h2>

                        <div class="space-y-4 sm:space-y-5 min-w-0">
                            <div class="min-w-0">
                                <label for="title" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 truncate">
                                    Judul Ringkas Masalah <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    placeholder="Contoh: Printer resep error / Komputer kasir mati"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 focus:bg-white transition @error('title') border-rose-500 @enderror">
                                @error('title')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="min-w-0">
                                <label for="description" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 truncate">
                                    Deskripsi Lengkap Kendala <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4" required
                                    placeholder="Jelaskan secara detail kendala yang dialami, pesan error, atau langkah yang sudah dicoba..."
                                    class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 focus:bg-white transition @error('description') border-rose-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upload multiple file & Paste Support via ContentEditable Box -->
                            <div class="min-w-0">
                                <label for="attachments" class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 truncate">
                                    Unggah Bukti Kendala (Foto &amp; Video)
                                </label>

                                <!-- Kotak interaktif upload file, foto kamera, dan paste clipboard -->
                                <div id="drop-zone" contenteditable="true" onpaste="handlePaste(event)"
                                    class="w-full border border-slate-200 bg-slate-50/60 rounded-2xl p-3 sm:p-4 flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 focus:outline-none transition group cursor-text relative">
                                    
                                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 sm:gap-2.5 w-full sm:w-auto min-w-0 pointer-events-none order-1">
                                        <!-- Tombol 1: Pilih File dari Galeri / Folder -->
                                        <button type="button" onclick="event.stopPropagation(); document.getElementById('attachments').click();" 
                                            class="pointer-events-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-800 text-white text-xs font-bold hover:bg-emerald-900 transition shrink-0 shadow-sm active:scale-95 cursor-pointer">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            <span>Pilih File</span>
                                        </button>

                                        <!-- Tombol 2: Ambil Foto Kamera Langsung (HP / Webcam Laptop) -->
                                        <button type="button" onclick="event.stopPropagation(); triggerCamera();" 
                                            class="pointer-events-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-teal-700 text-white text-xs font-bold hover:bg-teal-800 transition shrink-0 shadow-sm active:scale-95 cursor-pointer">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span>Buka Kamera</span>
                                        </button>

                                        <span id="file-chosen-text" class="text-xs text-slate-500 font-medium truncate py-1">
                                            Tidak ada file yang dipilih
                                        </span>
                                    </div>

                                    <!-- Span tersembunyi di awal baris agar kursor fokus di sisi kiri -->
                                    <span id="cursor-anchor" class="inline-block w-0 h-0 overflow-hidden select-none outline-none focus:outline-none order-0 shrink-0"></span>

                                    <div class="text-[11px] text-slate-400 font-medium text-left sm:text-right shrink-0 pointer-events-none select-none order-2 sm:order-2 ml-auto">
                                        Klik &amp; tekan <kbd class="px-1.5 py-0.5 text-[10px] font-semibold text-slate-700 bg-white border border-slate-200 rounded shadow-2xs">Ctrl+V</kbd> untuk paste gambar
                                    </div>

                                    <!-- Input file galeri tersembunyi -->
                                    <div class="hidden">
                                        <input type="file" name="attachments[]" id="attachments" multiple accept="image/*,video/*,.heic,.heif" onchange="handleFileSelect(event)">
                                        <!-- Input kamera native mobile -->
                                        <input type="file" id="camera-native-input" accept="image/*" capture="environment" onchange="handleFileSelect(event)">
                                    </div>
                                </div>
                                
                                <p class="text-[10px] sm:text-[11px] text-slate-400 mt-1.5 font-medium flex items-start sm:items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Bisa <strong>Pilih File</strong>, <strong>Buka Kamera (HP/Laptop)</strong>, atau langsung <strong>Paste (Ctrl+V)</strong> screenshot ke dalam kotak.</span>
                                </p>

                                <div id="preview-container" class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 mt-3 hidden min-w-0"></div>

                                @error('attachments')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                                @error('attachments.*')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Actions -->
                    <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 min-w-0">
                        <a href="{{ route('guest.landing') }}" class="text-xs sm:text-sm font-bold text-slate-500 hover:text-slate-700 text-center sm:text-left py-2">
                            &larr; Kembali ke Beranda
                        </a>

                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-800 hover:bg-emerald-900 text-white font-extrabold px-6 sm:px-8 py-3.5 rounded-2xl shadow-lg shadow-emerald-900/25 transition active:scale-95 text-xs sm:text-sm">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                            <span>Kirim Pengaduan Sekarang</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Live Webcam Laptop / Komputer dengan Tombol Switch Mirror -->
    <div id="webcam-modal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-5 sm:p-6 shadow-2xl space-y-4 text-slate-900">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Kamera Webcam Langsung</h3>
                        <p class="text-[11px] text-slate-500">Arahkan kamera ke perangkat kendala lalu jepret foto</p>
                    </div>
                </div>
                <button type="button" onclick="closeWebcamModal()" class="text-slate-400 hover:text-slate-700 font-bold text-lg p-1">&times;</button>
            </div>

            <!-- Area Video Live Preview -->
            <div class="relative bg-black rounded-2xl overflow-hidden aspect-video flex items-center justify-center">
                <video id="webcam-video" autoplay playsinline class="w-full h-full object-cover transition-transform duration-200"></video>
                <canvas id="webcam-canvas" class="hidden"></canvas>
                
                <!-- Tombol Switch Mirror di atas Frame Video -->
                <button type="button" id="mirror-toggle-btn" onclick="toggleMirrorMode()" class="absolute top-3 right-3 bg-black/60 hover:bg-black/80 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg backdrop-blur-md transition flex items-center gap-1.5 shadow-md">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    <span id="mirror-status-text">Mirror: OFF</span>
                </button>
            </div>

            <div class="flex items-center justify-between gap-3 pt-2">
                <button type="button" onclick="closeWebcamModal()" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="button" onclick="snapWebcamPhoto()" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-md transition flex items-center gap-2 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    <span>Jepret Foto</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        let selectedFiles = [];
        let webcamStream = null;
        let isMirrorEnabled = false; // Status awal Mirror (OFF)

        function toggleCustomUnitInput(value) {
            const wrapper = document.getElementById('custom_unit_wrapper');
            const customInput = document.getElementById('custom_unit_name');
            if (value === 'other') {
                wrapper.classList.remove('hidden');
                customInput.focus();
                customInput.setAttribute('required', 'required');
            } else {
                wrapper.classList.add('hidden');
                customInput.removeAttribute('required');
            }
        }

        // Fungsi untuk mengaktifkan/menonaktifkan mode mirror secara live
        function toggleMirrorMode() {
            isMirrorEnabled = !isMirrorEnabled;
            const video = document.getElementById('webcam-video');
            const statusText = document.getElementById('mirror-status-text');

            if (isMirrorEnabled) {
                video.style.transform = 'scaleX(-1)';
                statusText.textContent = 'Mirror: ON';
            } else {
                video.style.transform = 'scaleX(1)';
                statusText.textContent = 'Mirror: OFF';
            }
        }

        // Pemicu Kamera: Jika mobile langsung buka kamera HP, jika laptop/desktop buka modal Webcam
        function triggerCamera() {
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            if (isMobile) {
                // Di HP: picu kamera bawaan HP secara instan
                document.getElementById('camera-native-input').click();
            } else {
                // Di Laptop: buka live webcam modal jika didukung browser
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    openWebcamModal();
                } else {
                    document.getElementById('camera-native-input').click();
                }
            }
        }

        async function openWebcamModal() {
            const modal = document.getElementById('webcam-modal');
            const video = document.getElementById('webcam-video');
            
            // Set default mirror ke OFF saat pertama kali buka modal
            isMirrorEnabled = false;
            video.style.transform = 'scaleX(1)';
            document.getElementById('mirror-status-text').textContent = 'Mirror: OFF';

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            try {
                webcamStream = await navigator.mediaDevices.getUserMedia({
                    video: { width: { ideal: 1280 }, height: { ideal: 720 }, facingMode: 'environment' },
                    audio: false
                });
                video.srcObject = webcamStream;
            } catch (err) {
                console.error("Gagal membuka webcam:", err);
                closeWebcamModal();
                document.getElementById('camera-native-input').click();
            }
        }

        function closeWebcamModal() {
            const modal = document.getElementById('webcam-modal');
            const video = document.getElementById('webcam-video');
            if (webcamStream) {
                webcamStream.getTracks().forEach(track => track.stop());
                webcamStream = null;
            }
            if (video) {
                video.srcObject = null;
            }
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function snapWebcamPhoto() {
            const video = document.getElementById('webcam-video');
            const canvas = document.getElementById('webcam-canvas');
            if (!video || !canvas) return;

            canvas.width = video.videoWidth || 1280;
            canvas.height = video.videoHeight || 720;
            const ctx = canvas.getContext('2d');

            ctx.save();
            // Jika mode mirror aktif saat menjepret, balikkan hasil render canvas agar sesuai dengan preview
            if (isMirrorEnabled) {
                ctx.scale(-1, 1);
                ctx.drawImage(video, -canvas.width, 0, canvas.width, canvas.height);
            } else {
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            }
            ctx.restore();

            canvas.toBlob(blob => {
                if (blob) {
                    const now = new Date();
                    const timestamp = now.toISOString().slice(0,10).replace(/-/g,"") + '_' + now.toTimeString().slice(0,8).replace(/:/g,"");
                    const file = new File([blob], `foto_kamera_${timestamp}.jpg`, { type: 'image/jpeg' });
                    selectedFiles.push(file);
                    updateFileInputAndPreview();
                }
                closeWebcamModal();
            }, 'image/jpeg', 0.88);
        }

        // Paksa kursor selalu fokus di awal (sebelah kiri tombol) saat area diklik di luar tombol
        document.getElementById('drop-zone').addEventListener('click', function(e) {
            if (e.target.tagName !== 'BUTTON' && !e.target.closest('button')) {
                const range = document.createRange();
                const sel = window.getSelection();
                const anchor = document.getElementById('cursor-anchor');
                range.setStartBefore(anchor);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        });

        function handleFileSelect(event) {
            const input = event.target;
            const files = Array.from(input.files);
            files.forEach(file => selectedFiles.push(file));
            input.value = ''; 
            updateFileInputAndPreview();
        }

        // Tangkap Paste (Ctrl+V) gambar dari clipboard
        function handlePaste(event) {
            const items = (event.clipboardData || event.originalEvent.clipboardData).items;
            let added = false;
            for (let i = 0; i < items.length; i++) {
                if (items[i].type.indexOf('image') !== -1) {
                    const file = items[i].getAsFile();
                    if (file) {
                        const timestamp = new Date().toISOString().slice(0,10).replace(/-/g,"");
                        const extension = file.type.split('/')[1] || 'png';
                        const renamedFile = new File([file], `screenshot_${timestamp}_${Math.random().toString(36).substring(2,7)}.${extension}`, { type: file.type });
                        selectedFiles.push(renamedFile);
                        added = true;
                    }
                }
            }
            if (added) {
                event.preventDefault();
                updateFileInputAndPreview();
            }
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            updateFileInputAndPreview();
        }

        function updateFileInputAndPreview() {
            const input = document.getElementById('attachments');
            const container = document.getElementById('preview-container');
            const fileChosenText = document.getElementById('file-chosen-text');
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;

            if (selectedFiles.length === 0) {
                fileChosenText.textContent = "Tidak ada file yang dipilih";
            } else if (selectedFiles.length === 1) {
                fileChosenText.textContent = selectedFiles[0].name;
            } else {
                fileChosenText.textContent = `${selectedFiles.length} file dipilih`;
            }

            container.innerHTML = '';
            if (selectedFiles.length === 0) {
                container.classList.add('hidden');
                return;
            }
            container.classList.remove('hidden');

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                const wrapperDiv = document.createElement('div');
                wrapperDiv.className = 'relative group bg-slate-50 border border-slate-200 rounded-xl p-2 flex flex-col items-center justify-center h-28 overflow-hidden shadow-xs';

                reader.onload = function(e) {
                    if (file.type.startsWith('image/')) {
                        wrapperDiv.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-20 object-cover rounded-lg">
                            <span class="text-[10px] text-slate-500 font-medium truncate w-full text-center mt-1">${file.name}</span>
                            <button type="button" onclick="removeFile(${index})" class="absolute top-1 right-1 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1 shadow-md transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        `;
                    } else if (file.type.startsWith('video/')) {
                        wrapperDiv.innerHTML = `
                            <div class="w-full h-20 bg-slate-900 rounded-lg flex items-center justify-center text-white">
                                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="text-[10px] text-slate-500 font-medium truncate w-full text-center mt-1">${file.name}</span>
                            <button type="button" onclick="removeFile(${index})" class="absolute top-1 right-1 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1 shadow-md transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        `;
                    }
                }

                if (file.type.startsWith('image/') || file.type.startsWith('video/')) {
                    reader.readAsDataURL(file);
                } else {
                    wrapperDiv.innerHTML = `
                        <div class="w-full h-20 bg-slate-200 rounded-lg flex items-center justify-center text-slate-600 font-bold text-xs">FILE</div>
                        <span class="text-[10px] text-slate-500 font-medium truncate w-full text-center mt-1">${file.name}</span>
                        <button type="button" onclick="removeFile(${index})" class="absolute top-1 right-1 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1 shadow-md transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    `;
                }
                container.appendChild(wrapperDiv);
            });
        }
    </script>
</x-guest-portal-layout>