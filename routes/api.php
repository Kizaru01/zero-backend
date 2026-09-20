<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RideController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/rides', [RideController::class, 'index']);

    Route::get('/rides/{ride}', [RideController::class, 'show']);

    Route::post('/rides', [RideController::class, 'store']);

    Route::put('/rides/{ride}', [RideController::class, 'update']);

    Route::delete('/rides/{ride}', [RideController::class, 'destroy']);

    Route::patch(
        '/rides/{ride}/status',
        [RideController::class, 'updateStatus']
    );

    Route::patch(
        '/rides/{ride}/accept',
        [RideController::class, 'accept']
    );

    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});
