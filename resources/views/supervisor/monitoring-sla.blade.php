<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Monitoring SLA</h2>
                <p class="text-sm text-gray-500">Daftar pemantauan batas waktu penanganan tiket</p>
            </div>

            <!-- Table Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">No Tiket</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Kategori</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Teknisi</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Batas Waktu</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status SLA</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($tickets as $ticket)
                                <tr>
                                    <td class="px-4 py-4 text-sm font-semibold text-gray-800">{{ $ticket->ticket_number }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-600">{{ $ticket->category->name ?? '-' }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-600">{{ $ticket->technician->name ?? 'Belum Ditugaskan' }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-600">{{ $ticket->created_at->addHours(24)->format('d M Y, H:i') }}</td>
                                    <td class="px-4 py-4 text-sm">
                                        @php
                                            // Logika sederhana status SLA
                                            $isBreached = now()->greaterThan($ticket->created_at->addHours(24));
                                        @endphp
                                        
                                        @if($isBreached)
                                            <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-[10px] font-bold uppercase">Terlewati</span>
                                        @else
                                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-bold uppercase">Terjaga</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data tiket.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>