<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Cadastro de Vaga - GoVagas<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<?php include APPPATH . 'Views/layouts/dashboard.php'; ?>
<?php include APPPATH . 'Views/layouts/vaga_form.php'; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    $isOwner    = isset($isOwner) && $isOwner;
    $readonly   = isset($readonly) && $readonly;
    $isEdit     = isset($vaga['id']) && $vaga['id'] > 0 && $isOwner;
    $formAction = $isEdit ? site_url('empresa/vagas/update/' . $vaga['id']) : site_url('empresa/vagas/salvar');

    // Empresa: na criação vem de $empresa, na edição/visualização vem de $vaga['empresa']
    $empresaInfo = $vaga['empresa'] ?? $empresa ?? [];

    $beneficiosPadrao = ['Vale Refeição', 'Vale Alimentação', 'Plano de Saúde', 'Plano Odontológico', 'Vale Transporte', 'Home Office', 'Gympass', 'PLR', 'Seguro de Vida', 'Auxílio Creche'];

    // Benefícios já selecionados (salvo como string separada por vírgula)
    $beneficiosSalvos = array_map('trim', explode(',', $vaga['beneficios'] ?? ''));

    // Benefícios "outros" = os que estão salvos mas não são padrão
    $outrosBeneficios = implode(', ', array_filter($beneficiosSalvos, fn($b) => $b !== '' && !in_array($b, $beneficiosPadrao)));

    $estados = [
        'AC'=>'Acre','AL'=>'Alagoas','AP'=>'Amapá','AM'=>'Amazonas','BA'=>'Bahia',
        'CE'=>'Ceará','DF'=>'Distrito Federal','ES'=>'Espírito Santo','GO'=>'Goiás',
        'MA'=>'Maranhão','MT'=>'Mato Grosso','MS'=>'Mato Grosso do Sul','MG'=>'Minas Gerais',
        'PA'=>'Pará','PB'=>'Paraíba','PR'=>'Paraná','PE'=>'Pernambuco','PI'=>'Piauí',
        'RJ'=>'Rio de Janeiro','RN'=>'Rio Grande do Norte','RS'=>'Rio Grande do Sul',
        'RO'=>'Rondônia','RR'=>'Roraima','SC'=>'Santa Catarina','SP'=>'São Paulo',
        'SE'=>'Sergipe','TO'=>'Tocantins',
    ];

    // Extrair estado e cidade da localização salva "Cidade - UF"
    $localizacaoSalva = $vaga['localizacao'] ?? '';
    $cidadeSalva = ''; $estadoSalvo = '';
    if (preg_match('/^(.+?)\s*-\s*([A-Z]{2})$/', $localizacaoSalva, $m)) {
        $cidadeSalva  = trim($m[1]);
        $estadoSalvo  = trim($m[2]);
    }
?>
<div class="dashboard-wrapper">

    <?php if (session()->has('errors')): ?>
        <div class="alert error">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 6px 0 0; padding-left: 18px;">
                <?php foreach (session('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if (session()->has('error')): ?>
        <div class="alert error"><i class="fas fa-exclamation-circle"></i> <?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div class="vagas-header">
        <h2><?= $isEdit ? 'Editar Vaga' : ($readonly ? 'Detalhes da Vaga' : 'Nova Vaga') ?></h2>
        <a href="<?= site_url('empresa/vagas') ?>" class="btn-action secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <form action="<?= $formAction ?>" method="post" id="form-vaga">
        <?= csrf_field() ?>
        <!-- campo hidden que recebe o valor final de localização -->
        <input type="hidden" name="localizacao" id="localizacao_hidden" value="<?= esc($localizacaoSalva) ?>">
        <!-- campo hidden que recebe os benefícios montados -->
        <input type="hidden" name="beneficios" id="beneficios_hidden" value="<?= esc($vaga['beneficios'] ?? '') ?>">

        <div class="form-card">
            <h3>Informações Básicas</h3>
            <div class="form-grid" style="grid-template-columns: 1fr;">
                <div class="form-field">
                    <label>Título da Vaga</label>
                    <input type="text" name="titulo" placeholder="Ex: Desenvolvedor Fullstack" required
                        value="<?= esc($vaga['titulo'] ?? '') ?>" <?= $readonly ? 'readonly' : '' ?>>
                </div>
            </div>
            <div class="form-grid cols-3" style="margin-top: 14px;">
                <div class="form-field">
                    <label>Categoria</label>
                    <select name="categoria" <?= $readonly ? 'disabled' : '' ?>>
                        <option value="">Selecione</option>
                        <?php foreach (['tecnologia' => 'Tecnologia', 'administrativo' => 'Administrativo', 'vendas' => 'Vendas', 'outros' => 'Outros'] as $val => $label): ?>
                            <option value="<?= $val ?>" <?= ($vaga['categoria'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label>Tipo de Contrato</label>
                    <select name="tipo_contrato" <?= $readonly ? 'disabled' : '' ?>>
                        <option value="">Selecione</option>
                        <?php foreach (['CLT', 'PJ', 'Estágio', 'Temporário'] as $opt): ?>
                            <option value="<?= $opt ?>" <?= ($vaga['tipo_contrato'] ?? '') === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label>Modalidade</label>
                    <select name="modalidade" <?= $readonly ? 'disabled' : '' ?>>
                        <option value="">Selecione</option>
                        <?php foreach (['Presencial', 'Remoto', 'Híbrido'] as $opt): ?>
                            <option value="<?= $opt ?>" <?= ($vaga['modalidade'] ?? '') === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3>Localização</h3>
            <div class="form-grid cols-2">
                <div class="form-field">
                    <label>Estado</label>
                    <select id="select_estado" <?= $readonly ? 'disabled' : '' ?>>
                        <option value="">Selecione o estado</option>
                        <?php foreach ($estados as $uf => $nome): ?>
                            <option value="<?= $uf ?>" <?= $estadoSalvo === $uf ? 'selected' : '' ?>><?= $uf ?> — <?= $nome ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label>Cidade</label>
                    <input type="text" id="input_cidade" placeholder="Ex: São Paulo"
                        value="<?= esc($cidadeSalva) ?>" <?= $readonly ? 'readonly' : '' ?>>
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3>Detalhes</h3>
            <div class="form-grid cols-2">
                <div class="form-field">
                    <label>Faixa Salarial</label>
                    <input type="text" name="faixa_salarial" placeholder="Ex: R$ 3.000 - R$ 5.000"
                        value="<?= esc($vaga['faixa_salarial'] ?? '') ?>" <?= $readonly ? 'readonly' : '' ?>>
                </div>
                <div class="form-field">
                    <label>Quantidade de Vagas</label>
                    <input type="number" name="quantidade" min="1" placeholder="Ex: 2"
                        value="<?= esc($vaga['quantidade'] ?? '') ?>" <?= $readonly ? 'readonly' : '' ?>>
                </div>
                <div class="form-field" style="grid-column: 1 / -1;">
                    <label>Data de Encerramento</label>
                    <input type="date" name="data_encerramento"
                        value="<?= esc($vaga['data_encerramento'] ?? '') ?>" <?= $readonly ? 'readonly' : '' ?>>
                </div>
                <div class="form-field" style="grid-column: 1 / -1;">
                    <label>WhatsApp para Contato</label>
                    <input type="text" id="whatsapp_contato" placeholder="Ex: (11) 99999-9999"
                        value="<?= esc($vaga['whatsapp'] ?? ($empresaInfo['whatsapp'] ?? '')) ?>" <?= $readonly ? 'readonly' : '' ?>>
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3>Benefícios</h3>
            <div class="beneficios-grid" id="beneficios-grid">
                <?php foreach ($beneficiosPadrao as $b): ?>
                    <label class="beneficio-chip <?= $readonly ? 'disabled' : '' ?>">
                        <input type="checkbox" value="<?= esc($b) ?>"
                            <?= in_array($b, $beneficiosSalvos) ? 'checked' : '' ?>
                            <?= $readonly ? 'disabled' : '' ?>>
                        <?= esc($b) ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <?php if (! $readonly): ?>
                <div class="form-field" style="margin-top: 14px;">
                    <label>Outros benefícios</label>
                    <input type="text" id="outros_beneficios" placeholder="Ex: Bônus anual, Stock options"
                        value="<?= esc($outrosBeneficios) ?>">
                </div>
            <?php elseif ($outrosBeneficios): ?>
                <p style="margin: 12px 0 0; font-size: 0.88rem; color: #555;">Outros: <?= esc($outrosBeneficios) ?></p>
            <?php endif; ?>
        </div>

        <div class="form-card">
            <h3>Descrição</h3>
            <div class="form-field">
                <textarea name="descricao" placeholder="Descreva as responsabilidades, requisitos e diferenciais da vaga..." <?= $readonly ? 'readonly' : '' ?>><?= esc($vaga['descricao'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="form-card">
            <h3>Empresa Responsável</h3>
            <div class="empresa-info">
                <div class="empresa-avatar"><i class="fas fa-building"></i></div>
                <div class="empresa-info-text">
                    <strong><?= esc($empresaInfo['nome'] ?? 'Nome da Empresa') ?></strong>
                    <?php if (!empty($empresaInfo['email'])): ?>
                        <p><i class="fas fa-envelope" style="font-size:0.75rem;margin-right:4px;"></i><?= esc($empresaInfo['email']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($empresaInfo['whatsapp'])): ?>
                        <p><i class="fab fa-whatsapp" style="font-size:0.75rem;margin-right:4px;"></i><?= esc($empresaInfo['whatsapp']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (! $readonly): ?>
            <div class="form-actions">
                <a href="<?= site_url('empresa/vagas') ?>" class="btn-action secondary">Cancelar</a>
                <button type="submit" id="btn-save" class="btn-action primary">
                    <i class="fas fa-save"></i> <?= $isEdit ? 'Atualizar Vaga' : 'Publicar Vaga' ?>
                </button>
            </div>
        <?php elseif ($isOwner): ?>
            <div class="form-actions">
                <button type="button" id="btn-edit" class="btn-action primary">
                    <i class="fas fa-pen"></i> Editar Vaga
                </button>
            </div>
        <?php endif; ?>
    </form>
</div>

<script>
(function () {
    // ── Localização ──────────────────────────────────────────────────────────
    var selEstado  = document.getElementById('select_estado');
    var inpCidade  = document.getElementById('input_cidade');
    var hiddenLoc  = document.getElementById('localizacao_hidden');

    function atualizarLocalizacao() {
        var uf     = selEstado ? selEstado.value : '';
        var cidade = inpCidade ? inpCidade.value.trim() : '';
        hiddenLoc.value = cidade && uf ? cidade + ' - ' + uf : (cidade || uf);
    }

    if (selEstado) selEstado.addEventListener('change', atualizarLocalizacao);
    if (inpCidade) inpCidade.addEventListener('input', atualizarLocalizacao);

    // ── Benefícios ───────────────────────────────────────────────────────────
    var hiddenBen = document.getElementById('beneficios_hidden');
    var outrosInp = document.getElementById('outros_beneficios');

    function atualizarBeneficios() {
        var marcados = Array.from(document.querySelectorAll('#beneficios-grid input:checked')).map(function(el){ return el.value.trim(); });
        var outros   = outrosInp ? outrosInp.value.split(',').map(function(s){ return s.trim(); }).filter(Boolean) : [];
        hiddenBen.value = marcados.concat(outros).join(', ');
    }

    document.querySelectorAll('#beneficios-grid input').forEach(function(cb){
        cb.addEventListener('change', atualizarBeneficios);
    });
    if (outrosInp) outrosInp.addEventListener('input', atualizarBeneficios);

    // ── Submit: montar campos antes de enviar ────────────────────────────────
    var form = document.getElementById('form-vaga');
    if (form) {
        form.addEventListener('submit', function () {
            atualizarLocalizacao();
            atualizarBeneficios();
            // normalizar whatsapp
            var wp = document.getElementById('whatsapp_contato');
            if (wp) wp.value = wp.value.replace(/\D/g, '');
        });
    }

    // ── Máscara WhatsApp ─────────────────────────────────────────────────────
    var wp = document.getElementById('whatsapp_contato');
    if (wp) {
        wp.addEventListener('input', function () {
            var d = this.value.replace(/\D/g, '').replace(/^55/, '');
            if (d.length <= 2) this.value = d;
            else if (d.length <= 7) this.value = '(' + d.slice(0,2) + ') ' + d.slice(2);
            else this.value = '(' + d.slice(0,2) + ') ' + d.slice(2,7) + '-' + d.slice(7,11);
        });
    }

    // ── Botão Editar (modo readonly → edição) ────────────────────────────────
    var btnEdit = document.getElementById('btn-edit');
    if (btnEdit) {
        btnEdit.addEventListener('click', function () {
            form.querySelectorAll('input, select, textarea').forEach(function (el) {
                el.removeAttribute('readonly');
                el.removeAttribute('disabled');
            });
            document.querySelectorAll('.beneficio-chip').forEach(function(c){ c.classList.remove('disabled'); });
            btnEdit.style.display = 'none';
            var btnSave = document.getElementById('btn-save');
            if (btnSave) {
                btnSave.style.display = '';
            } else {
                btnSave = document.createElement('button');
                btnSave.type = 'submit';
                btnSave.id = 'btn-save';
                btnSave.className = 'btn-action primary';
                btnSave.innerHTML = '<i class="fas fa-save"></i> Atualizar Vaga';
                btnEdit.parentNode.appendChild(btnSave);
            }
        });
    }
})();
</script>
<?= $this->endSection() ?>
