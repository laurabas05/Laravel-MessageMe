<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation) {
        $request->validate([
            'content' => 'required|string',
        ]);

        $conversation->messages()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('chat_list', [
            'conversation' => $conversation->id
        ]);
    }
}