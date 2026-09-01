<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.mosque.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Edit Masjid
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.mosque.update', $mosque->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Kolom Kiri: Informasi Utama -->
                <div>
                    <h3 class="text-base font-semibold text-[#0A2B20] border-b border-gray-100 pb-3 mb-5">
                        Informasi Utama
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Nama Masjid -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Masjid <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required value="{{ old('name', $mosque->name) }}">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Foto Masjid -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Masjid</label>
                            @if($mosque->photo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $mosque->photo) }}" alt="Foto Masjid" class="h-32 object-cover rounded-lg shadow-sm border border-gray-200">
                                </div>
                            @endif
                            <div class="mt-1 flex justify-center items-center px-6 border-2 border-gray-200 border-dashed rounded-xl hover:border-gray-300 hover:bg-gray-50 transition-colors relative group" style="min-height: 215px;">
                                <div class="space-y-1 text-center">
                                    <i data-lucide="image" class="mx-auto h-12 w-12 text-gray-400 group-hover:text-gray-500 mb-3"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="photo" class="relative cursor-pointer rounded-md font-medium text-[#0A2B20] hover:text-[#0C3B2A] focus-within:outline-none">
                                            <span class="font-bold">Pilih file</span>
                                            <input id="photo" name="photo" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                                </div>
                            </div>
                            @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Lokasi & Peta -->
                <div>
                    <h3 class="text-base font-semibold text-[#0A2B20] border-b border-gray-100 pb-3 mb-5">
                        Lokasi & Peta
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Alamat Lengkap -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="address" id="address" rows="5" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 resize-none overflow-y-auto" required>{{ old('address', $mosque->address) }}</textarea>
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Latitude & Longitude -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude <span class="text-red-500">*</span></label>
                                <input type="text" name="latitude" id="latitude" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" value="{{ old('latitude', $mosque->latitude) }}" required>
                                @error('latitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude <span class="text-red-500">*</span></label>
                                <input type="text" name="longitude" id="longitude" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" value="{{ old('longitude', $mosque->longitude) }}" required>
                                @error('longitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Link Google Maps -->
                        <div>
                            <label for="google_maps_url" class="block text-sm font-medium text-gray-700 mb-1">Link Google Maps (Opsional)</label>
                            <input type="url" name="google_maps_url" id="google_maps_url" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" value="{{ old('google_maps_url', $mosque->google_maps_url) }}">
                            @error('google_maps_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-10 flex justify-end gap-3 pt-6">
                <a href="{{ route('admin.mosque.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-brand-emerald-900 border border-transparent rounded-lg hover:bg-brand-emerald-950 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
