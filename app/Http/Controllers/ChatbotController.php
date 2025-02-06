<?php

namespace App\Http\Controllers;

use App\Services\HuggingFaceService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected $huggingFaceService;

    public function __construct(HuggingFaceService $huggingFaceService)
    {
        $this->huggingFaceService = $huggingFaceService;
    }

    // Toon de chatpagina
    public function showChatForm()
    {
        return view('chat');
    }

    // Verwerk de prompt en geef de reactie van de AI weer
    public function generate(Request $request)
    {
        $prompt = $request->input('prompt');

        // Gebruik de HuggingFaceService om de respons te genereren
        $response = $this->huggingFaceService->generateResponse($prompt);

        // Geef de chatpagina weer met de AI-respons
        return view('chat', ['response' => $response['generated_text']]);
    }
}