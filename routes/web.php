<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//
Route::middleware(['auth'])->group(function () {
    Route::get('/chat_list', [ChatController::class, 'chat_list'])->name('chat_list');
    Route::post('/chat/start', [ChatController::class, 'start'])->name('chat.start');
});

Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');