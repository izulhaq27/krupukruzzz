@extends('admin.layouts.app')

@section('content')
<div class="container-fluid mt-4">

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-plus-circle text-primary"></i>
                        Tambah Kategori
                    </h4>
                </div>

                <div class="card-body px-4 pb-4">

                    <form action="{{ route('admin.categories.store') }}"
                            method="POST"
                            enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3 mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Nama Kategori -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kategori</label>
                            <input type="text"
                                    name="name"
                                    class="form-control rounded-3 @error('name') is-invalid @enderror"
                                    placeholder="Contoh: Original, Pedas, Manis"
                                    value="{{ old('name') }}"
                                    required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Slug akan dibuat otomatis dari nama kategori</small>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="description"
                                      class="form-control rounded-3 @error('description') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Jelaskan tentang kategori ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Kategori</label>
                            <input type="file"
                                    name="image"
                                    id="imageInput"
                                    class="form-control rounded-3 @error('image') is-invalid @enderror"
                                    accept="image/*"
                                    onchange="previewImage(event)">
                            <small class="text-muted">Format: jpg, jpeg, png, gif, svg • Max 2MB</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Preview Image -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <p class="fw-semibold mb-2">Preview:</p>
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
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Status Aktif
                                </label>
                            </div>
                            <small class="text-muted">Kategori aktif akan ditampilkan di website</small>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex gap-2">
                            <button type="submit"
                                    class="btn btn-primary px-4 rounded-3">
                                <i class="bi bi-save"></i> Simpan
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
