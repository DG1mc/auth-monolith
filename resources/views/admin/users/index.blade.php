<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="py-2 pe-4">Nama</th>
                                <th class="py-2 pe-4">Email</th>
                                <th class="py-2 pe-4">Role</th>
                                <th class="py-2 pe-4">Terdaftar</th>
                                <th class="py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-3 pe-4">{{ $user->name }}</td>
                                    <td class="py-3 pe-4">{{ $user->email }}</td>
                                    <td class="py-3 pe-4">
                                        @if ($user->is(auth()->user()))
                                            {{ ucfirst($user->role) }} <span class="text-gray-400">(Anda)</span>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.role', $user) }}" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" class="border-gray-300 rounded-md shadow-sm text-sm">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->value }}" @selected($user->role === $role->value)>{{ $role->label() }}</option>
                                                    @endforeach
                                                </select>
                                                <x-primary-button>{{ __('Ubah') }}</x-primary-button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="py-3 pe-4">{{ $user->created_at?->format('d M Y') }}</td>
                                    <td class="py-3">
                                        @unless ($user->is(auth()->user()))
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                  onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button>{{ __('Hapus') }}</x-danger-button>
                                            </form>
                                        @endunless
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
