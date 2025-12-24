@extends('admin.layouts.app')

@section('content')
<div class="container-fluid mt-4">

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-pencil-square text-warning"></i>
                        Edit Kategori
                    </h4>
                </div>

                <div class="card-body px-4 pb-4">

                    <form action="{{ route('admin.categories.update', $category) }}"
                            method="POST"
                            enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Kategori -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kategori</label>
                            <input type="text"
                                    name="name"
                                    class="form-control rounded-3 @error('name') is-invalid @enderror"
                                    value="{{ old('name', $category->name) }}"
                                    required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Slug akan diupdate otomatis jika nama diubah</small>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="description"
                                      class="form-control rounded-3 @error('description') is-invalid @enderror"
                                      rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gambar Saat Ini -->
                        @if($category->image)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Gambar Saat Ini</label>
                                <div>
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         alt="{{ $category->name }}" 
                                         class="rounded-3 border" 
                                         style="max-width: 100%; max-height: 200px;">
                                </div>
                            </div>
                        @endif

                        <!-- Upload Gambar Baru -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                {{ $category->image ? 'Ganti Gambar (Opsional)' : 'Gambar Kategori' }}
                            </label>
                            <input type="file"
                                    name="image"
                                    id="imageInput"
                                    class="form-control rounded-3 @error('image') is-invalid @enderror"
                                    accept="image/*"
                                    onchange="previewImage(event)">
                            <small class="text-muted">
                                Format: jpg, jpeg, png, gif, svg • Max 2MB 
                                @if($category->image)
                                    • Biarkan kosong jika tidak ingin mengubah
                                @endif
                            </small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Preview Gambar Baru -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <p class="fw-semibold mb-2">Preview Gambar Baru:</p>
                                <img id="preview" src="" alt="Preview" class="rounded-3 border" style="max-width: 100%; max-height: 300px;">
                            </div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       role="switch"
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Status Aktif
                                </label>
                            </div>
                            <small class="text-muted">Kategori aktif akan ditampilkan di website</small>
                        </div>

                        <!-- Info Produk -->
                        @if($category->products_count > 0)
                            <div class="alert alert-info rounded-3 mb-4">
                                <i class="bi bi-info-circle me-2"></i>
                                Kategori ini memiliki <strong>{{ $category->products_count }} produk</strong>
                            </div>
                        @endif

                        <!-- Tombol -->
                        <div class="d-flex gap-2">
                            <button type="submit"
                                    class="btn btn-primary px-4 rounded-3">
                                <i class="bi bi-save"></i> Update
                            </button>

                            <a href="{{ route('admin.categories.index') }}"
                                class="btn btn-secondary px-4 rounded-3">
                                Kembali
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
