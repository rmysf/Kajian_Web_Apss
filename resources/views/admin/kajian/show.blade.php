<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.kajian.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Detail Kajian: {{ $kajian->title }}
            
            @if($kajian->is_verified)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-emerald-100 text-brand-emerald-900 ml-2">Disetujui</span>
            @elseif($kajian->status === 'rejected')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">Ditolak</span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-gold-soft text-brand-gold-text ml-2">Menunggu</span>
            @endif
        </div>
    </x-slot>

    <!-- Single Main Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8">
            
            <!-- Kolom Kiri: Poster Kajian -->
            <div class="md:col-span-4 lg:col-span-3">
                <h3 class="text-lg font-bold text-brand-ink mb-4 md:mb-6 pb-4 border-b border-gray-100 text-center md:text-left">Poster Kajian</h3>
                <div class="w-full aspect-[4/5] bg-gray-50 rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                    @if($kajian->poster)
                        <img src="{{ Storage::url($kajian->poster) }}" alt="Poster {{ $kajian->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                            <i data-lucide="image" class="w-10 h-10 mb-2"></i>
                            <span class="text-xs font-medium">Tidak ada poster</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kolom Tengah: Detail Kajian -->
            <div class="md:col-span-8 lg:col-span-9 md:border-l md:border-gray-100 md:pl-6 lg:pl-8">
                <h3 class="text-lg font-bold text-brand-ink mb-4 md:mb-6 pb-4 border-b border-gray-100">Informasi Kajian</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Kategori</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->category->name ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Masjid</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->mosque->name ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Pemateri</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->speaker->name ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Penyelenggara</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->organizer->name ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Audiens</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold capitalize">{{ $kajian->audience === 'umum' ? 'Umum (Ikhwan & Akhwat)' : $kajian->audience }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Ramah Keluarga</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->is_family_friendly ? 'Ya' : 'Tidak' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Biaya Tiket</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->is_free ? 'Gratis' : 'Berbayar' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Harga Tiket</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->is_free || !$kajian->price ? '-' : 'Rp ' . number_format($kajian->price, 0, ',', '.') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Kuota Peserta</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->quota ? $kajian->quota . ' Orang' : 'Tidak Terbatas' }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Waktu Mulai</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ \Carbon\Carbon::parse($kajian->start_at)->translatedFormat('l, d F Y H:i') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Waktu Selesai</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ \Carbon\Carbon::parse($kajian->end_at)->translatedFormat('l, d F Y H:i') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Alamat Lengkap</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->address }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Koordinat (Lat, Lng)</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->latitude }}, {{ $kajian->longitude }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-brand-ink-soft">Deskripsi / Detail Kajian</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-normal leading-relaxed whitespace-pre-wrap max-h-40 overflow-y-auto pr-2 custom-scrollbar">{{ $kajian->description ?: 'Tidak ada deskripsi.' }}</dd>
                    </div>
                </dl>
                
                <!-- Tombol Aksi Moderasi -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap gap-3">
                    @if($kajian->is_verified)
                        <form action="{{ route('admin.kajian.reject', $kajian->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-red-200 text-red-600 bg-red-50 text-sm font-medium rounded-lg hover:bg-red-100 transition">
                                <i data-lucide="ban" class="w-4 h-4 mr-2"></i> Cabut & Tolak
                            </button>
                        </form>
                    @elseif($kajian->status === 'rejected')
                        <form action="{{ route('admin.kajian.verify', $kajian->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i> Setujui Kembali
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.kajian.verify', $kajian->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i> Setujui
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.kajian.reject', $kajian->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-red-200 text-red-600 bg-white text-sm font-medium rounded-lg hover:bg-red-50 transition">
                                <i data-lucide="ban" class="w-4 h-4 mr-2"></i> Tolak
                            </button>
                        </form>
                    @endif
                </div>
            </div>


            
        </div>
    </div>
</x-admin-layout>
