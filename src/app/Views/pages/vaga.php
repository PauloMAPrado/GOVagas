<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Detalhes da Vaga<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-cadastro">
    <h1 class="letras-formulario">Informações da Vaga</h1>
    <?php $loggedEmpresa = session()->get('empresa_id'); ?>
    <?php $isOwner = $loggedEmpresa && ((int) $loggedEmpresa === (int) ($vaga['empresa_id'] ?? 0)); ?>

    <form action="<?= site_url('vagas/salvar') ?>" method="post">
        <?= csrf_field() ?>

        <div style="display: flex; gap: 40px; padding: 0 3rem 2rem 3rem; align-items: flex-start;">
            <div style="flex: 1.2; display: flex; flex-direction: column; gap: 15px;">
                <input type="text" name="titulo" class="input-unico-formulario" placeholder="Título da Vaga" required value="<?= esc($vaga['titulo'] ?? '') ?>" <?= $isOwner ? '' : 'readonly' ?> >

                <div style="display: flex; gap: 15px;">
                    <select name="categoria" class="input-duplo-formulario" style="flex: 1;" <?= $isOwner ? '' : 'disabled' ?>>
                        <option value="">Categoria da Vaga</option>
                        <option value="tecnologia" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'tecnologia' ? 'selected' : '' ?>>Tecnologia</option>
                        <option value="administrativo" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'administrativo' ? 'selected' : '' ?>>Administrativo</option>
                        <option value="vendas" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'vendas' ? 'selected' : '' ?>>Vendas</option>
                        <option value="outros" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'outros' ? 'selected' : '' ?>>Outros</option>
                    </select>
                    
                    <select name="tipo_contrato" class="input-duplo-formulario" style="flex: 1;" <?= $isOwner ? '' : 'disabled' ?>>
                        <option value="">Tipo de Contrato</option>
                        <option value="CLT" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'CLT' ? 'selected' : '' ?>>CLT</option>
                        <option value="PJ" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'PJ' ? 'selected' : '' ?>>PJ</option>
                        <option value="Estágio" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'Estágio' ? 'selected' : '' ?>>Estágio</option>
                        <option value="Temporário" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'Temporário' ? 'selected' : '' ?>>Temporário</option>
                    </select>
                </div>

                <div style="display: flex; gap: 15px;">
                    <select name="modalidade" class="input-duplo-formulario" style="flex: 1;" <?= $isOwner ? '' : 'disabled' ?> >
                        <option value="">Modalidade de Trabalho</option>
                        <option value="Presencial" <?= isset($vaga['modalidade']) && $vaga['modalidade'] === 'Presencial' ? 'selected' : '' ?>>Presencial</option>
                        <option value="Remoto" <?= isset($vaga['modalidade']) && $vaga['modalidade'] === 'Remoto' ? 'selected' : '' ?>>Remoto</option>
                        <option value="Híbrido" <?= isset($vaga['modalidade']) && $vaga['modalidade'] === 'Híbrido' ? 'selected' : '' ?>>Híbrido</option>
                    </select>
                    <input type="date" name="data_encerramento" class="input-duplo-formulario" style="flex: 1;" title="Data de encerramento" value="<?= esc($vaga['data_encerramento'] ?? '') ?>" <?= $isOwner ? '' : 'readonly' ?> >
                </div>

                <div style="display: flex; gap: 15px;">
                    <input type="number" name="quantidade" class="input-duplo-formulario" style="flex: 0.5;" placeholder="Qtd Vagas" value="<?= esc($vaga['quantidade'] ?? '') ?>" <?= $isOwner ? '' : 'readonly' ?> >
                    <input type="text" name="faixa_salarial" class="input-duplo-formulario" style="flex: 1.5;" placeholder="Faixa Salarial (Ex: R$ 3.000 - R$ 5.000)" value="<?= esc($vaga['faixa_salarial'] ?? '') ?>" <?= $isOwner ? '' : 'readonly' ?> >
                </div>

                <input type="text" name="beneficios" class="input-unico-formulario" placeholder="Benefícios (VR, VA, Plano de Saúde...)" value="<?= esc($vaga['beneficios'] ?? '') ?>" <?= $isOwner ? '' : 'readonly' ?> >
                
                <input type="text" name="localizacao" class="input-unico-formulario" placeholder="Localização (Cidade - UF)" value="<?= esc($vaga['localizacao'] ?? '') ?>" <?= $isOwner ? '' : 'readonly' ?> >

                <input type="text" name="whatsapp_contato" class="input-unico-formulario" placeholder="WhatsApp para Contato (Ex: 5511999999999)" value="<?= esc($vaga['whatsapp'] ?? ($vaga['empresa']['whatsapp'] ?? '')) ?>" <?= $isOwner ? '' : 'readonly' ?> >
            </div>

            <div style="flex: 1; display: flex; flex-direction: column; gap: 20px; height: 100%;">
                <textarea name="descricao" class="input-unico-formulario" 
                    style="height: 320px; padding-top: 15px; border-radius: 15px; resize: none;" 
                    placeholder="Descrição detalhada da vaga..." <?= $isOwner ? '' : 'readonly' ?>><?= esc($vaga['descricao'] ?? '') ?></textarea>

                <div class="card" style="background: rgba(255,255,255,0.3); display: flex; align-items: center; gap: 15px; border-radius: 20px; padding: 15px; border: 1px solid rgba(255,255,255,0.2);">
                    <div style="width: 65px; height: 65px; border-radius: 50%; background: #ccc; flex-shrink: 0;">
                         </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; font-weight: 600; color: #333363; font-size: 1rem;"><?= esc($vaga['empresa']['nome'] ?? ($vaga['empresa_nome'] ?? 'Nome da Empresa')) ?></p>
                        <p style="margin: 0; font-size: 0.85rem; color: #444;"><?= esc($vaga['empresa']['whatsapp'] ?? '') ?></p>
                        <p style="margin: 0; font-size: 0.85rem; color: #444;"><?= esc($vaga['empresa']['email'] ?? '') ?></p>
                    </div>
                    <?php if ($isOwner): ?>
                        <a href="/minhas-vagas" class="botao-vidro" style="min-width: 120px; font-size: 0.8rem; padding: 8px;">Gerenciar</a>
                    <?php else: ?>
                        <a href="/empresas/{$vaga['empresa_id']}" class="botao-vidro" style="min-width: 120px; font-size: 0.8rem; padding: 8px;">Visualizar Perfil</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="text-align: center; padding-bottom: 3rem;">
            <?php if ($isOwner): ?>
                <button type="submit" class="botao-vidro" style="width: 300px;">Salvar</button>
            <?php else: ?>
                <button type="button" class="botao-vidro" style="width: 300px;" disabled>Salvar (login obrigatório)</button>
            <?php endif; ?>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
