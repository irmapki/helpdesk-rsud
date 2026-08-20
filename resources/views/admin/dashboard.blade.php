<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-xl font-bold">Dashboard Admin</h1>
                <p>Selamat datang, {{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>
</x-app-layout>