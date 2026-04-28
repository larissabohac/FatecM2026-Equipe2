<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact');
    }

    public function send(Request $request)
    {
        // Aqui você pode implementar envio de email para o TCC.
        return redirect('/contato')->with('status', 'Mensagem enviada com sucesso!');
    }
}
