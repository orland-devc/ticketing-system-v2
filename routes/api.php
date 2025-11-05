<?php

use App\Http\Controllers\AIChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/ai', [AIChatController::class, 'chat']);
Route::post('/tts', [AIChatController::class, 'tts']);
