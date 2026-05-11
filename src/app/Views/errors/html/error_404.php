<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>404 - Page introuvable</title>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0ede6, #ffffff);
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #1f2937;
        }
        h1 {
            font-size: 64px;
            margin: 0;
            color: #3a6ef0;
        }
        .wrap {
            width: min(720px, calc(100% - 32px));
            padding: 40px 36px;
            background: #ffffff;
            text-align: center;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            box-shadow: 0 18px 60px rgba(15, 23, 42, 0.08);
            position: relative;
        }
        p {
            margin: 14px 0 0;
            color: #6b7280;
            line-height: 1.7;
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
        .subtitle {
            margin-top: 10px;
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }
        .actions {
            margin-top: 24px;
        }
        .btn {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 12px;
            background: #3a6ef0;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <?php if (function_exists('session') && session()->has('user_id')) :
        $role = session()->get('auth_role') ?? 'sportif';
        $logoutUrl = $role === 'admin' ? '/espace-securise/admin/sortie' : ($role === 'coach' ? '/espace-securise/coach/sortie' : '/deconnexion');
    ?>
        <form method="post" action="<?= esc($logoutUrl, 'attr') ?>">
            <?= csrf_field() ?>
            <button type="submit" class="logout-discrete">Déconnexion</button>
        </form>
    <?php endif; ?>
    <div class="wrap">
        <h1>404</h1>
        <div class="subtitle">Page introuvable</div>

        <p>
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                Cette page n existe pas ou a ete deplacee.
            <?php endif; ?>
        </p>
        <div class="actions">
            <a class="btn" href="<?= esc(site_url('/')) ?>">Retour a l accueil</a>
        </div>
    </div>
</body>
</html>
