<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomFormRequest;
use App\Models\Rooms;
use App\Repositories\RoomRepositories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{

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

    public function store(RoomFormRequest $request, RoomRepositories $roomRepositories)
    {
        try {
            return response()->json([
                'message' => 'Room created',
                'room' => $roomRepositories->store($request->receiver_id)
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return response()->json(['message' => $e->getMessage(), 'rooms'=> []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
