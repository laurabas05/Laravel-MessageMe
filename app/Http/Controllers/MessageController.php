<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation) {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $conversation->messages()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return redirect()->route('chat_list', [
            'conversation' => $conversation->id
        ]);
    }
}