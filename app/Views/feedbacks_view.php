<?php

use App\View;

?>

<h1>Feedbacks</h1>
<p class="subtitle">Lista de todos os feedbacks enviados pelos usuários.</p>

<div class="card">
    <?php if (empty($feedbacks)): ?>
        <p>Nenhum feedback cadastrado até o momento.</p>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $item): ?>
                        <tr>
                            <td><?= (int) $item['id'] ?></td>
                            <td><?= View::e($item['titulo']) ?></td>
                            <td><?= View::e(ucfirst($item['tipo'])) ?></td>
                            <td>
                                <span class="badge status-<?= View::statusSlug($item['status']) ?>">
                                    <?= View::e($item['status']) ?>
                                </span>
                            </td>
                            <td><a href="/feedbacks/<?= (int) $item['id'] ?>">Detalhes</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
