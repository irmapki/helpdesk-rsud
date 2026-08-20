<x-guest-portal-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="mb-8 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-teal-100 text-teal-600 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Formulir Pengaduan Layanan IT RSUD RAA. SOEWONDO</h1>
                <p class="text-sm text-slate-500 mt-2">Sampaikan kendala teknis Anda. Tim Helpdesk IT RSUD akan segera memverifikasi dan menugaskan teknisi.</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 sm:p-8">
                <form action="{{ route('guest.ticket.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Section: Data Pelapor -->
                    <div class="border-b border-slate-100 pb-6">
                        <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-teal-50 text-teal-700 text-xs flex items-center justify-center font-bold">1</span>
                            Data Identitas Pelapor
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="guest_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Nama Lengkap Pelapor <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name') }}" required
                                    placeholder="Contoh: dr. Ahmad / Ns. Siti / Bpk. Rudi"
                                    class="w-full rounded-xl border-slate-200 text-sm focus:border-teal-500 focus:ring-teal-500 @error('guest_name') border-red-500 @enderror">
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
                                    class="w-full rounded-xl border-slate-200 text-sm focus:border-teal-500 focus:ring-teal-500 @error('guest_phone') border-red-500 @enderror">
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
                                    class="w-full rounded-xl border-slate-200 text-sm focus:border-teal-500 focus:ring-teal-500 @error('guest_email') border-red-500 @enderror">
                                @error('guest_email')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section: Lokasi & Kategori -->
                    <div class="border-b border-slate-100 pb-6">
                        <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-teal-50 text-teal-700 text-xs flex items-center justify-center font-bold">2</span>
                            Lokasi & Kategori Kendala
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="unit_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Unit / Instalasi / Ruangan <span class="text-red-500">*</span>
                                </label>
                                <select name="unit_id" id="unit_id" required
                                    class="w-full rounded-xl border-slate-200 text-sm focus:border-teal-500 focus:ring-teal-500 @error('unit_id') border-red-500 @enderror">
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
                                    class="w-full rounded-xl border-slate-200 text-sm focus:border-teal-500 focus:ring-teal-500 @error('category_id') border-red-500 @enderror">
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
                                    class="w-full rounded-xl border-slate-200 text-sm focus:border-teal-500 focus:ring-teal-500">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}" {{ old('priority_id', 2) == $priority->id ? 'selected' : '' }}>
                                            {{ $priority->name }} (Target SLA: {{ $priority->sla_hours }} Jam)
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[11px] text-slate-400 mt-1">*Admin IT akan memvalidasi kembali tingkat prioritas akhir saat triage tiket.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Rincian Kendala -->
                    <div class="pb-2">
                        <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-teal-50 text-teal-700 text-xs flex items-center justify-center font-bold">3</span>
                            Rincian Pengaduan & Lampiran
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Judul Ringkas Masalah <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    placeholder="Contoh: Printer cetak resep di Farmasi Rawat Jalan error / Komputer Kasir mati total"
                                    class="w-full rounded-xl border-slate-200 text-sm focus:border-teal-500 focus:ring-teal-500 @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Deskripsi Lengkap Kendala <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4" required
                                    placeholder="Jelaskan secara detail kendala yang dialami, pesan error yang muncul, atau langkah yang sudah dicoba..."
                                    class="w-full rounded-xl border-slate-200 text-sm focus:border-teal-500 focus:ring-teal-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="attachment" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Foto / Screenshot Bukti Kendala (Opsional)
                                </label>
                                <input type="file" name="attachment" id="attachment" accept="image/*"
                                    class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 border border-slate-200 rounded-xl p-1.5 focus:outline-none">
                                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maksimal 5MB). Lampirkan foto layar error atau kondisi alat.</p>
                                @error('attachment')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex items-center justify-between gap-4">
                        <a href="{{ route('guest.landing') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">
                            &larr; Kembali ke Beranda
                        </a>

                        <button type="submit" class="inline-flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold px-7 py-3 rounded-xl shadow-md shadow-teal-600/30 transition hover:scale-[1.02]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                            Kirim Pengaduan Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-portal-layout>
