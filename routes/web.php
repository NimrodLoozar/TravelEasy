<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\InvoiceController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/destinations', function () {
    return view('destinations');
})->name('destinations');

Route::get('/packages', function () {
    return view('packages');
})->name('packages');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function () {
    // Handle form submission
    return redirect()->route('contact')->with('success', 'Your message has been sent!');
})->name('contact.submit');

Route::get('/chat', [ChatbotController::class, 'showChatForm'])->name('chat');
Route::post('/huggingface/generate', [ChatbotController::class, 'generate'])->name('huggingface.generate');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
