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

    .modelo-filtro {
		background: rgba(255, 255, 255, 0.95);
		backdrop-filter: blur(10px);
		border: 1px solid rgba(255, 255, 255, 0.2);
		border-radius: 20px;
		padding: 32px;
		max-width: 420px;
		width: 90%;
		max-height: 85vh;
		overflow-y: auto;
		box-shadow: 
			0 8px 32px 0 rgba(31, 38, 135, 0.37),
			inset 0 1px 2px rgba(255, 255, 255, 0.6);
		animation: slideUp 0.4s ease-out;
		position: relative;
	}

    .vidro-cadastro {
        background: rgba(255, 255, 255, 0.55);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        color: #111;
        width: 100%;
        max-width: 920px;
        margin: 0 auto;
        padding: 2rem;
        box-sizing: border-box;
    }

    @media (max-width: 768px) {
        .vidro-cadastro {
            padding: 1.25rem 1rem;
            border-radius: 12px;
        }
    }

    .vidro-login {
        background: rgba(255, 255, 255, 0.55);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        color: #111;
        width: 90%;
        max-width: 480px;
        margin: 0 auto;
        padding: 2rem;
    }
</style>