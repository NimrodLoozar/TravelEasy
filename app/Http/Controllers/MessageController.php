<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = Conversation::with('user', 'messages.user')->get();
        $conversation = $conversations->first();
        return view('messages.index', compact('conversations', 'conversation'));
    }

    public function create()
    {
        return view('messages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Max length validation
        if (strlen($request->content) > 25) {
            return redirect()->back()->with('error', 'Bericht kan niet worden verzonden omdat het te lang is.');
        }

        // Create or get conversation
        $conversation = Conversation::firstOrCreate(['user_id' => Auth::id()]);

        // Create message
        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('messages.index', ['conversation_id' => $conversation->id])
            ->with('success', 'Nieuw gesprek succesvol gestart!');
    }

    public function reply(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $maxLength = 25; // Set your desired maximum length here

        if (strlen($request->content) > $maxLength) {
            return redirect()->back()->with('error', 'Bericht kan niet worden verzonden omdat het te lang is.');
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Antwoord succesvol verzonden!');
    }

    public function markAsRead(Message $message)
    {
        $message->is_read = true;
        $message->save();

        return redirect()->route('messages.index');
    }

    public function createConversation(Request $request)
    {
        // Create a new conversation
        $conversation = Conversation::create([
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard', ['conversation_id' => $conversation->id])->with('success', 'Nieuw gesprek succesvol aangemaakt!');
    }

    public function update(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $maxLength = 25; // Set your desired maximum length here

        if (strlen($request->content) > $maxLength) {
            return redirect()->back()->with('error', 'Bericht kan niet worden bijgewerkt omdat het te lang is.');
        }

        $lastMessage = $conversation->messages()->where('user_id', Auth::id())->latest()->first();
        if ($lastMessage) {
            $lastMessage->content = $request->content;
            $lastMessage->save();
        }

        return redirect()->back()->with('success', 'Bericht succesvol bijgewerkt!');
    }

    public function deleteLastMessage(Request $request, Conversation $conversation)
    {
        $lastMessage = $conversation->messages()->where('user_id', Auth::id())->latest()->first();
        if ($lastMessage) {
            $lastMessage->delete();
        }

        return redirect()->route('dashboard', ['conversation_id' => $conversation->id])->with('success', 'Laatste bericht succesvol verwijderd!');
    }

    public function destroy(Conversation $conversation)
    {
        $conversation->delete();

        return redirect()->route('messages.index')->with('success', 'Gesprek succesvol verwijderd!');
    }

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:messages,id',
        ]);

        Message::whereIn('id', $request->message_ids)->delete();

        return redirect()->route('messages.index')->with('success', 'Geselecteerde berichten succesvol verwijderd!');
    }
}
