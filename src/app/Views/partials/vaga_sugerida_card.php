<?php

/**

 * Template de card — recebe $vaga já formatada pelo VagaSugeridaModel.

 *

 * @var array<string, mixed> $vaga

 */

$compat = isset($vaga['compatibilidade']) ? (int) $vaga['compatibilidade'] : null;

$ringClass = $compat !== null

    ? ($compat >= 90 ? 'alta' : ($compat >= 80 ? 'media' : 'base'))

    : 'base';

$desc = (string) ($vaga['descricao'] ?? '');

if (strlen($desc) > 200) {

    $desc = substr($desc, 0, 200) . '...';

}

$createdTs = ! empty($vaga['created_at']) ? strtotime((string) $vaga['created_at']) : 0;

$salarioOrdem = (int) ($vaga['salario_ordem'] ?? 0);

?>

<article

    class="sugestao-card <?= $ringClass ?>"

    data-compat="<?= $compat ?? 0 ?>"

    data-created="<?= $createdTs ?>"

    data-salario="<?= $salarioOrdem ?>"

>

    <div class="sugestao-card-top">

        <?php if ($compat !== null): ?>

        <div class="compat-ring <?= $ringClass ?>" style="--compat: <?= $compat ?>">

            <span class="compat-value"><?= $compat ?>%</span>

            <span class="compat-label">match</span>

        </div>

        <?php endif; ?>

        <div class="sugestao-empresa">

            <div class="empresa-avatar" aria-hidden="true"></div>

            <div>

                <h3 class="sugestao-titulo"><?= esc($vaga['titulo'] ?? 'Vaga') ?></h3>

                <p class="sugestao-empresa-nome"><?= esc($vaga['empresa_nome'] ?? 'Empresa') ?> · <?= esc($vaga['categoria'] ?? '') ?></p>

            </div>

        </div>

    </div>



    <div class="sugestao-meta">

        <span><i class="fas fa-map-marker-alt"></i> <?= esc($vaga['localizacao'] ?: '—') ?></span>

        <span><i class="fas fa-dollar-sign"></i> <?= esc($vaga['faixa_salarial'] ?: 'A combinar') ?></span>

        <span><i class="fas fa-file-contract"></i> <?= esc($vaga['tipo_contrato'] ?: '—') ?></span>

        <span><i class="fas fa-laptop-house"></i> <?= esc($vaga['modalidade'] ?: '—') ?></span>

    </div>



    <?php if (! empty($vaga['motivos']) && is_array($vaga['motivos'])): ?>

    <div class="sugestao-motivos">

        <span class="motivos-label">Por que sugerimos:</span>

        <?php foreach ($vaga['motivos'] as $motivo): ?>

            <span class="motivo-tag"><?= esc($motivo) ?></span>

        <?php endforeach; ?>

    </div>

    <?php endif; ?>



    <?php if ($desc !== ''): ?>

    <p class="sugestao-desc"><?= esc($desc) ?></p>

    <?php endif; ?>



    <div class="sugestao-actions">

        <?php if (! empty($vaga['id'])): ?>

        <a href="<?= url_to('vaga.show', $vaga['id']) ?>" class="btn-sugestao primario">

            <i class="fas fa-eye"></i> Ver vaga

        </a>

        <?php endif; ?>

        <button type="button" class="btn-sugestao secundario" disabled title="Em breve">

            <i class="far fa-bookmark"></i> Salvar

        </button>

    </div>

</article>

