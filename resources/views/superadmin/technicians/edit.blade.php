<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Edit Data Teknisi: ') }} {{ $technician->name }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Perbarui keahlian, nomor kontak WhatsApp, dan status aktif teknisi</p>
            </div>
            <a href="{{ route('superadmin.technicians.index') }}" class="text-xs font-semibold text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-xl transition">
                &larr; Kembali ke Data Teknisi
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6 sm:p-8">
                <form action="{{ route('superadmin.technicians.update', $technician) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nama Teknisi</label>
                        <div class="text-sm font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-750 p-3 rounded-xl border border-gray-150">
                            {{ $technician->name }} ({{ $technician->email }})
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">No. WhatsApp / HP Teknisi</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $technician->phone) }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500 @error('phone') border-red-500 @enderror">
                        @error('phone') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="specialization" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Keahlian / Spesialisasi Kendala</label>
                        <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $technician->specialization) }}"
                            placeholder="Contoh: Hardware, Printer Resep, Jaringan LAN, SIMRS"
                            class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-teal-500 focus:border-teal-500 @error('specialization') border-red-500 @enderror">
                        @error('specialization') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $technician->is_active) ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                        <label for="is_active" class="text-xs font-semibold text-gray-700 dark:text-gray-300">Teknisi Aktif (Dapat menerima penugasan tiket)</label>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3">
                        <a href="{{ route('superadmin.technicians.index') }}" class="text-xs font-semibold text-gray-500 hover:text-gray-700">Batal</a>
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-6 py-2.5 rounded-xl shadow-sm transition">
                            Simpan Data Teknisi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
