<?php

namespace App\Http\Controllers;

use App\Services\HuggingFaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent; // ✅ Importeer Jenssegers/Agent

// composer require jenssegers/agent

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

    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:255',
            'language' => 'nullable|string|in:nl,en',
        ]);

        $language = $request->input('language', 'en'); // Standaardtaal is Engels
        $prompt = $request->input('prompt');

        $response = $this->huggingFaceService->generateResponse($prompt, $language);

        return response()->json(['response' => $response]);
    }
}