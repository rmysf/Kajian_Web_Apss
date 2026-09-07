@extends('layouts.landing')

@section('content')
<div class="container" style="padding-top:40px; padding-bottom:40px; min-height: 40vh;">
    
    <div style="margin-bottom:40px; text-align:center;">
        <h2 style="font-family:'Fraunces',serif; font-size:36px; font-weight:600; color:var(--jade-950); margin:0 0 10px;">
            Kajian <em style="color:var(--gold); font-style:italic;">Tersimpan</em>
        </h2>
        <p style="color:var(--ink-soft); font-size:15px; margin:0;">Daftar kajian yang telah Anda simpan untuk dilihat nanti.</p>
    </div>

    <!-- Results List -->
    <div class="kajian-grid">
        @forelse($favorites as $favorite)
            <x-kajian-card :kajian="$favorite->kajian" />
        @empty
            <div style="grid-column: 1 / -1; text-align:center; padding:60px 20px; background:var(--paper); border:1px solid var(--line); border-radius:24px; box-shadow:var(--shadow);">
                <div style="width:64px; height:64px; background:rgba(184,134,59,.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:var(--gold);">
                    <svg style="width:32px; height:32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h4 style="font-family:'Fraunces',serif; font-size:22px; color:var(--jade-950); margin:0 0 10px;">Belum Ada Kajian Tersimpan</h4>
                <p style="color:var(--ink-soft); font-size:14px; margin:0 0 24px;">Anda belum menyimpan kajian apapun. Jelajahi kajian dan simpan yang Anda sukai.</p>
                <a href="{{ url('/kajian') }}" class="btn btn-solid">
                    Jelajahi Kajian
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div style="margin-top:50px;">
        {{ $favorites->onEachSide(1)->links() }}
    </div>

</div>
@endsection
