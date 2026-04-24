<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Cadastro de Vaga - GoVagas<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vidro-cadastro">
    <h1 class="letras-formulario">Informações da Vaga</h1>
    
    <?php
        $isOwner = isset($isOwner) && $isOwner;
        $isEdit = isset($vaga['id']) && $isOwner;
        $formAction = $isEdit ? site_url('vagas/update/' . $vaga['id']) : site_url('vagas/salvar');
    ?>
    <form action="<?= $formAction ?>" method="post">
        <?= csrf_field() ?>
        <?php $readonly = isset($readonly) && $readonly; ?>
        
        <div style="display: flex; gap: 40px; padding: 0 3rem 2rem 3rem; align-items: flex-start;">
            
            <div style="flex: 1.2; display: flex; flex-direction: column; gap: 15px;">
                
                <input type="text" name="titulo" class="input-unico-formulario" placeholder="Título da Vaga" required value="<?= esc($vaga['titulo'] ?? '') ?>" <?= $readonly ? 'readonly' : '' ?>>

                <div style="display: flex; gap: 15px;">
                    <select name="categoria" class="input-duplo-formulario" style="flex: 1;" <?= $readonly ? 'disabled' : '' ?>>
                        <option value="">Categoria da Vaga</option>
                        <option value="tecnologia" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'tecnologia' ? 'selected' : '' ?>>Tecnologia</option>
                        <option value="administrativo" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'administrativo' ? 'selected' : '' ?>>Administrativo</option>
                        <option value="vendas" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'vendas' ? 'selected' : '' ?>>Vendas</option>
                        <option value="outros" <?= isset($vaga['categoria']) && $vaga['categoria'] === 'outros' ? 'selected' : '' ?>>Outros</option>
                    </select>
                    
                    <select name="tipo_contrato" class="input-duplo-formulario" style="flex: 1;" <?= $readonly ? 'disabled' : '' ?>>
                        <option value="">Tipo de Contrato</option>
                        <option value="CLT" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'CLT' ? 'selected' : '' ?>>CLT</option>
                        <option value="PJ" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'PJ' ? 'selected' : '' ?>>PJ</option>
                        <option value="Estágio" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'Estágio' ? 'selected' : '' ?>>Estágio</option>
                        <option value="Temporário" <?= isset($vaga['tipo_contrato']) && $vaga['tipo_contrato'] === 'Temporário' ? 'selected' : '' ?>>Temporário</option>
                    </select>
                </div>

                <div style="display: flex; gap: 15px;">
                    <select name="modalidade" class="input-duplo-formulario" style="flex: 1;" <?= $readonly ? 'disabled' : '' ?>>
                        <option value="">Modalidade de Trabalho</option>
                        <option value="Presencial" <?= isset($vaga['modalidade']) && $vaga['modalidade'] === 'Presencial' ? 'selected' : '' ?>>Presencial</option>
                        <option value="Remoto" <?= isset($vaga['modalidade']) && $vaga['modalidade'] === 'Remoto' ? 'selected' : '' ?>>Remoto</option>
                        <option value="Híbrido" <?= isset($vaga['modalidade']) && $vaga['modalidade'] === 'Híbrido' ? 'selected' : '' ?>>Híbrido</option>
                    </select>
                    <input type="date" name="data_encerramento" class="input-duplo-formulario" style="flex: 1;" title="Data de encerramento" value="<?= esc($vaga['data_encerramento'] ?? '') ?>" <?= $readonly ? 'readonly' : '' ?>>
                </div>

                <div style="display: flex; gap: 15px;">
                    <input type="number" name="quantidade" class="input-duplo-formulario" style="flex: 0.5;" placeholder="Qtd Vagas" value="<?= esc($vaga['quantidade'] ?? '') ?>" <?= $readonly ? 'readonly' : '' ?>>
                    <input type="text" name="faixa_salarial" class="input-duplo-formulario" style="flex: 1.5;" placeholder="Faixa Salarial (Ex: R$ 3.000 - R$ 5.000)" value="<?= esc($vaga['faixa_salarial'] ?? '') ?>" <?= $readonly ? 'readonly' : '' ?>>
                </div>

                <input type="text" name="beneficios" class="input-unico-formulario" placeholder="Benefícios (VR, VA, Plano de Saúde...)" value="<?= esc($vaga['beneficios'] ?? '') ?>" <?= $readonly ? 'readonly' : '' ?>>
                
                <input type="text" name="localizacao" class="input-unico-formulario" placeholder="Localização (Cidade - UF)" value="<?= esc($vaga['localizacao'] ?? '') ?>" <?= $readonly ? 'readonly' : '' ?> >

                <?php
                    // simple phone formatter for BR numbers (server-side display)
                    $format_phone = function($raw) {
                        $digits = preg_replace('/\D+/', '', (string) $raw);
                        if ($digits === '') return '';
                        // drop country code if present (55)
                        if (substr($digits, 0, 2) === '55') $digits = substr($digits, 2);
                        $len = strlen($digits);
                        if ($len === 11) { // (AA) 9XXXX-XXXX
                            return '(' . substr($digits,0,2) . ') ' . substr($digits,2,5) . '-' . substr($digits,7);
                        } elseif ($len === 10) { // (AA) XXXX-XXXX
                            return '(' . substr($digits,0,2) . ') ' . substr($digits,2,4) . '-' . substr($digits,6);
                        } elseif ($len > 4) {
                            return substr($digits,0,$len-4) . '-' . substr($digits,-4);
                        }
                        return $raw;
                    };
                    $whatsapp_val = $format_phone($vaga['whatsapp'] ?? ($vaga['empresa']['whatsapp'] ?? ''));
                ?>
                <input type="text" name="whatsapp_contato" class="input-unico-formulario" placeholder="WhatsApp para Contato (Ex: (11) 99999-9999)" value="<?= esc($whatsapp_val) ?>" <?= $readonly ? 'readonly' : '' ?> >
            </div>

            <div style="flex: 1; display: flex; flex-direction: column; gap: 20px; height: 100%;">
                
                <textarea name="descricao" class="input-unico-formulario" 
                    style="height: 320px; padding-top: 15px; border-radius: 15px; resize: none;" 
                    placeholder="Descrição detalhada da vaga..." <?= $readonly ? 'readonly' : '' ?>><?= esc($vaga['descricao'] ?? '') ?></textarea>

                <div class="card" style="background: rgba(255,255,255,0.3); display: flex; align-items: center; gap: 15px; border-radius: 20px; padding: 15px; border: 1px solid rgba(255,255,255,0.2);">
                    <div style="width: 65px; height: 65px; border-radius: 50%; background: #ccc; flex-shrink: 0;">
                         </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; font-weight: 600; color: #333363; font-size: 1rem;"><?= esc($vaga['empresa']['nome'] ?? ($vaga['empresa_nome'] ?? 'Nome da Empresa')) ?></p>
                        <p style="margin: 0; font-size: 0.85rem; color: #444;"><?= esc($vaga['empresa']['whatsapp'] ?? '') ?></p>
                        <p style="margin: 0; font-size: 0.85rem; color: #444;"><?= esc($vaga['empresa']['email'] ?? '') ?></p>
                    </div>
                    <button type="button" class="botao-vidro" style="min-width: 120px; font-size: 0.8rem; padding: 8px;">Visualizar Perfil</button>
                </div>
            </div>
        </div>

        <div style="text-align: center; padding-bottom: 3rem;">
            <?php if (! $readonly): ?>
                <button id="btn-save" type="submit" class="botao-vidro" style="width: 300px;">Salvar</button>
            <?php else: ?>
                <?php if (isset($isOwner) && $isOwner): ?>
                    <button id="btn-edit" type="button" class="botao-vidro" style="width:300px;">Editar</button>
                <?php else: ?>
                    <!-- owner not logged in: hide publish link and show no action -->
                    <span style="display:inline-block;width:300px;height:38px;"></span>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </form>

    <script>
        (function(){
            var btnEdit = document.getElementById('btn-edit');
            if (!btnEdit) return;
            btnEdit.addEventListener('click', function(){
                var form = btnEdit.closest('form');
                if (!form) return;
                // enable inputs/selects/textareas
                var elems = form.querySelectorAll('input, select, textarea');
                elems.forEach(function(el){
                    el.removeAttribute('readonly');
                    el.removeAttribute('disabled');
                });
                // show save button (create if necessary)
                var btnSave = document.getElementById('btn-save');
                if (!btnSave) {
                    btnSave = document.createElement('button');
                    btnSave.type = 'submit';
                    btnSave.id = 'btn-save';
                    btnSave.className = 'botao-vidro';
                    btnSave.style.width = '300px';
                    btnSave.textContent = 'Salvar';
                    form.querySelector('div[style*="text-align: center"]').appendChild(btnSave);
                } else {
                    btnSave.style.display = '';
                }
                // remove edit button
                btnEdit.style.display = 'none';
            });
        })();
</script>

    <script>
        // Dynamic mask for WhatsApp input: formats as (AA) 9XXXX-XXXX while typing
        (function(){
            var input = document.querySelector('input[name="whatsapp_contato"]');
            if (!input) return;

            function onlyDigits(v){ return v.replace(/\D/g,''); }

            function formatBR(v){
                var d = onlyDigits(v);
                // remove leading 55 if present
                if (d.length > 2 && d.substr(0,2) === '55') d = d.substr(2);
                if (d.length <= 2) return d;
                if (d.length <= 6) return '(' + d.substr(0,2) + ') ' + d.substr(2);
                if (d.length <= 10) return '(' + d.substr(0,2) + ') ' + d.substr(2, d.length-6) + '-' + d.substr(-4);
                return '(' + d.substr(0,2) + ') ' + d.substr(2,5) + '-' + d.substr(-4);
            }

            input.addEventListener('input', function(e){
                var pos = this.selectionStart;
                var before = this.value;
                this.value = formatBR(this.value);
                // attempt to restore caret position roughly
                if (this.value.length > before.length) pos += this.value.length - before.length;
                this.setSelectionRange(pos, pos);
            });

            // Normalize to digits before submit
            var form = input.closest('form');
            if (form) {
                form.addEventListener('submit', function(){
                    input.value = onlyDigits(input.value);
                });
            }
        })();
    </script>
</div>
<?= $this->endSection() ?>
