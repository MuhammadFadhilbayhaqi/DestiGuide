@extends('layouts.mitra-layout')

@section('title', 'Edit Wisata')

@section('content')
<div class="container">
    <div class="mitra-page-header">
        <h1><i class="bi bi-pencil-square me-2" style="color:var(--mitra-primary);"></i>Edit Wisata</h1>
        <p class="page-subtitle">Perbarui informasi wisata <strong>{{ $wisata->nama }}</strong></p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Current Images --}}
            @if($wisata->images->count() > 0 || $wisata->image)
            <div class="mitra-form-card mb-0 p-3">
                <h3 class="mitra-section-title"><i class="bi bi-images"></i> Foto Saat Ini</h3>
                <div class="d-flex flex-wrap gap-2">
                    @forelse($wisata->images as $img)
                    <div style="position:relative;width:150px;height:110px;border-radius:8px;overflow:hidden;border:2px solid #E2E8F0;">
                        <img src="{{ asset('storage/' . $img->image_path) }}" style="width:100%;height:100%;object-fit:cover;">
                        <label style="position:absolute;top:4px;right:4px;background:rgba(239,68,68,0.9);color:#fff;font-size:0.7rem;padding:2px 6px;border-radius:4px;cursor:pointer;">
                            <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" form="editForm" style="display:none;">
                            <i class="bi bi-trash3"></i> Hapus
                        </label>
                    </div>
                    @empty
                    {{-- Fallback: show old single image --}}
                    <div style="position:relative;width:150px;height:110px;border-radius:8px;overflow:hidden;border:2px solid #E2E8F0;">
                        <img src="{{ asset('storage/' . $wisata->image) }}" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    @endforelse
                </div>
                <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Centang <i class="bi bi-trash3"></i> untuk menghapus foto saat menyimpan.</div>
            </div>
            @endif

            {{-- Edit Form --}}
            <form id="editForm" action="{{ route('updateWisata', ['id' => $wisata->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mitra-form-card mt-3">
                    <div class="mitra-form-section">
                        <h3 class="mitra-section-title">
                            <i class="bi bi-info-circle"></i> Informasi Wisata
                        </h3>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Wisata <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                   value="{{ $wisata->nama }}" required>
                            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Tiket (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="harga" name="harga"
                                   value="{{ $wisata->harga }}" min="0" required>
                            @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mitra-form-section">
                        <h3 class="mitra-section-title">
                            <i class="bi bi-image"></i> Tambah Foto Baru
                        </h3>

                        <div class="mb-3">
                            <label for="images" class="form-label">Unggah Foto Tambahan (Maks. {{ 10 - ($wisata->images->count() ?: 1) }} lagi)</label>
                            <input type="file" class="form-control" id="images" name="images[]" accept="image/*"
                                   multiple onchange="previewImages(event)">
                            <div class="form-text"><i class="bi bi-info-circle me-1"></i>Total semua foto maksimal 10.</div>
                            <div id="imagePreviewGrid" class="d-flex flex-wrap gap-2 mt-2"></div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('mitra') }}" class="btn-mitra-outline">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-mitra">
                        <i class="bi bi-check-lg"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

            {{-- Delete --}}
            <div class="mitra-form-card mb-5" style="border-color:#FECACA;">
                <h3 class="mitra-section-title" style="color:var(--mitra-danger); border-color:#FECACA;">
                    <i class="bi bi-exclamation-triangle"></i> Zona Bahaya
                </h3>
                <p style="font-size:0.9rem; color:var(--mitra-text-light);">
                    Menghapus wisata bersifat permanen dan tidak dapat dikembalikan.
                </p>
                <form action="{{ route('deleteWisata', ['id' => $wisata->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-mitra-danger"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus wisata ini? Tindakan ini tidak dapat dibatalkan.')">
                        <i class="bi bi-trash3"></i> Hapus Wisata Ini
                    </button>
                </form>
            </div>
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

// Toggle delete checkbox visual
document.querySelectorAll('input[name="delete_images[]"]').forEach(cb => {
    cb.addEventListener('change', function() {
        const wrapper = this.closest('div');
        wrapper.style.opacity = this.checked ? '0.4' : '1';
        wrapper.style.border = this.checked ? '2px solid #EF4444' : '2px solid #E2E8F0';
    });
});
</script>
@endpush
