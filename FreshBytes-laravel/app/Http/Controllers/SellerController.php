<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function create()
    {
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

        return redirect()->route('market.home')->with('status', 'Seller registration submitted successfully! Awaiting verification.');
    }
}

