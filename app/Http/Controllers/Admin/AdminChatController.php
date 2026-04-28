<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    public function index()
    {
        $sessions = ChatSession::latest()->get();
        return view('admin.chat.index', compact('sessions'));
    }

    public function messages($id)
{
    // marca como lida
    ChatMessage::where('chat_session_id', $id)
        ->where('sender','user')
        ->update(['is_read' => true]);

    // retorna mensagens
    return ChatMessage::where('chat_session_id',$id)->get();
}

    public function send(Request $request)
    {
        ChatMessage::create([
            'chat_session_id' => $request->session_id,
            'sender' => 'admin',
            'message' => $request->message
        ]);

        return response()->json(['ok'=>true]);
    }

    public function unread()
    {
        $count = \App\Models\ChatMessage::where('sender','user')
            ->where('is_read', false)
            ->count();

        return response()->json(['total' => $count]);
    }
}