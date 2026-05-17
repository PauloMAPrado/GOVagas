<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Minhas Vagas<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<?php include APPPATH . 'Views/layouts/dashboard.php'; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-wrapper">

    <?php if (session()->getFlashdata('status')): ?>
        <div class="alert success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('status') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert error"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="vagas-header">
        <h2>Minhas Vagas</h2>
        <a href="/empresa/vagas/nova" class="btn-action primary"><i class="fas fa-plus"></i> Nova Vaga</a>
    </div>

    <?php
        $todas    = $vagas;
        $filtro   = $_GET['status'] ?? 'todas';
        $ativos   = array_filter($vagas, fn($v) => $v['status'] === 'ativo');
        $pausados = array_filter($vagas, fn($v) => $v['status'] === 'pausado');

        $listagem = match($filtro) {
            'ativo'   => $ativos,
            'pausado' => $pausados,
            default   => $todas,
        };
    ?>

    <div class="stats-grid" style="grid-template-columns: repeat(3,1fr); margin-bottom:20px;">
        <div class="stat-card">
            <div class="stat-icon total"><i class="fas fa-briefcase"></i></div>
            <div class="stat-info">
                <div class="num"><?= count($todas) ?></div>
                <div class="label">Total</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ativo"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="num"><?= count($ativos) ?></div>
                <div class="label">Ativas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pausado"><i class="fas fa-pause-circle"></i></div>
            <div class="stat-info">
                <div class="num"><?= count($pausados) ?></div>
                <div class="label">Pausadas</div>
            </div>
        </div>
    </div>

    <div class="filter-tabs">
        <a href="/empresa/vagas" class="filter-tab <?= $filtro === 'todas' ? 'active' : '' ?>">Todas</a>
        <a href="/empresa/vagas?status=ativo" class="filter-tab <?= $filtro === 'ativo' ? 'active' : '' ?>">Ativas</a>
        <a href="/empresa/vagas?status=pausado" class="filter-tab <?= $filtro === 'pausado' ? 'active' : '' ?>">Pausadas</a>
    </div>

    <table class="table-glass">
        <thead>
            <tr>
                <th>Título</th>
                <th>Localização</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listagem)): ?>
                <?php foreach ($listagem as $v): ?>
                <tr>
                    <td><?= esc($v['titulo']) ?></td>
                    <td><?= esc($v['localizacao']) ?></td>
                    <td><?= esc($v['tipo_contrato'] ?? '—') ?></td>
                    <td>
                        <span class="badge <?= $v['status'] ?>">
                            <?= $v['status'] === 'ativo' ? 'Ativa' : 'Pausada' ?>
                        </span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="/empresa/vagas/toggle/<?= $v['id'] ?>" class="btn-sm <?= $v['status'] === 'ativo' ? 'pausar' : 'ativar' ?>">
                                <?= $v['status'] === 'ativo' ? 'Pausar' : 'Ativar' ?>
                            </a>
                            <a href="/empresa/vagas/<?= $v['id'] ?>" class="btn-sm editar">Editar</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            Nenhuma vaga <?= $filtro !== 'todas' ? $filtro . 'a' : 'cadastrada' ?> ainda.
                            <?php if ($filtro === 'todas'): ?>
                                <br><a href="/empresa/vagas/nova" class="btn-action primary" style="margin-top:16px; display:inline-flex;">+ Criar primeira vaga</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
<?= $this->endSection() ?>
