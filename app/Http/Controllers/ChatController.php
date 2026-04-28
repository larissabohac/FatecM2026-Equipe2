<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ChatSession;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    private function getSession()
    {
        if(auth()->check()){
            return ChatSession::firstOrCreate([
                'user_id' => auth()->id()
            ]);
        }

        // visitante
        $token = session()->get('chat_token');

        if(!$token){
            $token = Str::uuid();
            session()->put('chat_token', $token);
        }

        return ChatSession::firstOrCreate([
            'guest_token' => $token
        ]);
    }

    public function send(Request $request)
    {
        $session = $this->getSession();

        // salva mensagem do usuário
        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender' => 'user',
            'message' => $request->message
        ]);

        // resposta simples
        $msg = strtolower($request->message);

        if(str_contains($msg,'oi')){
            $reply = 'Olá! 🌸 Como posso ajudar?';
        } elseif(str_contains($msg,'preço')){
            $reply = 'Temos opções a partir de R$ 30 😊';
        } elseif(str_contains($msg,'entrega')){
            $reply = 'Fazemos entrega sim 🚚';
        } else {
            $reply = 'Pode me dar mais detalhes? 😊';
        }

        // salva resposta do bot
        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender' => 'bot',
            'message' => $reply
        ]);

        return response()->json(['reply'=>$reply]);
    }

    public function history()
    {
        $session = $this->getSession();

        return response()->json(
            $session->messages()->orderBy('id')->get()
        );
    }
}