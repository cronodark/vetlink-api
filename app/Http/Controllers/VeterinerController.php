<?php

namespace App\Http\Controllers;

use App\Http\Resources\VeterinerResource;
use App\Models\Veteriner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
            'data' => $veteriner
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
            'data' => $veteriner
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
