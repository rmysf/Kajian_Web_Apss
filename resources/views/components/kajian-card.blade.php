@props(['kajian', 'attendanceStatus' => null])
<div class="kcard" style="background:var(--paper);border-radius:20px;overflow:hidden;border:none;box-shadow:0 15px 40px rgba(6,26,19,0.08);transition:transform 0.3s, box-shadow 0.3s; display:flex; flex-direction:column;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 25px 50px rgba(6,26,19,0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 15px 40px rgba(6,26,19,0.08)'">
  
  @php
    $bgImage = $kajian->poster ? Storage::url($kajian->poster) : asset('images/about_mosque.jpg');
  @endphp

  <div class="kcard-media" style="height:150px; background: linear-gradient(rgba(15, 81, 55, 0.7), rgba(15, 81, 55, 0.9)), url('{{ $bgImage }}') center/cover; position:relative; display:flex; align-items:flex-end; padding:16px;">
    <span class="ribbon" style="background:var(--gold); color:var(--paper); padding:4px 12px; border-radius:8px; font-size:12px; font-weight:700; position:absolute; top:16px; left:16px; letter-spacing:1px; text-transform:uppercase;">{{ $kajian->category->name ?? 'Kajian' }}</span>
    
    @if($attendanceStatus)
        @php
            $bg = $attendanceStatus === 'registered' ? 'var(--jade-600)' : ($attendanceStatus === 'attended' ? 'var(--jade-900)' : 'var(--terracotta)');
            $label = $attendanceStatus === 'registered' ? 'Akan Hadir' : ($attendanceStatus === 'attended' ? 'Hadir' : 'Dibatalkan');
        @endphp
        <span style="background:{{ $bg }}; color:white; padding:4px 12px; border-radius:8px; font-size:11px; font-weight:700; position:absolute; top:16px; right:16px; letter-spacing:1px; text-transform:uppercase;">{{ $label }}</span>
    @else
        @php
            $isFavorited = false;
            if(auth()->check()) {
                $isFavorited = \App\Models\Favorite::where('user_id', auth()->id())->where('kajian_id', $kajian->id)->exists();
            }
        @endphp
        <form action="{{ url('/kajian/'.$kajian->slug.'/favorite') }}" method="POST" style="position:absolute; top:16px; right:16px; z-index:10;" onsubmit="handleFavoriteToggle(event, this)">
            @csrf
            <button type="submit" class="kcard-save" data-favorited="{{ $isFavorited ? 'true' : 'false' }}" style="width:32px; height:32px; background:{{ $isFavorited ? 'rgba(255,255,255,0.9)' : 'rgba(255,255,255,0.2)' }}; backdrop-filter:blur(4px); border-radius:50%; display:flex; align-items:center; justify-content:center; color:{{ $isFavorited ? 'var(--terracotta)' : '#fff' }}; border:none; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.9)'; this.style.color='var(--terracotta)';" onmouseout="this.dataset.favorited === 'true' ? (this.style.background='rgba(255,255,255,0.9)', this.style.color='var(--terracotta)') : (this.style.background='rgba(255,255,255,0.2)', this.style.color='#fff');">♥</button>
        </form>

        <script>
            if (typeof window.handleFavoriteToggle === 'undefined') {
                window.handleFavoriteToggle = async function(event, form) {
                    event.preventDefault();
                    
                    const btn = form.querySelector('button');
                    
                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        if (response.status === 401) {
                            window.location.href = '/login';
                            return;
                        }
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            btn.dataset.favorited = data.is_favorited ? 'true' : 'false';
                            if (data.is_favorited) {
                                btn.style.background = 'rgba(255,255,255,0.9)';
                                btn.style.color = 'var(--terracotta)';
                            } else {
                                btn.style.background = 'rgba(255,255,255,0.2)';
                                btn.style.color = '#fff';
                            }
                        }
                    } catch (error) {
                        console.error('Error toggling favorite:', error);
                    }
                };
            }
        </script>
    @endif
  </div>
  
  <div class="kcard-body" style="padding: 24px; display: flex; flex-direction: column; flex-grow: 1;">
    <h4 style="margin:0 0 8px; font-family:'Amiri',serif; font-size:24px; color:var(--jade-950); line-height:1.3;">{{ Str::limit($kajian->title, 40) }}</h4>
    <div class="ustadz" style="font-family:'Amiri',serif; font-size:16px; color:var(--jade-800); font-weight:700; margin-bottom:16px;">
        {{ $kajian->speaker->name ?? 'Ustadz' }}
    </div>
    
    <div class="kcard-meta" style="display:flex; flex-direction: column; gap:10px; font-size:14px; font-weight:600; color:var(--ink-soft); border-top:1px dashed var(--line); padding-top:16px; margin-bottom: 24px; margin-top: auto;">
        @php
          $cDate = \Carbon\Carbon::parse($kajian->start_at);
          $hari = ['Sunday'=>'Ahad','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
          $bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
          $strHari = $hari[$cDate->format('l')];
          $strBulan = $bulan[$cDate->format('n') - 1];
          $tglIndo = $strHari . ', ' . $cDate->format('d') . ' ' . $strBulan;
        @endphp
        <div style="display: flex; gap: 8px; align-items: center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            <span style="color:var(--jade-950);">{{ $tglIndo }}</span>
        </div>
        <div style="display: flex; gap: 8px; align-items: center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span style="color:var(--jade-950);">{{ \Carbon\Carbon::parse($kajian->start_at)->format('H:i') }} WIB</span>
        </div>
        <div style="display: flex; gap: 8px; align-items: flex-start; margin-top: 2px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span style="line-height: 1.4; color:var(--jade-950);">{{ $kajian->mosque->name ?? 'Masjid' }}<br><span style="font-size: 13px; font-weight: 500; color:var(--ink-soft);">{{ Str::limit($kajian->mosque->address ?? '', 40) }}</span></span>
        </div>
        @if(isset($kajian->distance))
        <div style="display: flex; gap: 8px; align-items: flex-start; margin-top: 2px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span style="line-height: 1.4; color:var(--jade-950);">Jarak: {{ number_format($kajian->distance, 1) }} KM</span>
        </div>
        @endif
    </div>
    
    <a href="{{ route('kajian.show', $kajian->slug) }}" style="display: block; text-align: center; background: var(--gold-pale); color: var(--gold-deep); padding: 12px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 15px; transition: background 0.2s;" onmouseover="this.style.background='var(--gold)'; this.style.color='white';" onmouseout="this.style.background='var(--gold-pale)'; this.style.color='var(--gold-deep)';">Lihat Detail</a>
  </div>
</div>
