<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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

        $anchor = trim((string) $request->input('return_anchor', 'fresh-near-you'));
        $fragment = $anchor !== '' ? '#' . ltrim($anchor, '#') : '';

        return redirect()->to(route('market.home') . $fragment)->with('success', 'Product added to cart!');
    }
    
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart = Session::get('cart', []);

        if (!isset($cart[$id])) {
            return redirect()->route('cart.index')->with('error', 'Item not found in cart.');
        }

        $cart[$id]['quantity'] = (int) $request->input('quantity');
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:120',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,gcash,card',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += ((float) $item['price']) * ((int) $item['quantity']);
        }

        $orderId = null;

        if (Schema::hasTable('orders') && Schema::hasTable('order_items')) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'full_name' => $request->input('full_name'),
                'address' => $request->input('address'),
                'payment_method' => $request->input('payment_method'),
                'status' => 'placed',
                'total_amount' => $total,
            ]);
            $orderId = $order->order_id;

            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => (int) $productId,
                    'product_name' => $item['name'],
                    'unit_price' => (float) $item['price'],
                    'quantity' => (int) $item['quantity'],
                    'subtotal' => ((float) $item['price']) * ((int) $item['quantity']),
                ]);
            }
        } else {
            $history = Session::get('order_history', []);
            $orderId = count($history) + 1;
            $history[] = [
                'order_id' => $orderId,
                'status' => 'placed',
                'total_amount' => $total,
                'created_at' => now()->toDateTimeString(),
                'items' => array_values(array_map(function ($productId, $item) {
                    return [
                        'product_id' => (int) $productId,
                        'product_name' => $item['name'],
                        'unit_price' => (float) $item['price'],
                        'quantity' => (int) $item['quantity'],
                        'subtotal' => ((float) $item['price']) * ((int) $item['quantity']),
                    ];
                }, array_keys($cart), $cart)),
            ];
            Session::put('order_history', $history);
        }

        Session::forget('cart');

        return redirect()->route('market.home')->with('success', 'Checkout successful! Order #' . $orderId . ' placed.');
    }
}

