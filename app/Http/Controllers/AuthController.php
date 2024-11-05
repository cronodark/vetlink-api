<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Veteriner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
            'message' => 'Success',
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
            'message' => 'Success',
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
            'password' => 'required|string|min:3',
            'role' => 'required|in:customer,veteriner',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:25|unique:users',
            'photo' => 'sometimes|file|mimes:jpeg,png,jpg,gif,webp|max:51200',
            //Vetetiner
            'clinic_name' => 'required_if:role,veteriner|string|max:255',
            'clinic_image' => 'sometimes|file|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'latitude' => 'required_if:role,veteriner|numeric',
            'longitude' => 'required_if:role,veteriner|numeric',
            'city' => 'required_if:role,veteriner|string',
            'address' => 'required_if:role,veteriner|string',
            'document' => 'sometimes|file|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'open_time' => 'required_if:role,veteriner|date_format:H:i',
            'close_time' => 'required_if:role,veteriner|date_format:H:i|after:open_time',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();

        try {
            
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

            
            if ($request->role === 'veteriner') {
                $veterinerData = [
                    'clinic_name' => $request->clinic_name,
                    'register_status' => 'pending',
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'city' => $request->city,
                    'address' => $request->address,
                    'id_user' => $user->id,
                    'open_time' => $request->open_time,
                    'close_time' => $request->close_time,
                ];

                
                if ($request->hasFile('clinic_image')) {
                    $file = $request->file('clinic_image');
                    $filename = 'clinic_' . $user->id . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('clinic', $filename, 'public');
                    $veterinerData['clinic_image'] = $path;
                }

                
                if ($request->hasFile('document')) {
                    $file = $request->file('document');
                    $filename = 'doc_' . $user->id . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('documents', $filename, 'public');
                    $veterinerData['document'] = $path;
                }

                $veteriner = Veteriner::create($veterinerData);
                $user->load('veteriner');
            }

            DB::commit();
            
            if ($user->photo) {
                $user->photo = url('storage/' . $user->photo);
            }

            
            if ($user->veteriner) {
                if ($user->veteriner->clinic_image) {
                    $user->veteriner->clinic_image = url('storage/' . $user->veteriner->clinic_image);
                }
                if ($user->veteriner->document) {
                    $user->veteriner->document = url('storage/' . $user->veteriner->document);
                }
            }

        

            return response()->json([
                'status' => Response::HTTP_CREATED,
                'message' => 'User Registered Success',
                'data' => 
                [
                    'user' => $user,
                ]
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
