<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Dashboard - <?= esc(session()->get('empresa_nome')) ?><?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .dashboard-wrapper {
        max-width: 960px;
        margin: 0 auto;
    }

    .dashboard-header {
        margin-bottom: 28px;
    }

    .dashboard-header h2 {
        font-size: 1.6rem;
        font-weight: 700;
        margin: 0 0 4px;
        color: #1a1a2e;
    }

    .dashboard-header p {
        margin: 0;
        color: #555;
        font-size: 0.95rem;
    }

    /* ── Alertas ── */
    .alert {
        padding: 12px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 500;
        font-size: 0.95rem;
    }
    .alert.success { background: rgba(34,197,94,0.15); color: #166534; border: 1px solid rgba(34,197,94,0.3); }
    .alert.error   { background: rgba(239,68,68,0.12);  color: #991b1b; border: 1px solid rgba(239,68,68,0.25); }

    /* ── Cards de estatísticas ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: rgba(255,255,255,0.55);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 14px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .stat-icon.total   { background: rgba(99,102,241,0.15); color: #4f46e5; }
    .stat-icon.ativo   { background: rgba(34,197,94,0.15);  color: #16a34a; }
    .stat-icon.pausado { background: rgba(234,179,8,0.15);  color: #b45309; }

    .stat-info .num {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        color: #1a1a2e;
    }

    .stat-info .label {
        font-size: 0.82rem;
        color: #666;
        margin-top: 2px;
    }

    /* ── Ações rápidas ── */
    .quick-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid transparent;
    }

    .btn-action.primary {
        background: rgba(79,70,229,0.85);
        color: #fff;
        box-shadow: 0 4px 12px rgba(79,70,229,0.3);
    }

    .btn-action.primary:hover { background: rgba(79,70,229,1); }

    .btn-action.secondary {
        background: rgba(255,255,255,0.5);
        backdrop-filter: blur(8px);
        color: #333;
        border-color: rgba(255,255,255,0.5);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .btn-action.secondary:hover { background: rgba(255,255,255,0.75); }

    /* ── Tabela ── */
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0 0 12px;
    }

    .table-glass {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255,255,255,0.5);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.4);
    }

    .table-glass thead th {
        background: rgba(255,255,255,0.3);
        padding: 12px 16px;
        text-align: left;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #555;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }

    .table-glass tbody td {
        padding: 13px 16px;
        font-size: 0.9rem;
        color: #333;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        vertical-align: middle;
    }

    .table-glass tbody tr:last-child td { border-bottom: none; }
    .table-glass tbody tr:hover td { background: rgba(255,255,255,0.3); }

    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .badge.ativo   { background: rgba(34,197,94,0.15);  color: #16a34a; }
    .badge.pausado { background: rgba(234,179,8,0.15);  color: #b45309; }

    .table-actions { display: flex; gap: 8px; align-items: center; }

    .btn-sm {
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-sm.pausar { background: rgba(234,179,8,0.15);  color: #b45309; }
    .btn-sm.ativar { background: rgba(34,197,94,0.15);  color: #16a34a; }
    .btn-sm.editar { background: rgba(99,102,241,0.12); color: #4f46e5; }
    .btn-sm:hover  { filter: brightness(0.9); }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #888;
    }

    .empty-state i { font-size: 2.5rem; margin-bottom: 12px; display: block; opacity: 0.4; }

    /* ── Responsivo ── */
    @media (max-width: 640px) {
        .stats-grid { grid-template-columns: 1fr; }
        .table-glass thead th:nth-child(2),
        .table-glass tbody td:nth-child(2) { display: none; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-wrapper">

    <?php if (session()->getFlashdata('status')): ?>
        <div class="alert success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('status') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert error"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="dashboard-header">
        <h2>Olá, <?= esc($empresa['nome']) ?>!</h2>
        <p>Gerencie suas vagas e acompanhe o desempenho da sua empresa.</p>
    </div>

    <?php
        $total   = count($vagas);
        $ativos  = count(array_filter($vagas, fn($v) => $v['status'] === 'ativo'));
        $pausados = $total - $ativos;
    ?>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total"><i class="fas fa-briefcase"></i></div>
            <div class="stat-info">
                <div class="num"><?= $total ?></div>
                <div class="label">Total de vagas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ativo"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="num"><?= $ativos ?></div>
                <div class="label">Vagas ativas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pausado"><i class="fas fa-pause-circle"></i></div>
            <div class="stat-info">
                <div class="num"><?= $pausados ?></div>
                <div class="label">Vagas pausadas</div>
            </div>
        </div>
    </div>

    <div class="quick-actions">
        <a href="/empresa/vagas/nova" class="btn-action primary"><i class="fas fa-plus"></i> Nova Vaga</a>
        <a href="/empresa/vagas"      class="btn-action secondary"><i class="fas fa-list"></i> Gerenciar Vagas</a>
        <a href="/empresa/perfil"     class="btn-action secondary"><i class="fas fa-user-edit"></i> Editar Perfil</a>
    </div>

    <p class="section-title">Vagas recentes</p>

    <table class="table-glass">
        <thead>
            <tr>
                <th>Título</th>
                <th>Localização</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vagas)): ?>
                <?php foreach (array_slice($vagas, 0, 5) as $v): ?>
                <tr>
                    <td><?= esc($v['titulo']) ?></td>
                    <td><?= esc($v['localizacao']) ?></td>
                    <td>
                        <span class="badge <?= $v['status'] ?>">
                            <?= $v['status'] === 'ativo' ? 'Ativa' : 'Pausada' ?>
                        </span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="/empresa/vagas/toggle/<?= $v['id'] ?>" class="btn-sm <?= $v['status'] === 'ativo' ? 'pausar' : 'ativar' ?>">
                                <?= $v['status'] === 'ativo' ? 'Pausar' : 'Ativar' ?>
                            </a>
                            <a href="/empresa/vagas/<?= $v['id'] ?>" class="btn-sm editar">Editar</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            Nenhuma vaga cadastrada ainda.<br>
                            <a href="/empresa/vagas/nova" class="btn-action primary" style="margin-top:16px; display:inline-flex;">+ Criar primeira vaga</a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
<?= $this->endSection() ?>
