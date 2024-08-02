<?php
use App\Models\User;


test("should create a new chat room", function() {
    $sender = User::factory()->create();
    $receiver = User::factory()->create();

    $response = $this->actingAs($sender)
        ->postJson('/api/chat/room/store',[
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


    $responseRoom = $this->actingAs($sender)
        ->getJson('/api/chat/rooms');
    expect($responseRoom->status())
        ->toBe(200);
    expect($responseRoom->json())
        ->toBeArray();

    $roomId = $response['room']['id'];

    $responseMessage = $this->actingAs($sender)
        ->getJson("/api/chat/messages/{$roomId}");

    expect($responseMessage->status())
        ->toBe(200);
    expect($responseMessage->json())
        ->toBeArray();

    $initMessage = $responseMessage->json()[0]['content'];

    expect($initMessage)
        ->toBe('');
    
});
