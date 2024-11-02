<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->identifier)
        ->orWhere('username', $request->identifier)
        ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => Response::HTTP_UNAUTHORIZED, 'message' => 'Invalid credentials']);
        }

        $token = $user->createToken('user_login')->plainTextToken;
        if($user->photo != null){
            $user->photo = url($user->photo);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'success',
            'data' => [
                'token' => $token,
                'user' => $user,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Logged out successfully'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Logout failed: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function me()
    {

        $user = Auth::user();

        if ($user->photo) {
            $user->photo= url('storage/' . $user->photo);
        }


        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'success',
            'data' => $user
        ]);
    }

    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        // Check if the email exists in the database
        $emailExists = User::where('email', $request->email)->exists();

        if ($emailExists) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Email already exists',
                'isExists' => true
            ]);
        } else {
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Email does not exist, you can proceed with registration',
                'exists' => false
            ]);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'photo' => 'sometimes|file|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'password' => 'required|string|min:3',
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

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = $user->id . '.' . $file->getClientOriginalExtension(); // Rename the file with the user ID
            $path = $file->storeAs('user', $filename, 'public'); // Store in 'storage/app/public/user' folder

            // Optionally, save the file path to the user record
            $user->update(['photo' => $path]);
        }

        if ($user->photo) {
            $user->photo= url('storage/' . $user->photo);
        }

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'message' => 'User Registered Success',
            'data' => [
                'user' => $user,
            ]
        ], Response::HTTP_CREATED);
    }
}
