<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Minhas Vagas<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Gerenciar minhas vagas</h2>

<?php if (session()->getFlashdata('status')): ?>
    <div class="alert success"><?= session()->getFlashdata('status') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

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
        <?php if (!empty($vagas) && is_array($vagas)): ?>
            <?php foreach ($vagas as $v): ?>
            <tr>
                <td><?= esc($v['titulo']) ?></td>
                <td><?= esc($v['localizacao']) ?></td>
                <td>
                    <span class="badge <?= $v['status'] === 'ativo' ? 'bg-success' : 'bg-secondary' ?>">
                        <?= ucfirst($v['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('vagas/toggle/' . $v['id']) ?>" class="btn-acao">
                        <?= $v['status'] === 'ativo' ? 'Pausar' : 'Ativar' ?>
                    </a>
                    |
                    <a href="<?= base_url('vagas/' . $v['id']) ?>">Ver/Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Nenhuma vaga encontrada.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<p><a href="<?= base_url('vagas/novo') ?>" class="botao-vidro">Anunciar Nova Vaga</a></p>

<?= $this->endSection() ?>