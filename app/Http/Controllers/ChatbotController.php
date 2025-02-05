<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $conversationHistory = session('conversation', []);
        $message = $request->input('message');
        
        // Add user message
        $conversationHistory[] = ['role' => 'user', 'content' => $message];
    
        // Create a formatted prompt
        $systemMessage = "You are a helpful assistant.";
        $formattedConversation = $systemMessage . "\n";
        
        foreach ($conversationHistory as $entry) {
            $formattedConversation .= $entry['role'] . ": " . $entry['content'] . "\n";
        }
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/completions', [
            'model' => 'gpt-3.5-turbo',
            'prompt' => $formattedConversation,
            'max_tokens' => 150,
            'temperature' => 0.7,
        ]);
    
        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to get a response from the AI.',
                'messages' => $conversationHistory
            ], 500);
        }

        $botResponse = $response->json()['choices'][0]['text'] ?? 'Sorry, I did not understand that.';
    
        // Add bot's response
        $conversationHistory[] = ['role' => 'assistant', 'content' => $botResponse];
    
        // Store the updated conversation in the session
        session(['conversation' => $conversationHistory]);
    
        return response()->json([
            'message' => $botResponse,
            'messages' => $conversationHistory
        ]);
    }    
}
