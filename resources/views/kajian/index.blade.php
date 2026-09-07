@extends('layouts.landing')

@section('content')
<div class="container" style="padding-top:40px; padding-bottom:40px; min-height: 40vh;">
    
    <div style="margin-bottom:40px; text-align:center;">
        <h2 style="font-family:'Fraunces',serif; font-size:36px; font-weight:600; color:var(--jade-950); margin:0 0 10px;">
            Jelajah <em style="color:var(--gold); font-style:italic;">Kajian</em>
        </h2>
        <p style="color:var(--ink-soft); font-size:15px; margin:0;">Temukan jadwal kajian yang sesuai dengan waktu dan lokasimu.</p>
    </div>

    <!-- Search Form -->
    <form action="{{ url('/kajian') }}" method="GET" style="margin-bottom:30px;">
        <!-- Preserve hidden filters -->
        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
        @if(request('date')) <input type="hidden" name="date" value="{{ request('date') }}"> @endif
        @if(request('audience')) <input type="hidden" name="audience" value="{{ request('audience') }}"> @endif
        @if(request('lat')) <input type="hidden" name="lat" value="{{ request('lat') }}"> @endif
        @if(request('lng')) <input type="hidden" name="lng" value="{{ request('lng') }}"> @endif
        @if(request('nearby')) <input type="hidden" name="nearby" value="{{ request('nearby') }}"> @endif
        
        <div style="display:flex; align-items:center; background:var(--paper); border:1px solid var(--line); border-radius:99px; padding:6px 6px 6px 20px; max-width:100%; width:100%; margin:0 auto; box-shadow:0 10px 25px rgba(10,43,32,0.05); overflow:hidden;">
            <svg style="width:20px; height:20px; color:var(--ink-soft); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="search" name="q" value="{{ request('q') }}" class="focus:ring-0 focus:outline-none" style="flex:1; min-width:0; background:transparent; border:none; outline:none; padding:10px 14px; font-size:15px; color:var(--ink); box-shadow:none;" placeholder="Cari ustadz, masjid, atau tema...">
            <button type="submit" class="btn btn-solid" style="padding:10px 24px; flex-shrink: 0;">Cari</button>
        </div>
    </form>

    <style>
        .filter-container {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            flex-wrap: nowrap;
            width: 100%;
            scrollbar-width: none;
            -ms-overflow-style: none;
            -webkit-overflow-scrolling: touch;
        }
        .filter-container::-webkit-scrollbar {
            display: none;
        }
        .filter-btn {
            white-space: nowrap;
            flex-shrink: 0;
            padding: 8px 18px;
            font-size: 13px;
            border-color: var(--line-on-dark);
        }
    </style>

    <!-- Categories Filter -->
    <div class="filter-container" style="margin-bottom:20px; padding-bottom:8px;">
        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="btn filter-btn {{ !request('category') ? 'btn-solid' : 'btn-outline' }}">Semua</a>
        @foreach($categories as $cat)
            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" class="btn filter-btn {{ request('category') === $cat->slug ? 'btn-solid' : 'btn-outline' }}">{{ $cat->name }}</a>
        @endforeach
    </div>

    <!-- Additional Filters: Date & Audience & Nearby -->
    <div class="filter-container" style="margin-bottom:40px; border-top:1px solid var(--line); padding-top:20px; padding-bottom:8px;">
        <!-- Nearby -->
        @if(request('lat') && request('lng'))
            <a href="{{ request('nearby') == 1 ? request()->fullUrlWithQuery(['nearby' => null]) : request()->fullUrlWithQuery(['nearby' => 1]) }}" class="btn filter-btn {{ request('nearby') == 1 ? 'btn-solid' : 'btn-outline' }}">
                <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Terdekat
            </a>
        @else
            <button type="button" onclick="requestLocation(this)" class="btn filter-btn btn-outline" id="btn-terdekat">
                <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Terdekat
            </button>
        @endif

        <!-- Date -->
        @php $dates = ['today' => 'Hari ini', 'besok' => 'Besok', 'malam-ini' => 'Malam ini']; @endphp
        @foreach($dates as $key => $label)
            <a href="{{ request('date') === $key ? request()->fullUrlWithQuery(['date' => null]) : request()->fullUrlWithQuery(['date' => $key]) }}" class="btn filter-btn {{ request('date') === $key ? 'btn-solid' : 'btn-outline' }}">
                {{ $label }}
            </a>
        @endforeach

        <!-- Audience -->
        @php $audiences = ['umum' => 'Umum', 'ikhwan' => 'Ikhwan', 'akhwat' => 'Akhwat']; @endphp
        @foreach($audiences as $key => $label)
            <a href="{{ request('audience') === $key ? request()->fullUrlWithQuery(['audience' => null]) : request()->fullUrlWithQuery(['audience' => $key]) }}" class="btn filter-btn {{ request('audience') === $key ? 'btn-solid' : 'btn-outline' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Results List -->
    <div class="kajian-grid">
        @forelse($kajians as $kajian)
            <x-kajian-card :kajian="$kajian" />
        @empty
            <div style="grid-column: 1 / -1; text-align:center; padding:60px 20px; background:var(--paper); border:1px solid var(--line); border-radius:24px; box-shadow:var(--shadow);">
                <div style="width:64px; height:64px; background:rgba(184,134,59,.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:var(--gold);">
                    <svg style="width:32px; height:32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                </div>
                <h4 style="font-family:'Fraunces',serif; font-size:22px; color:var(--jade-950); margin:0 0 10px;">Pencarian Tidak Ditemukan</h4>
                <p style="color:var(--ink-soft); font-size:14px; margin:0 0 24px;">Tidak ada kajian yang sesuai dengan kriteria filter Anda saat ini.</p>
                <a href="{{ url('/kajian' . (request('lat') && request('lng') ? '?lat='.request('lat').'&lng='.request('lng') : '')) }}" class="btn btn-solid">
                    Reset Filter
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div style="margin-top:50px;">
        {{ $kajians->onEachSide(1)->links() }}
    </div>

</div>
@endsection
