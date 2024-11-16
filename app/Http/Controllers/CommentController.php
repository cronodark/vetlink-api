<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\CommentResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentController extends Controller
{
    public function index($forumId)
    {
        $comments = ForumComment::with('user')
            ->where('forum_post_id', $forumId)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => CommentResource::collection($comments)
        ], Response::HTTP_OK);
    }

    public function store(Request $request, $forumId)
    {
        try {
            $forum = ForumPost::findOrFail($forumId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Forum post not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $comment = ForumComment::create([
            'content' => $request->input('content'),
            'forum_post_id' => $forumId,
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'message' => 'Comment created successfully',
        ], Response::HTTP_CREATED);
    }

    public function show($forumId, $commentId)
    {
        $comment = ForumComment::with('user')
            ->where('forum_post_id', $forumId)
            ->findOrFail($commentId);

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => $comment
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $forumId, $commentId)
    {
        $comment = ForumComment::where('forum_post_id', $forumId)
            ->findOrFail($commentId);


        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'Not authorized'
            ], Response::HTTP_FORBIDDEN);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $comment->content = $request->input('content');
        $comment->save();


        $comment->load('user');

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Comment updated successfully',
            'data' => $comment
        ], Response::HTTP_OK);
    }

    public function destroy($forumId, $commentId)
    {
        $comment = ForumComment::where('forum_post_id', $forumId)
            ->findOrFail($commentId);


        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'Not authorized'
            ], Response::HTTP_FORBIDDEN);
        }

        $comment->delete();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Comment deleted successfully'
        ], Response::HTTP_OK);
    }
}
