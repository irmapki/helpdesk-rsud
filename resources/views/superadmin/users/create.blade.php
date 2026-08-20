<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Tambah Pengguna Baru') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Buat akun untuk Super Admin, Admin Helpdesk, Teknisi, atau Supervisor</p>
            </div>
            <a href="{{ route('superadmin.users.index') }}" class="text-xs font-semibold text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-xl transition">
                &larr; Kembali ke Daftar User
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6 sm:p-8">
                <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            placeholder="Contoh: Budi Santoso, S.Kom"
                            class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror">
                        @error('name') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Email Login <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                placeholder="budi@rsud.test"
                                class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500 @error('email') border-red-500 @enderror">
                            @error('email') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">No. WhatsApp / HP</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                placeholder="08123456789"
                                class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500 @error('phone') border-red-500 @enderror">
                            @error('phone') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="role_id" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Role Pengguna <span class="text-red-500">*</span></label>
                            <select name="role_id" id="role_id" required
                                class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500 @error('role_id') border-red-500 @enderror">
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->id }}" {{ old('role_id') == $r->id ? 'selected' : '' }}>
                                        {{ $r->label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="unit_id" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Unit RSUD (Opsional)</label>
                            <select name="unit_id" id="unit_id"
                                class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                                <option value="">-- Semua Unit / Pusat IT --</option>
                                @foreach ($units as $u)
                                    <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="specialization" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Spesialisasi / Keahlian (Khusus Teknisi)</label>
                        <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}"
                            placeholder="Contoh: Hardware & Printer / Jaringan LAN / SIMRS & Database"
                            class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required
                            placeholder="Minimal 8 karakter"
                            class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500 @error('password') border-red-500 @enderror">
                        @error('password') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                        <label for="is_active" class="text-xs font-semibold text-gray-700 dark:text-gray-300">Akun Aktif (Dapat langsung login)</label>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3">
                        <a href="{{ route('superadmin.users.index') }}" class="text-xs font-semibold text-gray-500 hover:text-gray-700">Batal</a>
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-6 py-2.5 rounded-xl shadow-sm transition">
                            Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
