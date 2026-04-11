<?php /**
        * Layout base para as telas do projeto
        */
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= $this->renderSection('title') ?: 'ClickVagas' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <?= $this->renderSection('styles') ?>
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.25);
            --accent: #dd4814
        }

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

        .govagas-block {
            display: inline-flex;
            align-items: center;
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
            font-size: 1rem;
            letter-spacing: .2px;
            backface-visibility: hidden;
            min-height: 70px;
            min-width: 750px;
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.15);
            color: #111;
            justify-content: center;
        }

        .main-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 100px 20px 40px 20px
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 6px 20px rgba(16, 24, 40, 0.08)
        }

        @media (max-width:600px) {
            .govagas-block {
                padding: .35rem .6rem;
                font-size: .95rem;
                border-radius: 8px
            }

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
        <div class="govagas-block">GoVagas</div>
        <?= $this->renderSection('header') ?>
    </header>

    <main class="main-container">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->renderSection('scripts') ?>

</body>

</html>