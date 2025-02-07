<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HuggingFaceService
{
    protected $apiUrl = 'https://api-inference.huggingface.co/models/';
    protected $model = 'mistralai/Mistral-7B-Instruct'; // You can change this model

    public function generateResponse($prompt)
    {
        $apiKey = env('HUGGINGFACE_API_KEY');
       
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
        ])
        ->timeout(60)
        ->withoutVerifying()
        ->post('https://api-inference.huggingface.co/models/HuggingFaceH4/zephyr-7b-beta', [
            'inputs' => $prompt,  // Changed from $request->input('prompt') to $prompt
            'parameters' => [
                'max_length' => 20,  // Further reduced length for shorter responses
                'temperature' => 0.5,
                'top_p' => 0.9,
            ]
        ]);
        
        $data = $response->json();
        $generatedText = $data[0]['generated_text'] ?? 'No response';

        // Truncate the response to a maximum of 100 characters
        return strlen($generatedText) > 100 ? substr($generatedText, 0, 100) . '...' : $generatedText;
    }
}
