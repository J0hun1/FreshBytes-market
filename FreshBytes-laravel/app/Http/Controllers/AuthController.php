<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('market.home');
        }

        return view('auth.login');
    }

    public function showSignup(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('market.home');
        }

        return view('auth.signup');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('market.home')->with('status', 'Welcome back!');
        }

        return back()
            ->withErrors(['email' => 'Invalid credentials. Please try again.'])
            ->onlyInput('email');
    }

    public function signup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $nameParts = preg_split('/[._-]+/', $validated['username']) ?: [];
        $firstName = ucfirst($nameParts[0] ?? $validated['username']);
        $lastName = ucfirst($nameParts[1] ?? 'User');

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'role' => 'user',
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('market.home')->with('status', 'Account created successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('status', 'You have been logged out.');
    }

    public function google(): RedirectResponse
    {
        return back()->with('status', 'Google auth is not configured yet.');
    }

    public function forgotPassword(Request $request): RedirectResponse
    {
        if ($request->filled('email')) {
            $request->validate([
                'email' => ['email'],
            ]);
        }

        return back()->with('status', 'Password reset is not configured yet. Please contact support.');
    }
}
