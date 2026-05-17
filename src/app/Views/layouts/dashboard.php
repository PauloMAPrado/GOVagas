<?php /** Estilos do Dashboard da Empresa - GoVagas */ ?>
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

    .alert {
        padding: 12px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 500;
        font-size: 0.95rem;
    }
    .alert.success { background: rgba(34,197,94,0.15); color: #166534; border: 1px solid rgba(34,197,94,0.3); }
    .alert.error   { background: rgba(239,68,68,0.12);  color: #991b1b; border: 1px solid rgba(239,68,68,0.25); }

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

    .vagas-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }

    .vagas-header h2 {
        font-size: 1.6rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }

    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid rgba(0,0,0,0.1);
        background: rgba(255,255,255,0.4);
        color: #555;
        text-decoration: none;
        transition: all 0.2s;
    }

    .filter-tab:hover,
    .filter-tab.active { background: rgba(79,70,229,0.85); color: #fff; border-color: transparent; }

    @media (max-width: 640px) {
        .stats-grid { grid-template-columns: 1fr; }
        .table-glass thead th:nth-child(2),
        .table-glass tbody td:nth-child(2) { display: none; }
    }
</style>
