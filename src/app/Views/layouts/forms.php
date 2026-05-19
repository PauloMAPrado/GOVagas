<?php /** Estilos dos Formulários - GoVagas */ ?>
<style>
    .letras-formulario {
        color: #1a1a2e;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.8rem 1.5rem;
    }

    .posicionamento-inputs {
        padding-top: 10px;
        display: flex;
        gap: 12px;
        width: 100%;
    }

    .input-duplo-formulario,
    .input-unico-formulario {
        height: 42px;
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        background: rgba(255, 255, 255, 0.7);
        color: #1a1a2e;
        padding: 0 14px;
        font-size: 0.95rem;
        font-family: inherit;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        width: 100%;
    }

    .input-duplo-formulario {
        flex: 1;
        width: auto;
    }

    .input-duplo-formulario:focus,
    .input-unico-formulario:focus {
        border-color: rgba(79, 70, 229, 0.6);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        background: rgba(255, 255, 255, 0.9);
    }

    .input-duplo-formulario::placeholder,
    .input-unico-formulario::placeholder {
        color: #aaa;
        font-size: 0.9rem;
    }

    .botao-vidro {
        border-radius: 10px;
        background: rgba(79, 70, 229, 0.85);
        border: none;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        min-width: 200px;
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        padding: 12px 28px;
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }

    .botao-vidro:hover {
        background: rgba(79, 70, 229, 1);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
    }

    .letras-pequenas {
        color: #555;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-block;
        padding: 4px 0;
        transition: color 0.2s;
    }

    .letras-pequenas:hover {
        color: #4f46e5;
    }

    select.input-duplo-formulario,
    select.input-unico-formulario {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23555' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
    }

    textarea.input-unico-formulario {
        height: auto;
        padding-top: 10px;
        resize: vertical;
    }

    /* Layout do formulário de vaga (nova / editar / visualizar) */
    .vaga-form-layout {
        display: flex;
        gap: 40px;
        padding: 0 1.5rem 2rem;
        align-items: flex-start;
    }

    .vaga-form-col {
        display: flex;
        flex-direction: column;
        gap: 15px;
        min-width: 0;
    }

    .vaga-form-col--main { flex: 1.2; }
    .vaga-form-col--side { flex: 1; }

    .vaga-form-row {
        display: flex;
        gap: 15px;
    }

    .vaga-form-row > * {
        flex: 1;
        min-width: 0;
    }

    .vaga-form-row--qty .vaga-form-qty { flex: 0.5; }
    .vaga-form-row--qty .vaga-form-salary { flex: 1.5; }

    .vaga-form-descricao {
        height: 320px;
        padding-top: 15px;
        border-radius: 15px;
        resize: vertical;
    }

    .vaga-empresa-card {
        background: rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        gap: 15px;
        border-radius: 20px;
        padding: 15px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .vaga-empresa-avatar {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: #ccc;
        flex-shrink: 0;
    }

    .vaga-empresa-info { flex: 1; min-width: 0; }
    .vaga-empresa-info p { margin: 0; }
    .vaga-empresa-info .nome { font-weight: 600; color: #333363; font-size: 1rem; }
    .vaga-empresa-info .detalhe { font-size: 0.85rem; color: #444; }

    .vaga-form-actions {
        text-align: center;
        padding-bottom: 3rem;
    }

    .vaga-form-actions .botao-vidro {
        width: 100%;
        max-width: 300px;
    }

    @media (max-width: 768px) {
        .vaga-form-layout {
            flex-direction: column;
            gap: 24px;
            padding: 0 0 1.5rem;
        }

        .vaga-form-row {
            flex-direction: column;
        }

        .vaga-form-row > *,
        .vaga-form-row--qty .vaga-form-qty,
        .vaga-form-row--qty .vaga-form-salary {
            flex: 1 1 auto;
            width: 100%;
        }

        .vaga-form-descricao {
            height: auto;
            min-height: 180px;
        }

        .vaga-empresa-card {
            flex-wrap: wrap;
        }

        .vaga-empresa-card .botao-vidro {
            width: 100%;
            min-width: unset;
            margin-top: 4px;
        }

        .letras-formulario { padding: 0.6rem 0; }
    }

    @media (max-width: 600px) {
        .posicionamento-inputs { flex-direction: column; }
    }
</style>
