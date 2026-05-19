<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>GoVagas - Vagas Sugeridas<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.sugestoes-page {
    max-width: 980px;
    margin: 0 auto;
}

.sugestoes-hero {
    text-align: center;
    margin-bottom: 28px;
}

.sugestoes-hero h1 {
    margin: 0 0 8px;
    font-size: clamp(1.6rem, 3vw, 2.1rem);
    color: #1a1a2e;
    font-weight: 700;
}

.sugestoes-hero p {
    margin: 0;
    color: #4a5568;
    font-size: 1rem;
    max-width: 560px;
    margin-inline: auto;
}

.perfil-vidro {
    background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(248,250,255,0.92));
    border: 1px solid rgba(255,255,255,0.5);
    border-radius: 16px;
    padding: 22px 24px;
    box-shadow: 0 8px 28px rgba(31, 38, 135, 0.12);
    margin-bottom: 24px;
}

.perfil-vidro-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.perfil-vidro-header h2 {
    margin: 0;
    font-size: 1.1rem;
    color: #2b4f9a;
}

.perfil-vidro-header span {
    display: block;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 400;
    margin-top: 4px;
}

.btn-perfil-editar {
    border: 1px solid rgba(43, 79, 154, 0.25);
    background: rgba(207, 224, 255, 0.5);
    color: #1b3a7a;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: not-allowed;
    opacity: 0.85;
}

.perfil-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.perfil-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 999px;
    background: #eef3ff;
    color: #1e3a6e;
    font-size: 0.82rem;
    font-weight: 600;
}

.perfil-chip i {
    color: #3b5bdb;
    font-size: 0.75rem;
}

.sugestoes-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.sugestoes-count {
    font-weight: 600;
    color: #334155;
}

.sort-pills {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.sort-pill {
    border: 1px solid rgba(0,0,0,0.08);
    background: rgba(255,255,255,0.75);
    color: #475569;
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, color 0.2s, border-color 0.2s;
}

.sort-pill:hover {
    background: #fff;
    border-color: rgba(43, 79, 154, 0.3);
}

.sort-pill.ativo {
    background: linear-gradient(180deg, #9fbaf6, #cfe0ff);
    color: #1b3a7a;
    border-color: transparent;
}

.sugestoes-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.sugestao-card {
    background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(250,252,255,0.95));
    border-radius: 14px;
    padding: 20px 22px;
    box-shadow: 0 6px 20px rgba(16, 24, 40, 0.1);
    border: 1px solid rgba(255,255,255,0.6);
    border-left: 4px solid #9fbaf6;
}

.sugestao-card.alta { border-left-color: #22c55e; }
.sugestao-card.media { border-left-color: #3b82f6; }

.sugestao-card-top {
    display: flex;
    gap: 16px;
    align-items: flex-start;
    margin-bottom: 14px;
}

.compat-ring {
    flex: 0 0 72px;
    width: 72px;
    height: 72px;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: conic-gradient(#3b82f6 calc(var(--compat) * 1%), #e8eef9 0);
    position: relative;
}

.compat-ring::after {
    content: '';
    position: absolute;
    inset: 7px;
    border-radius: 50%;
    background: #fff;
}

.compat-ring.alta { background: conic-gradient(#22c55e calc(var(--compat) * 1%), #e8f7ef 0); }
.compat-ring.media { background: conic-gradient(#3b82f6 calc(var(--compat) * 1%), #e8eef9 0); }

.compat-value,
.compat-label {
    position: relative;
    z-index: 1;
    line-height: 1.1;
}

.compat-value {
    font-size: 1rem;
    font-weight: 700;
    color: #1e3a6e;
}

.compat-label {
    font-size: 0.65rem;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.04em;
}

.sugestao-empresa {
    display: flex;
    gap: 12px;
    flex: 1;
    min-width: 0;
}

.sugestao-empresa .empresa-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #dde4f5;
    flex: 0 0 52px;
    border: 3px solid rgba(255,255,255,0.8);
}

.sugestao-titulo {
    margin: 0 0 4px;
    font-size: 1.15rem;
    color: #1a1a2e;
}

.sugestao-empresa-nome {
    margin: 0;
    font-size: 0.88rem;
    color: #64748b;
}

.sugestao-meta {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px 16px;
    margin-bottom: 12px;
    font-size: 0.88rem;
    color: #475569;
}

.sugestao-meta span {
    display: flex;
    align-items: center;
    gap: 8px;
}

.sugestao-meta i {
    color: #2b4f9a;
    width: 16px;
    text-align: center;
}

.sugestao-motivos {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.motivos-label {
    font-size: 0.78rem;
    font-weight: 600;
    color: #64748b;
}

.motivo-tag {
    font-size: 0.75rem;
    padding: 4px 10px;
    border-radius: 999px;
    background: #f0f4ff;
    color: #334155;
    border: 1px solid rgba(59, 91, 219, 0.15);
}

.sugestao-desc {
    margin: 0 0 16px;
    color: #334155;
    font-size: 0.92rem;
    line-height: 1.5;
}

.sugestao-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-sugestao {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 24px;
    font-size: 0.88rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.btn-sugestao.primario {
    background: linear-gradient(180deg, #9fbaf6, #cfe0ff);
    color: #1b3a7a;
    box-shadow: 0 4px 12px rgba(100, 140, 220, 0.2);
}

.btn-sugestao.secundario {
    background: rgba(255,255,255,0.9);
    color: #64748b;
    border: 1px solid rgba(0,0,0,0.1);
}

.sugestoes-empty {
    text-align: center;
    padding: 48px 24px;
    background: rgba(255,255,255,0.85);
    border-radius: 14px;
    color: #64748b;
}

.sugestoes-empty i {
    font-size: 2.5rem;
    color: #94a3b8;
    margin-bottom: 12px;
}

.sugestoes-cta-home {
    text-align: center;
    margin-top: 28px;
}

.sugestoes-cta-home a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #2b4f9a;
    font-weight: 600;
    text-decoration: none;
}

@media (max-width: 600px) {
    .sugestao-card-top { flex-direction: column; align-items: center; text-align: center; }
    .sugestao-empresa { flex-direction: column; align-items: center; }
    .sugestao-meta { grid-template-columns: 1fr; }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="sugestoes-page">

    <header class="sugestoes-hero">
        <h1><i class="fas fa-wand-magic-sparkles" style="color:#3b5bdb;"></i> Vagas Sugeridas</h1>
        <p>Oportunidades selecionadas com base no seu perfil de busca. Quanto maior o match, mais alinhada a vaga está com você.</p>
    </header>

    <?php if (! empty($perfil)): ?>
    <section class="perfil-vidro" aria-label="Perfil de busca">
        <div class="perfil-vidro-header">
            <div>
                <h2>Seu perfil de busca</h2>
                <span>Preferências usadas para calcular o match com cada vaga.</span>
            </div>
            <button type="button" class="btn-perfil-editar" disabled title="Em breve">
                <i class="fas fa-sliders"></i> Ajustar preferências
            </button>
        </div>
        <div class="perfil-chips">
            <span class="perfil-chip"><i class="fas fa-briefcase"></i> <?= esc($perfil['area']) ?></span>
            <span class="perfil-chip"><i class="fas fa-laptop-house"></i> <?= esc($perfil['modalidade']) ?></span>
            <span class="perfil-chip"><i class="fas fa-file-contract"></i> <?= esc($perfil['contrato']) ?></span>
            <span class="perfil-chip"><i class="fas fa-map-marker-alt"></i> <?= esc($perfil['localizacao']) ?></span>
            <span class="perfil-chip"><i class="fas fa-layer-group"></i> <?= esc($perfil['nivel']) ?></span>
        </div>
    </section>
    <?php endif; ?>

    <div class="sugestoes-toolbar">
        <p class="sugestoes-count"><?= (int) $total ?> <?= $total === 1 ? 'vaga sugerida' : 'vagas sugeridas' ?></p>
        <div class="sort-pills" role="tablist" aria-label="Ordenar sugestões">
            <button type="button" class="sort-pill ativo" data-sort="compat">Maior compatibilidade</button>
            <button type="button" class="sort-pill" data-sort="recente">Mais recentes</button>
            <button type="button" class="sort-pill" data-sort="salario">Salário</button>
        </div>
    </div>

    <?php if (empty($vagas)): ?>
        <div class="sugestoes-empty">
            <div><i class="fas fa-search"></i></div>
            <p>Nenhuma sugestão disponível no momento.</p>
            <p>Tente explorar todas as vagas na página inicial.</p>
        </div>
    <?php else: ?>
        <div class="sugestoes-grid" id="sugestoesGrid">
            <?php foreach ($vagas as $vaga): ?>
                <?= view('partials/vaga_sugerida_card', ['vaga' => $vaga]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="sugestoes-cta-home">
        <a href="<?= base_url('/') ?>"><i class="fas fa-arrow-left"></i> Ver todas as vagas</a>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
    const grid = document.getElementById('sugestoesGrid');
    const pills = document.querySelectorAll('.sort-pill');
    if (!grid || !pills.length) return;

    function ordenarCards(sort) {
        const cards = Array.from(grid.querySelectorAll('.sugestao-card'));

        cards.sort(function (a, b) {
            if (sort === 'compat') {
                return (parseInt(b.dataset.compat, 10) || 0) - (parseInt(a.dataset.compat, 10) || 0);
            }
            if (sort === 'recente') {
                return (parseInt(b.dataset.created, 10) || 0) - (parseInt(a.dataset.created, 10) || 0);
            }
            if (sort === 'salario') {
                return (parseInt(b.dataset.salario, 10) || 0) - (parseInt(a.dataset.salario, 10) || 0);
            }
            return 0;
        });

        cards.forEach(function (card) { grid.appendChild(card); });
    }

    pills.forEach(function (pill) {
        pill.addEventListener('click', function () {
            pills.forEach(function (p) { p.classList.remove('ativo'); });
            pill.classList.add('ativo');
            ordenarCards(pill.dataset.sort);
        });
    });
})();
</script>
<?= $this->endSection() ?>
