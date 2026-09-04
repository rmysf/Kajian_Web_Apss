<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.speaker.index') }}" class="mr-4 text-gray-400 hover:text-gray-600 transition-colors">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Edit Data Pemateri
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.speaker.update', $speaker->id) }}" method="POST" enctype="multipart/form-data" x-data="photoPreview('{{ $speaker->photo ? Storage::url($speaker->photo) : '' }}')">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Kolom Kiri: Foto Profil -->
                <div class="lg:col-span-1">
                    <h3 class="text-base font-semibold text-brand-emerald-900 border-b border-gray-100 pb-3 mb-5">
                        Foto Profil
                    </h3>
                    
                    <div class="flex flex-col items-center justify-center py-4">
                        <input type="file" name="photo" id="photo" accept="image/*" class="sr-only" @change="fileChosen">
                        <label for="photo" class="relative w-48 h-48 rounded-full border border-gray-200 shadow-sm overflow-hidden bg-gray-50 mb-4 flex items-center justify-center group cursor-pointer hover:border-gray-300 transition-colors">
                            <template x-if="imageUrl">
                                <img :src="imageUrl" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" alt="Preview" />
                            </template>
                            <template x-if="!imageUrl">
                                <i data-lucide="user" class="w-16 h-16 text-gray-300"></i>
                            </template>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i data-lucide="camera" class="w-8 h-8 text-white"></i>
                            </div>
                        </label>
                        
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                            <p x-show="fileError" x-text="fileError" class="mt-2 text-sm text-red-500" style="display: none;"></p>
                            @error('photo')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Informasi Utama -->
                <div class="lg:col-span-2">
                    <h3 class="text-base font-semibold text-brand-emerald-900 border-b border-gray-100 pb-3 mb-5">
                        Informasi Utama
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Nama -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $speaker->name) }}" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi / Bio -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Biografi / Deskripsi Singkat</label>
                            <textarea name="description" id="description" rows="6" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 resize-none overflow-y-auto">{{ old('description', $speaker->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.speaker.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-brand-emerald-900 border border-transparent rounded-lg hover:bg-brand-emerald-950 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        function photoPreview(initialUrl) {
            return {
                imageUrl: initialUrl || null,
                fileError: null,
                fileChosen(event) {
                    if (! event.target.files.length) return;
                    let file = event.target.files[0];
                    if (file.size > 2 * 1024 * 1024) {
                        this.fileError = 'Ukuran file maksimal adalah 2MB. Silakan pilih file yang lebih kecil.';
                        event.target.value = '';
                        return;
                    }
                    this.fileError = null;
                    this.fileToDataUrl(file, src => this.imageUrl = src)
                },
                fileToDataUrl(file, callback) {
                    let reader = new FileReader()
                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
            }
        }
    </script>
</x-admin-layout>
