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
use Illuminate\Support\Facades\File;
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
        if ($user->photo != null) {
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

    public function show()
    {

        $user = Auth::user();

        if ($user->photo) {
            $user->photo = url('storage/' . $user->photo);
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
                'isExists' => false
            ]);
        }
    }

    public function checkUsername(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $usernameExists = User::where('username', $request->username)->exists();

        if ($usernameExists) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Username already exists',
                'isExists' => true
            ]);
        } else {
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Username does not exist, you can proceed with registration',
                'isExists' => false
            ]);
        }
    }

    public function register(Request $request)
    {
        $validator = null;

        if ($request->role == 'customer') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:3',
                'role' => 'required|in:customer,veteriner',
                'username' => 'required|string|max:255|unique:users',
                'phone' => 'required|string|max:25|unique:users',
                'photo' => 'sometimes|file|mimes:jpeg,png,jpg,gif,webp|max:51200',
            ]);
        } else if ($request->role == 'veteriner') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:3',
                'role' => 'required|in:customer,veteriner',
                'username' => 'required|string|max:255|unique:users',
                'phone' => 'required|string|max:25|unique:users',
                'photo' => 'sometimes|file|mimes:jpeg,png,jpg,gif,webp|max:51200',
                'clinic_name' => 'required_if:role,veteriner|string|max:255',
                'clinic_image' => 'sometimes|file|mimes:jpeg,png,jpg,gif,webp|max:51200',
                'latitude' => 'required_if:role,veteriner|numeric',
                'longitude' => 'required_if:role,veteriner|numeric',
                'city' => 'required_if:role,veteriner|string',
                'address' => 'required_if:role,veteriner|string',
                'document' => 'sometimes|file|mimes:docx,pdf',
                'open_time' => 'required_if:role,veteriner|date_format:H:i',
                'close_time' => 'required_if:role,veteriner|date_format:H:i|after:open_time',
            ]);
        } else {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Invalid Role',
            ], Response::HTTP_BAD_REQUEST);
        }

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
                $filename = $user->id . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('user', $filename, 'public');
                $user->update(['photo' => $path]);
            }


            $veterinerData = null;

            if ($request->role === 'veteriner') {
                $veterinerData = [
                    'clinic_name' => $request->clinic_name,
                    'register_status' => 'pending',
                    'register_status_message' => 'Please wait for the admin to verify your clinic',
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

            if ($request->role === 'veteriner') {
                if ($user->veteriner->clinic_image) {
                    $user->veteriner->clinic_image = url('storage/' . $user->veteriner->clinic_image);
                }
                if ($user->veteriner->document) {
                    $user->veteriner->document = url('storage/' . $user->veteriner->document);
                }
            }

            $responseData = [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'username' => $user->username,
                'phone' => $user->phone,
                'email_verified_at' => $user->email_verified_at,
                'updated_at' => $user->updated_at,
                'created_at' => $user->created_at,
                'id' => $user->id,
                'photo' => $user->photo,
            ];

            if ($request->role === 'veteriner') {
                $responseData['veteriner'] = $user->veteriner;
            }

            return response()->json([
                'status' => Response::HTTP_CREATED,
                'message' => 'User Registered Success',
                'data' => $responseData
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

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:32',
            'phone' => 'sometimes|required|string|max:25|unique:users,phone,' . $user->id,
            'photo' => 'sometimes|file|mimes:jpeg,png,jpg,gif,webp|max:51200', // Max size 50MB
            'password' => 'sometimes|required|string',
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Check if a photo file is being uploaded
        if ($request->hasFile('photo')) {

            $oldPath = $user->photo ? public_path("storage/" . $user->photo) : null;

            // Delete old photo if it exists
            if ($oldPath && File::exists($oldPath)) {
                File::delete($oldPath);
            }

            // Store the new photo with the user ID as the name
            $file = $request->file('photo');
            $filename = $user->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('user', $filename, 'public');
            $user->update(['photo' => $path]);
        }

        // Handle password hashing if password is provided
        if ($request->filled('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        // Update user details
        $user->update($request->except(['photo', 'password'])); // Exclude the raw password from being directly set

        if ($request->has('password')) {
            $user->password = $request->password;
        }

        $user->save();

        if($user->photo){
            $user->photo = url('storage/' . $user->photo);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }
}
