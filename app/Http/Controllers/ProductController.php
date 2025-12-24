<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->paginate(12);
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function adminIndex()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // =========================
    // FORM TAMBAH
    // =========================
    public function create()
    {
        return view('admin.products.create');
    }

    // =========================
    // SIMPAN PRODUK
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();

            $image->storeAs('products', $imageName, 'public');
        }

        Product::create([
            'name'  => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageName, // 🔥 SIMPAN NAMA FILE SAJA
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // =========================
    // UPDATE PRODUK
    // =========================
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only('name','price','stock');

        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
                Storage::disk('public')->delete('products/'.$product->image);
            }

            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('products', $imageName, 'public');

            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    // =========================
    // HAPUS PRODUK
    // =========================
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
            Storage::disk('public')->delete('products/'.$product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
