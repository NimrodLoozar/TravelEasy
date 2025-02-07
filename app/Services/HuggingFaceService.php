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
        ->post('https://api-inference.huggingface.co/models/gpt2', [
            'inputs' => $prompt,
            'parameters' => [
                'max_length' => 100, // Limit to 100 tokens
                'temperature' => 0.7, // Control randomness
                'top_k' => 50, // Limit possible next tokens to the top 50
            ]
        ]);
        
        $data = $response->json();
        
        
    }
}
