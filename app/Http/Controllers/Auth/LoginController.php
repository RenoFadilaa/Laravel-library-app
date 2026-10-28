<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return Auth::user()->isadmin ? redirect()->route('admin.dashboard') : redirect()->route('home');
        }
        return view('auth.login');
    }

    public function action(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isadmin) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Welcome Admin.');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Successfully logged in.');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }
}

