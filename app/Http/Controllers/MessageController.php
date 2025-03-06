<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Get all conversations for the authenticated user
     */
    public function getConversations()
    {
        $conversations = Conversation::where('user_id', Auth::id())
            ->orWhere('recipient', Auth::user()->name)
            ->with(['messages' => function ($query) {
                $query->latest()->first();
            }])
            ->latest()
            ->get();

        return response()->json([
            'conversations' => $conversations
        ]);
    }

    /**
     * Get a specific conversation with all messages
     */
    public function getConversation($id)
    {
        $conversation = Conversation::with(['messages' => function ($query) {
            $query->with('user')->orderBy('created_at', 'asc');
        }])->findOrFail($id);

        // Mark all unread messages as read
        Message::where('conversation_id', $id)
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'conversation' => $conversation
        ]);
    }

    /**
     * Start a new conversation or get existing one
     */
    public function startConversation(Request $request)
    {
        $request->validate([
            'recipient' => 'required|exists:users,name'
        ]);

        // Check if conversation already exists
        $conversation = Conversation::where(function ($query) use ($request) {
            $query->where('user_id', Auth::id())
                ->where('recipient', $request->recipient);
        })->orWhere(function ($query) use ($request) {
            $query->where('user_id', User::where('name', $request->recipient)->first()->id)
                ->where('recipient', Auth::user()->name);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_id' => Auth::id(),
                'recipient' => $request->recipient
            ]);
        }

        return response()->json([
            'conversation' => $conversation
        ]);
    }

    /**
     * Send a message in a conversation
     */
    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $conversation = Conversation::findOrFail($conversationId);

        // Verify user is part of the conversation
        if ($conversation->user_id !== Auth::id() && $conversation->recipient !== Auth::user()->name) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message = Message::create([
            'conversation_id' => $conversationId,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_read' => false
        ]);

        return response()->json([
            'message' => $message->load('user')
        ]);
    }

    /**
     * Get unread messages count
     */
    public function getUnreadCount()
    {
        $count = Message::whereHas('conversation', function ($query) {
            $query->where('user_id', Auth::id())
                ->orWhere('recipient', Auth::user()->name);
        })
        ->where('user_id', '!=', Auth::id())
        ->where('is_read', false)
        ->count();

        return response()->json([
            'unread_count' => $count
        ]);
    }

    /**
     * Delete a conversation
     */
    public function deleteConversation($id)
    {
        $conversation = Conversation::findOrFail($id);

        // Verify user is part of the conversation
        if ($conversation->user_id !== Auth::id() && $conversation->recipient !== Auth::user()->name) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $conversation->delete();

        return response()->json([
            'message' => 'Conversation deleted successfully'
        ]);
    }
}