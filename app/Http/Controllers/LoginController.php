<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Auth::attempt($user)) {
            return response()->json([
                'errors' => ['message' => 'you entered an invalid email or password']
            ], 422);
        }

        $user = Auth::user();

        $token = auth()->user()->createToken('laravel_reactnative_login')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }

    public function profile()
    {
        return response()->json([
            'user' => auth()->user()
        ]);
    }
}
