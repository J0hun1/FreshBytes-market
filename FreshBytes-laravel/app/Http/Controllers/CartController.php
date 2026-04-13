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

        // Use centralized catalog config for product images and details
        $catalog = config('market_catalog');
        $productProfiles = $catalog['products'] ?? [];
        $fallbackProfile = $catalog['fallback'] ?? [];

        // Resolve product profile
        $normalized = strtolower(trim((string) $product->product_name));
        $matchedProfile = $productProfiles[$normalized] ?? null;

        if (!$matchedProfile) {
            foreach ($productProfiles as $name => $profile) {
                if (str_contains($normalized, $name) || str_contains($name, $normalized)) {
                    $matchedProfile = $profile;
                    break;
                }
            }
        }

        $profile = $matchedProfile ?? $fallbackProfile;
        
        $cart = Session::get('cart', []);
        
        $cart[$id] = [
            'name' => $product->product_name,
            'price' => $product->product_price,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + 1,
            'image' => $profile['image'] ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1200&q=80'
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

