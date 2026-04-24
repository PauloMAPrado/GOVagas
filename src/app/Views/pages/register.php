<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>GoVagas - Cadastro<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-cadastro">
    <form action="/register" method="post">
        <?= csrf_field() ?>

        <div class="letras-formulario">
            <label for="Acesso">Acesso:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="text" id="nome_da_empresa" name="nome_da_empresa" required placeholder="Nome da Empresa">
                <input class="input-duplo-formulario" type="email" id="email" name="email" required placeholder="Email">
            </div>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="password" id="senha" name="senha" required placeholder="Senha">
                <input class="input-duplo-formulario" type="password" id="confirmacao_de_senha" name="confirmacao_de_senha" required placeholder="Confirmar Senha">
            </div>
        </div>

        <div class="letras-formulario">
            <label for="Instituicao">Instituição:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="number" id="cnpj" name="cnpj" required placeholder="CNPJ">
                <input class="input-duplo-formulario" type="text" id="endereco" name="endereco" required placeholder="Endereço">
            </div>
        </div>

        <div class="letras-formulario">
            <label for="Contato">Contato:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="number" id="contato" name="contato" required placeholder="Whatsapp">
                <input class="input-duplo-formulario" type="email" id="email" name="email" required placeholder="Email">
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
<?= $this->endSection() ?>