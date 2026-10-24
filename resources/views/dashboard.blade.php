<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-lg font-semibold">Halo, {{ auth()->user()->name }}!</p>
                    <p class="mt-1">Anda login sebagai <strong>{{ auth()->user()->role }}</strong>.</p>
                    <p class="mt-3 text-sm text-gray-600">
                        Halaman ini dapat diakses semua pengguna yang sudah login.
                        Anda dapat mengubah data diri di menu <a class="underline" href="{{ route('profile.edit') }}">Profile</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
