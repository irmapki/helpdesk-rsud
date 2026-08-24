<x-app-layout>
    <div class="space-y-6">
        <!-- Top Title & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Pengguna Sistem</h1>
                <p class="text-xs text-slate-500 font-normal mt-1">Daftar semua pengguna terdaftar, peran akses, dan unit penempatan pada Helpdesk RSUD RAA Soewondo.</p>
            </div>
            <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center gap-1.5 bg-[#0f333a] hover:bg-[#092227] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition hover:scale-[1.02]">
                <span class="text-sm font-bold">+</span>
                <span>Tambah Pengguna Baru</span>
            </a>
        </div>

        <!-- Filter & Search Card -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <form method="GET" action="{{ route('superadmin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Cari Nama / Email / HP</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..."
                        class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 font-medium">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Role Pengguna</label>
                    <select name="role_id" class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                        <option value="">-- Semua Role --</option>
                        @foreach ($roles as $r)
                            <option value="{{ $r->id }}" {{ request('role_id') == $r->id ? 'selected' : '' }}>{{ $r->label ?? $r->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Unit RSUD</label>
                    <select name="unit_id" class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 font-medium">
                        <option value="">-- Semua Unit --</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->id }}" {{ request('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full bg-[#0f333a] hover:bg-[#092227] text-white text-xs font-bold py-2.5 px-4 rounded-xl transition shadow-xs">
                        Filter Data
                    </button>
                    <a href="{{ route('superadmin.users.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 px-3 rounded-xl transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Users Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="text-slate-400 uppercase font-bold text-[11px] border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-2">NAMA PENGGUNA</th>
                            <th class="py-3 px-2">ROLE</th>
                            <th class="py-3 px-2">UNIT</th>
                            <th class="py-3 px-2">SPESIALISASI</th>
                            <th class="py-3 px-2">STATUS</th>
                            <th class="py-3 px-2 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($users as $user)
                            @php
                                $roleName = strtolower($user->role->name ?? '');
                                $roleLabel = $user->role->label ?? $user->role->name ?? '-';

                                $avatarClass = 'bg-slate-600';
                                $roleBadgeClass = 'bg-slate-100 text-slate-700';

                                if (str_contains($roleName, 'superadmin')) {
                                    $avatarClass = 'bg-purple-700';
                                    $roleBadgeClass = 'bg-purple-100 text-purple-700';
                                } elseif (str_contains($roleName, 'admin')) {
                                    $avatarClass = 'bg-teal-700';
                                    $roleBadgeClass = 'bg-sky-100 text-sky-700';
                                } elseif (str_contains($roleName, 'teknisi') || str_contains($roleName, 'technician')) {
                                    $avatarClass = 'bg-amber-700';
                                    $roleBadgeClass = 'bg-orange-100 text-orange-700';
                                } elseif (str_contains($roleName, 'supervisor')) {
                                    $avatarClass = 'bg-indigo-800';
                                    $roleBadgeClass = 'bg-blue-100 text-blue-700';
                                }

                                $words = explode(' ', trim($user->name));
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : substr($words[0], 1, 1)));
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full {{ $avatarClass }} text-white font-bold text-xs flex items-center justify-center shrink-0">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm">{{ $user->name }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono">{{ $user->email }} &bull; {{ $user->phone ?: 'No HP -' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-2">
                                    <span class="inline-block px-3 py-1 rounded-xl text-xs font-bold {{ $roleBadgeClass }}">
                                        {{ $roleLabel }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-2 text-slate-700 font-medium text-xs">
                                    {{ $user->unit->name ?? 'Semua Unit (Pusat)' }}
                                </td>
                                <td class="py-3.5 px-2 text-slate-500 text-xs">
                                    {{ $user->specialization ?: '-' }}
                                </td>
                                <td class="py-3.5 px-2">
                                    <form action="{{ route('superadmin.users.toggle-status', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" onclick="return confirm('Ubah status user ini?')"
                                            class="inline-flex items-center gap-1.5 text-xs font-bold transition {{ $user->is_active ? 'text-emerald-600 hover:text-emerald-700' : 'text-slate-400 hover:text-slate-600' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="py-3.5 px-2 text-right">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <a href="{{ route('superadmin.users.edit', $user) }}" class="p-1.5 rounded-lg border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-800 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun pengguna ini secara permanen?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-rose-600 transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-slate-400 text-xs">
                                    Tidak ada data pengguna yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="mt-4 pt-4 border-t border-slate-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
