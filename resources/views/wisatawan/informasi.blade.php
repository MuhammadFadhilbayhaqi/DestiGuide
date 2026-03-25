@extends('layouts.wisatawan-layout')

@section('title', $wisatas->first()->nama ?? 'Detail Wisata')

@section('content')
@foreach ($wisatas as $wisata)

{{-- Image Carousel --}}
@php
    $allImages = $wisata->images->count() > 0
        ? $wisata->images->pluck('image_path')
        : ($wisata->image ? collect([$wisata->image]) : collect());
@endphp

@if($allImages->count() > 0)
<div class="wst-carousel-wrapper">
    <div class="wst-carousel" id="wisataCarousel">
        @foreach($allImages as $i => $imgPath)
        <div class="wst-carousel-slide {{ $i === 0 ? 'active' : '' }}">
            <img src="{{ asset('storage/' . $imgPath) }}" alt="{{ $wisata->nama }} - Foto {{ $i+1 }}">
            <div class="slide-overlay"></div>
        </div>
        @endforeach

        {{-- Hero text overlay --}}
        <div class="wst-carousel-hero">
            <div class="container">
                <h1>{{ $wisata->nama }}</h1>
                <div class="d-flex flex-wrap gap-3 mt-2" style="font-size:0.9rem;">
                    <span><i class="bi bi-geo-alt-fill me-1"></i>{{ $wisata->alamatLengkap }}, {{ $wisata->provinsi }}</span>
                    <span><i class="bi bi-clock me-1"></i>{{ $wisata->jadwal ?? 'Setiap hari' }}</span>
                </div>
            </div>
        </div>

        @if($allImages->count() > 1)
        {{-- Controls --}}
        <button class="wst-carousel-btn prev" onclick="carouselNav(-1)"><i class="bi bi-chevron-left"></i></button>
        <button class="wst-carousel-btn next" onclick="carouselNav(1)"><i class="bi bi-chevron-right"></i></button>

        {{-- Dots --}}
        <div class="wst-carousel-dots">
            @foreach($allImages as $i => $img)
            <span class="dot {{ $i === 0 ? 'active' : '' }}" onclick="carouselGo({{ $i }})"></span>
            @endforeach
        </div>

        {{-- Counter --}}
        <div class="wst-carousel-counter">
            <span id="carouselCurrent">1</span> / {{ $allImages->count() }}
        </div>
        @endif
    </div>
</div>
@endif

<div class="container mt-4 mb-5">
    <div class="row g-4">
        {{-- Left: Info --}}
        <div class="col-lg-7">
            <div class="wst-panel">
                <h3 class="wst-panel-title">
                    <i class="bi bi-info-circle"></i> Informasi Wisata
                </h3>
                <p style="color:var(--wst-text); line-height:1.7; font-size:0.95rem;">{{ $wisata->informasi }}</p>
            </div>

            @if($wisata->syarat)
            <div class="wst-panel">
                <h3 class="wst-panel-title">
                    <i class="bi bi-list-check"></i> Syarat & Ketentuan
                </h3>
                <p style="color:var(--wst-text); line-height:1.7; font-size:0.95rem;">{{ $wisata->syarat }}</p>
            </div>
            @endif

            @if($wisata->detail)
            <div class="wst-panel">
                <h3 class="wst-panel-title">
                    <i class="bi bi-map"></i> Lokasi di Peta
                </h3>
                @if(str_contains($wisata->detail, 'google.com/maps'))
                <div style="border-radius:var(--wst-radius-sm);overflow:hidden;">
                    <iframe src="{{ $wisata->detail }}" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                @else
                <a href="{{ $wisata->detail }}" target="_blank" class="btn-wst">
                    <i class="bi bi-map"></i> Buka di Google Maps
                </a>
                @endif
            </div>
            @endif
        </div>

        {{-- Right: Ticket --}}
        <div class="col-lg-5">
            <div class="wst-panel" style="position:sticky; top:80px;">
                <h3 class="wst-panel-title">
                    <i class="bi bi-ticket-perforated"></i> Pesan Tiket
                </h3>

                <div class="wst-ticket-card mb-3">
                    <div class="ticket-name">{{ $wisata->nama }}</div>
                    <div class="ticket-price">Rp {{ number_format($wisata->harga ?? 0, 0, ',', '.') }}</div>
                    <div style="font-size:0.8rem;opacity:0.8;margin-top:0.25rem;">
                        <i class="bi bi-ticket-perforated me-1"></i>{{ $wisata->jumlahTiket ?? 0 }} tiket tersedia
                    </div>
                </div>

                <form method="POST" action="{{ route('prosesPilihTiket', ['id' => $wisata->id]) }}">
                    @csrf
                    <input type="hidden" name="wisata_id" value="{{ $wisata->id }}">

                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold">Pilih Tanggal Kunjungan</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                               min="{{ date('Y-m-d') }}" required>
                    </div>

                    @auth
                    <button type="submit" class="btn-wst w-100 justify-content-center">
                        <i class="bi bi-cart-check"></i> Pesan Sekarang
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="btn-wst w-100 justify-content-center text-decoration-none">
                        <i class="bi bi-box-arrow-in-right"></i> Login untuk Memesan
                    </a>
                    @endauth
                </form>
            </div>

            <a href="{{ route('dashboard') }}" class="btn-wst" style="background:transparent;color:var(--wst-primary);border:2px solid var(--wst-primary);width:100%;justify-content:center;">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.wst-carousel-slide');
const dots = document.querySelectorAll('.wst-carousel-dots .dot');
const total = slides.length;
let autoTimer;

function carouselGo(n) {
    slides[currentSlide].classList.remove('active');
    if (dots.length) dots[currentSlide].classList.remove('active');
    currentSlide = ((n % total) + total) % total; // infinite loop
    slides[currentSlide].classList.add('active');
    if (dots.length) dots[currentSlide].classList.add('active');
    const counter = document.getElementById('carouselCurrent');
    if (counter) counter.textContent = currentSlide + 1;
    resetAuto();
}

function carouselNav(dir) {
    carouselGo(currentSlide + dir);
}

function resetAuto() {
    clearInterval(autoTimer);
    if (total > 1) autoTimer = setInterval(() => carouselNav(1), 5000);
}

// Touch/swipe support
let touchX = 0;
const carousel = document.getElementById('wisataCarousel');
if (carousel) {
    carousel.addEventListener('touchstart', e => touchX = e.touches[0].clientX);
    carousel.addEventListener('touchend', e => {
        const diff = touchX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) carouselNav(diff > 0 ? 1 : -1);
    });
}

resetAuto();
</script>
@endpush
