<?php

use App\View;

?>

<div class="card narrow">
    <h1>Entrar</h1>
    <p class="subtitle">Acesso restrito ao administrador.</p>

    <?php if (!empty($error)): ?>
        <div class="msg msg-error"><?= View::e($error) ?></div>
    <?php endif; ?>

    <form action="/login" method="POST">
        <label for="username">Usuário</label>
        <input type="text" id="username" name="username" placeholder="Digite seu usuário" required autofocus>

        <label for="password">Senha</label>
        <input type="password" id="password" name="password" placeholder="Digite sua senha" required>

        <div class="mt">
            <button type="submit">Entrar</button>
        </div>
    </form>
</div>
