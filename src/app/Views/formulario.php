<?= $this->extend('base') ?>

<?= $this->section('title') ?>
Cadastro de Vaga - GoVagas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-cadastro">
    <h1 class="letras-formulario">Informações da Vaga</h1>
    
    <form action="<?= site_url('vagas/salvar') ?>" method="post">
        <?= csrf_field() ?>
        
        <div style="display: flex; gap: 40px; padding: 0 3rem 2rem 3rem; align-items: flex-start;">
            
            <div style="flex: 1.2; display: flex; flex-direction: column; gap: 15px;">
                
                <input type="text" name="titulo" class="input-unico-formulario" placeholder="Título da Vaga" required>

                <div style="display: flex; gap: 15px;">
                    <select name="categoria" class="input-duplo-formulario" style="flex: 1;">
                        <option value="">Categoria da Vaga</option>
                        <option value="tecnologia">Tecnologia</option>
                        <option value="administrativo">Administrativo</option>
                        <option value="vendas">Vendas</option>
                        <option value="outros">Outros</option>
                    </select>
                    
                    <select name="tipo_contrato" class="input-duplo-formulario" style="flex: 1;">
                        <option value="">Tipo de Contrato</option>
                        <option value="CLT">CLT</option>
                        <option value="PJ">PJ</option>
                        <option value="Estágio">Estágio</option>
                        <option value="Temporário">Temporário</option>
                    </select>
                </div>

                <div style="display: flex; gap: 15px;">
                    <select name="modalidade" class="input-duplo-formulario" style="flex: 1;">
                        <option value="">Modalidade de Trabalho</option>
                        <option value="Presencial">Presencial</option>
                        <option value="Remoto">Remoto</option>
                        <option value="Híbrido">Híbrido</option>
                    </select>
                    <input type="date" name="data_encerramento" class="input-duplo-formulario" style="flex: 1;" title="Data de encerramento">
                </div>

                <div style="display: flex; gap: 15px;">
                    <input type="number" name="quantidade" class="input-duplo-formulario" style="flex: 0.5;" placeholder="Qtd Vagas">
                    <input type="text" name="faixa_salarial" class="input-duplo-formulario" style="flex: 1.5;" placeholder="Faixa Salarial (Ex: R$ 3.000 - R$ 5.000)">
                </div>

                <input type="text" name="beneficios" class="input-unico-formulario" placeholder="Benefícios (VR, VA, Plano de Saúde...)">
                
                <input type="text" name="localizacao" class="input-unico-formulario" placeholder="Localização (Cidade - UF)">

                <input type="text" name="whatsapp_contato" class="input-unico-formulario" placeholder="WhatsApp para Contato (Ex: 5511999999999)">
            </div>

            <div style="flex: 1; display: flex; flex-direction: column; gap: 20px; height: 100%;">
                
                <textarea name="descricao" class="input-unico-formulario" 
                    style="height: 320px; padding-top: 15px; border-radius: 15px; resize: none;" 
                    placeholder="Descrição detalhada da vaga..."></textarea>

                <div class="card" style="background: rgba(255,255,255,0.3); display: flex; align-items: center; gap: 15px; border-radius: 20px; padding: 15px; border: 1px solid rgba(255,255,255,0.2);">
                    <div style="width: 65px; height: 65px; border-radius: 50%; background: #ccc; flex-shrink: 0;">
                         </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; font-weight: 600; color: #333363; font-size: 1rem;">Nome da Empresa</p>
                        <p style="margin: 0; font-size: 0.85rem; color: #444;">(11) 99999-9999</p>
                        <p style="margin: 0; font-size: 0.85rem; color: #444;">contato@empresa.com</p>
                    </div>
                    <button type="button" class="botao-vidro" style="min-width: 120px; font-size: 0.8rem; padding: 8px;">Perfil</button>
                </div>
            </div>
        </div>

        <div style="text-align: center; padding-bottom: 3rem;">
            <button type="submit" class="botao-vidro" style="width: 300px;">Publicar Vaga</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>