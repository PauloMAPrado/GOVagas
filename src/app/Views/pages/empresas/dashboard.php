<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Dashboard - <?= esc(session()->get('empresa_nome')) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('status')): ?>
    <div class="alert success"><?= session()->getFlashdata('status') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<h2>Olá, <?= esc($empresa['nome']) ?>!</h2>

<div style="display:flex; gap:20px; margin-bottom:32px; flex-wrap:wrap;">
    <div class="vidro-cadastro" style="flex:1; min-width:180px; text-align:center; padding:24px;">
        <p style="font-size:2.5rem; font-weight:700; margin:0;"><?= count($vagas) ?></p>
        <p style="margin:4px 0 0;">Vagas cadastradas</p>
    </div>
    <div class="vidro-cadastro" style="flex:1; min-width:180px; text-align:center; padding:24px;">
        <p style="font-size:2.5rem; font-weight:700; margin:0;"><?= count(array_filter($vagas, fn($v) => $v['status'] === 'ativo')) ?></p>
        <p style="margin:4px 0 0;">Vagas ativas</p>
    </div>
    <div class="vidro-cadastro" style="flex:1; min-width:180px; text-align:center; padding:24px;">
        <p style="font-size:2.5rem; font-weight:700; margin:0;"><?= count(array_filter($vagas, fn($v) => $v['status'] === 'pausado')) ?></p>
        <p style="margin:4px 0 0;">Vagas pausadas</p>
    </div>
</div>

<div style="display:flex; gap:12px; margin-bottom:28px; flex-wrap:wrap;">
    <a href="/empresa/vagas/nova" class="botao-vidro"> Nova Vaga</a>
    <a href="/empresa/vagas" class="botao-vidro">Gerenciar Vagas</a>
    <a href="/empresa/perfil" class="botao-vidro">Editar Perfil</a>
</div>

<h3>Suas vagas recentes</h3>
<table class="tabela">
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
                    <span class="badge <?= $v['status'] === 'ativo' ? 'bg-success' : 'bg-secondary' ?>">
                        <?= ucfirst($v['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="/empresa/vagas/toggle/<?= $v['id'] ?>" class="btn-acao">
                        <?= $v['status'] === 'ativo' ? 'Pausar' : 'Ativar' ?>
                    </a>
                    | <a href="/empresa/vagas/<?= $v['id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">Nenhuma vaga cadastrada ainda.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
