<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function showLogin() {
        return view('admin.auth.login');
    }
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            if (!Auth::user()->hasAnyRole('admin', 'Sadmin')) {
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized.']);
            }
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Logged out successfully.');
    }
    public function profile() {
        $user = Auth::user();
        return view('admin.auth.profile', compact('user'));
    }

    public function update(Request $request) {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);
        $user = Auth::user();
        $user->update($request->only('first_name', 'last_name', 'email'));

        return back()->with('status', 'Profile updated successfully.');
    }

    public function changePassword(Request $request) {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return back()->with('status', 'Password changed successfully.');
    }
}
