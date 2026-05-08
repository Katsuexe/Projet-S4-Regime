<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Projet Regime') ?></title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body class="auth-page">
    <main class="page-shell">
        <?= $this->renderSection('content') ?>
    </main>
</body>
</html>
