<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $imageByName = [
            'Eggplant' => 'https://images.unsplash.com/photo-1518735869015-566a18eae4be?auto=format&fit=crop&w=640&q=80',
            'Lettuce' => 'https://images.unsplash.com/photo-1622205313162-be1d5712a43f?auto=format&fit=crop&w=640&q=80',
            'Squash' => 'https://images.unsplash.com/photo-1604977042946-1eecc30f269e?auto=format&fit=crop&w=640&q=80',
            'Watermelon' => 'https://images.unsplash.com/photo-1563114773-84221bd62daa?auto=format&fit=crop&w=640&q=80',
            'Apple' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?auto=format&fit=crop&w=640&q=80',
            'Carrot' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?auto=format&fit=crop&w=640&q=80',
            'Pechay' => 'https://images.unsplash.com/photo-1618040996337-56904b7850b9?auto=format&fit=crop&w=640&q=80',
        ];
        
        $cart = Session::get('cart', []);
        
        $cart[$id] = [
            'name' => $product->product_name,
            'price' => $product->product_price,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + 1,
            'image' => $imageByName[$product->product_name] ?? '/images/market_banner.png'
        ];
        
        Session::put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product added to cart!');
    }
    
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }
}

