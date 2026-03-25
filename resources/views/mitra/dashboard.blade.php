@extends('layouts.mitra-layout')

@section('title', 'Dashboard Mitra')

@section('content')
<div class="container">
    {{-- Greeting --}}
    <div class="mitra-greeting mt-4">
        <h2><i class="bi bi-hand-wave me-2"></i>Halo, {{ Auth::user()->name }}!</h2>
        <p>Selamat datang di panel mitra DestiGuide. Kelola wisata Anda dengan mudah dari sini.</p>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="mitra-stat-card">
                <div class="stat-icon"><i class="bi bi-map"></i></div>
                <div class="stat-value">{{ $wisatas->count() }}</div>
                <div class="stat-label">Total Wisata</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="mitra-stat-card">
                <div class="stat-icon"><i class="bi bi-ticket-perforated"></i></div>
                <div class="stat-value">{{ $wisatas->sum('jumlahTiket') }}</div>
                <div class="stat-label">Total Tiket Tersedia</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="mitra-stat-card">
                <div class="stat-icon"><i class="bi bi-plus-circle"></i></div>
                <a href="{{ route('viewWisata') }}" class="btn-mitra btn-mitra-sm mt-2 text-decoration-none">
                    <i class="bi bi-plus-lg"></i> Tambah Wisata Baru
                </a>
            </div>
        </div>
    </div>

    {{-- Wisata List --}}
    <div class="mitra-page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>Wisata Anda</h1>
            <p class="page-subtitle">Daftar wisata yang Anda kelola</p>
        </div>
        <a href="{{ route('kelolaWisata') }}" class="btn-mitra-outline btn-mitra-sm">
            <i class="bi bi-table"></i> Lihat Semua
        </a>
    </div>

    @if($wisatas->isEmpty())
        <div class="mitra-empty-state">
            <div class="empty-icon"><i class="bi bi-geo-alt"></i></div>
            <h3>Belum ada wisata terdaftar</h3>
            <p>Mulai tambahkan wisata pertama Anda agar bisa ditemukan wisatawan.</p>
            <a href="{{ route('viewWisata') }}" class="btn-mitra">
                <i class="bi bi-plus-lg"></i> Tambah Wisata
            </a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            @foreach($wisatas as $wisata)
            <div class="col">
                <div class="mitra-card">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('storage/' . $wisata->image) }}" alt="{{ $wisata->nama }}">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $wisata->nama }}</h5>
                        <div class="card-detail">
                            <i class="bi bi-geo-alt-fill text-danger"></i>
                            {{ $wisata->provinsi ?? '-' }}, {{ $wisata->kecamatan ?? '-' }}
                        </div>
                        <div class="card-detail">
                            <i class="bi bi-tag-fill" style="color:var(--mitra-primary);"></i>
                            Rp {{ number_format($wisata->harga ?? 0, 0, ',', '.') }}
                        </div>
                        <div class="card-detail">
                            <i class="bi bi-ticket-perforated-fill" style="color:var(--mitra-warning);"></i>
                            {{ $wisata->jumlahTiket ?? 0 }} tiket tersedia
                        </div>
                        <div class="card-actions">
                            <a href="{{ route('editWisata', $wisata->id) }}" class="btn-mitra btn-mitra-sm w-100 justify-content-center">
                                <i class="bi bi-pencil-square"></i> Kelola
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
