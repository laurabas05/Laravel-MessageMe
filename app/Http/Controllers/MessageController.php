<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation) {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        //WEBSOCKET
        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        // se envía a todos menos al que escribe
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => $message->load('user')
        ]);
    }
}