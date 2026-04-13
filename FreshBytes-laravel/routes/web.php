<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AuthController;
use App\Models\Product;

Route::get('/', function () {
    $categories = Category::where('category_isActive', true)->get();
    $products = Product::where('is_active', true)->get();
    return view('welcome', compact('categories', 'products'));
});

Route::get('/market', function (Request $request) {
    $categories = Category::where('category_isActive', true)
        ->orderBy('category_name')
        ->get();

    $query = Product::where('is_active', true)->where('is_deleted', false);

    if ($request->filled('q')) {
        $q = $request->string('q')->toString();
        $query->where(function ($builder) use ($q) {
            $builder->where('product_name', 'like', "%{$q}%")
                ->orWhere('product_brief_description', 'like', "%{$q}%")
                ->orWhere('product_location', 'like', "%{$q}%");
        });
    }

    if ($request->filled('category')) {
        $query->where('category_id', (int) $request->input('category'));
    }

    $products = $query->latest('post_date')->get();

    $featuredCategories = $categories->take(4);
    $recommendedProducts = Product::where('is_active', true)
        ->where('is_deleted', false)
        ->when($request->filled('category'), fn ($builder) => $builder->where('category_id', (int) $request->input('category')))
        ->orderByDesc('top_rated')
        ->orderByDesc('sell_count')
        ->limit(8)
        ->get();

    return view('market-home', compact('categories', 'products', 'featuredCategories', 'recommendedProducts'));
})->name('market.home');

$products = [
    1 => [
        'name' => 'Apple iMac 27", 1TB HDD, Retina 5K Display, M3 Max',
        'price' => '₱1,699',
        'rating' => 5.0,
        'reviews' => 455,
        'image_light' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg',
        'image_dark' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg',
        'discount' => 'Up to 35% off',
        'features' => ['Fast Delivery', 'Best Price']
    ],
    2 => [
        'name' => 'Apple iPhone 15 Pro Max, 256GB, Blue Titanium',
        'price' => '₱1,199',
        'rating' => 4.9,
        'reviews' => 1233,
        'image_light' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/iphone-light.svg',
        'image_dark' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/iphone-dark.svg',
        'discount' => 'Up to 15% off',
        'features' => ['Best Seller', 'Best Price']
    ],
    3 => [
        'name' => 'iPad Pro 13-Inch (M4): XDR Display, 512GB',
        'price' => '₱799',
        'rating' => 4.9,
        'reviews' => 879,
        'image_light' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/ipad-light.svg',
        'image_dark' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/ipad-dark.svg',
        'discount' => 'Up to 35% off',
        'features' => ['Shipping Today', 'Best Price']
    ],
    4 => [
        'name' => 'PlayStation®5 Console – 1TB, PRO Controller',
        'price' => '₱499',
        'rating' => 4.8,
        'reviews' => 2957,
        'image_light' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/ps5-light.svg',
        'image_dark' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/ps5-dark.svg',
        'discount' => 'Up to 10% off',
        'features' => ['Fast Delivery', 'Best Price']
    ],
    5 => [
        'name' => 'Microsoft Xbox Series X 1TB Gaming Console',
        'price' => '₱499',
        'rating' => 4.8,
        'reviews' => 4263,
        'image_light' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/xbox-light.svg',
        'image_dark' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/xbox-dark.svg',
        'discount' => 'Up to 10% off',
        'features' => ['Best Seller', 'Best Price']
    ],
    6 => [
        'name' => 'Apple MacBook PRO Laptop with M2 chip',
        'price' => '₱2,599',
        'rating' => 4.9,
        'reviews' => 1076,
        'image_light' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/macbook-pro-light.svg',
        'image_dark' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/macbook-pro-dark.svg',
        'discount' => 'Up to 5% off',
        'features' => ['Fast Delivery', 'Best Price']
    ],
    7 => [
        'name' => 'Apple Watch SE [GPS 40mm], Smartwatch',
        'price' => '₱699',
        'rating' => 4.7,
        'reviews' => 387,
        'image_light' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/apple-watch-light.svg',
        'image_dark' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/apple-watch-dark.svg',
        'discount' => 'Up to 20% off',
        'features' => ['Fast Delivery', 'Best Price']
    ],
    8 => [
        'name' => 'Microsoft Surface Pro, Copilot+ PC, 13 Inch',
        'price' => '₱899',
        'rating' => 4.9,
        'reviews' => 4775,
        'image_light' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/ipad-keyboard.svg',
        'image_dark' => 'https://flowbite.s3.amazonaws.com/blocks/e-commerce/ipad-keyboard-dark.svg',
        'discount' => 'Up to 35% off',
        'features' => ['Fast Delivery', 'Best Price']
    ]
];

Route::get('/products/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return view('layouts.product-overview', compact('product'));
})->name('product.show');

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::get('/signup', [AuthController::class, 'showSignup'])->name('auth.signup');

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.submit');
    Route::post('/signup', [AuthController::class, 'signup'])->name('auth.signup.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');
Route::post('/auth/google', [AuthController::class, 'google'])->name('auth.google');

Route::middleware('auth')->group(function () {
Route::get('/seller/register', [SellerController::class, 'create'])->name('seller.register');
Route::post('/seller/register', [SellerController::class, 'store']);
});
Route::match(['get', 'post'], '/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password');
