<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>403 - Acces refuse</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0ede6, #ffffff);
            font-family: "Helvetica Neue", Arial, sans-serif;
            color: #1f2937;
        }
        .wrap {
            width: min(720px, calc(100% - 32px));
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            box-shadow: 0 18px 60px rgba(15, 23, 42, 0.08);
            padding: 40px 36px;
            text-align: center;
        }
        h1 { font-size: 64px; margin: 0; color: #dc2626; }
        h2 { margin: 10px 0 14px; font-size: 28px; }
        p { color: #6b7280; line-height: 1.7; }
        .actions { margin-top: 24px; }
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
    <div class="wrap">
        <h1>403</h1>
        <h2>Acces refuse</h2>
        <p>Vous n avez pas les autorisations necessaires pour acceder a cette page ou a cette ressource.</p>
        <div class="actions">
            <a class="btn" href="<?= esc(site_url('/')) ?>">Retour a l accueil</a>
        </div>
    </div>
</body>
</html>
