<?php /** Estilos do Menu - GoVagas */ ?>
<style>
    .vidro-menu {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0 1.2rem;
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.3);
        box-shadow: 0 4px 18px rgba(0,0,0,0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        background: rgba(255,255,255,0.18);
        min-height: 64px;
        width: 100%;
        max-width: 1060px;
        box-sizing: border-box;
    }

    .logo-link {
        color: #1a1a2e;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.6rem;
        letter-spacing: -0.5px;
        transition: opacity 0.2s;
        white-space: nowrap;
    }

    .logo-link:hover { opacity: 0.75; }

    .menu-nav {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .menu-link {
        color: #33363B;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 14px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s, color 0.2s;
        white-space: nowrap;
    }

    .menu-link:hover { background: rgba(255,255,255,0.4); color: #1a1a2e; }

    .menu-link.active { background: rgba(79,70,229,0.12); color: #4f46e5; }

    .menu-link.destaque {
        background: rgba(79,70,229,0.85);
        color: #fff;
        box-shadow: 0 2px 8px rgba(79,70,229,0.3);
    }

    .menu-link.destaque:hover { background: rgba(79,70,229,1); color: #fff; }

    .menu-divider {
        width: 1px;
        height: 24px;
        background: rgba(0,0,0,0.1);
        margin: 0 4px;
    }

    .filtros-link {
        color: #33363B;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 14px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }

    .filtros-link:hover { background: rgba(255,255,255,0.4); }

  /* Perfil + sessão logada (um único link) */
    .menu-perfil {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 12px 6px 8px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.45);
        background: rgba(255, 255, 255, 0.35);
        text-decoration: none;
        max-width: 220px;
        flex-shrink: 1;
        min-width: 0;
        transition: background 0.2s, border-color 0.2s, box-shadow 0.2s;
    }

    .menu-perfil:hover {
        background: rgba(255, 255, 255, 0.55);
        color: #1a1a2e;
    }

    .menu-perfil.active {
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.25);
    }

    .menu-perfil--empresa {
        border-color: rgba(79, 70, 229, 0.35);
        background: rgba(79, 70, 229, 0.1);
    }

    .menu-perfil--empresa:hover,
    .menu-perfil--empresa.active {
        background: rgba(79, 70, 229, 0.16);
    }

    .menu-perfil--candidato {
        border-color: rgba(16, 185, 129, 0.35);
        background: rgba(16, 185, 129, 0.1);
    }

    .menu-perfil--candidato:hover,
    .menu-perfil--candidato.active {
        background: rgba(16, 185, 129, 0.16);
    }

    .menu-perfil-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.9rem;
        color: #fff;
    }

    .menu-perfil--empresa .menu-perfil-avatar {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
    }

    .menu-perfil--candidato .menu-perfil-avatar {
        background: linear-gradient(135deg, #34d399, #059669);
    }

    .menu-perfil-text {
        display: flex;
        flex-direction: column;
        min-width: 0;
        line-height: 1.25;
        text-align: left;
    }

    .menu-perfil-text strong {
        font-size: 0.84rem;
        font-weight: 700;
        color: #1a1a2e;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-perfil-text small {
        font-size: 0.68rem;
        font-weight: 600;
        color: #555;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-perfil--empresa .menu-perfil-text small { color: #4f46e5; }
    .menu-perfil--candidato .menu-perfil-text small { color: #059669; }

    /* login-link mantido por compatibilidade */
    .login-link {
        color: #33363B;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 14px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }

    .login-link:hover { background: rgba(255,255,255,0.4); }

    @media (max-width: 640px) {
        .vidro-menu { padding: 0 0.8rem; gap: 0.5rem; flex-wrap: wrap; }
        .menu-link span, .login-link span { display: none; }
        .logo-link { font-size: 1.3rem; }
        .menu-perfil { max-width: 44px; padding: 5px; }
        .menu-perfil-text { display: none; }
        .menu-perfil-avatar { width: 32px; height: 32px; font-size: 0.8rem; }
    }
</style>