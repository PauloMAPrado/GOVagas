<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>GoVagas - Cadastro<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-cadastro">

<?php if (session()->getFlashdata('errors')): ?>
    <?php foreach (session()->getFlashdata('errors') as $erro): ?>
        <div class="alert error"><?= esc($erro) ?></div>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('status')): ?>
    <div class="alert success"><?= session()->getFlashdata('status') ?></div>
<?php endif; ?>

<script src="https://unpkg.com/imask"></script>

    <form action="<?= base_url('cadastro/salvar') ?>" method="post">
        <?= csrf_field() ?>

        <div class="letras-formulario">
            <label for="Acesso">Acesso:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="text" id="nome" name="nome" required placeholder="Nome da Empresa" value="<?= old('nome') ?>">
                <input class="input-duplo-formulario" type="email" id="email" name="email" required placeholder="Email" value="<?= old('email') ?>">
            </div>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="password" id="senha" name="senha" required placeholder="Senha">
                <input class="input-duplo-formulario" type="password" id="confirmacao_de_senha" name="confirmacao_de_senha" required placeholder="Confirmar Senha">
            </div>
        </div>

        <div class="letras-formulario">
            <label for="Instituicao">Instituição:</label>
            <div class="posicionamento-inputs">
            <input class="input-duplo-formulario" type="text" id="cnpj" name="cnpj"  inputmode="numeric"  required placeholder="CNPJ" value="<?= old('cnpj') ?>">
                <input class="input-duplo-formulario" type="text" id="endereco" name="endereco" required placeholder="Endereço" value="<?= old('endereco') ?>">
            </div>
        </div>

        <div class="letras-formulario">
            <label for="Contato">Contato:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="tel" id="contato" name="contato" required placeholder="Whatsapp" value="<?= old('contato') ?>">
            </div>
        </div>

        <div class="letras-formulario">
            <label for="Link">Link para LinkIn ou site da empresa:</label>
            <div class="posicionamento-inputs">
                <input class="input-unico-formulario" type="text" id="link" name="link" required placeholder="Link">
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="botao-vidro">Cadastrar</button>
        </div>
    </form>
</div>

<script>
    IMask(document.getElementById('cnpj'), {
        mask: '00.000.000/0000-00'
    });

    IMask(document.getElementById('contato'), {
        mask: '(00) 00000-0000'
    });
</script>



<?= $this->endSection() ?>