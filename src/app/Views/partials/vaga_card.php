<?php
/**
 * Card de vaga para a tela inicial — recebe $vaga formatada pelo VagaModel.
 *
 * @var array<string, mixed> $vaga
 */
?>
<article class="vaga-card">
    <div class="vaga-header">
        <div class="empresa-avatar" aria-hidden="true"></div>
        <div>
            <h3 class="empresa-nome"><?= esc($vaga['empresa_nome'] ?? 'Empresa') ?></h3>
            <p class="empresa-cat"><?= esc($vaga['categoria'] ?? '') ?></p>
        </div>
    </div>

    <div class="vaga-meta-grid" role="list">
        <div class="meta-col" role="listitem">
            <span class="fa-icon"><i class="fas fa-briefcase"></i></span>
            <span class="meta-text"><?= esc($vaga['titulo'] ?? '') ?></span>
        </div>
        <div class="meta-col" role="listitem">
            <span class="fa-icon"><i class="fas fa-map-marker-alt"></i></span>
            <span class="meta-text"><?= esc($vaga['localizacao'] ?: '—') ?></span>
        </div>
        <div class="meta-col" role="listitem">
            <span class="fa-icon"><i class="fas fa-dollar-sign"></i></span>
            <span class="meta-text"><?= esc($vaga['faixa_salarial'] ?: 'A combinar') ?></span>
        </div>
        <div class="meta-col" role="listitem">
            <span class="fa-icon"><i class="fas fa-users"></i></span>
            <span class="meta-text"><?= (int) ($vaga['quantidade'] ?? 1) ?> <?= ((int) ($vaga['quantidade'] ?? 1)) === 1 ? 'vaga' : 'vagas' ?></span>
        </div>
        <?php if (! empty($vaga['tipo_contrato'])): ?>
        <div class="meta-col" role="listitem">
            <span class="fa-icon"><i class="fas fa-file-contract"></i></span>
            <span class="meta-text"><?= esc($vaga['tipo_contrato']) ?></span>
        </div>
        <?php endif; ?>
        <?php if (! empty($vaga['modalidade'])): ?>
        <div class="meta-col" role="listitem">
            <span class="fa-icon"><i class="fas fa-laptop-house"></i></span>
            <span class="meta-text"><?= esc($vaga['modalidade']) ?></span>
        </div>
        <?php endif; ?>
    </div>

    <?php if (! empty($vaga['descricao_resumida'])): ?>
    <p class="vaga-desc"><?= esc($vaga['descricao_resumida']) ?></p>
    <?php endif; ?>

    <?php if (! empty($vaga['id'])): ?>
    <a class="btn-visualizar" href="<?= url_to('vaga.show', $vaga['id']) ?>">Visualizar Vaga</a>
    <?php endif; ?>
</article>
