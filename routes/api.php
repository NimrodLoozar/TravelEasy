<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

Route::prefix('api')->post('huggingface/generate', [ChatbotController::class, 'generate']);
