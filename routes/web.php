<?php

use App\Http\Controllers\AIChatController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('tickets', TicketController::class);
    Route::resource('offices', OfficeController::class);
    Route::get('users/all-users', [UserController::class, 'index'])->name('users.all');
    Route::get('users/requests', [UserController::class, 'request'])->name('users.request');

    Route::get('/ai-chat', [AIChatController::class, 'index'])->name('ai.chat');
    Route::post('/ai-chat/send', [AIChatController::class, 'send'])->name('ai.chat.send');

    Route::post('/api/bot/chat', [AIChatController::class, 'chat'])->name('bot.chat');
    Route::post('/api/bot/tts', [AIChatController::class, 'textToSpeech'])->name('bot.tts');

    Route::get('/test-config', function() {
        return response()->json([
            'gemini_key_exists' => env('GEMINI_API_KEY') ? 'YES' : 'NO',
            'gemini_key_length' => env('GEMINI_API_KEY') ? strlen(env('GEMINI_API_KEY')) : 0,
            'voice_key_exists' => env('VOICE_API_KEY') ? 'YES' : 'NO',
            'voice_id_exists' => env('VOICE_ID') ? 'YES' : 'NO',
        ]);
    });
});

require __DIR__.'/auth.php';
