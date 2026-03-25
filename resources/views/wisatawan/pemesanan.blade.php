@extends('layouts.wisatawan-layout')

@section('title', 'Pemesanan Tiket')

@section('content')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="wst-section-header">
                <h2><i class="bi bi-cart-check me-2" style="color:var(--wst-primary);"></i>Pemesanan Tiket</h2>
                <p>Lengkapi data diri Anda untuk melanjutkan pemesanan</p>
            </div>

            <form method="POST" action="{{ route('pemesanan.store') }}">
                @csrf

                {{-- Data Diri --}}
                <div class="wst-panel">
                    <h3 class="wst-panel-title">
                        <i class="bi bi-person-vcard"></i> Data Pemesan
                    </h3>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                               placeholder="Masukkan nama lengkap Anda" value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomor_handphone" class="form-label">No. Handphone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="nomor_handphone" name="nomor_handphone"
                                       placeholder="Contoh: 08123456789" value="{{ old('nomor_handphone') }}" required>
                                @error('nomor_handphone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="nama@email.com" value="{{ old('email') }}" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ktp" class="form-label">Nomor KTP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ktp" name="ktp"
                               placeholder="Masukkan 16 digit nomor KTP" value="{{ old('ktp') }}" required>
                        @error('ktp') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Pembayaran --}}
                <div class="wst-panel">
                    <h3 class="wst-panel-title">
                        <i class="bi bi-credit-card"></i> Metode Pembayaran
                    </h3>

                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Pilih Metode Pembayaran <span class="text-danger">*</span></label>
                        <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                            <option value="" selected disabled>-- Pilih metode --</option>
                            <option value="Bca - 7751330611">BCA — 7751330611</option>
                            <option value="Mandiri - 141-00-1234567-8">Mandiri — 141-00-1234567-8</option>
                        </select>
                    </div>

                    {{-- Price Summary --}}
                    <div style="background:var(--wst-body-bg);border-radius:var(--wst-radius-sm);padding:1.25rem;">
                        @if($wisata)
                        <div class="mb-2" style="font-size:0.85rem;color:var(--wst-text-light);">
                            <i class="bi bi-geo-alt me-1"></i>{{ $wisata->nama }}
                            @if($tanggalPemesanan)
                            &nbsp;•&nbsp; <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($tanggalPemesanan)->format('d M Y') }}
                            @endif
                        </div>
                        <hr style="border-color:var(--wst-border);">
                        @endif
                        <div class="d-flex justify-content-between mb-2" style="font-size:0.9rem;">
                            <span style="color:var(--wst-text-light);">Tiket Wisata × 1</span>
                            <span>Rp {{ number_format($wisata->harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" style="font-size:0.9rem;">
                            <span style="color:var(--wst-text-light);">Biaya Layanan</span>
                            <span>Rp 0</span>
                        </div>
                        <hr style="border-color:var(--wst-border);">
                        <div class="d-flex justify-content-between">
                            <span style="font-weight:600;">Total Bayar</span>
                            <span style="font-weight:700;font-size:1.15rem;color:var(--wst-primary);">Rp {{ number_format($wisata->harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('dashboard') }}" style="color:var(--wst-primary);font-weight:500;text-decoration:none;">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn-wst">
                        <i class="bi bi-shield-check"></i> Bayar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
