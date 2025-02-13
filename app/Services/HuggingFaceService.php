<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;

class HuggingFaceService
{
    protected $apiUrl = 'https://api-inference.huggingface.co/models/tiiuae/falcon-7b-instruct';

    public function generateResponse($prompt, $language = null)
    {
        $apiKey = env('HUGGINGFACE_API_KEY');

        // ✅ Detecteer taal als deze niet is opgegeven
        if (!$language) {
            $agent = new Agent();
            $language = substr($agent->languages()[0] ?? 'en', 0, 2);
            $language = in_array($language, ['nl', 'en']) ? $language : 'en'; // Alleen NL en EN ondersteunen
        }

        // ✅ Pas prompt aan voor de taal
        if ($language === 'nl') {
            $prompt = "Beantwoord in het Nederlands: " . $prompt;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])
        ->timeout(60)
        ->withoutVerifying()
        ->post($this->apiUrl, [
            'inputs' => $prompt,
            'parameters' => [
                'max_length' => 30,
                'temperature' => 0.3,
                'top_p' => 0.8,
            ]
        ]);

        if ($response->failed()) {
            \Log::error('Hugging Face API-fout', ['response' => $response->body()]);
            return 'Geen reactie van de AI';
        }

        $data = $response->json();
        $generatedText = $data[0]['generated_text'] ?? 'Geen reactie';

        \Log::info('AI Response:', ['response' => $data]);
        return strlen($generatedText) > 150 ? substr($generatedText, 0, 150) . '...' : $generatedText;
    }
}
