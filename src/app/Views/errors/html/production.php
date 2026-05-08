<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title><?= lang('Errors.whoops') ?></title>

    <style>
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>

        .logout-discrete {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            font-size: 0.85rem;
            opacity: 0.7;
            text-decoration: none;
            color: #555;
            background: rgba(255,255,255,0.9);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            border: 1px solid #eee;
        }
    </style>
</head>
<body>

    <?php if (function_exists('session') && session()->has('user_id')) :
        $role = session()->get('auth_role') ?? 'sportif';
        $logoutUrl = $role === 'admin' ? '/espace-securise/admin/sortie' : ($role === 'coach' ? '/espace-securise/coach/sortie' : '/deconnexion');
    ?>
        <a class="logout-discrete" href="<?= esc($logoutUrl, 'attr') ?>">Déconnexion</a>
    <?php endif; ?>

    <div class="container text-center">

        <h1 class="headline"><?= lang('Errors.whoops') ?></h1>

        <p class="lead"><?= lang('Errors.weHitASnag') ?></p>

    </div>

</body>

</html>
