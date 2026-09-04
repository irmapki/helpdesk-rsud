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

                                <!-- Kotak interaktif berbasis contenteditable dengan kursor rapi di sebelah kiri tombol -->
                                <div id="drop-zone" contenteditable="true" onpaste="handlePaste(event)"
                                    class="w-full border border-slate-200 bg-slate-50/60 rounded-xl p-3 sm:p-4 flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 focus:outline-none transition group cursor-text relative">
                                    
                                    <div class="flex items-center gap-3 w-full sm:w-auto min-w-0 pointer-events-none order-1">
                                        <!-- Tombol Pilih File diberi pointer-events-auto agar tetap bisa diklik secara mandiri -->
                                        <button type="button" onclick="event.stopPropagation(); document.getElementById('attachments').click();" class="pointer-events-auto inline-flex items-center justify-center px-3.5 py-2 rounded-xl bg-emerald-800 text-white text-xs font-bold hover:bg-emerald-900 transition shrink-0 shadow-sm active:scale-95">
                                            Pilih File
                                        </button>
                                        <span id="file-chosen-text" class="text-xs text-slate-500 font-medium truncate">
                                            Tidak ada file yang dipilih
                                        </span>
                                    </div>

                                    <!-- Span tersembunyi/dummy di awal baris agar kursor mutlak selalu berfokus di sisi kiri sebelah tombol -->
                                    <span id="cursor-anchor" class="inline-block w-0 h-0 overflow-hidden select-none outline-none focus:outline-none order-0 shrink-0"></span>

                                    <div class="text-[11px] text-slate-400 font-medium text-center sm:text-right shrink-0 pointer-events-none select-none order-2 sm:order-2 ml-auto">
                                        Klik area ini &amp; tekan <kbd class="px-1.5 py-0.5 text-[10px] font-semibold text-slate-700 bg-white border border-slate-200 rounded shadow-2xs">Ctrl+V</kbd> untuk paste gambar
                                    </div>

                                    <div class="hidden">
                                        <input type="file" name="attachments[]" id="attachments" multiple accept="image/*,video/*,.heic,.heif" onchange="handleFileSelect(event)">
                                    </div>
                                </div>
                                
                                <p class="text-[10px] sm:text-[11px] text-slate-400 mt-1.5 font-medium flex items-start sm:items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Mendukung upload <strong>Foto (JPG, PNG)</strong>, <strong>Video (MP4, MKV)</strong>, atau langsung <strong>Paste (Ctrl+V)</strong> gambar ke dalam kotak.</span>
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

    <script>
        let selectedFiles = [];

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
            updateFileInputAndPreview();
        }

        // Fungsi khusus untuk menangkap Paste (Ctrl+V) gambar dari clipboard pada elemen contenteditable
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