<x-app-layout>
    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Halaman (Menyesuaikan standar judul menu admin) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">
                    {{ __('Profil Pengguna') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola informasi profil, alamat email, dan keamanan kata sandi akun Anda.
                </p>
            </div>

            <!-- Card Update Profile Information -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Card Update Password -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Card Delete User -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>