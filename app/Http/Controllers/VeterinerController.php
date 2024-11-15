<?php

namespace App\Http\Controllers;

use App\Http\Resources\VeterinerResource;
use App\Models\Veteriner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class VeterinerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $veteriners = Veteriner::all();

        if (!$veteriners) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'No veteriners found',
            ], 404);
        }

        $veteriners  =  VeterinerResource::collection($veteriners);

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => $veteriners
        ], 200);
    }

    public function customerIndex()
    {
        $veteriners = Veteriner::where('register_status', 'approved')->get();

        if (!$veteriners) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'No veteriners found',
            ], 404);
        }

        $veteriners  =  VeterinerResource::collection($veteriners);

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => $veteriners
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $veteriner = Veteriner::findOrFail($id);

        if (!$veteriner) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Veteriner not found',
            ], 404);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => new VeterinerResource($veteriner)
        ], 200);
    }

    public function customerShow($id)
    {
        $veteriner = Veteriner::where('register_status', 'approved')->find($id);

        if (!$veteriner) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Veteriner not found',
            ], 404);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => new VeterinerResource($veteriner)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $veteriner = Veteriner::find($id);

        if (!$veteriner) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Veteriner not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'clinic_name' => 'sometimes|required|string|max:255',
            'clinic_image' => 'sometimes|nullable|string',
            'register_status' => 'sometimes|required|in:pending,approved,rejected',
            'latitude' => 'sometimes|required|string',
            'longitude' => 'sometimes|required|string',
            'city' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'document' => 'sometimes|nullable|string',
            'id_user' => 'sometimes|required|exists:users,id',
            'open_time' => 'sometimes|nullable|date_format:H:i',
            'close_time' => 'sometimes|nullable|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $veteriner->update($request->all());

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Veteriner updated successfully',
            'data' => new VeterinerResource($veteriner)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $veteriner = Veteriner::find($id);

        if (!$veteriner) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Veteriner not found',
            ], 404);
        }

        $veteriner->delete();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Veteriner deleted successfully',
        ], 200);
    }
}
