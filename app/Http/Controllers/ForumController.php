<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forums = ForumPost::with('user')->get();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Forums Success',
            'data' => $forums
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255', 
        'last_seen' => 'required|string',
        'description' => 'required|string|max:255',
        'pet_image' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => 'Validation error',
            'errors' => $validator->errors()
        ], Response::HTTP_BAD_REQUEST);
    }

    $user = auth()->user();
    if (!$user) {
        return response()->json([
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
    }
    $forum = ForumPost::create([
        'title' => $request->title,
        'last_seen' => $request->last_seen,
        'description' => $request->description,
        'pet_image' => $request->pet_image,
        'id_user' => $user->id,
    ]);

    return response()->json([
        'status' => Response::HTTP_CREATED,
        'message' => 'Forum Created success',
        'data' => $forum
    ], Response::HTTP_CREATED);
}


    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        $forums = ForumPost::where('id_user', $userId)->with('user')->get();
    
        if ($forums->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'No forums found for this user',
            ], Response::HTTP_NOT_FOUND);
        }
    
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Forums retrieved successfully',
            'data' => $forums
        ], Response::HTTP_OK);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $forum = ForumPost::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:forum_posts,title,' . $id,
            'last_seen' => 'required|string',
            'description' => 'required|string|max:255',
            'pet_image' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $forum->update([
            'title' => $request->title,
            'last_seen' => $request->last_seen,
            'description' => $request->description,
            'pet_image' => $request->pet_image,
        ]);

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Forum Updated Successfully',
            'data' => $forum
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $forum = ForumPost::findOrFail($id);
        $forum->delete();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Forum Deleted Success'
        ], Response::HTTP_OK);
    }
}
