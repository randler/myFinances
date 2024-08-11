<?php

use App\Models\User;

test('Send Message to something', function () {
   $sender = User::factory()->create();
   $receiver = User::factory()->create();

    $response = $this->actingAs($sender)
        ->postJson('/api/chat/room/store', [
            'receiver_id' => $receiver->id
        ]);
    expect($response->status())
        ->toBe(200);
    expect($response->json())
        ->toHaveKey('room');
    expect($response['room']['sender_id'])
    ->toBe($sender->id);
    expect($response['room']['receiver_id'])
    ->toBe($receiver->id);
    expect($response['room']['id'])
    ->not()->toBeNull();

    $roomId = $response['room']['id'];

    $response = $this->actingAs($sender)
        ->postJson('/api/chat/messages/store', 
            [
                'room_id' => $roomId,
                'content' => 'Hello World!'
            ]);

    expect($response->status())
        ->toBe(200);

    expect($response->json())
        ->toHaveKey('message');

});
