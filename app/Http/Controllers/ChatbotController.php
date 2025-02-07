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
        ]);
    
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
            ])->withoutVerifying()->timeout(60)->post('https://api-inference.huggingface.co/models/HuggingFaceH4/zephyr-7b-beta', [
                'inputs' => $request->input('prompt'),
                'parameters' => [
                    'max_length' => 50,  // Shorter, focused response
                    'temperature' => 0.5, // Less randomness
                    'top_p' => 0.9,       // Controlled creativity
                ]
            ]);
    
            if ($response->successful()) {
                $data = $response->json();
                $generatedText = $data[0]['generated_text'] ?? 'No response';
    
                return response()->json(['response' => $generatedText]);  // ✅ Return JSON
            } else {
                \Log::error('API request failed', ['response' => $response->body()]);
                return response()->json(['error' => 'API call failed'], 500);  // ✅ Return JSON
            }
        } catch (\Exception $e) {
            \Log::error('API call exception', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);  // ✅ Return JSON
        }
    }
    
}