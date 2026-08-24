<x-app-layout>
    <div class="space-y-6 max-w-3xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Tambah Pengguna Baru</h1>
                <p class="text-xs text-slate-500 mt-1">Daftarkan akun staf IT, teknisi, admin, atau pimpinan rumah sakit.</p>
            </div>
            <a href="{{ route('superadmin.users.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-xl transition">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="role_id" class="block text-xs font-bold text-slate-700 uppercase mb-1">Role / Hak Akses <span class="text-rose-500">*</span></label>
                        <select name="role_id" id="role_id" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                            <option value="">-- Pilih Role --</option>
                            @foreach ($roles as $r)
                                <option value="{{ $r->id }}" {{ old('role_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->label ?? $r->name }} ({{ $r->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('role_id') <span class="text-[11px] text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

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
                </div>

                <div>
                    <label for="specialization" class="block text-xs font-bold text-slate-700 uppercase mb-1">Keahlian / Spesialisasi (Khusus Teknisi IT)</label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" class="w-full text-xs rounded-xl border-slate-200 focus:ring-emerald-600 focus:border-emerald-600 font-medium" placeholder="Contoh: Hardware, Printer Resep, SIMRS & Bridging BPJS, Jaringan LAN">
                </div>

                <div class="pt-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span class="ml-2 text-xs font-bold text-slate-700">Akun Aktif (Dapat langsung login)</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('superadmin.users.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-5 py-2.5 rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-xs transition">
                        Simpan Pengguna Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
