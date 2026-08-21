<x-guest-portal-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="mb-8 text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-500 to-teal-600 text-white mb-4 shadow-lg shadow-teal-600/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Formulir Pengaduan Layanan IT</h1>
                <p class="text-sm font-semibold text-teal-700 mt-1">RSUD RAA. SOEWONDO</p>
                <p class="text-sm text-slate-500 mt-3 max-w-xl mx-auto">Sampaikan kendala teknis Anda. Tim Helpdesk IT RSUD akan segera memverifikasi dan menugaskan teknisi.</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden p-6 sm:p-8">
                <form action="{{ route('guest.ticket.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Section: Data Pelapor -->
                    <div class="border-b border-slate-100 pb-7">
                        <h2 class="text-base font-bold text-slate-900 mb-5 flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-teal-600 text-white text-xs flex items-center justify-center font-bold shadow-sm">1</span>
                            Data Identitas Pelapor
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="guest_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Nama Lengkap Pelapor <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name') }}" required
                                    placeholder="Contoh: dr. Ahmad / Ns. Siti / Bpk. Rudi"
                                    class="w-full rounded-xl border-slate-200 text-sm transition-colors focus:border-teal-500 focus:ring-teal-500 @error('guest_name') border-red-500 @enderror">
                                @error('guest_name')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="guest_phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    No. WhatsApp / HP Aktif <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="guest_phone" id="guest_phone" value="{{ old('guest_phone') }}" required
                                    placeholder="Contoh: 081234567890 (untuk info progress)"
                                    class="w-full rounded-xl border-slate-200 text-sm transition-colors focus:border-teal-500 focus:ring-teal-500 @error('guest_phone') border-red-500 @enderror">
                                @error('guest_phone')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="guest_email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Email (Opsional)
                                </label>
                                <input type="email" name="guest_email" id="guest_email" value="{{ old('guest_email') }}"
                                    placeholder="nama@rsud.go.id / email aktif"
                                    class="w-full rounded-xl border-slate-200 text-sm transition-colors focus:border-teal-500 focus:ring-teal-500 @error('guest_email') border-red-500 @enderror">
                                @error('guest_email')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section: Lokasi & Kategori -->
                    <div class="border-b border-slate-100 pb-7">
                        <h2 class="text-base font-bold text-slate-900 mb-5 flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-teal-600 text-white text-xs flex items-center justify-center font-bold shadow-sm">2</span>
                            Lokasi & Kategori Kendala
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="unit_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Unit / Instalasi / Ruangan <span class="text-red-500">*</span>
                                </label>
                                <select name="unit_id" id="unit_id" required
                                    class="w-full rounded-xl border-slate-200 text-sm transition-colors focus:border-teal-500 focus:ring-teal-500 @error('unit_id') border-red-500 @enderror">
                                    <option value="">-- Pilih Unit / Ruangan RSUD --</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }} {{ $unit->location ? "({$unit->location})" : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Kategori Masalah <span class="text-red-500">*</span>
                                </label>
                                <select name="category_id" id="category_id" required
                                    class="w-full rounded-xl border-slate-200 text-sm transition-colors focus:border-teal-500 focus:ring-teal-500 @error('category_id') border-red-500 @enderror">
                                    <option value="">-- Pilih Kategori Kendala --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="priority_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Perkiraan Tingkat Urgensi
                                </label>
                                <select name="priority_id" id="priority_id"
                                    class="w-full rounded-xl border-slate-200 text-sm transition-colors focus:border-teal-500 focus:ring-teal-500">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}" {{ old('priority_id', 2) == $priority->id ? 'selected' : '' }}>
                                            {{ $priority->name }} (Target SLA: {{ $priority->sla_hours }} Jam)
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[11px] text-slate-400 mt-1.5">*Admin IT akan memvalidasi kembali tingkat prioritas akhir saat triage tiket.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Rincian Kendala -->
                    <div class="pb-2">
                        <h2 class="text-base font-bold text-slate-900 mb-5 flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-teal-600 text-white text-xs flex items-center justify-center font-bold shadow-sm">3</span>
                            Rincian Pengaduan & Lampiran
                        </h2>

                        <div class="space-y-5">
                            <div>
                                <label for="title" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Judul Ringkas Masalah <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    placeholder="Contoh: Printer cetak resep di Farmasi Rawat Jalan error"
                                    class="w-full rounded-xl border-slate-200 text-sm transition-colors focus:border-teal-500 focus:ring-teal-500 @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Deskripsi Lengkap Kendala <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4" required
                                    placeholder="Jelaskan detail kendala, pesan error yang muncul, atau langkah yang sudah dicoba..."
                                    class="w-full rounded-xl border-slate-200 text-sm transition-colors focus:border-teal-500 focus:ring-teal-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upload dengan preview -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Foto / Screenshot Bukti Kendala (Opsional)
                                </label>

                                <div id="dropzone"
                                     class="relative rounded-xl border-2 border-dashed border-slate-200 hover:border-teal-400 transition-colors bg-slate-50/60 p-5 text-center cursor-pointer @error('attachment') border-red-400 @enderror">
                                    <input type="file" name="attachment" id="attachment" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                                    <div id="dropzone-empty">
                                        <svg class="w-8 h-8 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="text-sm text-slate-600 font-medium">Klik atau seret foto ke sini</p>
                                        <p class="text-[11px] text-slate-400 mt-1">Format JPG, PNG, WEBP — Maksimal 5MB</p>
                                    </div>

                                    <div id="dropzone-preview" class="hidden items-center gap-3 text-left">
                                        <img id="preview-img" src="" class="w-16 h-16 rounded-lg object-cover border border-slate-200 shadow-sm" alt="Preview">
                                        <div class="min-w-0">
                                            <p id="preview-filename" class="text-sm font-semibold text-slate-700 truncate"></p>
                                            <p class="text-[11px] text-teal-600 font-medium mt-0.5">Klik untuk ganti gambar</p>
                                        </div>
                                    </div>
                                </div>

                                @error('attachment')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex items-center justify-between gap-4">
                        <a href="{{ route('guest.landing') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700 transition-colors">
                            &larr; Kembali ke Beranda
                        </a>

                        <button type="submit" class="inline-flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold px-7 py-3 rounded-xl shadow-md shadow-teal-600/30 transition-all hover:scale-[1.02] active:scale-[0.98]">
                            Kirim Pengaduan Sekarang
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const attachmentInput = document.getElementById('attachment');
        const dropzoneEmpty = document.getElementById('dropzone-empty');
        const dropzonePreview = document.getElementById('dropzone-preview');
        const previewImg = document.getElementById('preview-img');
        const previewFilename = document.getElementById('preview-filename');

        attachmentInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (ev) {
                previewImg.src = ev.target.result;
                previewFilename.textContent = file.name;
                dropzoneEmpty.classList.add('hidden');
                dropzonePreview.classList.remove('hidden');
                dropzonePreview.classList.add('flex');
            };
            reader.readAsDataURL(file);
        });
    </script>
</x-guest-portal-layout>