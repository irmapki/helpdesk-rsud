<x-app-layout>
    <div class="space-y-6 max-w-3xl mx-auto px-3 sm:px-0">
        <!-- Header & Back Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Tambah Pengguna Baru</h1>
                <p class="text-xs text-slate-500 mt-1">Daftarkan akun staf IT, teknisi, admin, atau pimpinan rumah sakit.</p>
            </div>
            <a href="{{ route('superadmin.users.index') }}" class="inline-flex items-center justify-center text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-xl transition shadow-xs self-start sm:self-auto">
                &larr; Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-8">
            <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-emerald-600 focus:border-emerald-600 font-medium" placeholder="Contoh: Dedi Kurniawan, S.Kom">
                        @error('name') <span class="text-[11px] text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-emerald-600 focus:border-emerald-600 font-medium" placeholder="Contoh: dedi.k@rsudsoewondo.go.id">
                        @error('email') <span class="text-[11px] text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full text-xs rounded-xl border-slate-200 focus:ring-emerald-600 focus:border-emerald-600 font-medium" placeholder="081234567890">
                        @error('phone') <span class="text-[11px] text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase mb-1">Kata Sandi Awal <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" id="password" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-emerald-600 focus:border-emerald-600 font-medium" placeholder="Minimal 8 karakter">
                        @error('password') <span class="text-[11px] text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">
                        Pilih Role / Hak Akses (Multi-Role) <span class="text-rose-500">*</span>
                        <span class="text-[10px] text-slate-400 font-normal lowercase">(Bisa centang lebih dari satu role)</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach ($roles as $r)
                            @php
                                $isChecked = is_array(old('roles')) ? in_array($r->name, old('roles')) : false;
                            @endphp
                            <label class="relative flex items-start p-3 rounded-2xl border-2 cursor-pointer transition-all hover:border-emerald-500 hover:bg-emerald-50/20 select-none {{ $isChecked ? 'border-emerald-600 bg-emerald-50/40' : 'border-slate-200 bg-white' }}">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="roles[]" value="{{ $r->name }}" {{ $isChecked ? 'checked' : '' }} 
                                        class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                </div>
                                <div class="ml-3 text-xs min-w-0">
                                    <span class="font-bold text-slate-900 block truncate">{{ $r->label ?? $r->name }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium block">
                                        @if($r->name === 'super_admin')
                                            Hak akses penuh seluruh sistem & master data
                                        @elseif($r->name === 'admin')
                                            Triage, verifikasi, & dispatch tiket masuk
                                        @elseif($r->name === 'teknisi')
                                            Workboard, antrean, & penanganan kendala
                                        @elseif($r->name === 'supervisor')
                                            Monitoring SLA, performa teknisi, & laporan
                                        @endif
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('roles') <span class="text-[11px] text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="unit_id" class="block text-xs font-bold text-slate-700 uppercase mb-1">Unit / Bagian Penempatan</label>
                        <select name="unit_id" id="unit_id" class="w-full text-xs rounded-xl border-slate-200 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                            <option value="">-- Divisi IT / Umum --</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="specialization" class="block text-xs font-bold text-slate-700 uppercase mb-1">Keahlian / Spesialisasi (Khusus Teknisi IT)</label>
                        <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" class="w-full text-xs rounded-xl border-slate-200 focus:ring-emerald-600 focus:border-emerald-600 font-medium" placeholder="Contoh: Hardware, Printer Resep, SIMRS & Bridging BPJS, Jaringan LAN">
                    </div>
                </div>

                <div class="pt-2">
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span class="ml-2 text-xs font-bold text-slate-700">Akun Aktif (Dapat langsung login)</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2.5 sm:gap-3">
                    <a href="{{ route('superadmin.users.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-5 py-3 sm:py-2.5 rounded-xl transition text-center">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs px-6 py-3 sm:py-2.5 rounded-xl shadow-xs transition text-center">
                        Simpan Pengguna Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>