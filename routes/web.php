<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat', function () {
    return view('chat');  // Return the chat interface
})->name('chat');


Route::post('/chat', function (Request $request) {
    $userMessage = $request->input('message');

    // Send request to OpenAI
    $response = Http::withOptions(['verify' => false])  // Disable SSL verification
    ->withHeaders([
        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        'Content-Type' => 'application/json',
    ])
    ->post('https://api.openai.com/v1/completions', [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => $userMessage],
        ],
        // 'prompt' => $userMessage,
        // 'max_tokens' => 50,
    ]);


    // Log the response for debugging
    \Log::info('OpenAI API Response:', $response->json());

    // Check if response contains choices
    if ($response->successful() && isset($response->json()['choices'][0]['text'])) {
        return response()->json(['message' => $response->json()['choices'][0]['text']]);
    } else {
        return response()->json(['message' => 'Error: No valid response from OpenAI API'], 500);
    }
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
