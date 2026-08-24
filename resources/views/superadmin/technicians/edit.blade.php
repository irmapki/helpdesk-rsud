<x-app-layout>
    <div class="space-y-6 max-w-2xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Edit Data Teknisi</h1>
                <p class="text-xs text-slate-500 mt-1">Perbarui spesialisasi keahlian dan nomor kontak teknisi</p>
            </div>
            <a href="{{ route('superadmin.technicians.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-2xl transition shadow-xs">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
            <form action="{{ route('superadmin.technicians.update', $technician) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Teknisi</label>
                    <div class="text-sm font-bold text-slate-900 bg-slate-50 p-3.5 rounded-xl border border-slate-200">
                        {{ $technician->name }} ({{ $technician->email }})
                    </div>
                </div>

                <div>
                    <label for="specialization" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Bidang Spesialisasi / Keahlian <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $technician->specialization) }}" required
                        placeholder="Contoh: Hardware, Jaringan & WiFi, SIMRS, Printer"
                        class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        No. WhatsApp / HP Aktif
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $technician->phone) }}"
                        placeholder="081234567890 (digunakan untuk notifikasi & dispatch)"
                        class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('superadmin.technicians.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700 px-4 py-2.5">Batal</a>
                    <button type="submit" class="bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-bold px-6 py-2.5 rounded-xl shadow-xs transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
