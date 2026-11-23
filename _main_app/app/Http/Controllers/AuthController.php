<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('status', [
                'type' => 'success',
                'code' => 'ACCESS_GRANTED',
                'message' => 'Identity authenticated. Welcome back, Operator ' . (Auth::user()->playerProfile->ign ?? Auth::user()->name) . '.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Authorization failed: Invalid tactical access credentials.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', [
            'type' => 'info',
            'code' => 'TERMINAL_STANDBY',
            'message' => 'Tactical terminal session terminated successfully.',
        ]);
    }
}
