<?php

use App\Http\Controllers\BotSettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/bot/chat', [BotSettingController::class, 'chat'])->name('bot.chat');
Route::post('/bot/tts', [BotSettingController::class, 'textToSpeech'])->name('bot.tts');

Route::get('/test-config', function () {
    return response()->json([
        'gemini_key_exists' => env('GEMINI_API_KEY') ? 'YES' : 'NO',
        'gemini_key_length' => env('GEMINI_API_KEY') ? strlen(env('GEMINI_API_KEY')) : 0,
        'voice_key_exists' => env('VOICE_API_KEY') ? 'YES' : 'NO',
        'voice_id_exists' => env('VOICE_ID') ? 'YES' : 'NO',
    ]);
});
