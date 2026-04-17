<?php
/**
 * Estilos Glassmorphism - GoVagas
 */
?>
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.12);
        --glass-border: rgba(255, 255, 255, 0.25);
        --accent: #dd4814;
    }

    .card {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 6px 20px rgba(16, 24, 40, 0.08);
    }

    .vidro-cadastro {
        border-radius: 10px;
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.2);
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
        color: #fff;
        backface-visibility: hidden;
        min-height: 700px;
        min-width: 1200px;
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.15);
        color: #111;
        justify-content: center;
        position: absolute;
        top: 54%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .vidro-login {
        border-radius: 10px;
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.2);
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
        color: #fff;
        backface-visibility: hidden;
        min-height: 600px;
        min-width: 900px;
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.15);
        color: #111;
        justify-content: center;
        position: absolute;
        top: 54%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>