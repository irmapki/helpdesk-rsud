<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Kelola Pengguna (User Management)') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Daftar semua pengguna terdaftar, peran akses, dan unit penempatan RSUD</p>
            </div>
            <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah User Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Filter & Search Card -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm">
                <form method="GET" action="{{ route('superadmin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Cari Nama / Email / HP</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Role Pengguna</label>
                        <select name="role_id" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">-- Semua Role --</option>
                            @foreach ($roles as $r)
                                <option value="{{ $r->id }}" {{ request('role_id') == $r->id ? 'selected' : '' }}>{{ $r->label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase mb-1">Unit / Bagian RSUD</label>
                        <select name="unit_id" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">-- Semua Unit --</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->id }}" {{ request('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition">
                            Filter
                        </button>
                        <a href="{{ route('superadmin.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold py-2.5 px-3 rounded-xl transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Users Table Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="px-5 py-3.5">Nama & Kontak</th>
                                <th class="px-5 py-3.5">Role</th>
                                <th class="px-5 py-3.5">Unit Penempatan</th>
                                <th class="px-5 py-3.5">Spesialisasi</th>
                                <th class="px-5 py-3.5">Status Akun</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-750 transition">
                                    <td class="px-5 py-3.5">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-gray-400 text-[11px]">{{ $user->email }} &bull; {{ $user->phone ?: 'No HP -' }}</div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-teal-50 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300">
                                            {{ $user->role->label ?? $user->role->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ $user->unit->name ?? 'Semua Unit (Pusat)' }}
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500">
                                        {{ $user->specialization ?: '-' }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <form action="{{ route('superadmin.users.toggle-status', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" onclick="return confirm('Ubah status aktif user ini?')"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold transition {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-5 py-3.5 text-right space-x-2">
                                        <a href="{{ route('superadmin.users.edit', $user) }}" class="font-bold text-teal-600 hover:text-teal-800">Edit</a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-bold text-red-500 hover:text-red-700">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-400">Tidak ada data pengguna yang sesuai filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($users->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
