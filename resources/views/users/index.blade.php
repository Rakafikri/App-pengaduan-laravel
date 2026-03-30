<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Tombol Tambah User -->
            <div class="mb-4">
                <a href="{{ route('users.create') }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Tambah User Baru
                </a>
            </div>

            <!-- Pesan Sukses/Error -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tabel Daftar User -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left">No</th>
                                <th class="py-2 text-left">Nama</th>
                                <th class="py-2 text-left">Email</th>
                                <th class="py-2 text-left">Role</th>
                                <th class="py-2 text-left">Terdaftar</th>
                                <th class="py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3">{{ $loop->iteration }}</td>
                                    <td class="py-3">{{ $user->name }}</td>
                                    <td class="py-3">{{ $user->email }}</td>
                                    <td class="py-3">
                                        @if($user->role === 'guru')
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                                Guru
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                                                Siswa
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-3">
                                        <a href="{{ route('users.edit', $user->id) }}" 
                                           class="text-green-600 hover:text-green-900 mr-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-gray-500">
                                        Belum ada user terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>