<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Editar Perfil<?= $this->endSection() ?>

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

    <form action="<?= base_url('empresa/perfil/salvar') ?>" method="post">
        <?= csrf_field() ?>

        <div class="letras-formulario">
            <label>Acesso:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="text" name="nome_da_empresa" required placeholder="Nome da Empresa" value="<?= old('nome_da_empresa', esc($empresa['nome'])) ?>">
                <input class="input-duplo-formulario" type="email" name="email" required placeholder="Email" value="<?= old('email', esc($empresa['email'])) ?>">
            </div>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="password" name="senha" placeholder="Senha (deixe em branco para não alterar)">
                <input class="input-duplo-formulario" type="password" name="confirmacao_de_senha" placeholder="Confirmar Senha">
            </div>
        </div>

        <div class="letras-formulario">
            <label>Instituição:</label>
            <div class="posicionamento-inputs">
                <input class="input-duplo-formulario" type="text" name="cnpj" inputmode="numeric" placeholder="CNPJ" value="<?= old('cnpj', esc($empresa['cnpj'] ?? '')) ?>">
                <input class="input-duplo-formulario" type="text" name="endereco" placeholder="Endereço" value="<?= old('endereco', esc($empresa['endereco'] ?? '')) ?>">
            </div>
        </div>

        <div class="letras-formulario">
            <label>Contato:</label>
            <div class="posicionamento-inputs">
                <input class="input-unico-formulario" type="text" name="contato" inputmode="numeric" placeholder="WhatsApp" value="<?= old('contato', esc($empresa['whatsapp'] ?? '')) ?>">
            </div>
        </div>

        <div class="letras-formulario">
            <label>Link (LinkedIn ou site):</label>
            <div class="posicionamento-inputs">
                <input class="input-unico-formulario" type="text" name="link" placeholder="https://..." value="<?= old('link', esc($empresa['link'] ?? '')) ?>">
            </div>
        </div>

        <div style="text-align: center; margin-top: 24px; padding-bottom: 1.5rem;">
            <button type="submit" class="botao-vidro">Salvar Alterações</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
