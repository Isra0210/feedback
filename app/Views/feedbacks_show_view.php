<?php

use App\View;

$slug = View::statusSlug($feedback['status']);

?>

<a class="link-back" href="/feedbacks">Voltar para a lista</a>

<div class="card">
    <span class="badge badge-type">#<?= (int) $feedback['id'] ?> - <?= View::e(ucfirst($feedback['tipo'])) ?></span>

    <h1 style="margin-top:12px;"><?= View::e($feedback['titulo']) ?></h1>

    <p class="subtitle" style="margin-bottom:20px;">
        Status atual: <span class="badge status-<?= $slug ?>"><?= View::e($feedback['status']) ?></span>
    </p>

    <h2>Descrição</h2>
    <p style="white-space:pre-wrap; margin-top:0;"><?= View::e($feedback['descricao']) ?></p>

    <hr style="border:0; border-top:1px solid var(--border); margin:24px 0;">

    <h2>Alterar status</h2>
    <form action="/feedback/atualizar" method="POST">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="<?= (int) $feedback['id'] ?>">

        <label for="status">Novo status</label>
        <select id="status" name="status">
            <?php foreach ($statusList as $s): ?>
                <option value="<?= View::e($s) ?>" <?= $s === $feedback['status'] ? 'selected' : '' ?>>
                    <?= View::e($s) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="mt">
            <button type="submit">Atualizar Status</button>
        </div>
    </form>
</div>
