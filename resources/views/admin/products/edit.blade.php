@extends('admin.layouts.app')

@section('content')
<div class="container-fluid mt-4">

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-pencil-square text-warning"></i>
                        Edit Produk
                    </h4>
                </div>

                <div class="card-body px-4 pb-4">

                    <form action="{{ route('admin.products.update', $product) }}"
                            method="POST"
                            enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Produk</label>
                            <input type="text"
                                    name="name"
                                    class="form-control rounded-3 @error('name') is-invalid @enderror"
                                    value="{{ old('name', $product->name) }}"
                                    required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Slug akan diupdate otomatis jika nama diubah</small>
                        </div>

                        <div class="row">
                            <!-- Harga -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number"
                                        name="price"
                                        class="form-control rounded-3 @error('price') is-invalid @enderror"
                                        value="{{ old('price', $product->price) }}"
                                        min="0"
                                        required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Stok</label>
                                <input type="number"
                                        name="stock"
                                        class="form-control rounded-3 @error('stock') is-invalid @enderror"
                                        value="{{ old('stock', $product->stock) }}"
                                        min="0"
                                        required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="description"
                                      class="form-control rounded-3 @error('description') is-invalid @enderror"
                                      rows="4">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="categories[]" 
                                    class="form-select rounded-3 @error('categories') is-invalid @enderror"
                                    multiple
                                    size="5">
                                @foreach(\App\Models\Category::active()->get() as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tekan Ctrl (atau Cmd) untuk memilih beberapa kategori</small>
                        </div>

                        <!-- Gambar Saat Ini -->
                        @if($product->image)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Gambar Saat Ini</label>
                                <div>
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="rounded-3 border" 
                                         style="max-width: 100%; max-height: 200px;">
                                </div>
                            </div>
                        @endif

                        <!-- Upload Gambar Baru -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                {{ $product->image ? 'Ganti Gambar (Opsional)' : 'Gambar Produk' }}
                            </label>
                            <input type="file"
                                    name="image"
                                    id="imageInput"
                                    class="form-control rounded-3 @error('image') is-invalid @enderror"
                                    accept="image/*"
                                    onchange="previewImage(event)">
                            <small class="text-muted">
                                Format: jpg, jpeg, png, gif • Max 2MB 
                                @if($product->image)
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

                        <!-- Tombol -->
                        <div class="d-flex gap-2">
                            <button type="submit"
                                    class="btn btn-primary px-4 rounded-3">
                                <i class="bi bi-save"></i> Update
                            </button>

                            <a href="{{ route('admin.products.index') }}"
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