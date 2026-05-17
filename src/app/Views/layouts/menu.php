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
        .vidro-menu { padding: 0 0.8rem; gap: 0.5rem; }
        .menu-link span, .login-link span { display: none; }
        .logo-link { font-size: 1.3rem; }
    }
</style>