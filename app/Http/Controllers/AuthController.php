<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            return response()->json(['status' => Response::HTTP_UNAUTHORIZED,'message' => 'Invalid credentials']);
        }
        
        $token = $user->createToken('user_login')->plainTextToken;

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'success',
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
            'status' => Response::HTTP_OK,
            'message' => 'success',
            'data' => [Auth::user()]
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',
            'role' => 'required|in:customer,veteriner',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'username' => $request->username,
            'phone' => $request->phone,
            'email_verified_at' => now(), 
            'remember_token' => Str::random(10),
           
        ]);
    
        $token = $user->createToken('user_register')->plainTextToken;
    
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'message' => 'User Registered Success',
            'data' => [
                'token' => $token,
                'user' => $user,
            ]
        ], Response::HTTP_CREATED);
    }
}
