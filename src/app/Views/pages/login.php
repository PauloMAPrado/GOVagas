<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>GoVagas - Login<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-login">
    <div class="letras-formulario">
        <div class="letras-formulario">
            <label for="CNPJ">CNPJ:</label>
            <div class="posicionamento-inputs">
                <input class="input-unico-formulario" type="number" id="cnpj" name="cnpj" required placeholder="CNPJ">
            </div>
            <br>
            <label for="Senha">Senha:</label>
            <div class="posicionamento-inputs">
                <input class="input-unico-formulario" type="password" id="senha" name="senha" required placeholder="Senha">
            </div>
        </div>
    <a href="<?= site_url('register') ?>" class="letras-pequenas">Não tem login? Comece pelo Cadastro</a>
    <br>
    <a href="/recuperar-senha" class="letras-pequenas">Esqueceu a Senha? Recuperar a Senha</a>
    </div>
    <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="botao-vidro">Logar</button>
    </div>
</div>
<?= $this->endSection() ?>
