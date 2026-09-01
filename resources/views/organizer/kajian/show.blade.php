<x-organizer-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('organizer.kajian.index') }}" class="mr-4 text-gray-400 hover:text-gray-600 transition-colors">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Detail Kajian: {{ $kajian->title }}
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
            <div class="md:col-span-8 lg:col-span-6 md:border-l lg:border-x md:border-gray-100 md:pl-6 lg:px-8">
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
                        <dt class="text-sm font-medium text-brand-ink-soft">Audiens</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold capitalize">{{ $kajian->audience }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Waktu Mulai</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ \Carbon\Carbon::parse($kajian->start_at)->translatedFormat('l, d F Y H:i') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-brand-ink-soft">Waktu Selesai</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ \Carbon\Carbon::parse($kajian->end_at)->translatedFormat('l, d F Y H:i') }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-brand-ink-soft">Alamat Lengkap</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->address }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-brand-ink-soft">Koordinat (Lat, Lng)</dt>
                        <dd class="mt-1 text-sm text-brand-ink font-semibold">{{ $kajian->latitude }}, {{ $kajian->longitude }}</dd>
                    </div>
                </dl>
                
                <!-- Tombol Aksi -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap gap-3">
                    <a href="{{ url('/organizer/kajian/'.$kajian->slug.'/peserta') }}" class="inline-flex justify-center items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition">
                        <i data-lucide="users" class="w-4 h-4 mr-2"></i> Lihat Daftar Peserta
                    </a>
                    <a href="{{ route('organizer.kajian.edit', $kajian->slug) }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-brand-ink bg-white text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Edit Data Kajian
                    </a>
                </div>
            </div>

            <!-- Kolom Kanan: QR Code -->
            <div class="md:col-span-12 lg:col-span-3 mt-6 lg:mt-0 pt-6 lg:pt-0 border-t lg:border-t-0 border-gray-100">
                <h3 class="text-lg font-bold text-brand-ink mb-4 md:mb-6 pb-4 border-b border-gray-100 text-center lg:text-left">Check-in</h3>
                <!-- QR Code Presensi -->
                <div class="bg-brand-emerald-50/50 rounded-xl border border-brand-emerald-100 p-5 text-center flex flex-col items-center">
                    <h3 class="text-sm font-bold text-brand-emerald-950 mb-3">QR Code Presensi</h3>
                    <div id="qr-container" class="bg-white p-2.5 rounded-xl border border-gray-200 shadow-sm inline-block mb-3">
                        {!! QrCode::size(140)->generate(url('/checkin/'.$kajian->uuid)) !!}
                    </div>
                    <p class="text-xs text-brand-emerald-800 mb-4 leading-relaxed">
                        Tunjukkan QR Code ini kepada jamaah untuk di-scan saat acara berlangsung.
                    </p>
                    
                    <button onclick="downloadQR()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-brand-emerald-200 text-brand-emerald-800 bg-brand-emerald-100/50 text-sm font-medium rounded-lg hover:bg-brand-emerald-200 transition">
                        <i data-lucide="download" class="w-4 h-4 mr-2"></i> Download QR
                    </button>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        function downloadQR() {
            const svg = document.querySelector('#qr-container svg');
            if(!svg) {
                alert('QR Code belum siap untuk di-download.');
                return;
            }
            
            // Clone the SVG so we don't modify the one visible on the page
            const svgClone = svg.cloneNode(true);
            
            // Tambahkan atribut xmlns jika belum ada
            if (!svgClone.hasAttribute("xmlns")) {
                svgClone.setAttribute("xmlns", "http://www.w3.org/2000/svg");
            }
            
            // Set ukuran SVG ke 1024x1024 untuk hasil PNG beresolusi tinggi
            const size = 1024;
            svgClone.setAttribute("width", size);
            svgClone.setAttribute("height", size);
            
            const svgData = new XMLSerializer().serializeToString(svgClone);
            const blob = new Blob([svgData], {type: "image/svg+xml;charset=utf-8"});
            const url = URL.createObjectURL(blob);
            
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement("canvas");
                canvas.width = size;
                canvas.height = size;
                const ctx = canvas.getContext("2d");
                
                // Tambahkan background putih (karena SVG mungkin transparan)
                ctx.fillStyle = "#ffffff";
                ctx.fillRect(0, 0, size, size);
                
                // Gambar SVG ke atas canvas
                ctx.drawImage(img, 0, 0, size, size);
                
                // Download hasil render sebagai PNG
                const pngUrl = canvas.toDataURL("image/png");
                const link = document.createElement("a");
                link.href = pngUrl;
                link.download = "QR-Presensi-{{ Str::slug($kajian->title) }}.png";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                // Bersihkan URL object memory
                URL.revokeObjectURL(url);
            };
            img.src = url;
        }
    </script>
</x-organizer-layout>
