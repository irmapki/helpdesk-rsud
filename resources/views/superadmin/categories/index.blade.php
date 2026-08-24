<x-app-layout>
<<<<<<< HEAD
    <div class="space-y-6">
        <!-- Top Title -->
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kategori Tiket</h1>
            <p class="text-xs text-slate-500 font-normal mt-1">Master kategori kendala pengaduan IT RSUD RAA Soewondo Pati (Hardware, Software, SIMRS, Jaringan, dll).</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Add Category Form (1 col) -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-sm">
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
                        @error('name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
=======
    <x-slot name="pageTitle">
        Kategori Tiket
    </x-slot>
    <x-slot name="breadcrumb">
        Super Admin &rsaquo; Master Data &rsaquo; Kategori Tiket
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Kategori Tiket Pengaduan</h1>
                <p class="text-xs text-slate-500 mt-1">Klasifikasi jenis permasalahan IT untuk memudahkan penanganan dan penugasan teknisi.</p>
            </div>

            <!-- Modal / Form Trigger -->
            <div x-data="{ openAdd: false }">
                <button @click="openAdd = true" class="inline-flex items-center justify-center gap-2 bg-[#0a252a] hover:bg-[#0e353c] text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition">
                    + Tambah Kategori
                </button>

                <!-- Add Category Modal -->
                <div x-show="openAdd" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4" x-cloak>
                    <div @click.away="openAdd = false" class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-extrabold text-sm text-slate-900">Tambah Kategori Baru</h3>
                            <button @click="openAdd = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                        </div>
                        <form action="{{ route('superadmin.categories.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Kategori</label>
                                <input type="text" name="name" required placeholder="contoh: SIMRS & Bridging BPJS" class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi / Contoh Kasus</label>
                                <textarea name="description" rows="2" placeholder="contoh: Error login SIMRS, kendala SEP BPJS..." class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500"></textarea>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="openAdd = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200">Batal</button>
                                <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#0a252a] hover:bg-[#0e353c]">Simpan</button>
                            </div>
                        </form>
>>>>>>> f4c8eafc5fe0abfe5e41063d4fc6d2e45d4dd3a4
                    </div>

                    <div>
                        <label for="description" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1">Deskripsi Layanan</label>
                        <textarea name="description" id="description" rows="3" placeholder="Keterangan singkat cakupan kendala kategori ini..."
                            class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 focus:ring-emerald-600 focus:border-emerald-600 placeholder-slate-400 font-medium"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-[#0f333a] hover:bg-[#092227] text-white font-bold py-2.5 px-4 rounded-xl shadow-xs transition">
                        Simpan Kategori
                    </button>
                </form>
            </div>

            <!-- Categories List (2 cols) -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 overflow-hidden">
                <h3 class="font-bold text-base text-slate-900 mb-4">Daftar Kategori Tiket</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
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
                                            <input type="text" form="edit-form-{{ $cat->id }}" name="name" value="{{ $cat->name }}" class="text-xs rounded-xl border-slate-200 bg-white text-slate-800 p-1.5 w-full">
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-2 text-slate-500">
                                        <div x-show="!edit">{{ $cat->description ?: '-' }}</div>
                                        <div x-show="edit">
                                            <input type="text" form="edit-form-{{ $cat->id }}" name="description" value="{{ $cat->description }}" class="text-xs rounded-xl border-slate-200 bg-white text-slate-800 p-1.5 w-full">
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-2 text-center font-bold text-slate-800">
                                        {{ $cat->tickets_count }}
                                    </td>
                                    <td class="py-3.5 px-2 text-right">
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
                                            @if ($cat->tickets_count == 0)
                                                <form action="{{ route('superadmin.categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
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
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($categories as $cat)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 flex flex-col justify-between" x-data="{ openEdit: false }">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400">{{ $cat->tickets->count() }} Tiket</span>
                        </div>
                        <h2 class="text-sm font-extrabold text-slate-900">{{ $cat->name }}</h2>
                        <p class="text-xs text-slate-500 mt-1">{{ $cat->description ?: 'Kategori kendala operasional rumah sakit.' }}</p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                        <button @click="openEdit = true" class="text-xs font-bold text-slate-600 hover:text-teal-700 bg-slate-50 px-3 py-1.5 rounded-lg">
                            Edit
                        </button>
                        <form action="{{ route('superadmin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-slate-400 hover:text-rose-600 bg-slate-50 px-3 py-1.5 rounded-lg">
                                Hapus
                            </button>
                        </form>
                    </div>

                    <!-- Edit Modal -->
                    <div x-show="openEdit" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4" x-cloak>
                        <div @click.away="openEdit = false" class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="font-extrabold text-sm text-slate-900">Edit Kategori</h3>
                                <button @click="openEdit = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                            </div>
                            <form action="{{ route('superadmin.categories.update', $cat) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Kategori</label>
                                    <input type="text" name="name" value="{{ $cat->name }}" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi</label>
                                    <textarea name="description" rows="2" class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">{{ $cat->description }}</textarea>
                                </div>
                                <div class="flex justify-end gap-2 pt-2">
                                    <button type="button" @click="openEdit = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200">Batal</button>
                                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#0a252a] hover:bg-[#0e353c]">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
