<?php

use App\Http\Controllers\api\MessageController;
use App\Http\Controllers\api\RoomController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

// group auth api
Route::group(['prefix' => 'chat', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/rooms', [RoomController::class,'list'])->name('rooms.list');
    Route::post('/room/store', [RoomController::class,'store'])->name('rooms.store');
    
    Route::get('/messages/{room_id}', [MessageController::class,'list'])->name('messages.list');
    Route::post('/messages/store', [MessageController::class,'store'])->name('messages.store');
});