<?php

use App\View;

?>

<div class="card narrow">
    <h1>Enviar um feedback</h1>
    <p class="subtitle">Conte pra gente sobre um bug, uma sugestão, uma reclamação ou um feedback geral.</p>

    <?php if (!empty($success)): ?>
        <div class="msg msg-ok">Feedback enviado com sucesso. Obrigado!</div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="msg msg-error"><?= View::e($error) ?></div>
    <?php endif; ?>

    <form action="/feedback/cadastrar" method="POST">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" maxlength="150" placeholder="Resuma em poucas palavras" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" maxlength="2000" placeholder="Descreva com detalhes" required></textarea>

        <label for="tipo">Tipo</label>
        <select id="tipo" name="tipo" required>
            <?php foreach ($types as $type): ?>
                <option value="<?= View::e($type) ?>"><?= View::e(ucfirst($type)) ?></option>
            <?php endforeach; ?>
        </select>

        <div class="mt">
            <button type="submit">Enviar feedback</button>
        </div>
    </form>
</div>
