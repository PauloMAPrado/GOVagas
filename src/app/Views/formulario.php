<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Nova Vaga - GoVagas<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<?php include APPPATH . 'Views/layouts/vaga_form.php'; ?>
<style>
    .vidro-cadastro--vaga { max-width: 920px; padding: 1.5rem 1.25rem 2rem; }
    .vidro-cadastro--vaga .form-card { margin-bottom: 16px; }
    .vidro-cadastro--vaga .form-card:last-of-type { margin-bottom: 0; }
    .vaga-form-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }
    .vaga-form-topbar h1 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 700;
        color: #1a1a2e;
    }
    .vaga-form-topbar a {
        font-size: 0.88rem;
        color: #4f46e5;
        text-decoration: none;
        font-weight: 600;
    }
    .vaga-form-topbar a:hover { text-decoration: underline; }
    .empresa-info-footer {
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: center;
        gap: 14px;
    }
    .empresa-info-footer .link-perfil {
        font-size: 0.85rem;
        font-weight: 600;
        color: #4f46e5;
        text-decoration: none;
        white-space: nowrap;
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid rgba(79, 70, 229, 0.35);
        background: rgba(255, 255, 255, 0.6);
    }
    .empresa-info-footer .link-perfil:hover {
        background: rgba(79, 70, 229, 0.08);
    }
    @media (max-width: 640px) {
        .empresa-info-footer {
            grid-template-columns: auto 1fr;
        }
        .empresa-info-footer .link-perfil {
            grid-column: 1 / -1;
            text-align: center;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    helper('vaga');

    $empresaInfo = $empresa ?? [];
    $vagaEdicao = $vaga ?? [];
    $isEdit = ! empty($vagaEdicao['id']);
    $campo = static fn (string $key) => old($key, $vagaEdicao[$key] ?? '');

    $beneficiosPadrao = [
        'Vale Refeição', 'Vale Alimentação', 'Plano de Saúde', 'Plano Odontológico',
        'Vale Transporte', 'Home Office', 'Gympass', 'PLR', 'Seguro de Vida', 'Auxílio Creche',
    ];
    $beneficiosSalvos = array_map('trim', explode(',', (string) $campo('beneficios')));
    $outrosBeneficios = implode(', ', array_filter(
        $beneficiosSalvos,
        static fn ($b) => $b !== '' && ! in_array($b, $beneficiosPadrao, true)
    ));

    $estados = vaga_estados();
    $localizacaoOld = (string) $campo('localizacao');

    $formAction = $isEdit
        ? site_url('empresa/vagas/update/' . $vagaEdicao['id'])
        : site_url('empresa/vagas/salvar');
    $cidadeSalva = '';
    $estadoSalvo = '';
    if (preg_match('/^(.+?)\s*-\s*([A-Z]{2})$/', $localizacaoOld, $m)) {
        $cidadeSalva = trim($m[1]);
        $estadoSalvo = trim($m[2]);
    }
?>
<div class="vidro-cadastro vidro-cadastro--vaga">
    <div class="vaga-form-topbar">
        <h1><?= $isEdit ? 'Editar vaga' : 'Nova vaga' ?></h1>
        <a href="<?= site_url('empresa/vagas') ?>"><i class="fas fa-arrow-left"></i> Voltar às vagas</a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert error" style="margin-bottom: 12px;">
            <ul style="margin: 6px 0 0; padding-left: 18px;">
                <?php foreach (session()->getFlashdata('errors') as $erro): ?>
                    <li><?= esc($erro) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert error" style="margin-bottom: 12px;"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <form action="<?= $formAction ?>" method="post" id="form-vaga">
        <?= csrf_field() ?>
        <input type="hidden" name="localizacao" id="localizacao_hidden" value="<?= esc($localizacaoOld) ?>">
        <input type="hidden" name="beneficios" id="beneficios_hidden" value="<?= esc($campo('beneficios')) ?>">

        <div class="form-card">
            <h3>Informações básicas</h3>
            <div class="form-grid" style="grid-template-columns: 1fr;">
                <div class="form-field">
                    <label for="titulo">Título da vaga</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ex: Desenvolvedor Fullstack" required
                        value="<?= esc($campo('titulo')) ?>">
                </div>
            </div>
            <div class="form-grid cols-3" style="margin-top: 14px;">
                <div class="form-field">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Selecione</option>
                        <?php foreach (vaga_categorias() as $val => $label): ?>
                            <option value="<?= esc($val) ?>" <?= $campo('categoria') === $val ? 'selected' : '' ?>><?= esc($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label for="tipo_contrato">Tipo de contrato</label>
                    <select id="tipo_contrato" name="tipo_contrato" required>
                        <option value="">Selecione</option>
                        <?php foreach (vaga_tipos_contrato() as $tipo): ?>
                            <option value="<?= esc($tipo) ?>" <?= $campo('tipo_contrato') === $tipo ? 'selected' : '' ?>><?= esc($tipo) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label for="modalidade">Modalidade</label>
                    <select id="modalidade" name="modalidade" required>
                        <option value="">Selecione</option>
                        <?php foreach (vaga_modalidades() as $mod): ?>
                            <option value="<?= esc($mod) ?>" <?= $campo('modalidade') === $mod ? 'selected' : '' ?>><?= esc($mod) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3>Localização</h3>
            <div class="form-grid cols-2">
                <div class="form-field">
                    <label for="select_estado">Estado</label>
                    <select id="select_estado" required>
                        <option value="">Selecione o estado</option>
                        <?php foreach ($estados as $uf => $nome): ?>
                            <option value="<?= esc($uf) ?>" <?= $estadoSalvo === $uf ? 'selected' : '' ?>><?= esc($uf) ?> — <?= esc($nome) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label for="input_cidade">Cidade</label>
                    <input type="text" id="input_cidade" placeholder="Ex: São Paulo" required
                        value="<?= esc($cidadeSalva) ?>">
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3>Detalhes</h3>
            <div class="form-grid cols-2">
                <div class="form-field">
                    <label for="faixa_salarial">Faixa salarial</label>
                    <input type="text" id="faixa_salarial" name="faixa_salarial" placeholder="Ex: R$ 3.000 - R$ 5.000"
                        value="<?= esc($campo('faixa_salarial')) ?>">
                </div>
                <div class="form-field">
                    <label for="quantidade">Quantidade de vagas</label>
                    <input type="number" id="quantidade" name="quantidade" min="1" placeholder="Ex: 2" required
                        value="<?= esc($campo('quantidade')) ?>">
                </div>
                <div class="form-field" style="grid-column: 1 / -1;">
                    <label for="data_encerramento">Data de encerramento</label>
                    <input type="date" id="data_encerramento" name="data_encerramento"
                        value="<?= esc($campo('data_encerramento')) ?>">
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3>Benefícios</h3>
            <p style="margin: 0 0 12px; font-size: 0.85rem; color: #666;">Marque os benefícios oferecidos:</p>
            <div class="beneficios-grid" id="beneficios-grid">
                <?php foreach ($beneficiosPadrao as $b): ?>
                    <label class="beneficio-chip">
                        <input type="checkbox" value="<?= esc($b) ?>" <?= in_array($b, $beneficiosSalvos, true) ? 'checked' : '' ?>>
                        <?= esc($b) ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="form-field" style="margin-top: 14px;">
                <label for="outros_beneficios">Outros benefícios</label>
                <input type="text" id="outros_beneficios" placeholder="Ex: Bônus anual, Stock options"
                    value="<?= esc($outrosBeneficios) ?>">
            </div>
        </div>

        <div class="form-card">
            <h3>Descrição</h3>
            <div class="form-field">
                <label for="descricao">Descrição da vaga</label>
                <textarea id="descricao" name="descricao" placeholder="Responsabilidades, requisitos e diferenciais..." required><?= esc($campo('descricao')) ?></textarea>
            </div>
        </div>

        <div class="form-card">
            <h3>Empresa responsável</h3>
            <div class="empresa-info empresa-info-footer">
                <div class="empresa-avatar"><i class="fas fa-building"></i></div>
                <div class="empresa-info-text">
                    <strong><?= esc($empresaInfo['nome'] ?? 'Empresa') ?></strong>
                    <?php if (! empty($empresaInfo['email'])): ?>
                        <p><i class="fas fa-envelope" style="font-size:0.75rem;margin-right:4px;"></i><?= esc($empresaInfo['email']) ?></p>
                    <?php endif; ?>
                    <?php if (! empty($empresaInfo['whatsapp'])): ?>
                        <p><i class="fab fa-whatsapp" style="font-size:0.75rem;margin-right:4px;"></i><?= esc($empresaInfo['whatsapp']) ?></p>
                    <?php endif; ?>
                </div>
                <a href="<?= base_url('empresa/perfil') ?>" class="link-perfil">Editar perfil</a>
            </div>
        </div>

        <div class="form-actions" style="justify-content: center; margin-top: 8px;">
            <button type="submit" class="botao-vidro" style="min-width: 220px;">
                <i class="fas fa-save"></i> <?= $isEdit ? 'Salvar alterações' : 'Publicar vaga' ?>
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
    var selEstado = document.getElementById('select_estado');
    var inpCidade = document.getElementById('input_cidade');
    var hiddenLoc = document.getElementById('localizacao_hidden');
    var hiddenBen = document.getElementById('beneficios_hidden');
    var outrosInp = document.getElementById('outros_beneficios');
    var form = document.getElementById('form-vaga');

    function atualizarLocalizacao() {
        var uf = selEstado ? selEstado.value : '';
        var cidade = inpCidade ? inpCidade.value.trim() : '';
        hiddenLoc.value = cidade && uf ? cidade + ' - ' + uf : (cidade || uf);
    }

    function atualizarBeneficios() {
        var marcados = Array.from(document.querySelectorAll('#beneficios-grid input:checked'))
            .map(function (el) { return el.value.trim(); });
        var outros = outrosInp
            ? outrosInp.value.split(',').map(function (s) { return s.trim(); }).filter(Boolean)
            : [];
        hiddenBen.value = marcados.concat(outros).join(', ');
    }

    if (selEstado) selEstado.addEventListener('change', atualizarLocalizacao);
    if (inpCidade) inpCidade.addEventListener('input', atualizarLocalizacao);
    document.querySelectorAll('#beneficios-grid input').forEach(function (cb) {
        cb.addEventListener('change', atualizarBeneficios);
    });
    if (outrosInp) outrosInp.addEventListener('input', atualizarBeneficios);

    if (form) {
        form.addEventListener('submit', function () {
            atualizarLocalizacao();
            atualizarBeneficios();
        });
        atualizarBeneficios();
        if (hiddenLoc.value) atualizarLocalizacao();
    }
})();
</script>
<?= $this->endSection() ?>
