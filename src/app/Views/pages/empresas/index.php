<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Empresas<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>Lista de Empresas</h2>

<?php if (session()->getFlashdata('status')): ?>
    <div class="alert success"><?= session()->getFlashdata('status') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<p><a href="/register" class="botao-vidro">Nova Empresa</a></p>

<table class="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Whatsapp</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($empresas as $e): ?>
        <tr>
            <td><?= esc($e['id']) ?></td>
            <td><?= esc($e['nome']) ?></td>
            <td><?= esc($e['email']) ?></td>
            <td><?= esc($e['whatsapp']) ?></td>
            <td>
                <a href="/empresas/edit/<?= $e['id'] ?>">Editar</a> |
                <a href="/empresas/delete/<?= $e['id'] ?>" onclick="return confirm('Excluir empresa?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
