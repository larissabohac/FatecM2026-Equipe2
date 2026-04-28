<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show()
    {
        return view('pages.login');
    }

    public function authenticate(Request $request)
    {
        // Aqui você pode implementar autenticação real caso queira
        return redirect('/admin/dashboard');
    }
}
