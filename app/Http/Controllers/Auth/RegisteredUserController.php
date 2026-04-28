<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();

        try {

            // 🔹 1. CRIA USUÁRIO
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
            ]);

            // 🔹 2. CRIA CLIENTE (DADOS DO FORM)
            Customer::create([
                'user_id' => $user->id,
                'type' => $request->type,
                'name' => $request->name,
                'cpf' => $request->cpf,
                'cnpj' => $request->cnpj,
                'cep' => $request->cep,
                'address' => $request->address,
                'number' => $request->number,
                'city' => $request->city,
                'state' => $request->state,
                'phone' => $request->phone,
            ]);

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            // REDIRECIONAMENTO
            return $user->role === 'admin'
                ? redirect('/admin/dashboard')
                : redirect('/dashboard');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Erro ao cadastrar');
        }
    }
}