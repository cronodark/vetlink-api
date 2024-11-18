<?php

namespace App\Http\Controllers;

use App\Http\Resources\VeterinerResource;
use App\Models\Veteriner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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

    public function vetShow(){
        $veteriner = Veteriner::where('id_user', Auth::id())->first();

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
    public function adminUpdate(Request $request, string $id)
    {
        $veteriner = Veteriner::find($id);

        if (!$veteriner) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Veteriner not found',
            ], 404);
        }

        // Basic validation for register_status
        $validator = Validator::make($request->all(), [
            'register_status' => 'required|in:pending,approved,rejected',
            'register_status_message' => 'required_if:register_status,rejected|string'
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

    public function update(Request $request)
    {

        $veteriner = Veteriner::where('id_user', Auth::id())->first();

        if (!$veteriner) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Veteriner not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'clinic_name' => 'sometimes|required|string|max:255',
            'clinic_image' => 'sometimes|nullable|string',
            'latitude' => 'sometimes|required|string',
            'longitude' => 'sometimes|required|string',
            'city' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'document' => 'sometimes|file|mimes:docx,pdf',
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

        // Set register_status to 'pending'
        $requestData = $request->except(['clinic_image', 'document']);
        $requestData['register_status'] = 'pending';

        $veteriner->update($requestData);

        $updateFiles = false;

        if ($request->hasFile('clinic_image')) {
            $file = $request->file('clinic_image');
            $filename = 'clinic_' . $veteriner->id_user . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('clinic', $filename, 'public');
            $veteriner->clinic_image = $path;
            $updateFiles = true;
        }

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = 'doc_' . $veteriner->id_user . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('documents', $filename, 'public');
            $veteriner->document = $path;
            $updateFiles = true;
        }

        // Save the file fields to the database only after text fields have been updated.
        if ($updateFiles) {
            $veteriner->save();
        }

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
