<x-app-layout>
    <div class="space-y-6 max-w-3xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Edit Pengguna: {{ $user->name }}</h1>
                <p class="text-xs text-slate-500 mt-1">Perbarui data login, peran akses, dan unit penempatan</p>
            </div>
            <a href="{{ route('superadmin.users.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-2xl transition shadow-xs">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
            <form action="{{ route('superadmin.users.update', $user) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium @error('name') border-rose-500 @enderror">
                    @error('name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Login <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium @error('email') border-rose-500 @enderror">
                        @error('email') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. WhatsApp / HP</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium @error('phone') border-rose-500 @enderror">
                        @error('phone') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="role_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Role Pengguna <span class="text-rose-500">*</span></label>
                        <select name="role_id" id="role_id" required
                            class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium @error('role_id') border-rose-500 @enderror">
                            @foreach ($roles as $r)
                                <option value="{{ $r->id }}" {{ old('role_id', $user->role_id) == $r->id ? 'selected' : '' }}>
                                    {{ $r->label ?? $r->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="unit_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Unit RSUD (Opsional)</label>
                        <select name="unit_id" id="unit_id"
                            class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                            <option value="">-- Semua Unit / Pusat IT --</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->id }}" {{ old('unit_id', $user->unit_id) == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="specialization" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Spesialisasi / Keahlian (Khusus Teknisi)</label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $user->specialization) }}"
                        class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password Baru (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" id="password"
                        placeholder="Ketik password baru jika ingin mengubah"
                        class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium @error('password') border-rose-500 @enderror">
                    @error('password') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                    <label for="is_active" class="text-xs font-bold text-slate-700">Akun Aktif (Dapat login ke sistem)</label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('superadmin.users.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700 px-4 py-2.5">Batal</a>
                    <button type="submit" class="bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-bold px-6 py-2.5 rounded-xl shadow-xs transition">
                        Perbarui Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
