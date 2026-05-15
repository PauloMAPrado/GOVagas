<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Dashboard - <?= esc(session()->get('empresa_nome')) ?><?= $this->endSection() ?>

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

    <div class="dashboard-header">
        <h2>Olá, <?= esc($empresa['nome']) ?>!</h2>
        <p>Gerencie suas vagas e acompanhe o desempenho da sua empresa.</p>
    </div>

    <?php
        $total   = count($vagas);
        $ativos  = count(array_filter($vagas, fn($v) => $v['status'] === 'ativo'));
        $pausados = $total - $ativos;
    ?>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total"><i class="fas fa-briefcase"></i></div>
            <div class="stat-info">
                <div class="num"><?= $total ?></div>
                <div class="label">Total de vagas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ativo"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="num"><?= $ativos ?></div>
                <div class="label">Vagas ativas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pausado"><i class="fas fa-pause-circle"></i></div>
            <div class="stat-info">
                <div class="num"><?= $pausados ?></div>
                <div class="label">Vagas pausadas</div>
            </div>
        </div>
    </div>

    <div class="quick-actions">
        <a href="/empresa/vagas/nova" class="btn-action primary"><i class="fas fa-plus"></i> Nova Vaga</a>
        <a href="/empresa/vagas"      class="btn-action secondary"><i class="fas fa-list"></i> Gerenciar Vagas</a>
        <a href="/empresa/perfil"     class="btn-action secondary"><i class="fas fa-user-edit"></i> Editar Perfil</a>
    </div>

    <p class="section-title">Vagas recentes</p>

    <table class="table-glass">
        <thead>
            <tr>
                <th>Título</th>
                <th>Localização</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vagas)): ?>
                <?php foreach (array_slice($vagas, 0, 5) as $v): ?>
                <tr>
                    <td><?= esc($v['titulo']) ?></td>
                    <td><?= esc($v['localizacao']) ?></td>
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
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            Nenhuma vaga cadastrada ainda.<br>
                            <a href="/empresa/vagas/nova" class="btn-action primary" style="margin-top:16px; display:inline-flex;">+ Criar primeira vaga</a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
<?= $this->endSection() ?>
