<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/chat', function () {
//     return view('chat');  // Return the chat interface
// })->name('chat');


// Route::post('huggingface/generate', [ChatbotController::class, 'generate']);


Route::get('chat', [ChatbotController::class, 'showChatForm'])->name('chat');
Route::post('huggingface/generate', [ChatbotController::class, 'generate'])->name('huggingface.generate');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
