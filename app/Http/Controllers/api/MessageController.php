<?php

namespace App\Http\Controllers\api;

use App\Events\NewMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageFormRequest;
use App\Http\Requests\MessageSendFormRequest;
use App\Models\Rooms;
use App\Repositories\MessageRepositories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    /**
     * List all messages
     * 
     * @param MessageFormRequest $request
     * @param MessageRepositories $messageRepositories
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(MessageFormRequest $request, MessageRepositories $messageRepositories)
    {
        try {
            $messages = $messageRepositories->getAllMessagesByRoom($request->room_id);
            return response()->json([
                'message' => 'Messages list',
                'conversations'  => $messages
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return response()->json([
                'message' => $e->getMessage(),
                'conversations' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Save a new message
     * 
     * @param MessageSendFormRequest $request
     * @param MessageRepositories $messageRepositories
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MessageSendFormRequest $request, MessageRepositories $messageRepositories)
    {
        try {
            $messageRepositories->store($request->room_id, $request->get('content'));
            $message = NewMessageEvent::dispatch(Rooms::find($request->room_id));
            return response()->json([
                'message' => 'Message sent',
                'conversations' => $message 
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return response()->json([
                'message' => $e->getMessage(),
                'conversations' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}