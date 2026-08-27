<x-app-layout>
    <div class="space-y-6 max-w-2xl mx-auto px-3 sm:px-0">
        <!-- Header & Back Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Edit Data &amp; Kontak Teknisi</h1>
                <p class="text-xs text-slate-500 mt-1">Perbarui nomor WhatsApp dan fokus keahlian penanganan teknisi IT RSUD.</p>
            </div>
            <a href="{{ route('superadmin.technicians.index') }}" class="inline-flex items-center justify-center text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-xl transition shadow-xs self-start sm:self-auto">
                &larr; Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-8">
            <form action="{{ route('superadmin.technicians.update', $technician) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Teknisi</label>
                    <div class="text-xs font-bold text-slate-800 bg-slate-50 p-3 rounded-xl border border-slate-200 break-all">
                        {{ $technician->name }} ({{ $technician->email }})
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor WhatsApp Teknisi</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $technician->phone) }}"
                        class="w-full text-xs rounded-xl border-slate-200 focus:ring-emerald-600 focus:border-emerald-600 font-medium" placeholder="081234567890">
                </div>

                <div>
                    <label for="specialization" class="block text-xs font-bold text-slate-700 uppercase mb-1">Spesialisasi / Keahlian Utama <span class="text-rose-500">*</span></label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $technician->specialization) }}" required
                        class="w-full text-xs rounded-xl border-slate-200 focus:ring-emerald-600 focus:border-emerald-600 font-medium" placeholder="Contoh: Hardware, Jaringan LAN, SIMRS & Bridging BPJS">
                </div>

                <div class="pt-2">
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $technician->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span class="ml-2 text-xs font-bold text-slate-700">Teknisi Aktif (Dapat menerima penugasan tiket)</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2.5 sm:gap-2">
                    <a href="{{ route('superadmin.technicians.index') }}" class="px-5 py-3 sm:py-2.5 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 text-center transition">Batal</a>
                    <button type="submit" class="px-6 py-3 sm:py-2.5 rounded-xl text-xs font-bold text-white bg-[#0f333a] hover:bg-[#092227] shadow-xs transition text-center">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>