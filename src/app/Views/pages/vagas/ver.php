<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?><?= esc($vaga['titulo'] ?? 'Vaga') ?> - GoVagas<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<?php include APPPATH . 'Views/layouts/vaga_form.php'; ?>
<style>
    .vaga-ver { max-width: 920px; margin: 0 auto; }
    .vaga-ver-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }
    .vaga-ver-top h1 { margin: 0; font-size: 1.4rem; color: #1a1a2e; }
    .vaga-ver-top .meta { font-size: 0.9rem; color: #555; margin-top: 6px; }
    .vaga-ver-tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 12px 0; }
    .vaga-ver-tag {
        font-size: 0.8rem;
        padding: 5px 12px;
        border-radius: 20px;
        background: rgba(79, 70, 229, 0.12);
        color: #4f46e5;
        font-weight: 600;
    }
    .vaga-ver-acoes {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-top: 1.25rem;
    }
    .vaga-ver-dl { margin: 0; }
    .vaga-ver-dl dt { font-size: 0.75rem; text-transform: uppercase; color: #666; font-weight: 600; margin-top: 12px; }
    .vaga-ver-dl dd { margin: 4px 0 0; font-size: 0.95rem; color: #1a1a2e; }
    .beneficios-lista { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px; }
    .beneficio-item {
        font-size: 0.82rem;
        padding: 4px 10px;
        border-radius: 6px;
        background: rgba(255,255,255,0.7);
        border: 1px solid rgba(0,0,0,0.08);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    helper(['auth', 'vaga']);
    $empresa = $vaga['empresa'] ?? [];
    $beneficios = array_filter(array_map('trim', explode(',', $vaga['beneficios'] ?? '')));
    $categoriaLabel = vaga_categorias()[$vaga['categoria'] ?? ''] ?? ($vaga['categoria'] ?? '');
?>
<div class="vidro-cadastro vaga-ver">
    <div class="vaga-ver-top">
        <div>
            <h1><?= esc($vaga['titulo'] ?? 'Vaga') ?></h1>
            <p class="meta">
                <i class="fas fa-building"></i>
                <?= esc($empresa['nome'] ?? 'Empresa') ?>
                <?php if (! empty($vaga['localizacao'])): ?>
                    · <i class="fas fa-map-marker-alt"></i> <?= esc($vaga['localizacao']) ?>
                <?php endif; ?>
            </p>
        </div>
        <a href="<?= base_url('/') ?>" style="font-size:0.88rem;color:#4f46e5;font-weight:600;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert error" style="margin-bottom:12px;"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('status')): ?>
        <div class="alert success" style="margin-bottom:12px;"><?= esc(session()->getFlashdata('status')) ?></div>
    <?php endif; ?>

    <div class="vaga-ver-tags">
        <?php if ($categoriaLabel): ?>
            <span class="vaga-ver-tag"><?= esc($categoriaLabel) ?></span>
        <?php endif; ?>
        <?php if (! empty($vaga['tipo_contrato'])): ?>
            <span class="vaga-ver-tag"><?= esc($vaga['tipo_contrato']) ?></span>
        <?php endif; ?>
        <?php if (! empty($vaga['modalidade'])): ?>
            <span class="vaga-ver-tag"><?= esc($vaga['modalidade']) ?></span>
        <?php endif; ?>
        <?php if (! empty($vaga['quantidade'])): ?>
            <span class="vaga-ver-tag"><?= (int) $vaga['quantidade'] ?> vaga(s)</span>
        <?php endif; ?>
    </div>

    <div class="form-card">
        <h3>Detalhes</h3>
        <dl class="vaga-ver-dl">
            <?php if (! empty($vaga['faixa_salarial'])): ?>
                <dt>Salário</dt>
                <dd><?= esc($vaga['faixa_salarial']) ?></dd>
            <?php endif; ?>
            <?php if (! empty($vaga['data_encerramento'])): ?>
                <dt>Encerramento</dt>
                <dd><?= esc(date('d/m/Y', strtotime($vaga['data_encerramento']))) ?></dd>
            <?php endif; ?>
            <dt>Descrição</dt>
            <dd style="white-space:pre-wrap;line-height:1.6;"><?= esc($vaga['descricao'] ?? '') ?></dd>
        </dl>
        <?php if ($beneficios !== []): ?>
            <dt style="font-size:0.75rem;text-transform:uppercase;color:#666;font-weight:600;margin-top:16px;">Benefícios</dt>
            <div class="beneficios-lista">
                <?php foreach ($beneficios as $b): ?>
                    <span class="beneficio-item"><?= esc($b) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="form-card">
        <h3>Empresa</h3>
        <div class="empresa-info">
            <div class="empresa-avatar"><i class="fas fa-building"></i></div>
            <div class="empresa-info-text">
                <strong><?= esc($empresa['nome'] ?? '—') ?></strong>
                <?php if (! empty($empresa['email'])): ?>
                    <p><i class="fas fa-envelope"></i> <?= esc($empresa['email']) ?></p>
                <?php endif; ?>
                <?php if (! empty($empresa['whatsapp'])): ?>
                    <p><i class="fab fa-whatsapp"></i> <?= esc($empresa['whatsapp']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="vaga-ver-acoes">
        <?php if (! empty($souDono)): ?>
            <a href="<?= site_url('empresa/vagas/' . $vaga['id']) ?>" class="botao-vidro">
                <i class="fas fa-pen"></i> Editar vaga
            </a>
            <a href="<?= site_url('empresa/vagas') ?>" class="botao-vidro" style="background:rgba(100,100,100,0.5);box-shadow:none;">
                Minhas vagas
            </a>
        <?php elseif (empresa_logada()): ?>
            <p style="margin:0;font-size:0.9rem;color:#666;">Você está logado como empresa. Esta vaga pertence a outro cadastro.</p>
        <?php elseif (usuario_logado()): ?>
            <a href="<?= url_to('vagas.sugeridas') ?>" class="botao-vidro">Ver vagas sugeridas</a>
        <?php else: ?>
            <a href="<?= url_to('usuario.login') ?>" class="botao-vidro" style="background:rgba(16,185,129,0.85);">Sou candidato</a>
            <a href="<?= base_url('login') ?>" class="botao-vidro">Sou empresa</a>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
