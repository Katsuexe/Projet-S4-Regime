<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Projet Regime') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <style>
        :root {
            --bg: #f0ede6;
            --surface: #ffffff;
            --surface-alt: #f9f7f3;
            --border: #e4dfd5;
            --border-md: #ccc8be;
            --blue: #3a6ef0;
            --blue-light: #ebf0fe;
            --blue-dark: #2150c0;
            --green: #15803d;
            --green-light: #dcfce7;
            --amber: #b45309;
            --amber-light: #fef3c7;
            --red: #dc2626;
            --red-light: #fee2e2;
            --gold: #d97706;
            --gold-light: #fef9c3;
            --text: #111827;
            --text-2: #374151;
            --text-3: #6b7280;
            --text-4: #9ca3af;
            --viande: #ef4444;
            --poisson: #3b82f6;
            --volaille: #f59e0b;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 18px;
            --radius-xl: 24px;
            --shadow-card: 0 2px 12px rgba(0,0,0,.07), 0 0 0 1px rgba(0,0,0,.04);
            --shadow-hover: 0 8px 28px rgba(0,0,0,.11);
            --font: "Plus Jakarta Sans", system-ui, sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }
        a { color: var(--blue); text-decoration: none; }
        img { display: block; max-width: 100%; }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            min-height: 60px;
            display: flex;
            align-items: center;
        }
        .navbar-logo {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--blue);
            letter-spacing: -0.02em;
            margin-right: auto;
        }
        .navbar-logo span { color: var(--text); }
        .navbar-links {
            display: flex;
            align-items: center;
            gap: 4px;
            list-style: none;
        }
        .navbar-links a {
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: .875rem;
            font-weight: 500;
            color: var(--text-2);
            transition: background .15s, color .15s;
        }
        .navbar-links a:hover,
        .navbar-links a.active {
            background: var(--blue-light);
            color: var(--blue);
        }
        .navbar-wallet {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: 12px;
            padding: 6px 14px;
            background: var(--surface-alt);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            font-size: .875rem;
        }
        .navbar-wallet .amount { font-weight: 700; color: var(--text); }
        .navbar-wallet .label { font-size: .75rem; color: var(--text-3); }
        .navbar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--blue-light);
            color: var(--blue);
            font-weight: 700;
            font-size: .8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
        }
        .badge-gold {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--gold-light);
            color: var(--gold);
            font-size: .7rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 99px;
            border: 1px solid #fde68a;
        }
        .page-content {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px 80px;
        }
        .flash {
            border-radius: var(--radius-md);
            padding: 12px 16px;
            font-size: .9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .flash-success { background: var(--green-light); color: var(--green); }
        .flash-error { background: var(--red-light); color: var(--red); }
        .flash-warning { background: var(--amber-light); color: var(--amber); }
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 36px;
        }
        .page-header-text .kicker {
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--blue);
            margin-bottom: 6px;
        }
        .page-header-text h1 {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: -.03em;
            line-height: 1.1;
        }
        .page-header-text p {
            margin-top: 8px;
            font-size: .95rem;
            color: var(--text-3);
        }
        .imc-widget {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 20px 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-card);
            min-width: 220px;
            text-align: center;
        }
        .imc-widget .title {
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-3);
            margin-bottom: 8px;
        }
        .imc-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .imc-cat {
            font-size: .8rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 99px;
            display: inline-block;
            margin-bottom: 6px;
        }
        .imc-cat.normal { background: var(--green-light); color: var(--green); }
        .imc-cat.surpoid { background: var(--amber-light); color: var(--amber); }
        .imc-cat.obese { background: var(--red-light); color: var(--red); }
        .imc-ideal { font-size: .75rem; color: var(--text-3); }
        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .regimes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .regime-card, .card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-card);
        }
        .regime-card {
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
            display: flex;
            flex-direction: column;
        }
        .regime-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }
        .regime-card-head {
            padding: 20px 20px 0;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }
        .regime-card-head h2 { font-size: 1.05rem; font-weight: 700; line-height: 1.2; }
        .regime-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 99px;
            font-size: .7rem;
            font-weight: 700;
            white-space: nowrap;
        }
        .regime-tag.reduire { background: var(--blue-light); color: var(--blue); }
        .regime-tag.augmenter { background: var(--green-light); color: var(--green); }
        .regime-tag.ideal { background: var(--amber-light); color: var(--amber); }
        .regime-card-body { padding: 14px 20px; display: flex; flex-direction: column; gap: 14px; flex: 1; }
        .regime-desc { font-size: .875rem; color: var(--text-3); line-height: 1.5; }
        .compo-label, .duration-label {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-3);
            margin-bottom: 8px;
        }
        .compo-bars { display: flex; flex-direction: column; gap: 6px; }
        .compo-row { display: flex; align-items: center; gap: 10px; }
        .compo-name { font-size: .75rem; color: var(--text-2); width: 54px; flex-shrink: 0; }
        .compo-bar-track {
            flex: 1;
            height: 6px;
            background: var(--surface-alt);
            border-radius: 99px;
            overflow: hidden;
        }
        .compo-bar-fill { height: 100%; border-radius: 99px; }
        .compo-pct { font-size: .72rem; font-weight: 700; color: var(--text-2); width: 30px; text-align: right; }
        .delta-poids {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: var(--surface-alt);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
        }
        .delta-poids .value { margin-left: auto; font-size: .85rem; font-weight: 600; }
        .duration-pills { display: flex; flex-wrap: wrap; gap: 6px; }
        .pill-input { display: none; }
        .pill-label {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 12px;
            border-radius: var(--radius-md);
            border: 1.5px solid var(--border-md);
            cursor: pointer;
            min-width: 64px;
            text-align: center;
        }
        .pill-label .days { font-size: .75rem; font-weight: 700; color: var(--text-2); }
        .pill-label .price { font-size: .8rem; font-weight: 700; color: var(--blue); margin-top: 2px; }
        .pill-label .price-gold { font-size: .65rem; color: var(--text-4); text-decoration: line-through; }
        .pill-input:checked + .pill-label { border-color: var(--blue); background: var(--blue-light); }
        .regime-card-foot { padding: 0 20px 20px; margin-top: auto; }
        .btn-subscribe, .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 24px;
            border-radius: var(--radius-md);
            background: var(--blue);
            color: #fff;
            border: none;
            font-size: .9rem;
            font-weight: 700;
            cursor: pointer;
            font-family: var(--font);
        }
        .btn-subscribe { width: 100%; }
        .btn-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            background: transparent;
            border: 1.5px solid var(--border-md);
            border-radius: var(--radius-md);
            font-size: .875rem;
            font-weight: 600;
            color: var(--text-2);
            cursor: pointer;
            font-family: var(--font);
        }
        .btn-outline:hover { background: var(--surface-alt); }
        .btn-subscribe.disabled { background: var(--surface-alt); color: var(--text-4); cursor: not-allowed; }
        .solde-warning { font-size: .75rem; color: var(--red); text-align: center; margin-top: 6px; }
        .objectif-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }
        .objectif-card {
            background: var(--surface);
            border: 2px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 32px 24px;
            text-align: center;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            position: relative;
        }
        .objectif-card.selected { border-color: var(--blue); background: var(--blue-light); }
        .objectif-card .check {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
        }
        .objectif-card.selected .check { opacity: 1; }
        .objectif-card .check::after { content: '✓'; color: #fff; font-size: .7rem; font-weight: 700; }
        .objectif-icon {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }
        .objectif-icon.up { background: var(--green-light); }
        .objectif-icon.down { background: var(--blue-light); }
        .objectif-icon.ideal { background: var(--amber-light); }
        .objectif-title { font-size: 1rem; font-weight: 700; }
        .objectif-desc { font-size: .825rem; color: var(--text-3); line-height: 1.5; }
        .objectif-tag { font-size: .7rem; font-weight: 700; padding: 3px 10px; border-radius: 99px; }
        .profil-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 24px;
            align-items: start;
        }
        .card-head {
            padding: 18px 20px 14px;
            border-bottom: 1px solid var(--border);
            font-size: .9rem;
            font-weight: 700;
        }
        .card-body { padding: 20px; }
        .profil-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--blue-light);
            color: var(--blue);
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .profil-name { text-align: center; font-size: 1.1rem; font-weight: 700; margin-bottom: 4px; }
        .profil-email { text-align: center; font-size: .825rem; color: var(--text-3); margin-bottom: 12px; }
        .profil-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .profil-stat {
            background: var(--surface-alt);
            border-radius: var(--radius-md);
            padding: 10px;
            text-align: center;
        }
        .profil-stat .val { font-size: 1.05rem; font-weight: 700; }
        .profil-stat .lbl { font-size: .7rem; color: var(--text-3); margin-top: 2px; }
        .imc-bar-wrap {
            position: relative;
            height: 10px;
            border-radius: 99px;
            background: linear-gradient(to right, #3b82f6 0%, #22c55e 40%, #f59e0b 70%, #ef4444 100%);
            margin: 8px 0;
        }
        .imc-marker {
            position: absolute;
            top: -4px;
            width: 18px;
            height: 18px;
            background: #fff;
            border: 2.5px solid var(--text);
            border-radius: 50%;
            transform: translateX(-50%);
        }
        .imc-scale { display: flex; justify-content: space-between; font-size: .65rem; color: var(--text-3); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
        .form-group label { font-size: .8rem; font-weight: 600; color: var(--text-2); }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid var(--border-md);
            border-radius: var(--radius-md);
            font-size: .9rem;
            color: var(--text);
            background: var(--surface);
            font-family: var(--font);
        }
        .form-error { font-size: .75rem; color: var(--red); }
        .wallet-hero {
            background: var(--blue);
            border-radius: var(--radius-xl);
            padding: 32px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 24px;
        }
        .wallet-balance .lbl { font-size: .8rem; opacity: .75; margin-bottom: 6px; }
        .wallet-balance .amount { font-size: 2.5rem; font-weight: 700; letter-spacing: -.04em; }
        .wallet-gold {
            background: rgba(255,255,255,.15);
            border: 1.5px solid rgba(255,255,255,.3);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            text-align: center;
            min-width: 160px;
        }
        .wallet-gold .gl { font-size: .75rem; opacity: .75; margin-bottom: 4px; }
        .code-input-wrap { display: flex; gap: 12px; margin-bottom: 16px; }
        .code-input-wrap input {
            flex: 1;
            padding: 14px 16px;
            border: 2px dashed var(--border-md);
            border-radius: var(--radius-md);
            font-size: 1rem;
            font-family: monospace;
            background: var(--surface);
            letter-spacing: .1em;
        }
        .code-result {
            display: none;
            padding: 14px 16px;
            border-radius: var(--radius-md);
            font-size: .9rem;
            font-weight: 500;
        }
        .code-result.success { display: flex; background: var(--green-light); color: var(--green); gap: 10px; align-items: center; }
        .code-result.error { display: flex; background: var(--red-light); color: var(--red); gap: 10px; align-items: center; }
        .history-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        .history-table th {
            text-align: left;
            padding: 8px 12px;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-3);
            border-bottom: 1px solid var(--border);
        }
        .history-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            color: var(--text-2);
        }
        .history-table tr:last-child td { border-bottom: none; }
        .auth-shell {
            max-width: 760px;
            margin: 48px auto;
            padding: 0 24px 48px;
        }
        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }
        .auth-card-head {
            padding: 28px 28px 18px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, var(--surface), var(--surface-alt));
        }
        .auth-card-head h1 { font-size: 1.65rem; margin-bottom: 8px; }
        .auth-card-head p { color: var(--text-3); line-height: 1.6; }
        .auth-kicker {
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--blue);
            margin-bottom: 8px;
        }
        .auth-progress {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 16px;
        }
        .auth-progress-step {
            padding: 8px 12px;
            border-radius: 999px;
            background: var(--surface-alt);
            border: 1px solid var(--border);
            color: var(--text-3);
            font-size: .8rem;
            font-weight: 600;
        }
        .auth-progress-step.is-active { background: var(--blue-light); border-color: var(--blue); color: var(--blue); }
        .auth-progress-step.is-done { background: var(--green-light); border-color: #86efac; color: var(--green); }
        .auth-card-body { padding: 28px; }
        .auth-footer {
            margin-top: 18px;
            font-size: .9rem;
            color: var(--text-3);
            text-align: center;
        }
        .action-row {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }
        @media (max-width: 768px) {
            .objectif-grid, .profil-grid, .form-row { grid-template-columns: 1fr; }
            .regimes-grid { grid-template-columns: 1fr; }
            .navbar { flex-wrap: wrap; gap: 12px; padding: 12px 16px; }
            .navbar-links { width: 100%; order: 3; justify-content: center; flex-wrap: wrap; }
            .page-header { flex-direction: column; }
            .wallet-hero, .code-input-wrap { flex-direction: column; }
        }
    </style>
</head>
<?php
$authGroups = config(\Config\AuthGroups::class);
$currentPath = trim(service('uri')->getPath(), '/');
$authPaths = array_filter([
    'connexion',
    'inscription/etape1',
    'inscription/etape2',
    trim($authGroups->hiddenLoginRoutes['admin'] ?? '', '/'),
    trim($authGroups->hiddenLoginRoutes['coach'] ?? '', '/'),
]);
$isAuthScreen = in_array($currentPath, $authPaths, true);
?>
<body class="<?= $isAuthScreen ? 'auth-page' : '' ?>">
    <?php if (session('user_id') && (session('auth_role') ?? 'sportif') === 'sportif'): ?>
        <?= view('partials/navbar_front') ?>
    <?php endif; ?>
    <?php if ($isAuthScreen): ?>
        <main class="page-shell">
            <div style="width:100%;display:flex;align-items:center;justify-content:center;min-height:calc(100vh - 64px);">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    <?php else: ?>
        <?= $this->renderSection('content') ?>
    <?php endif; ?>
</body>
</html>
