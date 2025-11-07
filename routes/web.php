<?php

use App\Http\Controllers\BotSettingController;
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

    Route::get('/ai-chat', [BotSettingController::class, 'index'])->name('ai.chat');
    Route::post('/ai-chat/send', [BotSettingController::class, 'send'])->name('ai.chat.send');

    Route::get('/chatbot/testing', [BotSettingController::class, 'test'])->name('chatbot.testing');
    Route::get('/chatbot/settings', [BotSettingController::class, 'manage'])->name('chatbot.settings');

});

require __DIR__.'/auth.php';
