<<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $cart = Session::get('cart', []);
        
        $cart[$id] = [
            'name' => $product->product_name,
            'price' => $product->product_price,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + 1,
            'image' => $product->image_light
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
?>

