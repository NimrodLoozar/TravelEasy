<?php

namespace App\Http\Controllers;

use App\Services\HuggingFaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent; // ✅ Importeer Jenssegers/Agent

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

        // ✅ Detecteer de taal automatisch
        $agent = new Agent();
        $browserLanguage = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2); // Haal eerste 2 letters (bv. 'nl', 'en')
        $defaultLanguage = in_array($browserLanguage, ['nl', 'en']) ? $browserLanguage : 'en';

        // Als de gebruiker een taal opgeeft, gebruik die. Anders detecteer automatisch.
        $language = $request->input('language', $defaultLanguage);
        $prompt = $request->input('prompt');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
            ])->withoutVerifying()->timeout(60)->post('https://api-inference.huggingface.co/models/tiiuae/falcon-7b-instruct', [
                'inputs' => $prompt,  // Gebruik gewoon de prompt, Hugging Face detecteert de taal zelf
                'parameters' => [
                    'max_length' => 30,
                    'temperature' => 0.3,
                    'top_p' => 0.8,
                    // 'repetition_penalty' => 2.0,
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
