<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
public function create()
    {
        if (Auth::user()->sellers()->where('is_active', true)->exists()) {
            return redirect()->route('seller.dashboard')->with('info', 'Welcome back to your seller dashboard!');
        }

        return view('seller.seller-reg');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_address' => 'required|string|max:500',
            'business_phone' => 'required|string|max:20',
            'business_email' => 'required|email|max:255',
            'tax_id' => 'nullable|string|max:100',
            'bank_account_details' => 'required|string',
        ]);

        Seller::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'is_verified' => false,
            'is_active' => true,
            'rating' => 0,
            'total_sales' => 0,
        ]));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'You are now an official seller!'
            ]);
        }

        return redirect()->route('market.home')->with('status', 'Seller registration submitted successfully! Awaiting verification.');
    }

    public function productCreate()
    {
        $categories = Category::where('category_isActive', true)->get();
        return view('seller.product-create', compact('categories'));
    }

    public function productStore(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_brief_description' => 'required|string',
            'product_detailed_description' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'product_location' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'product_unit' => 'required|string|max:20',
            'harvest_date' => 'required|date',
            'brand' => 'nullable|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        ]);

        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/images/products', $imageName);
            $validated['image'] = $imageName;
        }

        // Get latest seller for this user
        $seller = Seller::where('user_id', Auth::id())
            ->where('is_active', true)
            ->latest('created_at')
            ->first();

        if (!$seller) {
            return redirect()->route('seller.register')->with('error', 'Please register as seller first.');
        }

        $validated['seller_id'] = $seller->seller_id;
        $validated['user_id'] = Auth::id();
        $validated['post_date'] = now();
        $validated['is_active'] = true;
        $validated['is_deleted'] = false;
        $validated['sell_count'] = 0;
        $validated['product_status'] = 'fresh';
        $validated['product_sku'] = 'SKU-' . time() . '-' . strtoupper(substr($validated['product_name'], 0, 3));

        Product::create($validated);

        return redirect()->route('market.home')->with('success', 'Product listed successfully!');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $seller = $user->sellers()->where('is_active', true)->firstOrFail();
        $products = $seller->products()->where('is_deleted', false)->latest('post_date')->get();

        return view('seller.dashboard', compact('seller', 'products'));
    }

    public function productEdit(Product $product)
    {
        $user = Auth::user();
        $seller = $user->sellers()->where('is_active', true)->first();

        if (!$seller || $product->seller_id !== $seller->seller_id || $product->is_deleted) {
            abort(404);
        }

        $categories = Category::where('category_isActive', true)->get();

        return view('seller.product-edit', compact('product', 'categories'));
    }

    public function productUpdate(Request $request, Product $product)
    {
        $user = Auth::user();
        $seller = $user->sellers()->where('is_active', true)->first();

        if (!$seller || $product->seller_id !== $seller->seller_id || $product->is_deleted) {
            abort(404);
        }

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_brief_description' => 'required|string',
            'product_detailed_description' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'product_location' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'product_unit' => 'required|string|max:20',
            'harvest_date' => 'required|date',
            'brand' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                $oldImagePath = public_path('storage/images/products/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/images/products', $imageName);
            $validated['image'] = $imageName;
        }

        $product->update($validated);

        return redirect()->route('seller.dashboard')->with('success', 'Product updated successfully!');
    }

    public function productDestroy(Product $product)
    {
        $user = Auth::user();
        $seller = $user->sellers()->where('is_active', true)->first();

        if (!$seller || $product->seller_id !== $seller->seller_id || $product->is_deleted) {
            abort(404);
        }

        $product->update(['is_deleted' => true]);

        return redirect()->route('seller.dashboard')->with('success', 'Product deleted successfully!');
    }
}

