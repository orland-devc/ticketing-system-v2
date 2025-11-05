<?php

use App\Http\Controllers\AIChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post('/bot/chat', [AIChatController::class, 'chat'])->name('bot.chat');
// Route::post('/bot/tts', [AIChatController::class, 'textToSpeech'])->name('bot.tts');
