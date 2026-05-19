<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>GoVagas - Cadastro de Candidato<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-cadastro">

<?php if (session()->getFlashdata('errors')): ?>
    <?php foreach (session()->getFlashdata('errors') as $erro): ?>
        <div class="alert error"><?= esc(is_array($erro) ? implode(', ', $erro) : $erro) ?></div>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert error"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

    <form action="<?= url_to('usuario.cadastro.salvar') ?>" method="post">
        <?= csrf_field() ?>

        <div class="letras-formulario">
            <label>Acesso:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="text" name="nome_completo" required placeholder="Nome completo" value="<?= esc(old('nome_completo')) ?>">
                <input class="input-duplo-formulario" type="email" name="email" required placeholder="E-mail" value="<?= esc(old('email')) ?>">
            </div>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="text" id="cpf" name="cpf" inputmode="numeric" required placeholder="CPF" value="<?= esc(old('cpf')) ?>">
            </div>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="password" name="senha" required placeholder="Senha">
                <input class="input-duplo-formulario" type="password" name="confirmacao_de_senha" required placeholder="Confirmar senha">
            </div>
        </div>

        <?php
            $usuario = [];
            $val = static fn (string $key, $default = '') => old($key, $default);
            echo view('partials/usuario_preferencias', compact('usuario', 'val'));
        ?>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="botao-vidro">Cadastrar</button>
            <br><br>
            <a href="<?= url_to('usuario.login') ?>" class="letras-pequenas">Já tem conta? Faça login</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const cpfEl = document.getElementById('cpf');
if (cpfEl) IMask(cpfEl, { mask: '000.000.000-00' });
</script>
<?= $this->endSection() ?>
