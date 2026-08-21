<x-app-layout>
    <x-slot name="pageTitle">
        Konfigurasi Prioritas &amp; SLA
    </x-slot>
    <x-slot name="breadcrumb">
        Super Admin &rsaquo; Sistem &rsaquo; Konfigurasi SLA
    </x-slot>

    <div class="p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Konfigurasi Prioritas &amp; Target SLA</h1>
                <p class="text-xs text-slate-500 mt-1">Atur target Service Level Agreement (SLA) dalam satuan jam untuk setiap tingkatan urgensi.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($priorities as $pri)
                @php
                    $dotColor = match (strtolower($pri->name)) {
                        'high', 'tinggi', 'critical' => 'bg-rose-500 text-rose-700 bg-rose-50 border-rose-200',
                        'medium', 'sedang' => 'bg-amber-500 text-amber-700 bg-amber-50 border-amber-200',
                        'low', 'rendah' => 'bg-emerald-500 text-emerald-700 bg-emerald-50 border-emerald-200',
                        default => 'bg-slate-400 text-slate-700 bg-slate-50 border-slate-200',
                    };
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 flex flex-col justify-between">
                    <form action="{{ route('superadmin.priorities.update', $pri) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold border {{ $dotColor }}">
                                Prioritas {{ $pri->name }}
                            </span>
                            <span class="text-xs font-mono font-black text-slate-900 bg-slate-100 px-2.5 py-1 rounded-lg">
                                {{ $pri->sla_hours }} JAM
                            </span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Tingkat</label>
                            <input type="text" name="name" value="{{ $pri->name }}" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Batas Waktu SLA (Satuan Jam)</label>
                            <input type="number" name="sla_hours" value="{{ $pri->sla_hours }}" min="1" required class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500 font-mono font-bold">
                            <span class="text-[11px] text-slate-400 mt-1 block">Waktu hitung mundur otomatis sejak tiket dibuat.</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Keterangan / Kriteria</label>
                            <textarea name="description" rows="2" class="w-full text-xs rounded-xl border-slate-200 focus:ring-teal-500 focus:border-teal-500">{{ $pri->description }}</textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full bg-[#0a252a] hover:bg-[#0e353c] text-white font-bold text-xs py-2.5 rounded-xl shadow-xs transition">
                                Simpan SLA {{ $pri->name }}
                            </button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
