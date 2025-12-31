<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat_detail() {
        return view('chat.chat_detail');
    }

    public function chat_list() {
        return view('chat.chat_list');
    }
}
