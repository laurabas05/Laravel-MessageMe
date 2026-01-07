<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;

class ChatController extends Controller
{
    public function chat_list(Request $request)
{
    $conversations = Conversation::whereHas('users', function ($q) {
        $q->where('users.id', auth()->id());
    })->with(['lastMessage'])->get();

    $currentConversation = null;

    if ($request->conversation) {
        $currentConversation = Conversation::with([
            'messages.user'
        ])->findOrFail($request->conversation);
    }

    return view('chat.chat_list', compact(
        'conversations',
        'currentConversation'
    ));
}
}