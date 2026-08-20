<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Kategori Tiket') }}
            </h2>
            <p class="text-xs text-gray-500 mt-1">Master kategori kendala pengaduan IT RSUD (Hardware, Software, SIMRS, Jaringan, dll.)</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Add Category Form (1 col) -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-teal-50 text-teal-700 text-xs flex items-center justify-center font-bold">+</span>
                        Tambah Kategori Baru
                    </h3>

                    <form action="{{ route('superadmin.categories.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" required placeholder="Contoh: SIMRS & Database" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Deskripsi Layanan</label>
                            <textarea name="description" id="description" rows="3" placeholder="Keterangan singkat cakupan kendala kategori ini..." class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-sm transition">
                            Simpan Kategori
                        </button>
                    </form>
                </div>

                <!-- Categories List (2 cols) -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-4">Daftar Kategori Tiket</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100 dark:border-gray-700">
                                <tr>
                                    <th class="px-4 py-3">Nama Kategori</th>
                                    <th class="px-4 py-3">Deskripsi</th>
                                    <th class="px-4 py-3 text-center">Jumlah Tiket</th>
                                    <th class="px-4 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($categories as $cat)
                                    <tr x-data="{ edit: false }" class="hover:bg-gray-50/70 dark:hover:bg-gray-750 transition">
                                        <td class="px-4 py-3">
                                            <div x-show="!edit" class="font-bold text-gray-900 dark:text-white">{{ $cat->name }}</div>
                                            <div x-show="edit">
                                                <input type="text" form="edit-form-{{ $cat->id }}" name="name" value="{{ $cat->name }}" class="text-xs rounded-lg border-gray-200 p-1.5 w-full">
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500">
                                            <div x-show="!edit">{{ $cat->description ?: '-' }}</div>
                                            <div x-show="edit">
                                                <input type="text" form="edit-form-{{ $cat->id }}" name="description" value="{{ $cat->description }}" class="text-xs rounded-lg border-gray-200 p-1.5 w-full">
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center font-bold text-teal-600">
                                            {{ $cat->tickets_count }}
                                        </td>
                                        <td class="px-4 py-3 text-right space-x-2">
                                            <form id="edit-form-{{ $cat->id }}" action="{{ route('superadmin.categories.update', $cat) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <div x-show="!edit" class="inline space-x-2">
                                                <button @click="edit = true" class="font-bold text-teal-600 hover:text-teal-800">Edit</button>
                                                @if ($cat->tickets_count == 0)
                                                    <form action="{{ route('superadmin.categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-bold text-red-500 hover:text-red-700">Hapus</button>
                                                    </form>
                                                @endif
                                            </div>

                                            <div x-show="edit" class="inline space-x-1">
                                                <button type="submit" form="edit-form-{{ $cat->id }}" class="font-bold text-emerald-600 hover:text-emerald-800 text-[11px] bg-emerald-50 px-2 py-1 rounded">Simpan</button>
                                                <button @click="edit = false" type="button" class="text-gray-500 text-[11px] bg-gray-100 px-2 py-1 rounded">Batal</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6 text-gray-400">Belum ada kategori tiket.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
