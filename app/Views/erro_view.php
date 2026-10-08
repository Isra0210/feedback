<?php

use App\View;
?>
<div class="card narrow" style="text-align:center;">
    <h1>Ops!</h1>
    <div class="msg msg-error" style="text-align:left;"><?= View::e($message ?? 'Ocorreu um erro.') ?></div>
    <div class="mt"><a class="btn" href="/">Voltar para o início</a></div>
</div>
