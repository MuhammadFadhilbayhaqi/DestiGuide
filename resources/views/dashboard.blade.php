@extends('layouts.wisatawan-layout')

@section('title', 'Jelajahi Wisata Indonesia')

@section('content')
{{-- Hero --}}
<div class="wst-hero" style="background-image: url('{{ asset('img/Header2.png') }}');">
    <div class="container">
        <h1><i class="bi bi-compass me-2"></i>Pesona Indonesia</h1>
        <p>Temukan dan jelajahi keindahan wisata di seluruh Indonesia</p>
        @guest
        <div class="mt-3 d-flex justify-content-center gap-2">
            <a href="{{ route('login') }}" class="btn-wst-outline">
                <i class="bi bi-box-arrow-in-right"></i> Masuk
            </a>
            <a href="{{ route('register') }}" class="btn-wst">
                <i class="bi bi-person-plus"></i> Daftar Sekarang
            </a>
        </div>
        @endguest
        @auth
        <p class="mt-2" style="opacity:0.8;">Halo, <strong>{{ Auth::user()->name }}</strong>! Mau liburan ke mana hari ini?</p>
        @endauth
    </div>
</div>

{{-- Search --}}
<div class="container">
    <form class="wst-search-bar" action="{{ route('wisata.search') }}" method="GET">
        <input class="form-control" type="search" name="search" placeholder="Cari wisata..." value="{{ request('search') }}">
        <button class="btn-search" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>
</div>

{{-- Featured --}}
@if($destinations->count() > 0)
<div class="container mb-4">
    @foreach($destinations->shuffle()->take(1) as $featured)
    <div class="wst-panel" style="overflow:hidden; padding:0;">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . ($featured->images->first()->image_path ?? $featured->image)) }}" alt="{{ $featured->nama }}"
                     style="width:100%; height:300px; object-fit:cover;">
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center p-4">
                <span class="badge mb-2" style="background:var(--wst-primary-light);color:var(--wst-primary-dark);width:fit-content;font-size:0.8rem;">
                    <i class="bi bi-star-fill me-1"></i> Wisata Pilihan
                </span>
                <h3 style="font-weight:700;color:var(--wst-dark);">{{ $featured->nama }}</h3>
                <p style="color:var(--wst-text-light);font-size:0.9rem;">{{ Str::limit($featured->informasi, 150) }}</p>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span style="font-size:0.85rem;color:var(--wst-text-light);"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $featured->provinsi ?? '' }}</span>
                    <span style="font-size:1rem;font-weight:700;color:var(--wst-primary);">Rp {{ number_format($featured->harga ?? 0, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('informasi.show', $featured->id) }}" class="btn-wst" style="width:fit-content;">
                    <i class="bi bi-arrow-right"></i> Lihat Detail
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Destination Grid --}}
<div class="container mb-5">
    <div class="wst-section-header">
        <h2>Pilih Tujuan Wisata</h2>
        <p>Destinasi menarik menunggu Anda</p>
    </div>

    @if($destinations->count() > 0)
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
        @foreach($destinations as $dest)
        <div class="col">
            <a href="{{ route('informasi.show', $dest->id) }}" class="wst-dest-card">
                <div class="card-img-wrapper">
                    <img src="{{ asset('storage/' . ($dest->images->first()->image_path ?? $dest->image)) }}" alt="{{ $dest->nama }}">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $dest->nama }}</h5>
                    <div class="card-detail">
                        <i class="bi bi-geo-alt-fill text-danger"></i>
                        {{ $dest->provinsi ?? '-' }}, {{ $dest->kecamatan ?? '-' }}
                    </div>
                    <div class="card-detail">
                        <i class="bi bi-calendar-event" style="color:var(--wst-primary);"></i>
                        {{ $dest->jadwal ?? 'Setiap hari' }}
                    </div>
                    <div class="card-price">
                        Rp {{ number_format($dest->harga ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @else
    <div class="wst-empty-state">
        <div class="empty-icon"><i class="bi bi-geo-alt"></i></div>
        <h3>Belum ada wisata tersedia</h3>
        <p>Wisata akan segera ditambahkan. Silakan kunjungi lagi nanti.</p>
    </div>
    @endif
</div>
@endsection
