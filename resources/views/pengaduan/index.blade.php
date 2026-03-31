<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Tombol Buat Laporan -->
            <div class="mb-4">
                @if(auth()->user()->role !== 'admin')
                    <div class="mb-4">
                        <a href="{{ route('pengaduan.create') }}" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Buat Laporan Baru
                        </a>
                    </div>
                @endif
                
            </div>

            <!-- Pesan Sukses -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabel Daftar Pengaduan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2 text-left">No</th>

                                    <!-- Kolom pelapor. hanya untuk guru -->
                                    @if(auth()->user()->role === 'guru')
                                        <th class="py-2 text-left">Pelapor</th>
                                    @endif

                                    <th class="py-2 text-left">Pesan</th>
                                    <th class="py-2 text-left">Status</th>
                                    <th class="py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengaduan as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3">{{ $loop->iteration }}</td>

                                        <!-- Kolom pelapor. hanya untuk guru -->
                                        @if(auth()->user()->role === 'guru')
                                            <td class="py-3">{{ $item->user->name ?? 'Anonim' }}</td>
                                        @endif

                                        <td class="py-3">{{ Str::limit($item->pesan_laporan, 50) }}</td>
                                        <td class="py-3">
                                            @php
                                                $statusColor = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'proses' => 'bg-blue-100 text-blue-800',
                                                    'selesai' => 'bg-green-100 text-green-800',
                                                    'ditolak' => 'bg-red-100 text-red-800',
                                                ];
                                            @endphp
                                            <span class="{{ $statusColor[$item->status] ?? 'bg-gray-100' }} px-2 py-1 rounded text-sm">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <a href="{{ route('pengaduan.show', $item->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 mr-2">
                                                Lihat
                                            </a>

                                            <!-- Tombol Edit - HANYA untuk Guru -->
                                            @if(auth()->user()->role === 'guru')
                                                <a href="{{ route('pengaduan.edit', $item->id) }}" 
                                                   class="text-green-600 hover:text-green-900">
                                                    Edit
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ auth()->user()->role === 'guru' ? '5' : '4' }}" class="py-4 text-center text-gray-500">
                                            @if(auth()->user()->role === 'siswa')
                                                Belum ada laporan yang kamu buat.
                                            @else
                                                Belum ada laporan pengaduan.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $pengaduan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>