<x-app-layout>
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
                    </div>
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
