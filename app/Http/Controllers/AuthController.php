<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 401,'message' => 'Invalid credentials'], 401);
        }

        // Generate token based on user's role
        $token = $user->createToken('user_login')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'OK',
            'data' => [
                'token' => $token,
                'user' => $user,
            ]
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 200,'message' => 'Logged out successfully'], 200);
    }

    public function me(Request $request){
        return response()->json([
            'status' => 200,
            'message' => 'OK',
            'data' => [Auth::user()]
        ]);
    }
}
