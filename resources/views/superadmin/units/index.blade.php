<x-app-layout>
    <x-slot name="pageTitle">
        Unit / Bagian RSUD
    </x-slot>
    <x-slot name="breadcrumb">
        Super Admin &rsaquo; Master Data &rsaquo; Unit / Bagian
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Unit &amp; Instalasi RSUD</h1>
                <p class="text-xs text-slate-500 mt-1">Daftar ruangan, instalasi, dan poli penempatan perangkat IT di rumah sakit.</p>
            </div>

            <!-- Modal Add Unit -->
            <div x-data="{ openAdd: false }">
                <button @click="openAdd = true" class="inline-flex items-center justify-center gap-2 bg-[#0a252a] hover:bg-[#0e353c] text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition">
                    + Tambah Unit RSUD
                </button>

                <div x-show="openAdd" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4" x-cloak>
                    <div @click.away="openAdd = false" class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-extrabold text-sm text-slate-900">Tambah Unit Baru</h3>
                            <button @click="openAdd = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                        </div>
                        <form action="{{ route('superadmin.units.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Unit / Ruangan</label>
                                <input type="text" name="name" required placeholder="contoh: Instalasi Radiologi & CT-Scan" class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Lokasi Gedung / Lantai</label>
                                <input type="text" name="location" placeholder="contoh: Gedung B Lantai 1" class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi Tambahan</label>
                                <textarea name="description" rows="2" class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500"></textarea>
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

        <!-- Units Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($units as $unit)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 flex flex-col justify-between" x-data="{ openEdit: false }">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400">{{ $unit->tickets->count() }} Tiket</span>
                        </div>
                        <h2 class="text-sm font-extrabold text-slate-900">{{ $unit->name }}</h2>
                        <span class="text-[11px] font-semibold text-emerald-700 block mt-0.5">{{ $unit->location ?: 'Gedung Utama RSUD' }}</span>
                        <p class="text-xs text-slate-500 mt-2">{{ $unit->description ?: 'Unit pelayanan dan administrasi RSUD.' }}</p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                        <button @click="openEdit = true" class="text-xs font-bold text-slate-600 hover:text-teal-700 bg-slate-50 px-3 py-1.5 rounded-lg">
                            Edit
                        </button>
                        <form action="{{ route('superadmin.units.destroy', $unit) }}" method="POST" onsubmit="return confirm('Hapus unit ini?')">
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
                                <h3 class="font-extrabold text-sm text-slate-900">Edit Unit</h3>
                                <button @click="openEdit = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                            </div>
                            <form action="{{ route('superadmin.units.update', $unit) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Unit</label>
                                    <input type="text" name="name" value="{{ $unit->name }}" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Lokasi</label>
                                    <input type="text" name="location" value="{{ $unit->location }}" class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi</label>
                                    <textarea name="description" rows="2" class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">{{ $unit->description }}</textarea>
                                </div>
                                <div class="flex justify-end gap-2 pt-2">
                                    <button type="button" @click="openEdit = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200">Batal</button>
                                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#0a252a] hover:bg-[#0e353c]">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
