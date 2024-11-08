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
            $pet = Pet::with(['petType', 'petBreed'])->where('id', $id)->firstOrFail();

            // Wrap the result with PetResource to format it correctly
            $pet = new PetResource($pet);

            // Return a single object in the JSON response
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
            'gender' => $request->gender,
            'breed' => $request->breed,
            'age' => $request->age,
            'weight' => $request->weight,
            'notes' => $request->notes
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = $pet->id . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('pet', $fileName, 'public');

            $pet->update([
                'photo' => $path,
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
        // Validate the request data
        $validatedData = $request->validate([
            'pet_name' => 'sometimes|required|string|max:255',
            'photo' => 'sometimes|required|file|image|max:51200', // Max 50MB image file
            'age' => 'sometimes|required',
            'weight' => 'sometimes|required|',
            'gender' => 'sometimes|required|string|max:255',
            'notes' => 'sometimes|nullable|string|max:255',
            'type' => 'sometimes|required',
            'breed' => 'sometimes|required',
        ]);

        // Find the pet by ID or throw 404 error if not found
        $pet = Pet::findOrFail($id);

        // Store the old file path before updating
        $oldFilePath = $pet->photo ? public_path("storage/" . $pet->photo) : null;

        // Update the pet fields with validated input
        $pet->update($validatedData);

        // If a new file is uploaded, delete the old file first
        if ($request->hasFile('photo')) {
            if ($oldFilePath && File::exists($oldFilePath) && $pet->photo !== 'pet/default.jpeg') {
                File::delete($oldFilePath); // Delete the old photo if it exists and is not the default image
            }

            // Store the new file
            $file = $request->file('photo');
            $fileName = $pet->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pet', $fileName, 'public'); // Store in 'public/pet' directory

            if ($path) {
                // Update the pet's photo field with the new path
                $pet->update([
                    'photo' => $path,
                ]);
            }
        }

        $pet = new PetResource($pet);

        // Return the updated pet info
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

            // Get the file path for the pet's photo
            $filePath = $pet->photo;
            $absolutePath = public_path("storage/{$filePath}");

            // Check if the file exists and is not the default image
            if (File::exists($absolutePath) && $filePath !== 'pet/default.jpeg') {
                File::delete($absolutePath);
            }

            // Delete the pet record from the database
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
