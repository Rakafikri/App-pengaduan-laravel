<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Laporan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('pengaduan.store') }}" method="POST">
                        @csrf

                        <!-- Pesan Laporan -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Pesan Laporan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="pesan_laporan" rows="5"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pesan_laporan') border-red-500 @enderror"
                                      placeholder="Jelaskan masalah sarana/prasarana yang ingin dilaporkan...">{{ old('pesan_laporan') }}</textarea>
                            @error('pesan_laporan')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex items-center justify-between">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kirim Laporan
                            </button>
                            <a href="{{ route('pengaduan.index') }}" 
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