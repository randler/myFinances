<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomFormRequest;
use App\Repositories\RoomRepositories;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{

    /**
     * List all rooms
     * 
     * @param RoomRepositories $roomRepositories
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(RoomRepositories $roomRepositories)
    {
        try {
            return response()->json([
                'message' => 'Rooms list',
                'rooms' => $roomRepositories->allMyRooms()
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return response()->json([
                'message' => $e->getMessage(),
                'rooms' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Save a new room
     * 
     * @param RoomFormRequest $request
     * @param RoomRepositories $roomRepositories
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoomFormRequest $request, RoomRepositories $roomRepositories)
    {
        try {
            return response()->json([
                'message' => 'Room created',
                'room' => $roomRepositories->store($request->receiver_id)
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return response()->json([
                'message' => $e->getMessage(), 
                'rooms'=> []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
