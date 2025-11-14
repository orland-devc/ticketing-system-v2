<?php

use App\Http\Controllers\BotSettingController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('landing');
})->name('home');

// Route::get('/', function () {
//     $rdc = request()->query('_rdc');
//     $rdr = request()->query('_rdr');
//     return view('landing');
// });

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
    // Route::resource('tickets', TicketController::class);
    
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/subjects-&-categories', [TicketController::class, 'index'])->name('tickets.subjects');
    Route::get('offices/index', [OfficeController::class, 'index'])->name('offices.index');
    Route::get('offices/staffs', [OfficeController::class, 'staff'])->name('offices.staffs');
    Route::get('users/all-users', [UserController::class, 'index'])->name('users.all');
    Route::get('users/requests', [UserController::class, 'request'])->name('users.request');

    Route::get('/ai-chat', [BotSettingController::class, 'index'])->name('ai.chat');
    Route::post('/ai-chat/send', [BotSettingController::class, 'send'])->name('ai.chat.send');

    Route::get('/chatbot/testing', [BotSettingController::class, 'test'])->name('chatbot.testing');
    Route::get('/chatbot/faqs', [BotSettingController::class, 'faqs'])->name('chatbot.faqs');
    Route::get('/chatbot/settings', [BotSettingController::class, 'manage'])->name('chatbot.settings');

    Route::post('/bot/profile/update', [BotSettingController::class, 'profilePicture'])
        ->name('bot.profile.update');

    Route::get('/users/placeholder', function () {
        return view('components.users-placeholder');
    })->name('users.placeholder');

});

require __DIR__.'/auth.php';
