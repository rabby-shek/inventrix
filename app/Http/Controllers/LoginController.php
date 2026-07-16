<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('welcome');
    }
    public function store(LoginRequest $loginRequest)
    {
        if (!Auth::attempt(
            $loginRequest->only('email', 'password')
        )) {
            return back()
                ->withErrors([
                    'email' => 'Invalid credentials'
                ])->onlyInput('email');
        }
        $loginRequest->session()->regenerate();

        $loginRequest->user()->update([
            'last_login_at' => now(),
        ]);

        return redirect()->intended(route('dashboard'));
    }
}
