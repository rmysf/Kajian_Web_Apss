<x-organizer-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('organizer.kajian.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Edit Kajian
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('organizer.kajian.update', $kajian->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Kolom Kiri: Informasi Dasar -->
                <div>
                    <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                        <i data-lucide="info" class="w-5 h-5 mr-2 text-gray-500"></i> Informasi Dasar
                    </h3>
                    <div class="space-y-5">
                        <!-- Judul Kajian -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Kajian <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" required value="{{ old('title', $kajian->title) }}">
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Kategori & Pemateri -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                <select name="category_id" id="category_id" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 text-gray-600" required>
                                    <option value="" disabled>-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $kajian->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="speaker_id" class="block text-sm font-medium text-gray-700 mb-1">Pemateri <span class="text-red-500">*</span></label>
                                <select name="speaker_id" id="speaker_id" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 text-gray-600" required>
                                    <option value="" disabled>-- Pilih Pemateri --</option>
                                    @foreach($speakers as $speaker)
                                        <option value="{{ $speaker->id }}" {{ old('speaker_id', $kajian->speaker_id) == $speaker->id ? 'selected' : '' }}>{{ $speaker->name }}</option>
                                    @endforeach
                                </select>
                                @error('speaker_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Poster -->
                        <div x-data="{ imageUrl: '{{ $kajian->poster ? asset('storage/' . $kajian->poster) : '' }}', fileError: null }">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Poster Kajian</label>
                            
                            <input id="poster" name="poster" type="file" class="sr-only" accept="image/*" @change="
                                const file = $event.target.files[0];
                                if (file) {
                                    if (file.size > 2 * 1024 * 1024) {
                                        fileError = 'Ukuran file maksimal adalah 2MB. Silakan pilih file yang lebih kecil.';
                                        $event.target.value = '';
                                        return;
                                    }
                                    fileError = null;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { imageUrl = e.target.result; };
                                    reader.readAsDataURL(file);
                                } else {
                                    // If user cancels file dialog, keep the previous image (either old uploaded or original)
                                    fileError = null;
                                }
                            ">

                            <div class="mt-1 flex justify-center border-2 border-gray-200 border-dashed rounded-lg hover:border-gray-300 hover:bg-gray-50 transition-colors relative overflow-hidden"
                                 :class="{'p-0': imageUrl, 'px-6 pt-5 pb-6': !imageUrl}">
                                 
                                <div class="relative w-full h-48 sm:h-64 group" x-show="imageUrl" style="display: none;" x-cloak>
                                    <img :src="imageUrl" class="w-full h-full object-contain bg-gray-50 rounded-lg">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                        <label for="poster" class="cursor-pointer bg-white text-gray-800 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 flex items-center shadow-sm">
                                            <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Ganti Foto
                                        </label>
                                    </div>
                                </div>

                                <div class="space-y-1 text-center" x-show="!imageUrl">
                                    <i data-lucide="image-plus" class="mx-auto h-8 w-8 text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600 justify-center mt-2">
                                        <label for="poster" class="relative cursor-pointer rounded-md font-medium text-brand-emerald-900 hover:text-brand-emerald-800 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-emerald-900">
                                            <span>Pilih file</span>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maks 2MB. Biarkan kosong jika tak diubah.</p>
                                </div>
                            </div>
                            @error('poster') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            <p x-show="fileError" x-text="fileError" class="text-red-500 text-xs mt-1" style="display: none;"></p>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi / Detail Kajian</label>
                            <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 resize-none overflow-y-auto" placeholder="Jelaskan secara singkat materi yang akan dibahas...">{{ old('description', $kajian->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                @php
                    $startAt = \Carbon\Carbon::parse($kajian->start_at);
                    $endAt = \Carbon\Carbon::parse($kajian->end_at);
                    $tgl = $startAt->format('Y-m-d');
                    $sTime = $startAt->format('H:i');
                    $eTime = $endAt->format('H:i');
                @endphp

                <!-- Kolom Kanan: Waktu & Lokasi -->
                <div>
                    <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                        <i data-lucide="map-pin" class="w-5 h-5 mr-2 text-gray-500"></i> Waktu & Lokasi
                    </h3>
                    <div class="space-y-5">
                        <!-- Tanggal -->
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 text-gray-600" required value="{{ old('tanggal', $tgl) }}">
                            @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Jam Mulai & Jam Selesai -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                                <input type="text" name="start_time" id="start_time" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 text-gray-600 bg-white" required value="{{ old('start_time', $sTime) }}">
                                @error('start_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                                <input type="text" name="end_time" id="end_time" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 text-gray-600 bg-white" required value="{{ old('end_time', $eTime) }}">
                                @error('end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Masjid/Lokasi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Masjid / Lokasi</label>
                            
                            <select name="mosque_id" id="mosque_id" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 text-gray-600">
                                <option value="" {{ old('mosque_id', $kajian->mosque_id) == null ? 'selected' : '' }}>-- Pilih atau Ketik Manual --</option>
                                @foreach($mosques as $mosque)
                                    <option value="{{ $mosque->id }}" {{ old('mosque_id', $kajian->mosque_id) == $mosque->id ? 'selected' : '' }}>{{ $mosque->name }}</option>
                                @endforeach
                            </select>
                            
                            <div class="relative" id="custom_mosque_wrapper" style="display:none;">
                                <input type="text" name="custom_mosque_name" id="custom_mosque_name" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 pr-10" placeholder="Ketik nama masjid / lokasi..." value="{{ old('custom_mosque_name') }}">
                                <div id="btn_cancel_manual" class="absolute inset-y-0 right-0 flex items-center pr-2 cursor-pointer" title="Kembali ke Pilihan">
                                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            
                            @error('mosque_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            @error('custom_mosque_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap / Catatan Rute <span class="text-red-500">*</span></label>
                            <textarea name="address" id="address" rows="3" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 resize-none overflow-y-auto" required placeholder="Alamat lengkap menuju lokasi...">{{ old('address', $kajian->address) }}</textarea>
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Lat Lng -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude <span class="text-red-500">*</span></label>
                                <input type="text" name="latitude" id="latitude" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" value="{{ old('latitude', $kajian->latitude) }}" required inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.-]/g, '')">
                                @error('latitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude <span class="text-red-500">*</span></label>
                                <input type="text" name="longitude" id="longitude" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" value="{{ old('longitude', $kajian->longitude) }}" required inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.-]/g, '')">
                                @error('longitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100 my-8">

            <!-- Audien & Tiket -->
            <div>
                <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                    <i data-lucide="users" class="w-5 h-5 mr-2 text-gray-500"></i> Audien & Tiket
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5">
                    <!-- Tipe Peserta -->
                    <div>
                        <label for="audience" class="block text-sm font-medium text-gray-700 mb-1">Tipe Peserta <span class="text-red-500">*</span></label>
                        <select name="audience" id="audience" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 text-gray-600" required>
                            <option value="umum" {{ old('audience', $kajian->audience) == 'umum' ? 'selected' : '' }}>Umum (Ikhwan & Akhwat)</option>
                            <option value="ikhwan" {{ old('audience', $kajian->audience) == 'ikhwan' ? 'selected' : '' }}>Khusus Ikhwan</option>
                            <option value="akhwat" {{ old('audience', $kajian->audience) == 'akhwat' ? 'selected' : '' }}>Khusus Akhwat</option>
                        </select>
                        @error('audience') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Ramah Keluarga -->
                    <div class="md:pl-12">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ramah Keluarga</label>
                        <div class="h-[42px] flex items-center space-x-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="is_family_friendly" value="1" class="text-brand-emerald-900 border-gray-300 focus:ring-brand-emerald-900 w-4 h-4" {{ old('is_family_friendly', $kajian->is_family_friendly) == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Ya</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="is_family_friendly" value="0" class="text-brand-emerald-900 border-gray-300 focus:ring-brand-emerald-900 w-4 h-4" {{ old('is_family_friendly', $kajian->is_family_friendly) == '0' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Tidak</span>
                            </label>
                        </div>
                    </div>

                    <!-- Harga Tiket -->
                    <div id="price_container">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga Tiket (Rp)</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="text" name="price" id="price" class="block w-full rounded-md border-gray-200 pl-10 focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" placeholder="0" value="{{ old('price', $kajian->price) }}" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kuota Peserta -->
                    <div>
                        <label for="quota" class="block text-sm font-medium text-gray-700 mb-1">Kuota Peserta</label>
                        <input type="text" name="quota" id="quota" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" placeholder="Kosongkan jika tak terbatas" value="{{ old('quota', $kajian->quota) }}" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('quota') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Biaya Tiket -->
                    <div class="md:pl-12">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Tiket</label>
                        <div class="h-[42px] flex items-center space-x-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="is_free" value="1" id="radio_free" class="text-brand-emerald-900 border-gray-300 focus:ring-brand-emerald-900 w-4 h-4" {{ old('is_free', $kajian->is_free) == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Gratis</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="is_free" value="0" id="radio_paid" class="text-brand-emerald-900 border-gray-300 focus:ring-brand-emerald-900 w-4 h-4" {{ old('is_free', $kajian->is_free) == '0' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Berbayar</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Hidden facilities fallback so we don't break validation -->
                    <div class="hidden">
                        <input type="checkbox" name="facilities[]" value="Area Parkir" checked>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end items-center space-x-4 mt-10 pt-4">
                <a href="{{ route('organizer.kajian.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none transition-colors">
                    Batal
                </a>
                <button type="submit" name="status" value="draft" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none transition-colors">
                    Simpan Draft
                </button>
                <button type="submit" name="status" value="published" class="px-5 py-2.5 text-sm font-medium text-white bg-brand-emerald-900 border border-transparent rounded-lg hover:bg-brand-emerald-950 focus:outline-none transition-colors">
                    Publikasikan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        (function() {
            const mosquesData = @json($mosques);

            function initKajianForm() {
            // Prevent double initialization
            const formContainer = document.getElementById('mosque_id');
            if (!formContainer || formContainer.dataset.initialized) return;
            formContainer.dataset.initialized = 'true';
            // Inisialisasi Flatpickr untuk Jam (Format 24 Jam)
            flatpickr("#start_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });
            flatpickr("#end_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });

            const radioFree = document.getElementById('radio_free');
            const radioPaid = document.getElementById('radio_paid');
            const priceInput = document.getElementById('price');
            const priceContainer = document.getElementById('price_container');

            function togglePrice() {
                if (priceInput) {
                    if (radioFree && radioFree.checked) {
                        priceInput.disabled = true;
                        priceInput.value = '';
                        priceInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                        priceInput.classList.remove('bg-white');
                    } else {
                        priceInput.disabled = false;
                        priceInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                        priceInput.classList.add('bg-white');
                    }
                }
            }

            if(radioFree && radioPaid) {
                radioFree.addEventListener('change', togglePrice);
                radioPaid.addEventListener('change', togglePrice);
                // Run once on load
                togglePrice();
            }

            // Autofill Masjid Data
            const mosqueSelect = document.getElementById('mosque_id');
            const customMosqueInput = document.getElementById('custom_mosque_name');
            const customMosqueWrapper = document.getElementById('custom_mosque_wrapper');
            const btnCancelManual = document.getElementById('btn_cancel_manual');
            const addressTextarea = document.getElementById('address');
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');

            function showManualInput() {
                if (mosqueSelect) mosqueSelect.style.display = 'none';
                if (customMosqueWrapper) {
                    customMosqueWrapper.style.display = 'block';
                }
                if (customMosqueInput) {
                    customMosqueInput.focus();
                }
                
                addressTextarea.value = '';
                latInput.value = '';
                lngInput.value = '';
            }

            function showSelectDropdown() {
                if (mosqueSelect) {
                    mosqueSelect.style.display = 'block';
                    mosqueSelect.value = ''; // Reset select to default option
                }
                if (customMosqueWrapper) {
                    customMosqueWrapper.style.display = 'none';
                }
                if (customMosqueInput) {
                    customMosqueInput.value = '';
                }
            }

            if (btnCancelManual) {
                btnCancelManual.addEventListener('click', showSelectDropdown);
            }

            function handleMosqueChange() {
                const selectedId = mosqueSelect.value;
                if (!selectedId || selectedId === '') {
                    // Manual entry
                    showManualInput();
                } else {
                    // Fill fields based on selected mosque
                    const selectedMosque = mosquesData.find(m => m.id == selectedId);
                    if (selectedMosque) {
                        addressTextarea.value = selectedMosque.address;
                        latInput.value = selectedMosque.latitude;
                        lngInput.value = selectedMosque.longitude;
                    }
                }
            }

            if (mosqueSelect) {
                mosqueSelect.addEventListener('change', handleMosqueChange);
                // Check on load if we should show manual input (e.g. validation failed)
                if ((!mosqueSelect.value || mosqueSelect.value === '') && customMosqueInput && customMosqueInput.value !== '') {
                    showManualInput();
                } else if (!mosqueSelect.value || mosqueSelect.value === '') {
                    // If it is editing and it was already manual
                    // Wait, if it was already manual (kajian->mosque_id is null)
                    // Then we should probably show it, but in edit mode we might not have a custom name if they didn't supply one?
                    // Actually if mosque_id is null, it's manual.
                    // So let's show manual if value is empty
                    showManualInput();
                }
            }
        }

        // Run immediately if DOM is ready, otherwise wait for DOMContentLoaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initKajianForm);
        } else {
            initKajianForm();
        }

        // Listen for SPA navigations (Turbo / Livewire)
        document.addEventListener('turbo:load', initKajianForm);
        document.addEventListener('livewire:navigated', initKajianForm);
        })();
    </script>
</x-organizer-layout>
