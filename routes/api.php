<?php

use App\Http\Controllers\Api\FinanceAssetsController;
use App\Http\Controllers\api\MessageController;
use App\Http\Controllers\api\RoomController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(array(
            'message' => 'The provided credentials are incorrect.'
        ), Response::HTTP_UNAUTHORIZED);
    }

    return response()->json(array(
        'token' => $user->createToken($request->email)->plainTextToken 
    ), Response::HTTP_OK);
});

// group auth api
Route::group(['prefix' => 'chat', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/rooms', [RoomController::class,'list'])->name('rooms.list');
    Route::post('/room/store', [RoomController::class,'store'])->name('rooms.store');
    
    Route::get('/messages/{room_id}', [MessageController::class,'list'])->name('messages.list');
    Route::post('/messages/store', [MessageController::class,'store'])->name('messages.store');

});

// group auth api
Route::group(['prefix' => 'finance', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/list', [FinanceAssetsController::class,'list'])->name('finance.list');
    Route::get('/list-month', [FinanceAssetsController::class, 'listMonth'])->name('finance.listMonth');
    Route::post('/find', [FinanceAssetsController::class, 'find'])->name('finance.find');
    Route::post('/store', [FinanceAssetsController::class, 'store'])->name('finance.store');
    Route::put('/update', [FinanceAssetsController::class, 'update'])->name('finance.update');
    Route::delete('/delete', [FinanceAssetsController::class, 'delete'])->name('finance.delete');
});