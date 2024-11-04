<?php

namespace App\Http\Controllers;

use App\Http\Resources\PetResource;
use App\Http\Resources\PetTypeResource;
use App\Models\Pet;
use App\Models\PetType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\String_;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PetController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pets = Pet::with(['petType', 'petBreed'])
            ->where('id_user', $user->id)
            ->get();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "success",
            'data' => PetResource::collection($pets),
        ]);
    }

    public function show($id)
    {
        try {
            // Attempt to find the pet by ID
            $pet = Pet::findOrFail($id);

            // Update the photo attribute to include the full URL
            $pet->photo = url($pet->photo);

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => "success",
                'data' => $pet,
            ]);
        } catch (ModelNotFoundException $e) {
            // If pet not found, return a 404 error
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Pet not found",
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            // For any other errors, return a 500 error with a generic message
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => "An error occurred while retrieving the pet",
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(Request $request)
    {

        $user = Auth::user();

        $pet = Pet::create([
            'pet_name' => $request->pet_name,
            'id_user' => $user->id,
            'type' => $request->type,
            'breed' => $request->breed,
            'age' => $request->age,
            'weight' => $request->weight
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $pet->id . '.' . $file->extension();

            $path = $file->storeAs('pet', $fileName, 'public');
            $fullUrl = Storage::url($path);

            $pet->update([
                'photo' => $fullUrl,
            ]);
        }

        if ($pet->photo != null) {
            $pet->photo = url($pet->photo);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Pet created successfully',
            'data' => $pet,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data for fields and file
        $validatedData = $request->validate([
            'pet_name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:255',
            'breed' => 'sometimes|string|max:255',
            'age' => 'sometimes|integer',
            'id_user' => 'sometimes|integer',
            'weight' => 'sometimes|numeric',
            'file' => 'nullable|file|image|max:51200', // Max 50MB image file
        ]);

        // Find the pet by ID or throw 404 error if not found
        $pet = Pet::findOrFail($id);

        // If a new file is uploaded, delete the old file first
        if ($request->hasFile('file')) {
            // Get the old file path stored in the database (e.g., '/storage/pet/15.jpg')
            $oldFilePath = storage_path('app/' . str_replace('/storage/', 'public/', $pet->photo)); // Make the path relative to 'public/'

            // Delete the old file if it exists in the storage
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }

            // Upload the new file
            $file = $request->file('file'); // Get the uploaded file
            $fileName = $pet->id . '.' . $file->extension(); // Generate new file name using pet ID
            $path = $file->storeAs('pet', $fileName, 'public'); // Store the file in 'public/pet' directory

            // Store the full URL of the new file in the 'photo' field of the pet
            $fullUrl = Storage::url($path);
            $pet->update([
                'photo' => $fullUrl,
            ]);
        }

        // Update the pet fields based on validated input
        $pet->update($validatedData); // Update fields like pet_name, type, breed, age, etc.

        // Return the updated pet info in the response
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Pet updated successfully',
            'data' => $pet,
        ]);
    }

    public function delete($id)
    {
        try {
            // Find the pet by ID or throw an exception if not found
            $pet = Pet::findOrFail($id);

            // Get the absolute file path for the pet's photo
            $filePath = $pet->photo;
            $absolutePath = storage_path('app/' . str_replace('/storage/', 'public/', $filePath));

            // Check if the file exists and attempt to delete it
            if (File::exists($absolutePath)) {
                File::delete($absolutePath);
            }

            // Attempt to delete the pet record from the database
            $pet->delete();

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => "Pet deleted successfully"
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            // Handle the case where the pet was not found
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Pet not found"
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => "Failed to delete pet: " . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function typeWithBreeds()
    {
        $petTypes = PetType::with('breeds')->get();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "success",
            'data' => PetTypeResource::collection($petTypes),
        ]);
    }
}
