<?
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'type' => 'required',
        ]);

        // 🔹 Cria usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer'
        ]);

        // 🔹 Cria cliente
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


        return redirect()->route('home');
    }
}