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
            
            // Set ukuran SVG ke 600x600 
            const qrSize = 600;
            svgClone.setAttribute("width", qrSize);
            svgClone.setAttribute("height", qrSize);
            
            const svgData = new XMLSerializer().serializeToString(svgClone);
            const blob = new Blob([svgData], {type: "image/svg+xml;charset=utf-8"});
            const url = URL.createObjectURL(blob);
            
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement("canvas");
                // Ukuran poster: 1080 x 1080 (Square 1:1)
                const cWidth = 1080;
                const cHeight = 1080;
                canvas.width = cWidth;
                canvas.height = cHeight;
                const ctx = canvas.getContext("2d");
                
                // 1. Background (Warna hijau gelap)
                ctx.fillStyle = "#064e3b"; // Emerald 900
                ctx.fillRect(0, 0, cWidth, cHeight);

                // Tambahkan aksen pattern/garis di background
                ctx.strokeStyle = "#022c22"; // Emerald 950
                ctx.lineWidth = 20;
                ctx.strokeRect(40, 40, cWidth - 80, cHeight - 80);
                
                // 2. Header Text
                ctx.textAlign = "center";
                
                // Judul Presensi
                ctx.font = "bold 56px system-ui, -apple-system, sans-serif";
                ctx.fillStyle = "#ffffff";
                ctx.fillText("PRESENSI KAJIAN", cWidth / 2, 140);
                
                // Judul Kajian (Truncate if too long)
                let title = "{!! addslashes($kajian->title) !!}";
                ctx.font = "bold 36px system-ui, -apple-system, sans-serif";
                ctx.fillStyle = "#a7f3d0"; // Emerald 200
                if(title.length > 45) title = title.substring(0, 42) + '...';
                ctx.fillText(title, cWidth / 2, 210);

                // 3. Kotak QR Code
                const boxSize = 680; // Ukuran kotak putih
                const boxX = (cWidth - boxSize) / 2;
                const boxY = 280;
                
                // Gambar shadow
                ctx.shadowColor = "rgba(0,0,0,0.3)";
                ctx.shadowBlur = 20;
                ctx.shadowOffsetX = 0;
                ctx.shadowOffsetY = 10;
                
                // Background QR (Putih) dengan border radius
                ctx.fillStyle = "#ffffff";
                ctx.beginPath();
                if (ctx.roundRect) {
                    ctx.roundRect(boxX, boxY, boxSize, boxSize, 24);
                } else {
                    ctx.rect(boxX, boxY, boxSize, boxSize); // Fallback
                }
                ctx.fill();
                
                // Reset shadow
                ctx.shadowColor = "transparent";
                ctx.shadowBlur = 0;
                ctx.shadowOffsetX = 0;
                ctx.shadowOffsetY = 0;

                // 4. Gambar SVG (QR Code)
                // Posisikan QR di tengah kotak putih
                const qrPadding = 40;
                const qrActualSize = boxSize - (qrPadding * 2);
                ctx.drawImage(img, boxX + qrPadding, boxY + qrPadding, qrActualSize, qrActualSize);
                
                // 5. Footer Text
                ctx.font = "28px system-ui, -apple-system, sans-serif";
                ctx.fillStyle = "#ffffff";
                ctx.fillText("Scan QR code ini untuk mencatat kehadiran Anda", cWidth / 2, 1030);

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
