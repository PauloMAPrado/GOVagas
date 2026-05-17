<?php /**
        * Layout base para as telas do projeto
        */
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= $this->renderSection('title') ?: 'Base' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?= $this->renderSection('styles') ?>
    <?php include 'glass.php'; ?>
    <?php include 'menu.php'; ?>
    <?php include 'forms.php'; ?>
    <?php include 'filters.php'; ?>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', Segoe UI, Helvetica, Arial, sans-serif;
            color: #111
        }

        .app-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            background-attachment: fixed;
            pointer-events: none;
            filter: contrast(1) saturate(0.95);
        }

        header.layout-header {
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            z-index: 50;
            backdrop-filter: none;
        }

        .main-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 100px 20px 40px 20px;
        }

        @media (max-width:600px) {
            .main-container {
                padding: 84px 14px 24px 14px
            }
        }
    </style>

    <?= $this->renderSection('head') ?>
</head>

<body>

    <div class="app-bg" style="background-image: url('/img/background-img.jpg');"></div>

    <header class="layout-header">
        <div class="vidro-menu">
            <a href="<?= base_url('/') ?>" class="logo-link">GoVagas</a>

            <nav class="menu-nav">
                <?php $uri = service('uri')->setSilent(); $seg1 = $uri->getSegment(1); $seg2 = $uri->getSegment(2); ?>

                <?php if (session()->get('logado')): ?>
                    <a href="<?= base_url('empresa') ?>" class="menu-link <?= $seg1 === 'empresa' && !$seg2 ? 'active' : '' ?>">
                        <i class="fas fa-th-large"></i> <span>Dashboard</span>
                    </a>
                    <a href="<?= base_url('empresa/vagas') ?>" class="menu-link <?= $seg2 === 'vagas' ? 'active' : '' ?>">
                        <i class="fas fa-briefcase"></i> <span>Minhas Vagas</span>
                    </a>
                    <a href="<?= base_url('empresa/perfil') ?>" class="menu-link <?= $seg2 === 'perfil' ? 'active' : '' ?>">
                        <i class="fas fa-user-edit"></i> <span>Perfil</span>
                    </a>
                    <div class="menu-divider"></div>
                    <a href="<?= base_url('logout') ?>" class="menu-link">
                        <i class="fas fa-sign-out-alt"></i> <span>Sair</span>
                    </a>
                <?php else: ?>
                    <?php if ($seg1 === ''): ?>
                        <button id="filterToggleBtn" class="filtros-link">
                            <i class="fas fa-filter"></i> <span>Filtros</span>
                        </button>
                        <div class="menu-divider"></div>
                    <?php endif; ?>
                    <a href="<?= base_url('login') ?>" class="menu-link destaque">
                        <i class="fas fa-building"></i> <span>Sou Empresa</span>
                    </a>
                <?php endif; ?>
            </nav>
        </div>
        <?= $this->renderSection('header') ?>
    </header>

    <main class="main-container">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->renderSection('scripts') ?>

</body>

</html>