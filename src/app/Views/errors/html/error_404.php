<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= lang('Errors.pageNotFound') ?></title>

    <style>
        div.logo {
            height: 200px;
            width: 155px;
            display: inline-block;
            opacity: 0.08;
            position: absolute;
            top: 2rem;
            left: 50%;
            margin-left: -73px;
        }
        body {
            height: 100%;
            background: #fafafa;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #777;
            font-weight: 300;
        }
        h1 {
            font-weight: lighter;
            letter-spacing: normal;
            font-size: 3rem;
            margin-top: 0;
            margin-bottom: 0;
            color: #222;
        }
        .wrap {
            max-width: 1024px;
            margin: 5rem auto;
            padding: 2rem;
            background: #fff;
            text-align: center;
            border: 1px solid #efefef;
            border-radius: 0.5rem;
            position: relative;
        }
        pre {
            white-space: normal;
            margin-top: 1.5rem;
        }
        code {
            background: #fafafa;
            border: 1px solid #efefef;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            display: block;
        }
        p {
            margin-top: 1.5rem;
        }
        .footer {
            margin-top: 2rem;
            border-top: 1px solid #efefef;
            padding: 1em 2em 0 2em;
            font-size: 85%;
            color: #999;
        }
        a:active,
        a:link,
        a:visited {
            color: #dd4814;
        }
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
    <div class="wrap">
        <h1>404</h1>

        <p>
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                <?= lang('Errors.sorryCannotFind') ?>
            <?php endif; ?>
        </p>
    </div>
</body>
</html>
