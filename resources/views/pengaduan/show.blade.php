<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Kembali ke Index -->
            <div class="mb-4">
                <a href="{{ route('pengaduan.index') }}" 
                   class="text-blue-600 hover:text-blue-900">
                    ← Kembali ke Daftar Laporan
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Info Laporan -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-2">Informasi Laporan</h3>
                        <table class="w-full">
                            <tr class="border-b">
                                <td class="py-2 font-semibold">ID Laporan</td>
                                <td class="py-2">#{{ $pengaduan->id }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-2 font-semibold">Pelapor</td>
                                <td class="py-2">{{ $pengaduan->user->nama ?? 'Anonim' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-2 font-semibold">Tanggal</td>
                                <td class="py-2">{{ $pengaduan->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-2 font-semibold">Status</td>
                                <td class="py-2">
                                    @php
                                        $statusColor = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'proses' => 'bg-blue-100 text-blue-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="{{ $statusColor[$pengaduan->status] ?? 'bg-gray-100' }} px-3 py-1 rounded text-sm font-bold">
                                        {{ ucfirst($pengaduan->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Pesan Laporan -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-2">Pesan Laporan</h3>
                        <div class="bg-gray-50 p-4 rounded border">
                            {{ $pengaduan->pesan_laporan }}
                        </div>
                    </div>

                    <!-- Tanggapan Admin -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-2">Tanggapan Admin</h3>
                        @if($pengaduan->tanggapan_admin)
                            <div class="bg-blue-50 p-4 rounded border border-blue-200">
                                {{ $pengaduan->tanggapan_admin }}
                            </div>
                            <p class="text-sm text-gray-500 mt-2">
                                Ditanggapi pada: {{ $pengaduan->updated_at->format('d M Y, H:i') }}
                            </p>
                        @else
                            <div class="bg-gray-100 p-4 rounded border">
                                <p class="text-gray-500 italic">Belum ada tanggapan dari admin.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tombol Aksi (Hanya untuk Admin) -->
                    @if(auth()->user()->role === 'admin')
                        <div class="flex gap-2">
                            <a href="{{ route('pengaduan.edit', $pengaduan->id) }}" 
                               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Update Status
                            </a>
                            <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>