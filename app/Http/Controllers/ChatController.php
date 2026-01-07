<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;

class ChatController extends Controller
{
    public function chat_list(Request $request)
    {
        $conversations = auth()->user()
            ->conversations()
            ->with(['users', 'messages.user', 'lastMessage'])
            ->get();

        $currentConversation = null;
        $otherUser = null;

        if ($request->filled('conversation')) {
            $currentConversation = $conversations
                ->where('id', $request->conversation)
                ->first();

            if ($currentConversation) {
                $otherUser = $currentConversation->otherUser(auth()->user());
            }
        }

        return view('chat.chat_list', compact(
            'conversations',
            'currentConversation',
            'otherUser'
        ));
    }

    public function start(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:users,name'
        ]);

        $otherUser = User::where('name', $request->username)->first();

        // ¿ya existe conversación?
        $conversation = Conversation::whereHas('users', function ($q) use ($otherUser) {
                $q->where('users.id', auth()->id());
            })
            ->whereHas('users', function ($q) use ($otherUser) {
                $q->where('users.id', $otherUser->id);
            })
            ->first();

        // si no existe → crear
        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->users()->attach([
                auth()->id(),
                $otherUser->id
            ]);
        }

        return redirect()->route('chat_list', [
            'conversation' => $conversation->id
        ]);
    }
}