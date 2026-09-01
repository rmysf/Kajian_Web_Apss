<x-organizer-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Poster Kajian</label>
                            @if($kajian->poster)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $kajian->poster) }}" alt="Poster" class="w-32 h-32 object-cover rounded-lg shadow-sm border border-gray-200">
                                </div>
                            @endif
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-lg hover:border-gray-300 hover:bg-gray-50 transition-colors relative group">
                                <div class="space-y-1 text-center">
                                    <i data-lucide="image-plus" class="mx-auto h-8 w-8 text-gray-400 group-hover:text-gray-500"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="poster" class="relative cursor-pointer rounded-md font-medium text-brand-emerald-900 hover:text-brand-emerald-800 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-emerald-900">
                                            <span>Pilih file</span>
                                            <input id="poster" name="poster" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">Format: JPG, PNG, WEBP. Maks 2MB. Biarkan kosong jika tak diubah.</p>
                                </div>
                            </div>
                            @error('poster') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                            <label for="mosque_id" class="block text-sm font-medium text-gray-700 mb-1">Masjid / Lokasi <span class="text-red-500">*</span></label>
                            <select name="mosque_id" id="mosque_id" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 text-gray-600" required>
                                <option value="" disabled>-- Pilih Masjid --</option>
                                @foreach($mosques as $mosque)
                                    <option value="{{ $mosque->id }}" {{ old('mosque_id', $kajian->mosque_id) == $mosque->id ? 'selected' : '' }}>{{ $mosque->name }}</option>
                                @endforeach
                            </select>
                            @error('mosque_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                                <input type="text" name="latitude" id="latitude" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" value="{{ old('latitude', $kajian->latitude) }}" required>
                                @error('latitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude <span class="text-red-500">*</span></label>
                                <input type="text" name="longitude" id="longitude" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" value="{{ old('longitude', $kajian->longitude) }}" required>
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
                            <input type="number" name="price" id="price" class="block w-full rounded-md border-gray-200 pl-10 focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50 bg-white" placeholder="0" value="{{ old('price', $kajian->price) }}">
                        </div>
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kuota Peserta -->
                    <div>
                        <label for="quota" class="block text-sm font-medium text-gray-700 mb-1">Kuota Peserta</label>
                        <input type="number" name="quota" id="quota" min="1" class="w-full rounded-md border-gray-200 shadow-sm focus:border-brand-emerald-900 focus:ring focus:ring-brand-emerald-900 focus:ring-opacity-50" placeholder="Kosongkan jika tak terbatas" value="{{ old('quota', $kajian->quota) }}">
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                if (radioFree.checked) {
                    priceContainer.style.display = 'none';
                    priceInput.value = '';
                } else {
                    priceContainer.style.display = 'block';
                }
            }

            radioFree.addEventListener('change', togglePrice);
            radioPaid.addEventListener('change', togglePrice);
            
            // Run once on load
            togglePrice();
        });
    </script>
</x-organizer-layout>
