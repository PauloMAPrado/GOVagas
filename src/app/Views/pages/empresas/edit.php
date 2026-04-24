<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Editar Empresa<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-cadastro">
    <form action="/empresas/update/<?= $empresa['id'] ?>" method="post">

        <div class="letras-formulario">
            <label for="Acesso">Acesso:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="text" id="nome_da_empresa" name="nome_da_empresa" required value="<?= esc($empresa['nome']) ?>" placeholder="Nome da Empresa">
                <input class="input-duplo-formulario" type="email" id="email" name="email" required value="<?= esc($empresa['email']) ?>" placeholder="Email">
            </div>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="password" id="senha" name="senha" placeholder="Senha (deixe em branco para não alterar)">
                <input class="input-duplo-formulario" type="password" id="confirmacao_de_senha" name="confirmacao_de_senha" placeholder="Confirmar Senha">
            </div>
        </div>

        <div class="letras-formulario">
            <label for="Instituicao">Instituição:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="text" id="cnpj" name="cnpj" value="<?= esc($empresa['cnpj'] ?? '') ?>" placeholder="CNPJ">
                <input class="input-duplo-formulario" type="text" id="endereco" name="endereco" value="<?= esc($empresa['endereco'] ?? '') ?>" placeholder="Endereço">
            </div>
        </div>

        <div class="letras-formulario">
            <label for="Contato">Contato:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="text" id="contato" name="contato" value="<?= esc($empresa['whatsapp']) ?>" placeholder="Whatsapp">
                <input class="input-duplo-formulario" type="email" id="email" name="email" required value="<?= esc($empresa['email']) ?>" placeholder="Email">
            </div>
        </div>

        <div class="letras-formulario">
            <label for="Link">Link para LinkIn ou site da empresa:</label>
            <div class="posicionamento-inputs">
                <input class="input-unico-formulario" type="text" id="link" name="link" value="<?= esc($empresa['link'] ?? '') ?>" placeholder="Link">
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="botao-vidro">Atualizar</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
