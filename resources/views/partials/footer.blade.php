<footer class="site-footer">

    <div class="container footer-top">

        <!-- Coluna 1 -->
        <div class="col">
            <h4>Floricultura Maranata</h4>
            <p>Flores elegantes, arranjos especiais e presentes encantadores.</p>
        </div>

        <!-- Coluna 2 -->
        <div class="col">
            <h4>Atendimento</h4>
            <p>📞 (11) 99999-9999</p>
            <p>📍 Entregamos em toda a região</p>
            <p>⏰ Seg - Sáb: 8h às 18h</p>
        </div>

        <!-- Coluna 3 -->
        <div class="col">
            <h4>Links úteis</h4>
            <a href="{{ url('/') }}">Início</a><br>
            <a href="{{ url('/produtos') }}">Produtos</a><br>
            <a href="{{ url('/contato') }}">Contato</a>
        </div>

        <!-- Coluna 4 -->
        <div class="col">
            <h4>Siga-nos</h4>
            <p>Instagram • Facebook</p>
        </div>

    </div>

    <div class="container footer-bottom">
        <small>© {{ date('Y') }} Floricultura Maranata — Todos os direitos reservados.</small>
    </div>

</footer>
