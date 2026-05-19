<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Detalhes da Vaga<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-cadastro">
    <h1 class="letras-formulario">Informações da Vaga</h1>
    <?php
    $loggedEmpresa = session()->get('empresa_id');
    $isOwner       = isset($isOwner) ? $isOwner : ($loggedEmpresa && ((int) $loggedEmpresa === (int) ($vaga['empresa_id'] ?? 0)));
    $isEdit        = ! empty($vaga['id']);
    $formAction    = $isOwner && $isEdit
        ? site_url('empresa/vagas/update/' . $vaga['id'])
        : ($isOwner ? site_url('empresa/vagas/salvar') : '');
    $ro            = $isOwner ? '' : 'readonly';
    $dis           = $isOwner ? '' : 'disabled';
    ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <?php foreach (session()->getFlashdata('errors') as $erro): ?>
            <div class="alert error"><?= esc($erro) ?></div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('status')): ?>
        <div class="alert success"><?= esc(session()->getFlashdata('status')) ?></div>
    <?php endif; ?>

    <form action="<?= esc($formAction) ?>" method="post">
        <?= $isOwner ? csrf_field() : '' ?>

        <div class="vaga-form-layout">
            <div class="vaga-form-col vaga-form-col--main">
                <input type="text" name="titulo" class="input-unico-formulario" placeholder="Título da Vaga" required value="<?= esc($vaga['titulo'] ?? '') ?>" <?= $ro ?>>

                <div class="vaga-form-row">
                    <select name="categoria" class="input-duplo-formulario" <?= $dis ?>>
                        <option value="">Categoria da Vaga</option>
                        <option value="tecnologia" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'tecnologia' ? 'selected' : '' ?>>Tecnologia</option>
                        <option value="administrativo" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'administrativo' ? 'selected' : '' ?>>Administrativo</option>
                        <option value="vendas" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'vendas' ? 'selected' : '' ?>>Vendas</option>
                        <option value="outros" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'outros' ? 'selected' : '' ?>>Outros</option>
                    </select>

                    <select name="tipo_contrato" class="input-duplo-formulario" <?= $dis ?>>
                        <option value="">Tipo de Contrato</option>
                        <option value="CLT" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'CLT' ? 'selected' : '' ?>>CLT</option>
                        <option value="PJ" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'PJ' ? 'selected' : '' ?>>PJ</option>
                        <option value="Estágio" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'Estágio' ? 'selected' : '' ?>>Estágio</option>
                        <option value="Temporário" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'Temporário' ? 'selected' : '' ?>>Temporário</option>
                    </select>
                </div>

                <div class="vaga-form-row">
                    <select name="modalidade" class="input-duplo-formulario" <?= $dis ?>>
                        <option value="">Modalidade de Trabalho</option>
                        <option value="Presencial" <?= isset($vaga['modalidade']) && $vaga['modalidade'] === 'Presencial' ? 'selected' : '' ?>>Presencial</option>
                        <option value="Remoto" <?= isset($vaga['modalidade']) && $vaga['modalidade'] === 'Remoto' ? 'selected' : '' ?>>Remoto</option>
                        <option value="Híbrido" <?= isset($vaga['modalidade']) && $vaga['modalidade'] === 'Híbrido' ? 'selected' : '' ?>>Híbrido</option>
                    </select>
                    <input type="date" name="data_encerramento" class="input-duplo-formulario" title="Data de encerramento" value="<?= esc($vaga['data_encerramento'] ?? '') ?>" <?= $ro ?>>
                </div>

                <div class="vaga-form-row vaga-form-row--qty">
                    <input type="number" name="quantidade" class="input-duplo-formulario vaga-form-qty" placeholder="Qtd Vagas" value="<?= esc($vaga['quantidade'] ?? '') ?>" <?= $ro ?>>
                    <input type="text" name="faixa_salarial" class="input-duplo-formulario vaga-form-salary" placeholder="Faixa Salarial (Ex: R$ 3.000 - R$ 5.000)" value="<?= esc($vaga['faixa_salarial'] ?? '') ?>" <?= $ro ?>>
                </div>

                <input type="text" name="beneficios" class="input-unico-formulario" placeholder="Benefícios (VR, VA, Plano de Saúde...)" value="<?= esc($vaga['beneficios'] ?? '') ?>" <?= $ro ?>>

                <input type="text" name="localizacao" class="input-unico-formulario" placeholder="Localização (Cidade - UF)" value="<?= esc($vaga['localizacao'] ?? '') ?>" <?= $ro ?>>
            </div>

            <div class="vaga-form-col vaga-form-col--side">
                <textarea name="descricao" class="input-unico-formulario vaga-form-descricao"
                    placeholder="Descrição detalhada da vaga..." <?= $ro ?>><?= esc($vaga['descricao'] ?? '') ?></textarea>

                <div class="vaga-empresa-card">
                    <div class="vaga-empresa-avatar" aria-hidden="true"></div>
                    <div class="vaga-empresa-info">
                        <p class="nome"><?= esc($vaga['empresa']['nome'] ?? ($vaga['empresa_nome'] ?? 'Nome da Empresa')) ?></p>
                        <p class="detalhe"><?= esc($vaga['empresa']['whatsapp'] ?? '') ?></p>
                        <p class="detalhe"><?= esc($vaga['empresa']['email'] ?? '') ?></p>
                    </div>
                    <?php if ($isOwner): ?>
                        <a href="<?= base_url('empresa/vagas') ?>" class="botao-vidro" style="font-size: 0.8rem; padding: 8px;">Gerenciar</a>
                    <?php else: ?>
                        <a href="<?= base_url('/') ?>" class="botao-vidro" style="font-size: 0.8rem; padding: 8px;">Voltar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="vaga-form-actions">
            <?php if ($isOwner): ?>
                <button type="submit" class="botao-vidro">Salvar</button>
            <?php else: ?>
                <button type="button" class="botao-vidro" disabled>Salvar (login obrigatório)</button>
            <?php endif; ?>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
