<x-organizer-layout>
    <x-slot name="header">
        Profil Penyelenggara
    </x-slot>

    @if(!$organizer->is_verified)
    <div class="mb-6 rounded-xl bg-amber-50 p-4 border border-amber-200 shadow-sm flex items-start">
        <i data-lucide="alert-circle" class="w-5 h-5 text-amber-600 mt-0.5 mr-3 flex-shrink-0"></i>
        <div>
            <h3 class="text-sm font-semibold text-amber-800">Menunggu Verifikasi Admin</h3>
            <p class="mt-1 text-sm text-amber-700">Akun penyelenggara Anda saat ini sedang dalam proses peninjauan oleh admin pusat. Beberapa fitur mungkin dibatasi hingga akun Anda terverifikasi.</p>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-brand-ink">Informasi Profil</h2>
                <p class="text-sm text-brand-ink-soft">Perbarui detail profil penyelenggara Anda yang akan dilihat oleh jamaah.</p>
            </div>
        </div>

        <form action="{{ route('organizer.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8" x-data="photoPreview('{{ $organizer->logo ? \Illuminate\Support\Facades\Storage::url($organizer->logo) : '' }}')">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Kolom Kiri: Logo -->
                <div class="lg:col-span-1">
                    <h3 class="text-base font-semibold text-brand-emerald-900 border-b border-gray-100 pb-3 mb-5">
                        Logo Komunitas / Masjid
                    </h3>
                    
                    <div class="flex flex-col items-center justify-center py-4">
                        <input type="file" name="logo" id="logo" accept="image/*" class="sr-only" @change="fileChosen">
                        <label for="logo" class="relative w-48 h-48 rounded-full border border-gray-200 shadow-sm overflow-hidden bg-gray-50 mb-4 flex items-center justify-center group cursor-pointer hover:border-gray-300 transition-colors">
                            <template x-if="imageUrl">
                                <img :src="imageUrl" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" alt="Preview" />
                            </template>
                            <template x-if="!imageUrl">
                                <i data-lucide="image" class="w-16 h-16 text-gray-300"></i>
                            </template>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i data-lucide="camera" class="w-8 h-8 text-white"></i>
                            </div>
                        </label>
                        
                        <label for="logo" class="cursor-pointer inline-flex items-center px-4 py-2 border border-brand-border-light rounded-md shadow-sm text-sm font-medium text-brand-ink bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition mb-2">
                            <i data-lucide="upload" class="w-4 h-4 mr-2"></i> Pilih Foto
                        </label>

                        <div class="text-center">
                            <p class="text-xs text-gray-500">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                            @error('logo')
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-brand-ink mb-1">Nama Penyelenggara <span class="text-brand-danger">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $organizer->name) }}" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kontak / Telepon -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-brand-ink mb-1">Nomor Telepon / WhatsApp</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $organizer->phone) }}" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm" placeholder="Contoh: 081234567890">
                                @error('phone')
                                    <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-brand-ink mb-1">Deskripsi / Tentang Kami</label>
                            <textarea name="description" id="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm resize-none overflow-y-auto" placeholder="Ceritakan singkat mengenai komunitas atau DKM Anda...">{{ old('description', $organizer->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Pusat -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-brand-ink mb-1">Alamat Pusat / Sekretariat</label>
                            <textarea name="address" id="address" rows="2" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm resize-none overflow-y-auto">{{ old('address', $organizer->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Titik Koordinat -->
                        <div x-data="{ 
                            latitude: '{{ old('latitude', $organizer->latitude) }}', 
                            longitude: '{{ old('longitude', $organizer->longitude) }}',
                            loadingLocation: false,
                            getLocation() {
                                if (navigator.geolocation) {
                                    this.loadingLocation = true;
                                    navigator.geolocation.getCurrentPosition(
                                        (position) => {
                                            this.latitude = position.coords.latitude;
                                            this.longitude = position.coords.longitude;
                                            this.loadingLocation = false;
                                        },
                                        (error) => {
                                            alert('Gagal mendapatkan lokasi. Pastikan izin lokasi diberikan pada browser Anda.');
                                            this.loadingLocation = false;
                                        }
                                    );
                                } else {
                                    alert('Geolocation tidak didukung oleh browser ini.');
                                }
                            }
                        }">
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-sm font-medium text-brand-ink">Titik Koordinat (Opsional)</label>
                                <button type="button" @click="getLocation()" class="inline-flex items-center text-xs text-brand-emerald-600 hover:text-brand-emerald-800 font-medium transition-colors">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 mr-1" :class="loadingLocation ? 'animate-bounce' : ''"></i> 
                                    <span x-text="loadingLocation ? 'Mendeteksi...' : 'Ambil Lokasi Saat Ini'"></span>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" name="latitude" id="latitude" x-model="latitude" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm text-sm" placeholder="Latitude">
                                    @error('latitude')
                                        <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" name="longitude" id="longitude" x-model="longitude" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm text-sm" placeholder="Longitude">
                                    @error('longitude')
                                        <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit" class="inline-flex justify-center items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Alpine Component for Image Preview -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('photoPreview', (initialUrl) => ({
                imageUrl: initialUrl,
                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },
                fileToDataUrl(event, callback) {
                    if (! event.target.files.length) return
                    let file = event.target.files[0],
                        reader = new FileReader()
                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
            }))
        })
    </script>
</x-organizer-layout>
