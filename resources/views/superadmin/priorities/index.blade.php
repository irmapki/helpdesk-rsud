<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Prioritas Tiket & Konfigurasi SLA') }}
            </h2>
            <p class="text-xs text-gray-500 mt-1">Pengaturan Service Level Agreement (SLA) waktu respon dan target penyelesaian masalah IT di RSUD</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Add Priority Form (1 col) -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-teal-50 text-teal-700 text-xs flex items-center justify-center font-bold">+</span>
                        Tambah Prioritas & SLA Baru
                    </h3>

                    <form action="{{ route('superadmin.priorities.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Prioritas <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" required placeholder="Contoh: Critical / Urgent / High" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="sla_hours" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Target SLA Maksimal (Jam) <span class="text-red-500">*</span></label>
                            <input type="number" name="sla_hours" id="sla_hours" required min="1" max="720" placeholder="Contoh: 2 atau 4 atau 8" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500 @error('sla_hours') border-red-500 @enderror">
                            @error('sla_hours') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Warna Badge</label>
                            <select name="color" id="color" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500">
                                <option value="red">Merah (Darurat / High)</option>
                                <option value="yellow">Kuning / Oranye (Medium / Sedang)</option>
                                <option value="green">Hijau (Low / Rendah)</option>
                                <option value="blue">Biru (Normal)</option>
                                <option value="purple">Ungu (Khusus)</option>
                            </select>
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Keterangan / Kriteria Kendala</label>
                            <textarea name="description" id="description" rows="2" placeholder="Contoh: Digunakan untuk sistem pelayanan pasien IGD & ICU yang terhenti..." class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-sm transition">
                            Simpan Prioritas & SLA
                        </button>
                    </form>
                </div>

                <!-- Priorities List (2 cols) -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-4">Daftar Konfigurasi SLA & Prioritas</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100 dark:border-gray-700">
                                <tr>
                                    <th class="px-4 py-3">Tingkat Prioritas</th>
                                    <th class="px-4 py-3">Batas SLA</th>
                                    <th class="px-4 py-3">Keterangan Kriteria</th>
                                    <th class="px-4 py-3 text-center">Jumlah Tiket</th>
                                    <th class="px-4 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($priorities as $pri)
                                    <tr x-data="{ edit: false }" class="hover:bg-gray-50/70 dark:hover:bg-gray-750 transition">
                                        <td class="px-4 py-3">
                                            <div x-show="!edit">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg font-bold border {{ $pri->badge_class }}">
                                                    {{ $pri->name }}
                                                </span>
                                            </div>
                                            <div x-show="edit">
                                                <input type="text" form="edit-pri-form-{{ $pri->id }}" name="name" value="{{ $pri->name }}" class="text-xs rounded-lg border-gray-200 p-1.5 w-full">
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div x-show="!edit" class="font-bold text-gray-900 dark:text-white">
                                                {{ $pri->sla_hours }} Jam ({{ $pri->sla_hours * 60 }} Menit)
                                            </div>
                                            <div x-show="edit">
                                                <input type="number" form="edit-pri-form-{{ $pri->id }}" name="sla_hours" value="{{ $pri->sla_hours }}" class="text-xs rounded-lg border-gray-200 p-1.5 w-24">
                                                <input type="hidden" form="edit-pri-form-{{ $pri->id }}" name="color" value="{{ $pri->color }}">
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500">
                                            <div x-show="!edit">{{ $pri->description ?: '-' }}</div>
                                            <div x-show="edit">
                                                <input type="text" form="edit-pri-form-{{ $pri->id }}" name="description" value="{{ $pri->description }}" class="text-xs rounded-lg border-gray-200 p-1.5 w-full">
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center font-bold text-teal-600">
                                            {{ $pri->tickets_count }}
                                        </td>
                                        <td class="px-4 py-3 text-right space-x-2">
                                            <form id="edit-pri-form-{{ $pri->id }}" action="{{ route('superadmin.priorities.update', $pri) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <div x-show="!edit" class="inline space-x-2">
                                                <button @click="edit = true" class="font-bold text-teal-600 hover:text-teal-800">Edit</button>
                                                @if ($pri->tickets_count == 0)
                                                    <form action="{{ route('superadmin.priorities.destroy', $pri) }}" method="POST" class="inline" onsubmit="return confirm('Hapus prioritas ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-bold text-red-500 hover:text-red-700">Hapus</button>
                                                    </form>
                                                @endif
                                            </div>

                                            <div x-show="edit" class="inline space-x-1">
                                                <button type="submit" form="edit-pri-form-{{ $pri->id }}" class="font-bold text-emerald-600 hover:text-emerald-800 text-[11px] bg-emerald-50 px-2 py-1 rounded">Simpan</button>
                                                <button @click="edit = false" type="button" class="text-gray-500 text-[11px] bg-gray-100 px-2 py-1 rounded">Batal</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-gray-400">Belum ada prioritas SLA.</td>
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
