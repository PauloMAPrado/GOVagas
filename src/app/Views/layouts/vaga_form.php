<?php /** Estilos do Formulário de Vaga - GoVagas */ ?>
<style>
    .form-card {
        background: rgba(255,255,255,0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 14px;
        padding: 28px 32px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    .form-card h3 {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #555;
        margin: 0 0 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }

    .form-grid { display: grid; gap: 14px; }
    .form-grid.cols-2 { grid-template-columns: 1fr 1fr; }
    .form-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }

    .form-field { display: flex; flex-direction: column; gap: 6px; }

    .form-field label { font-size: 0.82rem; font-weight: 600; color: #444; }

    .form-field input,
    .form-field select,
    .form-field textarea {
        background: rgba(255,255,255,0.7);
        border: 1px solid rgba(0,0,0,0.12);
        border-radius: 8px;
        padding: 9px 14px;
        font-size: 0.9rem;
        font-family: inherit;
        color: #1a1a2e;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }

    .form-field input:focus,
    .form-field select:focus,
    .form-field textarea:focus {
        border-color: rgba(79,70,229,0.5);
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
    }

    .form-field input[readonly],
    .form-field select[disabled],
    .form-field textarea[readonly] {
        background: rgba(255,255,255,0.35);
        color: #666;
        cursor: default;
    }

    .form-field textarea { resize: vertical; min-height: 160px; }

    .beneficios-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .beneficio-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.12);
        background: rgba(255,255,255,0.6);
        font-size: 0.85rem;
        color: #444;
        cursor: pointer;
        transition: all 0.2s;
        user-select: none;
    }

    .beneficio-chip input[type="checkbox"] { display: none; }

    .beneficio-chip:has(input:checked) {
        background: rgba(79,70,229,0.12);
        border-color: rgba(79,70,229,0.4);
        color: #4f46e5;
        font-weight: 600;
    }

    .beneficio-chip.disabled { opacity: 0.5; cursor: default; pointer-events: none; }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 8px;
    }

    .empresa-info {
        display: flex;
        align-items: center;
        gap: 14px;
        background: rgba(255,255,255,0.4);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 10px;
        padding: 14px 16px;
    }

    .empresa-avatar {
        width: 48px; height: 48px;
        border-radius: 50%;
        background: rgba(99,102,241,0.15);
        display: flex; align-items: center; justify-content: center;
        color: #4f46e5; font-size: 1.2rem; flex-shrink: 0;
    }

    .empresa-info-text p { margin: 0; font-size: 0.85rem; color: #555; }
    .empresa-info-text strong { font-size: 0.95rem; color: #1a1a2e; }

    @media (max-width: 640px) {
        .form-grid.cols-2,
        .form-grid.cols-3 { grid-template-columns: 1fr; }
        .form-card { padding: 20px 16px; }
    }
</style>
