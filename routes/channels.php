<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;

Broadcast::channel('room.{roomId}', function ($user, $roomId) {
    return DB::selectOne(
        'SELECT COUNT(0) as count FROM rooms WHERE id = ? AND (sender_id = ? OR receiver_id = ?)', 
        [$roomId, $user->id, $user->id]
    )->count > 0;
});
