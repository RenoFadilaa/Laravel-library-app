<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return Auth::user()->isadmin ? redirect()->route('admin.dashboard') : redirect()->route('home');
        }
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'firstname' => $request->first_name,
            'lastname' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isadmin' => false,
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Successfully registered and logged in.');
    }
}