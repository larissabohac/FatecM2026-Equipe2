@extends('layouts.guest')

@section('title', 'Cadastrar - Floricultura Maranata')

@section('content')

<div class="login-page" style="max-width: 650px; margin: 30px auto;"> <h2 class="login-title">Criar conta</h2>

    <form method="POST" action="{{ route('register') }}" class="login-form">
        @csrf

        <div style="display: flex; gap: 15px; margin-bottom: 5px;">
            <div style="flex: 1;">
                <label>Tipo de Conta</label>
                <select name="type" id="type" onchange="toggleDocumento()" style="width:100%; padding:12px; border-radius:10px; border:1px solid #eee; background:#fafafa;">
                    <option value="fisica">Pessoa Física</option>
                    <option value="juridica">Pessoa Jurídica</option>
                </select>
            </div>
            <div style="flex: 2;">
                <label>Nome Completo</label>
                <input type="text" name="name" placeholder="Ex: João Silva" required>
            </div>
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 5px;">
            <div style="flex: 1;" id="cpfField">
                <label>CPF</label>
                <input type="text" name="cpf" placeholder="000.000.000-00">
            </div>
            <div style="flex: 1; display:none;" id="cnpjField">
                <label>CNPJ</label>
                <input type="text" name="cnpj" placeholder="00.000.000/0000-00">
            </div>
            <div style="flex: 1;">
                <label>E-mail</label>
                <input type="email" name="email" placeholder="seu@email.com" required>
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">

        <div style="display: flex; gap: 15px; margin-bottom: 5px;">
            <div style="flex: 1;">
                <label>CEP</label>
                <input type="text" name="cep" id="cep" placeholder="00000000" onblur="buscarCEP()">
            </div>
            <div style="flex: 2;">
                <label>Endereço</label>
                <input type="text" name="address" id="address" placeholder="Rua, Avenida...">
            </div>
            <div style="flex: 0.5;">
                <label>Nº</label>
                <input type="text" name="number" placeholder="123">
            </div>
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 5px;">
            <div style="flex: 2;">
                <label>Cidade</label>
                <input type="text" name="city" id="city" placeholder="Cidade">
            </div>
            <div style="flex: 1;">
                <label>UF</label>
                <input type="text" name="state" id="state" placeholder="UF">
            </div>
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 5px;">
            <div style="flex: 1;">
                <label>Senha</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <div style="flex: 1;">
                <label>Confirmar Senha</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn login-btn" style="margin-top: 20px;">
            Finalizar Cadastro
        </button>

        <p class="login-extra">
            Já tem uma conta? <a href="{{ route('login') }}">Entrar</a>
        </p>
    </form>
</div>

<script>
// CEP Automático Corrigido
function buscarCEP() {
    let cepInput = document.getElementById('cep');
    let cep = cepInput.value.replace(/\D/g, '');

    if (cep.length !== 8) return;

    // Feedback visual que está buscando
    cepInput.style.backgroundColor = "#fff4f4";

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(res => res.json())
        .then(data => {
            cepInput.style.backgroundColor = "#fafafa";
            if (!data.erro) {
                document.getElementById('address').value = data.logradouro;
                document.getElementById('city').value = data.localidade;
                document.getElementById('state').value = data.uf;
                // Pula para o campo número automaticamente
                document.getElementsByName('number')[0].focus();
            } else {
                alert('CEP não encontrado!');
            }
        })
        .catch(error => {
            console.error('Erro ao buscar CEP:', error);
            cepInput.style.backgroundColor = "#fafafa";
        });
}

function toggleDocumento() {
    let type = document.getElementById('type').value;
    document.getElementById('cpfField').style.display = type === 'fisica' ? 'block' : 'none';
    document.getElementById('cnpjField').style.display = type === 'juridica' ? 'block' : 'none';
}
</script>

@endsection