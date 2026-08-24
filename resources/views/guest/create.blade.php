<x-guest-portal-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="mb-8 text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-100 mb-3 shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Formulir Pengaduan Layanan IT RSUD</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-2 font-medium">Sampaikan kendala teknis Anda. Tim Helpdesk IT RSUD akan segera memverifikasi dan menugaskan teknisi.</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md p-6 sm:p-9">
                <form action="{{ route('guest.ticket.store') }}" method="POST" enctype="multipart/form-data" class="space-y-7">
                    @csrf

                    <!-- Section 1: Data Pelapor -->
                    <div class="border-b border-slate-100 pb-7">
                        <h2 class="text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 text-xs flex items-center justify-center font-black">1</span>
                            Data Identitas Pelapor
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="guest_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Nama Lengkap Pelapor <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name') }}" required
                                    placeholder="Contoh: dr. Ahmad / Ns. Siti / Bpk. Rudi"
                                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 @error('guest_name') border-rose-500 @enderror">
                                @error('guest_name')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="guest_phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    No. WhatsApp / HP Aktif <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="guest_phone" id="guest_phone" value="{{ old('guest_phone') }}" required
                                    placeholder="Contoh: 081234567890 (untuk info progress)"
                                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 @error('guest_phone') border-rose-500 @enderror">
                                @error('guest_phone')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="guest_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Email (Opsional)
                                </label>
                                <input type="email" name="guest_email" id="guest_email" value="{{ old('guest_email') }}"
                                    placeholder="nama@rsud.go.id / email aktif"
                                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 @error('guest_email') border-rose-500 @enderror">
                                @error('guest_email')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Lokasi & Kategori -->
                    <div class="border-b border-slate-100 pb-7">
                        <h2 class="text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 text-xs flex items-center justify-center font-black">2</span>
                            Lokasi &amp; Kategori Kendala
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-1">
                                <label for="unit_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Unit / Instalasi / Ruangan <span class="text-rose-500">*</span>
                                </label>
                                <select name="unit_id" id="unit_id" required onchange="toggleCustomUnitInput(this.value)"
                                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 @error('unit_id') border-rose-500 @enderror">
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
                                <div id="custom_unit_wrapper" class="{{ old('unit_id') == 'other' || old('custom_unit_name') ? '' : 'hidden' }} mt-3 p-3 bg-emerald-50/80 border border-emerald-200 rounded-2xl">
                                    <label for="custom_unit_name" class="block text-xs font-bold text-emerald-950 uppercase tracking-wider mb-1">
                                        Ketik Nama Ruangan / Unit Anda <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="custom_unit_name" id="custom_unit_name" value="{{ old('custom_unit_name') }}"
                                        placeholder="Contoh: Poli Eksekutif / Ruang ICU 2 / Farmasi Rawat Inap B"
                                        class="w-full rounded-xl border-slate-200 bg-white text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 @error('custom_unit_name') border-rose-500 @enderror">
                                    <p class="text-[10px] text-emerald-700 font-medium mt-1">Nama ruangan ini akan otomatis didaftarkan dan disimpan ke sistem.</p>
                                    @error('custom_unit_name')
                                        <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="category_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Kategori Masalah <span class="text-rose-500">*</span>
                                </label>
                                <select name="category_id" id="category_id" required
                                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 @error('category_id') border-rose-500 @enderror">
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

                            <div class="sm:col-span-2">
                                <label for="priority_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Perkiraan Tingkat Urgensi
                                </label>
                                <select name="priority_id" id="priority_id"
                                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}" {{ old('priority_id', 2) == $priority->id ? 'selected' : '' }}>
                                            {{ $priority->name }} (Target SLA: {{ $priority->sla_hours }} Jam)
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[11px] text-slate-400 mt-1 font-medium">*Admin IT akan memvalidasi kembali tingkat prioritas akhir saat triage tiket.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Rincian Kendala -->
                    <div class="pb-2">
                        <h2 class="text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 text-xs flex items-center justify-center font-black">3</span>
                            Rincian Pengaduan &amp; Lampiran
                        </h2>

                        <div class="space-y-5">
                            <div>
                                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Judul Ringkas Masalah <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    placeholder="Contoh: Printer cetak resep di Farmasi Rawat Jalan error / Komputer Kasir mati total"
                                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 @error('title') border-rose-500 @enderror">
                                @error('title')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Deskripsi Lengkap Kendala <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4" required
                                    placeholder="Jelaskan secara detail kendala yang dialami, pesan error yang muncul, atau langkah yang sudah dicoba..."
                                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600 @error('description') border-rose-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upload dengan multiple file (Foto & Video) -->
                            <div>
                                <label for="attachments" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Unggah Bukti Kendala (Foto &amp; Video) - Bisa Pilih Banyak
                                </label>
                                <input type="file" name="attachments[]" id="attachments" multiple accept="image/*,video/*"
                                    class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-800 hover:file:bg-emerald-100 border border-slate-200 rounded-xl p-1.5 focus:outline-none">
                                <p class="text-[11px] text-slate-400 mt-1.5 font-medium flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Mendukung upload <strong>Foto (JPG, PNG, WEBP)</strong> dan <strong>Video (MP4, MOV, WEBM)</strong> sekaligus.</span>
                                </p>
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
                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <a href="{{ route('guest.landing') }}" class="text-xs sm:text-sm font-bold text-slate-500 hover:text-slate-700 order-2 sm:order-1 text-center">
                            &larr; Kembali ke Beranda
                        </a>

                        <button type="submit" class="order-1 sm:order-2 inline-flex items-center justify-center gap-2 bg-emerald-800 hover:bg-emerald-900 text-white font-extrabold px-8 py-3.5 rounded-2xl shadow-lg shadow-emerald-900/25 transition hover:scale-[1.02] text-xs sm:text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    </script>
</x-guest-portal-layout>
