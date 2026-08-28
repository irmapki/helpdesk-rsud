<x-app-layout>
    <div class="space-y-6 px-3 sm:px-0">
        <!-- Top Title -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Kategori Tiket</h1>
                <p class="text-xs text-slate-500 font-normal mt-1">Master kategori kendala pengaduan IT RSUD RAA Soewondo Pati (Hardware, Software, SIMRS, Jaringan, dll).</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <!-- Add Category Form (1 col) -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-sm shrink-0">
                        +
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Tambah Kategori</h3>
                        <p class="text-[11px] text-slate-400">Klasifikasi kendala baru</p>
                    </div>
                </div>

                <form action="{{ route('superadmin.categories.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="name" required placeholder="Contoh: SIMRS & Database"
                            class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 font-medium @error('name') border-rose-500 @enderror">
                        @error('name') <p class="text-[11px] text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1">Deskripsi Layanan</label>
                        <textarea name="description" id="description" rows="3" placeholder="Keterangan singkat cakupan kendala kategori ini..."
                            class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 font-medium"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-[#0f333a] hover:bg-[#092227] text-white font-bold py-3 sm:py-2.5 px-4 rounded-xl shadow-xs transition text-center">
                        Simpan Kategori
                    </button>
                </form>
            </div>

            <!-- Categories List (2 cols) -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-4 sm:p-6 overflow-hidden">
                <h3 class="font-bold text-sm sm:text-base text-slate-900 mb-4">Daftar Kategori Tiket</h3>

                <div class="overflow-x-auto -mx-4 sm:mx-0 px-4 sm:px-0">
                    <table class="w-full text-left text-xs min-w-[550px]">
                        <thead class="text-slate-400 uppercase font-bold text-[11px] border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-2">NAMA KATEGORI</th>
                                <th class="py-3 px-2">DESKRIPSI</th>
                                <th class="py-3 px-2 text-center">JUMLAH TIKET</th>
                                <th class="py-3 px-2 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($categories as $cat)
                                <tr x-data="{ edit: false }" class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-2">
                                        <div x-show="!edit" class="font-bold text-slate-900">{{ $cat->name }}</div>
                                        <div x-show="edit">
                                            <input type="text" form="edit-form-{{ $cat->id }}" name="name" value="{{ $cat->name }}" class="text-xs rounded-xl border-slate-200 bg-white text-slate-800 p-1.5 w-full font-medium">
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-2 text-slate-500 whitespace-nowrap">
                                        <div x-show="!edit">{{ $cat->description ?: '-' }}</div>
                                        <div x-show="edit">
                                            <input type="text" form="edit-form-{{ $cat->id }}" name="description" value="{{ $cat->description }}" class="text-xs rounded-xl border-slate-200 bg-white text-slate-800 p-1.5 w-full font-medium">
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-2 text-center font-bold text-slate-800 whitespace-nowrap">
                                        {{ $cat->tickets_count ?? $cat->tickets->count() }}
                                    </td>
                                    <td class="py-3.5 px-2 text-right whitespace-nowrap">
                                        <form id="edit-form-{{ $cat->id }}" action="{{ route('superadmin.categories.update', $cat) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                        </form>

                                        <div x-show="!edit" class="inline-flex items-center gap-1.5 justify-end">
                                            <button @click="edit = true" class="p-1.5 rounded-lg border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-800 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('superadmin.categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-rose-600 transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <div x-show="edit" class="inline-flex items-center gap-1">
                                            <button type="submit" form="edit-form-{{ $cat->id }}" class="font-bold text-white bg-[#0f333a] text-[11px] px-2.5 py-1 rounded-lg">Simpan</button>
                                            <button @click="edit = false" type="button" class="text-slate-500 text-[11px] bg-slate-100 px-2.5 py-1 rounded-lg">Batal</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-slate-400">Belum ada kategori tiket.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-[10px] text-slate-400 text-center sm:hidden italic pt-3">
                    ← Geser tabel ke samping untuk melihat detail lengkap →
                </div>
            </div>
        </div>
    </div>
</x-app-layout>