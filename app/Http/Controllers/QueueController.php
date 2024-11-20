<?php

namespace App\Http\Controllers;

use App\Http\Resources\QueueResource;
use App\Http\Resources\VeterinerBasicResource;
use App\Http\Resources\VeterinerQueueResource;
use App\Models\Queue;
use App\Models\Veteriner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class QueueController extends Controller
{
    public function indexCustomer()
    {
        $user = Auth::user();
        $queues = Queue::where('id_customer', $user->id)->get();
        $queues = QueueResource::collection($queues);
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Queues retrieved successfully',
            'data' => $queues
        ], Response::HTTP_OK);
    }

    public function indexVeteriner()
    {
        $veteriner = Veteriner::where('id_user', Auth::id())->first();
        if (!$veteriner) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You are not registered as a veterinarian',
            ], Response::HTTP_FORBIDDEN);
        }

        $queues = Queue::with(['pet.petType', 'customer'])->where('id_veteriner', $veteriner->id)->get();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Queues retrieved successfully',
            'data' => QueueResource::collection($queues)
        ], Response::HTTP_OK);
    }

    public function showCustomer($id)
    {
        $queue = Queue::findOrFail($id);
        if ($queue->id_customer !== Auth::id()) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You are not authorized to view this queue',
            ], Response::HTTP_FORBIDDEN);
        }
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Queue retrieved successfully',
            'data' => $queue
        ], Response::HTTP_OK);
    }

    public function showVeteriner($id)
    {
        $veteriner = Veteriner::where('id_user', Auth::id())->first();
        if (!$veteriner) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You are not registered as a veterinarian',
            ], Response::HTTP_FORBIDDEN);
        }

        $queue = Queue::findOrFail($id);
        if ($queue->id_veteriner !== $veteriner->id) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You are not authorized to view this queue',
            ], Response::HTTP_FORBIDDEN);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Queue retrieved successfully',
            'data' => $queue
        ], Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $validator = validator($request->all(), [
            'appointment_time' => 'required|date',
            'id_veteriner' => 'required|exists:users,id',
            'id_pet' => 'required|exists:pets,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $queue = Queue::create([
            'appointment_time' => $request->appointment_time,
            'status' => 'ongoing',
            'id_customer' => Auth::id(),
            'id_veteriner' => $request->id_veteriner,
            'id_pet' => $request->id_pet
        ]);

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'message' => 'Queue created successfully',
            'data' => $queue
        ], Response::HTTP_CREATED);
    }

    public function update($id, Request $request)
    {
        try {
            $veteriner = Veteriner::where('id_user', Auth::id())->first();
            $queue = Queue::findOrFail($id);
            if ($queue->id_veteriner !== $veteriner->id) {
                return response()->json([
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not authorized to update this queue',
                ], Response::HTTP_FORBIDDEN);
            }

            $request->validate([
                'status' => 'required|in:canceled,finished,ongoing'
            ]);

            $queue->update($request->all());

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Queue updated successfully',
                'data' => $queue
            ], Response::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Queue not found',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $veteriner = Veteriner::where('id_user', Auth::id())->first();
        if (!$veteriner) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You are not registered as a veterinarian',
            ], Response::HTTP_FORBIDDEN);
        }

        $queue = Queue::findOrFail($id);

        if ($queue->id_veteriner !== $veteriner->id) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You are not authorized to delete this queue',
            ], Response::HTTP_FORBIDDEN);
        }

        $queue->delete();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Queue deleted successfully'
        ], Response::HTTP_OK);
    }

    public function latest()
    {
        $queue = Queue::with('veteriner')->where('id_customer', Auth::id())->where('status', 'finished')->latest()->first();
        $queue = $queue != null ? new VeterinerBasicResource($queue->veteriner) : null;

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Latest queue retrieved successfully',
            'data' => $queue
        ], Response::HTTP_OK);
    }
}
