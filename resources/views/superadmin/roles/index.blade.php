<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Role Pengguna') }}
            </h2>
            <p class="text-xs text-gray-500 mt-1">Daftar peran akses dalam sistem Helpdesk RSUD beserta anggota user</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($roles as $role)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700 shadow-sm p-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-4">
                            <div>
                                <span class="text-xs font-mono uppercase text-teal-600 dark:text-teal-400 font-bold">{{ $role->name }}</span>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $role->label }}</h3>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300">
                                {{ $role->users_count }} Pengguna
                            </span>
                        </div>

                        <div>
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider block mb-2">
                                Anggota dengan Role ini:
                            </span>

                            <div class="space-y-2 max-h-56 overflow-y-auto pr-1">
                                @forelse ($role->users as $u)
                                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 dark:bg-gray-750 text-xs">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-teal-600 text-white font-bold flex items-center justify-center text-[10px]">
                                                {{ substr($u->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white">{{ $u->name }}</div>
                                                <div class="text-gray-400 text-[10px]">{{ $u->email }}</div>
                                            </div>
                                        </div>
                                        <span class="text-[11px] text-gray-500 font-medium">
                                            {{ $u->unit->name ?? 'Semua Unit' }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 py-3 text-center">Belum ada user yang memiliki role ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
