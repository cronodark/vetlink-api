<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
    public function index()
    {
        $forums = ForumPost::with('user')->get();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => $forums
        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $forum = ForumPost::with('user')->findOrFail($id);
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => $forum
        ], Response::HTTP_OK);
    }

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

        $forum = ForumPost::create([
            'title' => $request->title,
            'last_seen' => $request->last_seen,
            'description' => $request->description,
            'pet_image' => $request->pet_image,
            'id_user' => Auth::id(),
        ]);

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'message' => 'Forum created success',
            'data' => $forum
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $forum = ForumPost::findOrFail($id);

        if ($forum->id_user !== Auth::id()) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'Not authorized',
            ], Response::HTTP_FORBIDDEN);
        }

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

        $forum->update($request->all());

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Forum updated success',
            'data' => $forum
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $forum = ForumPost::findOrFail($id);

        if ($forum->id_user !== Auth::id()) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'Not authorized',
            ], Response::HTTP_FORBIDDEN);
        }

        $forum->delete();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Forum deleted success'
        ], Response::HTTP_OK);
    }

    public function userForums()
    {
        $forums = ForumPost::where('id_user', Auth::id())->with('user')->get();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'User forums retrieved successfully',
            'data' => $forums
        ], Response::HTTP_OK);
    }
}