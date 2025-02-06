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
        // Validate the prompt
        $request->validate([
            'prompt' => 'required|string|max:255',
        ]);
    
        $prompt = $request->input('prompt');
    
        try {
            // Make the API request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
            ])->post('https://api-inference.huggingface.co/models/gpt2', [
                'inputs' => $prompt,
            ]);
    
            // Check if the response is successful
            if ($response->successful()) {
                $data = $response->json();
                $generatedText = $data['generated_text'] ?? 'No response';
                return view('chat', ['response' => $generatedText]);
            } else {
                // Log the response body if it's not successful
                \Log::error('API request failed', ['response' => $response->body()]);
                return view('chat', ['error' => 'API call failed']);
            }
        } catch (\Exception $e) {
            // Log the exception error
            \Log::error('API call exception', ['error' => $e->getMessage()]);
            return view('chat', ['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    
}