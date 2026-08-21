<x-app-layout>
    <x-slot name="pageTitle">
        Edit Teknisi
    </x-slot>
    <x-slot name="breadcrumb">
        Super Admin &rsaquo; Manajemen Staf &rsaquo; Edit Teknisi: {{ $technician->name }}
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Data &amp; Kontak Teknisi</h1>
                <p class="text-xs text-slate-500 mt-1">Perbarui nomor WhatsApp dan fokus keahlian penanganan teknisi.</p>
            </div>
            <a href="{{ route('superadmin.technicians.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2.5 rounded-xl transition">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 lg:p-8">
            <form action="{{ route('superadmin.technicians.update', $technician) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Teknisi</label>
                    <input type="text" value="{{ $technician->name }}" disabled class="w-full text-xs rounded-xl border-slate-200 bg-slate-100 text-slate-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor WhatsApp Teknisi</label>
                    <input type="text" name="phone" value="{{ old('phone', $technician->phone) }}" class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500" placeholder="081234567890">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Spesialisasi / Keahlian Utama</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $technician->specialization) }}" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500" placeholder="contoh: Hardware, Jaringan LAN, SIMRS & Bridging BPJS">
                </div>

                <div class="pt-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $technician->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span class="ml-2 text-xs font-bold text-slate-700">Teknisi Aktif (Dapat menerima penugasan tiket)</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                    <a href="{{ route('superadmin.technicians.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-[#0a252a] hover:bg-[#0e353c] shadow-xs">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
