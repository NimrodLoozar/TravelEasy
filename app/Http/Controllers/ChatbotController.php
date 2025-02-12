<?php

namespace App\Http\Controllers;

use App\Services\HuggingFaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
    $request->validate([
        'prompt' => 'required|string|max:255',
        'language' => 'nullable|string|in:nl,en',
    ]);

    $language = $request->input('language', 'en');
    $prompt = $request->input('prompt');

    // Verwijder de extra instructie om vertalingen te vermijden
    if ($language == 'nl') {
        // Gebruik alleen de prompt en vertrouw op het model om de taal te detecteren
        // Laat de instructie weg en stuur de vraag zoals deze is
    }

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
        ])->withoutVerifying()->timeout(60)->post('https://api-inference.huggingface.co/models/google/flan-t5-large', [
            'inputs' => $prompt,  // Direct de prompt sturen, zonder de vertaling
            'parameters' => [
                'max_length' => 150,
                'temperature' => 0.3,
                'top_p' => 0.95,
                'repetition_penalty' => 2.0,
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $generatedText = $data[0]['generated_text'] ?? 'Geen reactie';

            $truncatedText = strlen($generatedText) > 100 ? substr($generatedText, 0, 100) . '...' : $generatedText;

            return response()->json(['response' => $truncatedText]);
        } else {
            \Log::error('API-aanroep mislukt', ['response' => $response->body()]);
            return response()->json(['error' => 'API-aanroep mislukt'], 500);
        }
    } catch (\Exception $e) {
        \Log::error('API-aanroep fout', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Fout: ' . $e->getMessage()], 500);
    }
}

        
}