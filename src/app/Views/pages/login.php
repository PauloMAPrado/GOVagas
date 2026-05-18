<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>GoVagas - Login<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-login">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('status')): ?>
        <div class="alert success"><?= esc(session()->getFlashdata('status')) ?></div>
    <?php endif; ?>
    <form action="<?= url_to('login.autenticar') ?>" method="post">
        <?= csrf_field() ?>
        <div class="letras-formulario">
            <label for="cnpj">CNPJ:</label>
            <div class="posicionamento-inputs">
                <input class="input-unico-formulario" type="text" id="cnpj" name="cnpj" inputmode="numeric" required placeholder="CNPJ" value="<?= esc(old('cnpj')) ?>">
            </div>
            <br>
            <label for="senha">Senha:</label>
            <div class="posicionamento-inputs">
                <input class="input-unico-formulario" type="password" id="senha" name="senha" required placeholder="Senha">
            </div>
            <a href="<?= base_url('cadastro') ?>" class="letras-pequenas">Não tem login? Comece pelo Cadastro</a>
            <br>
            <a href="<?= base_url('recuperar-senha') ?>" class="letras-pequenas">Esqueceu a Senha? Recuperar a Senha</a>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="botao-vidro">Logar</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
