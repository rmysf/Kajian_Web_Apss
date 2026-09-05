@extends('layouts.landing')

@section('content')
<style>
    footer { display: none !important; }
</style>
<div style="background:var(--parchment); min-height:100vh; padding-bottom:120px;">
    
    <!-- Mobile Container Wrapper -->
    <div style="max-width: 480px; margin: 0 auto; position: relative;">
        
        <div style="padding: 24px 20px;">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/kajian') }}" class="btn btn-outline" style="border-color:var(--line); padding:8px 16px; font-size:13px; background:var(--paper); border-radius: 99px;">
                <svg style="width:18px; height:18px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <!-- Poster Section -->
        <div style="padding: 0 20px;">
            <div style="position:relative; width:100%; aspect-ratio: 4/5; max-height: 480px; border-radius:32px; overflow:hidden; box-shadow:0 20px 50px rgba(10,43,32,0.2); margin-bottom:32px;">
                @php
                  $bgImage = $kajian->poster ? Storage::url($kajian->poster) : asset('images/about_mosque.jpg');
                @endphp
                <div style="position:absolute; inset:0; background: linear-gradient(to top, rgba(10,43,32,0.95) 0%, rgba(10,43,32,0.3) 50%, rgba(10,43,32,0.1) 100%), url('{{ $bgImage }}') center/cover;"></div>
                
                <div style="position:absolute; bottom:0; left:0; width:100%; padding:30px 24px;">
                    <div style="display:flex; gap:8px; margin-bottom:12px;">
                        <span style="display:inline-block; padding:6px 14px; background:var(--gold); color:var(--paper); font-size:11px; font-weight:700; border-radius:99px; text-transform:uppercase; letter-spacing:1px;">
                            {{ $kajian->category->name }}
                        </span>
                        <span style="display:inline-block; padding:6px 14px; background:rgba(255,255,255,0.2); backdrop-filter:blur(4px); color:#fff; border:1px solid rgba(255,255,255,0.4); font-size:11px; font-weight:700; border-radius:99px; text-transform:uppercase; letter-spacing:1px;">
                            {{ $kajian->dynamic_status['label'] }}
                        </span>
                    </div>
                    <h1 style="font-family:'Fraunces',serif; font-size:28px; font-weight:700; color:#fff; line-height:1.25; margin:0;">{{ $kajian->title }}</h1>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div style="padding: 0 20px;">
            
            <!-- Flash Messages -->
            @if(session('status'))
                <div id="toast-status" style="position:fixed; top:24px; left:50%; transform:translateX(-50%); background:var(--jade-900); color:var(--parchment); padding:16px 24px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.2); z-index:9999; display:flex; align-items:center; gap:12px; font-size:14px; font-weight:600; animation: slideDownToast 0.4s ease-out forwards; width:max-content; max-width:90vw; text-align:center;">
                    <svg style="flex-shrink:0" width="24" height="24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>{{ session('status') }}</span>
                    <button onclick="document.getElementById('toast-status').style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer; margin-left:12px; padding:4px; display:flex; align-items:center; justify-content:center; opacity:0.8; transition:opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div id="toast-error" style="position:fixed; top:24px; left:50%; transform:translateX(-50%); background:var(--terracotta); color:var(--parchment); padding:16px 24px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.2); z-index:9999; display:flex; align-items:center; gap:12px; font-size:14px; font-weight:600; animation: slideDownToast 0.4s ease-out forwards; width:max-content; max-width:90vw; text-align:center;">
                    <svg style="flex-shrink:0" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span>{{ session('error') }}</span>
                    <button onclick="document.getElementById('toast-error').style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer; margin-left:12px; padding:4px; display:flex; align-items:center; justify-content:center; opacity:0.8; transition:opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
            @endif

            @if(session('status') || session('error'))
                <style>
                    @keyframes slideDownToast {
                        from { top: -50px; opacity: 0; }
                        to { top: 24px; opacity: 1; }
                    }
                </style>
                <script>
                    setTimeout(() => {
                        const toasts = [document.getElementById('toast-status'), document.getElementById('toast-error')];
                        toasts.forEach(toast => {
                            if(toast) {
                                toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                                toast.style.opacity = '0';
                                toast.style.transform = 'translate(-50%, -20px)';
                                setTimeout(() => toast.remove(), 500);
                            }
                        });
                    }, 5000);
                </script>
            @endif
            
            <!-- Status Alerts (For Admin) -->
            @if(Auth::check() && Auth::user()->role === 'admin')
                @if(!$kajian->is_verified && $kajian->status !== 'cancelled')
                    <div style="background:var(--gold-soft); border:1px solid var(--gold); border-radius:24px; padding:20px; margin-bottom:28px; display:flex; flex-direction:column; gap:12px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <svg style="width:20px; height:20px; color:var(--gold-text);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <h4 style="font-size:15px; font-weight:700; color:var(--ink); margin:0;">Menunggu Moderasi</h4>
                        </div>
                        <p style="font-size:13px; color:var(--ink-soft); margin:0 0 8px; line-height:1.5;">Kajian ini belum dipublikasikan ke Jamaah. Silakan tinjau dan berikan keputusan.</p>
                        <div style="display:flex; gap:10px;">
                            <form action="{{ route('admin.kajian.verify', $kajian->slug) }}" method="POST" style="flex:1;">
                                @csrf
                                <button type="submit" class="btn btn-solid" style="width:100%; padding:10px; font-size:13px; justify-content:center;">Setujui</button>
                            </form>
                            <form action="{{ route('admin.kajian.reject', $kajian->slug) }}" method="POST" style="flex:1;">
                                @csrf
                                <button type="submit" class="btn btn-outline" style="width:100%; padding:10px; font-size:13px; justify-content:center; border-color:var(--terracotta); color:var(--terracotta);">Tolak</button>
                            </form>
                        </div>
                    </div>
                @elseif($kajian->status === 'cancelled')
                    <div style="background:#FEE2E2; border:1px solid var(--terracotta); border-radius:20px; padding:16px; margin-bottom:28px; display:flex; align-items:center; gap:12px; color:var(--terracotta); font-size:13px; font-weight:600;">
                        <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Kajian dibatalkan / ditolak.
                    </div>
                @endif
            @endif

            <!-- Speaker Info -->
            <div style="background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:20px; margin-bottom:28px; display:flex; align-items:center; gap:16px; box-shadow:0 10px 30px rgba(10,43,32,0.05);">
                <div style="width:56px; height:56px; border-radius:50%; overflow:hidden; background:var(--parchment-deep); border:2px solid var(--parchment); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    @if($kajian->speaker->photo)
                        <img src="{{ Storage::url($kajian->speaker->photo) }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <span style="font-size:20px; font-weight:700; color:var(--ink-soft); font-family:'Fraunces',serif;">
                            {{ substr($kajian->speaker->name, 0, 1) }}
                        </span>
                    @endif
                </div>
                <div>
                    <span class="eyebrow" style="margin-bottom:4px; font-size:10px;">Pemateri</span>
                    <p style="font-family:'Amiri',serif; font-size:22px; font-weight:700; color:var(--jade-950); margin:0;">{{ $kajian->speaker->name }}</p>
                </div>
            </div>

            <!-- Detail Grid -->
            <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:32px;">
                
                <div style="display:flex; gap:16px;">
                    <!-- Waktu -->
                    <div style="flex:1; background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:20px; box-shadow:0 10px 30px rgba(10,43,32,0.05);">
                        <svg style="width:22px; height:22px; color:var(--jade-800); margin-bottom:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        
                        <div style="margin-bottom:10px;">
                            <span class="eyebrow" style="display:block; font-size:9px; color:var(--ink-soft); margin-bottom:2px;">Tanggal</span>
                            <p style="font-size:15px; font-weight:700; color:var(--ink); margin:0;">{{ $kajian->start_at->translatedFormat('d M Y') }}</p>
                        </div>
                        <div style="display:flex; gap:16px;">
                            <div>
                                <span class="eyebrow" style="display:block; font-size:9px; color:var(--ink-soft); margin-bottom:2px;">Jam Mulai</span>
                                <p style="font-size:14px; font-weight:700; color:var(--ink); margin:0;">{{ $kajian->start_at->format('H:i') }}</p>
                            </div>
                            <div>
                                <span class="eyebrow" style="display:block; font-size:9px; color:var(--ink-soft); margin-bottom:2px;">Jam Selesai</span>
                                <p style="font-size:14px; font-weight:700; color:var(--ink); margin:0;">{{ $kajian->end_at->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Peserta -->
                    <div style="flex:1; background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:20px; box-shadow:0 10px 30px rgba(10,43,32,0.05);">
                        <svg style="width:22px; height:22px; color:var(--jade-800); margin-bottom:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        
                        <span class="eyebrow" style="display:block; font-size:9px; color:var(--ink-soft); margin-bottom:4px;">Jumlah Calon Peserta</span>
                        <div style="font-size:24px; font-family:'Fraunces',serif; font-weight:700; color:var(--jade-950); margin:0 0 4px; display:flex; align-items:baseline; gap:4px;">
                            {{ $attendeesCount }}
                            @if($kajian->quota)
                                <span style="font-size:16px; color:var(--ink-soft); font-weight:600;">/ {{ $kajian->quota }}</span>
                            @endif
                        </div>
                        @if($kajian->quota)
                            @php $sisa = $kajian->quota - $attendeesCount; @endphp
                            <p style="font-size:12px; color:{{ $sisa <= 0 ? 'var(--terracotta)' : 'var(--ink-soft)' }}; font-weight:500; margin:0;">
                                {{ $sisa <= 0 ? 'Kuota sudah penuh' : 'Tersisa ' . $sisa . ' kuota pendaftaran' }}
                            </p>
                        @else
                            <p style="font-size:12px; color:var(--ink-soft); font-weight:500; margin:0;">Orang telah mendaftar (Tanpa batas kuota)</p>
                        @endif
                    </div>
                </div>

                <!-- Biaya -->
                <div style="background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:20px; box-shadow:0 10px 30px rgba(10,43,32,0.05); display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <span class="eyebrow" style="margin-bottom:4px; font-size:10px;">Biaya Pendaftaran</span>
                        @if($kajian->is_free)
                            <p style="font-size:16px; font-weight:800; color:var(--jade-700); margin:0;">Gratis (Free)</p>
                        @else
                            <p style="font-size:16px; font-weight:800; color:var(--ink); margin:0;">Rp {{ number_format($kajian->price, 0, ',', '.') }}</p>
                        @endif
                    </div>
                    <svg style="width:28px; height:28px; color:var(--gold);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <!-- Lokasi -->
            <div style="margin-bottom:32px;">
                <h3 style="font-family:'Fraunces',serif; font-size:20px; font-weight:700; color:var(--jade-950); margin:0 0 16px;">Lokasi Pelaksanaan</h3>
                <div style="background:var(--paper); border:1px solid var(--line); border-radius:24px; padding:20px; box-shadow:0 10px 30px rgba(10,43,32,0.05); display:flex; align-items:flex-start; gap:16px;">
                    <div style="width:40px; height:40px; border-radius:50%; background:var(--parchment-deep); display:flex; align-items:center; justify-content:center; color:var(--jade-800); flex-shrink:0;">
                        <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:16px; font-weight:700; color:var(--ink); margin:0 0 4px;">{{ $kajian->mosque->name }}</p>
                        <p style="font-size:14px; color:var(--ink-soft); line-height:1.5; margin:0;">{{ $kajian->address }}</p>
                    </div>
                    @if(isset($distance))
                    <div style="flex-shrink:0; text-align:right;">
                        <span style="font-size:16px; font-weight:800; color:var(--jade-700);">{{ number_format($distance, 1) }}</span>
                        <span style="font-size:12px; font-weight:600; color:var(--ink-soft); display:block;">KM</span>
                    </div>
                    @endif
                </div>
            </div>



            <!-- Deskripsi -->
            <div style="margin-bottom:40px;">
                <h3 style="font-family:'Fraunces',serif; font-size:20px; font-weight:700; color:var(--jade-950); margin:0 0 16px;">Deskripsi Kajian</h3>
                <div style="font-size:15px; color:var(--ink-soft); line-height:1.7;">
                    {!! nl2br(e($kajian->description ?: 'Tidak ada deskripsi tambahan untuk kajian ini.')) !!}
                </div>
            </div>

            <!-- Penyelenggara Info -->
            <div style="background:var(--parchment-deep); border-radius:24px; padding:20px; display:flex; align-items:center; gap:16px;">
                <div style="width:48px; height:48px; background:var(--paper); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:var(--shadow);">
                    <svg style="width:24px; height:24px; color:var(--jade-800);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <span class="eyebrow" style="margin-bottom:4px; font-size:10px;">Penyelenggara</span>
                    <p style="font-size:16px; font-weight:700; color:var(--ink); margin:0;">{{ $kajian->organizer->name }}</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Floating Action Bar -->
    <div style="position:fixed; bottom:0; left:0; width:100%; z-index:50; pointer-events:none;">
        <div style="max-width:480px; margin:0 auto; padding:16px 20px; pointer-events:auto;">
            <div style="background:rgba(244,238,220,0.95); backdrop-filter:blur(14px); border:1px solid var(--line); border-radius:28px; padding:12px; box-shadow:0 -10px 40px rgba(10,43,32,0.1); display:flex; gap:8px;">
                
                <form action="{{ url('/kajian/'.$kajian->slug.'/favorite') }}" method="POST" style="flex-shrink:0;">
                    @csrf
                    <button type="submit" style="width:52px; height:52px; border-radius:18px; background:{{ $isFavorited ? '#FEE2E2' : 'var(--paper)' }}; border:1px solid {{ $isFavorited ? 'var(--terracotta)' : 'var(--line)' }}; display:flex; align-items:center; justify-content:center; color:{{ $isFavorited ? 'var(--terracotta)' : 'var(--ink)' }}; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.color='var(--terracotta)'; this.style.borderColor='var(--terracotta)'; this.style.background='#FEE2E2';" onmouseout="this.style.color='{{ $isFavorited ? 'var(--terracotta)' : 'var(--ink)' }}'; this.style.borderColor='{{ $isFavorited ? 'var(--terracotta)' : 'var(--line)' }}'; this.style.background='{{ $isFavorited ? '#FEE2E2' : 'var(--paper)' }}';">
                        <svg style="width:22px; height:22px;" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </form>
                
                @if($isAttending)
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $kajian->latitude }},{{ $kajian->longitude }}" target="_blank" style="width:52px; height:52px; border-radius:18px; background:var(--paper); border:1px solid var(--line); display:flex; align-items:center; justify-content:center; color:var(--jade-900); flex-shrink:0; transition:all 0.2s;" onmouseover="this.style.background='var(--parchment-deep)';" onmouseout="this.style.background='var(--paper)';" title="Arahkan Lokasi">
                        <svg style="width:22px; height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </a>

                    <form action="{{ url('/kajian/'.$kajian->slug.'/join') }}" method="POST" style="flex:1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width:100%; height:52px; padding:0; border-radius:18px; background:#FEE2E2; border:1px solid var(--terracotta); display:flex; align-items:center; justify-content:center; color:var(--terracotta); cursor:pointer; transition:all 0.2s; font-size:14px; font-weight:700;" title="Batalkan Kehadiran" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            Batalkan
                        </button>
                    </form>

                    <form action="{{ url('/kajian/'.$kajian->slug.'/join') }}" method="POST" style="flex:1;">
                        @csrf
                        <button type="submit" style="width:100%; height:52px; border-radius:18px; background:var(--jade-800); border:none; color:var(--paper); font-size:14px; font-weight:700; cursor:pointer;">
                            Akan Hadir
                        </button>
                    </form>
                @else
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $kajian->latitude }},{{ $kajian->longitude }}" target="_blank" style="flex:1; display:flex; align-items:center; justify-content:center; height:52px; border-radius:18px; background:var(--paper); border:1px solid var(--line); color:var(--jade-900); font-size:14px; font-weight:700; text-decoration:none; gap:6px; transition:all 0.2s;" onmouseover="this.style.background='var(--parchment-deep)';" onmouseout="this.style.background='var(--paper)';">
                        <svg style="width:18px; height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Arahkan
                    </a>

                    <form action="{{ url('/kajian/'.$kajian->slug.'/join') }}" method="POST" style="flex:1.5;">
                        @csrf
                        <button type="submit" class="btn btn-solid" style="width:100%; height:52px; border-radius:18px; font-size:14px; justify-content:center; padding:0;">
                            Saya Mau Hadir
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>

</div>
@endsection
