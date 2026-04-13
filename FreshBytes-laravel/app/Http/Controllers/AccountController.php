<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = collect();
        if (Schema::hasTable('orders') && Schema::hasTable('order_items')) {
            $orders = Order::with('items')
                ->where('user_id', $user->user_id)
                ->latest('created_at')
                ->get();
        } else {
            $orders = collect(Session::get('order_history', []));
        }

        return view('account.index', compact('user', 'orders'));
    }

    public function updateSettings(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('auth.login');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        User::where('user_id', $user->user_id)->update($validated);

        return redirect()->route('account.index')->with('success', 'Account settings updated successfully.');
    }
}
