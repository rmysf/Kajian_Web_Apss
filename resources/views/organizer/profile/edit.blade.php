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

        <form id="profileForm" action="{{ route('organizer.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8" x-data="{
            originalImageUrl: '{{ $organizer->logo ? \Illuminate\Support\Facades\Storage::url($organizer->logo) : '' }}',
            imageUrl: '{{ $organizer->logo ? \Illuminate\Support\Facades\Storage::url($organizer->logo) : '' }}',
            fileError: null,
            isEditing: {{ $errors->any() ? 'true' : 'false' }},
            fileChosen(event) {
                if (! event.target.files.length) return;
                let file = event.target.files[0];
                if (file.size > 2 * 1024 * 1024) {
                    this.fileError = 'Ukuran file maksimal adalah 2MB. Silakan pilih file yang lebih kecil.';
                    event.target.value = '';
                    return;
                }
                this.fileError = null;
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = e => this.imageUrl = e.target.result;
            },
            cancelEdit() {
                this.isEditing = false;
                this.imageUrl = this.originalImageUrl;
                this.fileError = null;
                document.getElementById('profileForm').reset();
            }
        }">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Kolom Kiri: Logo -->
                <div class="lg:col-span-1">
                    <h3 class="text-base font-semibold text-brand-emerald-900 border-b border-gray-100 pb-3 mb-5">
                        Logo Komunitas / Masjid
                    </h3>
                    
                    <div class="flex flex-col items-center justify-center py-4">
                        <input type="file" name="logo" id="logo" accept="image/*" class="sr-only" @change="fileChosen" :disabled="!isEditing">
                        <label for="logo" class="relative w-48 h-48 rounded-full border border-gray-200 shadow-sm overflow-hidden bg-gray-50 mb-4 flex items-center justify-center group transition-colors"
                               :class="isEditing ? 'cursor-pointer hover:border-gray-300' : 'cursor-default'">
                            <template x-if="imageUrl">
                                <img :src="imageUrl" class="w-full h-full object-cover transition-transform duration-300" :class="isEditing ? 'group-hover:scale-105' : ''" alt="Preview" />
                            </template>
                            <template x-if="!imageUrl">
                                <i data-lucide="image" class="w-16 h-16 text-gray-300"></i>
                            </template>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 transition-opacity duration-300"
                                 x-bind:class="isEditing ? 'group-hover:opacity-100' : ''">
                                <i data-lucide="camera" class="w-8 h-8 text-white"></i>
                            </div>
                        </label>
                        
                        <label for="logo" x-show="isEditing" x-cloak class="cursor-pointer inline-flex items-center px-4 py-2 border border-brand-border-light rounded-md shadow-sm text-sm font-medium text-brand-ink bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition mb-2">
                            <i data-lucide="upload" class="w-4 h-4 mr-2"></i> Pilih Foto
                        </label>

                        <div class="text-center" x-show="isEditing" x-cloak>
                            <p class="text-xs text-gray-500">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                            <p x-show="fileError" x-text="fileError" class="mt-2 text-sm text-red-500" style="display: none;"></p>
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
                                <label for="name" class="block text-sm font-medium text-brand-ink mb-1">Nama Penyelenggara <span class="text-brand-danger" x-show="isEditing" x-cloak>*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $organizer->name) }}" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm disabled:bg-gray-50 disabled:text-gray-600 disabled:border-gray-200" required :disabled="!isEditing">
                                @error('name')
                                    <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kontak / Telepon -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-brand-ink mb-1">Nomor Telepon / WhatsApp</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $organizer->phone) }}" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm disabled:bg-gray-50 disabled:text-gray-600 disabled:border-gray-200" placeholder="Contoh: 081234567890" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" :disabled="!isEditing">
                                @error('phone')
                                    <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-brand-ink mb-1">Deskripsi / Tentang Kami</label>
                            <textarea name="description" id="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm resize-none overflow-y-auto disabled:bg-gray-50 disabled:text-gray-600 disabled:border-gray-200" placeholder="Ceritakan singkat mengenai komunitas atau DKM Anda..." :disabled="!isEditing">{{ old('description', $organizer->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Pusat -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-brand-ink mb-1">Alamat Pusat / Sekretariat</label>
                            <textarea name="address" id="address" rows="2" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm resize-none overflow-y-auto disabled:bg-gray-50 disabled:text-gray-600 disabled:border-gray-200" :disabled="!isEditing">{{ old('address', $organizer->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Titik Koordinat -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-sm font-medium text-brand-ink">Titik Koordinat <span class="text-brand-danger" x-show="isEditing" x-cloak>*</span></label>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" autocomplete="off" required name="latitude" id="latitude" value="{{ old('latitude', $organizer->latitude) }}" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm text-sm disabled:bg-gray-50 disabled:text-gray-600 disabled:border-gray-200" placeholder="Latitude" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.-]/g, '')" :disabled="!isEditing">
                                    @error('latitude')
                                        <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" autocomplete="off" required name="longitude" id="longitude" value="{{ old('longitude', $organizer->longitude) }}" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm text-sm disabled:bg-gray-50 disabled:text-gray-600 disabled:border-gray-200" placeholder="Longitude" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.-]/g, '')" :disabled="!isEditing">
                                    @error('longitude')
                                        <p class="mt-1 text-sm text-brand-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end items-center space-x-3">
                <button type="button" x-show="!isEditing" @click="isEditing = true" class="inline-flex justify-center items-center px-6 py-2 border border-brand-emerald-900 text-sm font-medium rounded-lg text-brand-emerald-900 bg-white hover:bg-brand-emerald-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition shadow-sm">
                    <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Edit Profil
                </button>
                
                <button type="button" x-show="isEditing" @click="cancelEdit()" x-cloak class="inline-flex justify-center items-center px-6 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition shadow-sm">
                    Batal
                </button>

                <button type="submit" x-show="isEditing" x-cloak class="inline-flex justify-center items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>


</x-organizer-layout>
