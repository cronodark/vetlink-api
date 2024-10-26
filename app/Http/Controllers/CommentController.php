<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller  
{
    public function index($forumId)
    {
        $comments = ForumComment::with('user')
            ->where('forum_post_id', $forumId)
            ->get();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => $comments
        ], Response::HTTP_OK);
    }

    public function store(Request $request, $forumId)
    {
      
        $forum = ForumPost::findOrFail($forumId);

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

        $comment = new ForumComment();
        $comment->content = $request->input('content'); // Menggunakan input()
        $comment->forum_post_id = $forumId;
        $comment->user_id = Auth::id();
        $comment->save();

        // Load the user relationship
        $comment->load('user');

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'message' => 'Comment created successfully',
            'data' => $comment
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