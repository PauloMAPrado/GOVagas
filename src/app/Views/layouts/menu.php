<?php
/**
 * Estilos do Menu - GoVagas
 */
?>
<style>
    .vidro-menu {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .5rem;
        padding: .4rem .8rem;
        border-radius: 10px;
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
        color: #fff;
        font-weight: 600;
        font-size: 2.5rem;
        letter-spacing: .2px;
        backface-visibility: hidden;
        min-height: 70px;
        min-width: 750px;
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.15);
        color: #33363B;
    }

    .menu-links {
        display: flex;
        gap: 1rem;
    }

    .logo-link {
        color: #33363B;
        text-decoration: none;
        font-weight: 600;
        font-size: 2.5rem;
        transition: all 0.3s ease;
    }

    .logo-link:hover {
        color: #333363;
    }

    .filtros-link {
        color: #33363B;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        padding: 10px 20px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: transparent;
        border: none;
        border-radius: 0;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        outline: none;
        box-shadow: none;
    }

    .filtros-link:hover {
        color: #333363;
    }

    .login-link {
        color: #33363B;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        padding: 10px 20px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .login-link:hover {
        color: #333363;
    }

    @media (max-width:600px) {
        .vidro-menu {
            padding: .35rem .6rem;
            font-size: .95rem;
            border-radius: 8px
        }
    }
</style>