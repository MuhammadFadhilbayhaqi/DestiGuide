@extends('layouts.mitra-layout')

@section('title', 'Pendaftaran Wisata')

@section('content')
<div class="container">
    <div class="mitra-page-header">
        <h1><i class="bi bi-plus-circle me-2" style="color:var(--mitra-primary);"></i>Pendaftaran Wisata Baru</h1>
        <p class="page-subtitle">Lengkapi data wisata Anda dengan benar agar mudah ditemukan wisatawan.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('registWisata') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Section: Info Dasar --}}
                <div class="mitra-form-card">
                    <div class="mitra-form-section">
                        <h3 class="mitra-section-title">
                            <i class="bi bi-info-circle"></i> Informasi Dasar
                        </h3>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Wisata <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                   placeholder="Contoh: Margacinta Park" value="{{ old('nama') }}" required>
                            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="noHp" class="form-label">No. Telepon Wisata <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="noHp" name="noHp"
                                           placeholder="Contoh: 628123456789" value="{{ old('noHp') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alamatEmail" class="form-label">Email Wisata <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="alamatEmail" name="alamatEmail"
                                           placeholder="Contoh: wisata@email.com" value="{{ old('alamatEmail') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="informasi" class="form-label">Informasi Umum <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="informasi" name="informasi" rows="3"
                                      placeholder="Ceritakan secara singkat tentang wisata Anda..." required>{{ old('informasi') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="syarat" class="form-label">Syarat &amp; Ketentuan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="syarat" name="syarat" rows="3"
                                      placeholder="Tuliskan aturan kunjungan, barang yang tidak boleh dibawa, dll..." required>{{ old('syarat') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Section: Lokasi --}}
                <div class="mitra-form-card">
                    <div class="mitra-form-section">
                        <h3 class="mitra-section-title">
                            <i class="bi bi-geo-alt"></i> Lokasi
                        </h3>

                        <div class="mb-3">
                            <label for="alamatLengkap" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="alamatLengkap" name="alamatLengkap"
                                   placeholder="Contoh: Jl. Raya No. 10, RT 01/RW 02, Kel. Sukamaju" value="{{ old('alamatLengkap') }}" required>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi"
                                           placeholder="Contoh: Jawa Barat" value="{{ old('provinsi') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kota" class="form-label">Kota</label>
                                    <input type="text" class="form-control" id="kota" name="kota"
                                           placeholder="Contoh: Bandung" value="{{ old('kota') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                           placeholder="Contoh: Lembang" value="{{ old('kecamatan') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="detail" class="form-label">Link Google Maps</label>
                            <input type="text" class="form-control" id="detail" name="detail"
                                   placeholder="Tempel link Google Maps lokasi wisata Anda" value="{{ old('detail') }}">
                            <div class="form-text"><i class="bi bi-info-circle me-1"></i>Opsional, untuk memudahkan wisatawan menemukan lokasi.</div>
                        </div>
                    </div>
                </div>

                {{-- Section: Tiket & Jadwal --}}
                <div class="mitra-form-card">
                    <div class="mitra-form-section">
                        <h3 class="mitra-section-title">
                            <i class="bi bi-ticket-perforated"></i> Tiket &amp; Jadwal
                        </h3>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga Tiket (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="harga" name="harga"
                                           placeholder="Contoh: 25000" value="{{ old('harga') }}" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jumlahTiket" class="form-label">Jumlah Tiket Tersedia <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="jumlahTiket" name="jumlahTiket"
                                           placeholder="Contoh: 100" value="{{ old('jumlahTiket') }}" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hari Buka <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="jadwal[]" value="{{ $hari }}" id="jadwal{{ $hari }}"
                                           {{ is_array(old('jadwal')) && in_array($hari, old('jadwal')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jadwal{{ $hari }}">{{ $hari }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section: Foto --}}
                <div class="mitra-form-card">
                    <div class="mitra-form-section">
                        <h3 class="mitra-section-title">
                            <i class="bi bi-image"></i> Foto Wisata
                        </h3>

                        <div class="mb-3">
                            <label for="images" class="form-label">Unggah Foto (Maks. 10) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="images" name="images[]" accept="image/*"
                                   multiple required onchange="previewImages(event)">
                            <div class="form-text"><i class="bi bi-info-circle me-1"></i>Format: JPG, PNG (maks. 2MB per foto). Pilih hingga 10 foto sekaligus.</div>
                            <div id="imagePreviewGrid" class="d-flex flex-wrap gap-2 mt-2"></div>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <a href="{{ route('mitra') }}" class="btn-mitra-outline">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-mitra">
                        <i class="bi bi-check-lg"></i> Simpan Wisata
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImages(event) {
    const grid = document.getElementById('imagePreviewGrid');
    grid.innerHTML = '';
    const files = Array.from(event.target.files).slice(0, 10);
    if (files.length > 10) {
        alert('Maksimal 10 foto!');
        event.target.value = '';
        return;
    }
    files.forEach((file, i) => {
        const wrapper = document.createElement('div');
        wrapper.style.cssText = 'position:relative;width:120px;height:90px;border-radius:8px;overflow:hidden;border:2px solid #E2E8F0;';
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
        const badge = document.createElement('span');
        badge.textContent = i + 1;
        badge.style.cssText = 'position:absolute;top:4px;left:4px;background:var(--mitra-primary);color:#fff;font-size:0.7rem;padding:1px 6px;border-radius:4px;';
        wrapper.appendChild(img);
        wrapper.appendChild(badge);
        grid.appendChild(wrapper);
    });
}
</script>
@endpush

