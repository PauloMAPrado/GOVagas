<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>GoVagas - Login Candidato<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-login">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('status')): ?>
        <div class="alert success"><?= esc(session()->getFlashdata('status')) ?></div>
    <?php endif; ?>
    <form action="<?= url_to('usuario.login.autenticar') ?>" method="post">
        <?= csrf_field() ?>
        <div class="letras-formulario">
            <label for="cpf">CPF:</label>
            <div class="posicionamento-inputs">
                <input class="input-unico-formulario" type="text" id="cpf" name="cpf" inputmode="numeric" required placeholder="CPF" value="<?= esc(old('cpf')) ?>">
            </div>
            <br>
            <label for="senha">Senha:</label>
            <div class="posicionamento-inputs">
                <input class="input-unico-formulario" type="password" id="senha" name="senha" required placeholder="Senha">
            </div>
            <a href="<?= url_to('usuario.cadastro') ?>" class="letras-pequenas">Não tem conta? Cadastre-se</a>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="botao-vidro">Entrar</button>
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
