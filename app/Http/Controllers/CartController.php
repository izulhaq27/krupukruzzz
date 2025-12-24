<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }
        
        session()->put('cart', $cart);
        
        // Redirect based on button clicked
        $redirectTo = $request->input('redirect_to', 'back');
        
        if ($redirectTo === 'checkout') {
            if (auth()->check()) {
                return redirect()->route('checkout.index')
                    ->with('success', 'Produk ditambahkan! Silakan lanjutkan checkout.');
            } else {
                return redirect()->route('login')
                    ->with('info', 'Silakan login terlebih dahulu untuk checkout.');
            }
        } elseif ($redirectTo === 'cart') {
            return redirect()->route('cart.index')
                ->with('success', 'Produk ditambahkan ke keranjang!');
        }
        
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Keranjang diperbarui!');
    }

    /**
     * Remove item from cart.
     */
    public function remove($id)
    {
        $cart = session()->get('cart');
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }
}