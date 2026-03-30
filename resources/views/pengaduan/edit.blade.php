<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Status Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Kembali ke Detail -->
                    <div class="mb-4">
                        <a href="{{ route('pengaduan.show', $pengaduan->id) }}" 
                           class="text-blue-600 hover:text-blue-900">
                            ← Kembali ke Detail Laporan
                        </a>
                    </div>

                    <form action="{{ route('pengaduan.update', $pengaduan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Info Laporan -->
                        <div class="mb-6 bg-gray-50 p-4 rounded">
                            <h3 class="font-bold mb-2">Laporan #{{ $pengaduan->id }}</h3>
                            <p class="text-gray-700">{{ $pengaduan->pesan_laporan }}</p>
                            <p class="text-sm text-gray-500 mt-2">
                                Pelapor: {{ $pengaduan->user->name ?? 'Anonim' }} | 
                                Tanggal: {{ $pengaduan->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Status
                            </label>
                            <select name="status" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror">
                                <option value="pending" {{ $pengaduan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="proses" {{ $pengaduan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggapan Admin -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tanggapan Admin
                            </label>
                            <textarea name="tanggapan_admin" rows="4"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggapan_admin') border-red-500 @enderror"
                                      placeholder="Berikan tanggapan atau update untuk laporan ini...">{{ old('tanggapan_admin', $pengaduan->tanggapan_admin) }}</textarea>
                            @error('tanggapan_admin')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex items-center justify-between">
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Laporan
                            </button>
                            <a href="{{ route('pengaduan.show', $pengaduan->id) }}" 
                               class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>