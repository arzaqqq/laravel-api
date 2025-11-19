<?php

namespace App\Http\Controllers\Auth;

use auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth as AuthFacade;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
public function __invoke(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (!AuthFacade::attempt($credentials)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    $token = AuthFacade::user()->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token
    ]);
}

}
