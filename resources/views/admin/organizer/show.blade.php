<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.organizer.index') }}" class="mr-4 text-gray-400 hover:text-gray-600 transition-colors">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Detail Penyelenggara: {{ $organizer->name }}
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8">
            
            <!-- Kolom Kiri: Logo -->
            <div class="md:col-span-4 lg:col-span-3">
                <h3 class="text-lg font-bold text-brand-ink mb-4 md:mb-6 pb-4 border-b border-gray-100 text-center md:text-left">Logo Komunitas / Masjid</h3>
                <div class="w-full aspect-square bg-gray-50 rounded-full overflow-hidden border border-gray-200 shadow-sm flex items-center justify-center mx-auto md:mx-0 max-w-[200px]">
                    @if($organizer->logo)
                        <img src="{{ Storage::url($organizer->logo) }}" alt="Logo {{ $organizer->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                            <i data-lucide="image" class="w-10 h-10 mb-2"></i>
                            <span class="text-xs font-medium text-center">Belum ada logo</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kolom Kanan: Informasi Utama -->
            <div class="md:col-span-8 lg:col-span-9 md:border-l border-gray-100 md:pl-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 md:mb-6 pb-4 border-b border-gray-100 gap-4">
                    <h3 class="text-lg font-bold text-brand-ink">Informasi Utama</h3>
                    <div>
                        @if($organizer->is_verified)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-brand-emerald-100 text-brand-emerald-950">
                                <i data-lucide="check-circle-2" class="w-4 h-4 mr-1.5"></i> Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                <i data-lucide="clock" class="w-4 h-4 mr-1.5"></i> Belum Diverifikasi
                            </span>
                        @endif
                    </div>
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Nama Penyelenggara</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $organizer->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Nomor Telepon / WhatsApp</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $organizer->phone ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Email Akun</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $organizer->user->email ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Titik Koordinat (Lat, Lng)</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $organizer->latitude ?? '-' }}, {{ $organizer->longitude ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Alamat Pusat / Sekretariat</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $organizer->address ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Deskripsi / Tentang Kami</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-normal leading-relaxed whitespace-pre-wrap max-h-40 overflow-y-auto pr-2 custom-scrollbar">{{ $organizer->description ?: 'Tidak ada deskripsi.' }}</dd>
                    </div>
                </dl>
                
                <!-- Tombol Aksi Verifikasi -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap gap-3">
                    <form action="{{ route('admin.organizer.verify', $organizer->id) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @if($organizer->is_verified)
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-brand-ink bg-white text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                                <i data-lucide="shield-x" class="w-4 h-4 mr-2 text-brand-danger"></i> Cabut Verifikasi
                            </button>
                        @else
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition">
                                <i data-lucide="shield-check" class="w-4 h-4 mr-2"></i> Verifikasi Sekarang
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
