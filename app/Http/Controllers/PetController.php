<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\String_;

class PetController extends Controller
{
    public function index($id)
    {
        $pets = Pet::where('id_user', $id)->get();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "success",
            'data' => $pets,
        ]);
    }

    public function show($id)
    {
        $pet = Pet::findOrFail($id);

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "success",
            'data' => $pet,
        ]);
    }

    public function create(Request $request)
    {
        $pet = Pet::create([
            'pet_name' => $request->pet_name,
            'type' => $request->type,
            'breed' => $request->breed,
            'age' => $request->age,
            'id_user' => $request->id_user,
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

        return response()->json([
            'status' => 'success',
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
        $pet = Pet::findOrFail($id);

        $filePath = $pet->photo;
        $absolutePath = storage_path('app/' . str_replace('/storage/', 'public/', $filePath)); // Get absolute path

        // Check if the file exists before attempting to delete
        if ($absolutePath) {
            // Attempt to delete the file
            File::delete($absolutePath);
        }
        $pet->delete();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => "Pet deleted successfully"
        ]);
    }

    /* TODO:
     * Implement the following methods:
     * 2. update
     */
}
