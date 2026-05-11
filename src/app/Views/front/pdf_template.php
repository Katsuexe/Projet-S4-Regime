<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Programme regime</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; line-height: 1.5; margin: 24px; }
        .brand { margin-bottom: 10px; }
        .brand-badge { display: inline-block; padding: 6px 10px; border-radius: 999px; background: #dbeafe; color: #1d4ed8; font-size: 10px; font-weight: bold; letter-spacing: .06em; text-transform: uppercase; }
        .header { border-bottom: 2px solid #3a6ef0; padding-bottom: 12px; margin-bottom: 18px; }
        .header h1 { margin: 0 0 4px; font-size: 22px; color: #1e40af; }
        .muted { color: #6b7280; }
        .grid { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .grid td { width: 50%; vertical-align: top; padding: 8px 10px; }
        .card { border: 1px solid #dbe3f1; border-radius: 8px; padding: 12px; margin-bottom: 14px; background: #fdfefe; }
        .label { font-size: 10px; text-transform: uppercase; color: #6b7280; margin-bottom: 4px; }
        .value { font-size: 14px; font-weight: bold; color: #111827; }
        .section-title { font-size: 14px; font-weight: bold; color: #1f2937; margin: 18px 0 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #e5e7eb; padding: 8px 10px; text-align: left; }
        .table th { background: #eff6ff; color: #1d4ed8; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 999px; background: #dbeafe; color: #1d4ed8; font-size: 10px; }
        .hero { margin: 14px 0 18px; padding: 14px 16px; border: 1px solid #dbeafe; background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%); border-radius: 10px; }
        .hero-title { margin: 0 0 4px; font-size: 16px; color: #1e3a8a; font-weight: bold; }
        .hero-note { margin: 0; color: #475569; }
        .footer-note { margin-top: 18px; font-size: 10px; color: #6b7280; text-align: right; }
    </style>
</head>
<body>
    <div class="brand">
        <span class="brand-badge">Projet Regime</span>
    </div>
    <div class="header">
        <h1>Recapitulatif de votre programme</h1>
        <div class="muted">Genere le <?= esc($generatedAt ?? '-') ?></div>
    </div>

    <div class="hero">
        <p class="hero-title"><?= esc($regime['nom'] ?? 'Programme personnalise') ?></p>
        <p class="hero-note">Document de suivi pour accompagner votre regime alimentaire, votre objectif et votre activite recommandee.</p>
    </div>

    <table class="grid">
        <tr>
            <td>
                <div class="card">
                    <div class="label">Sportif</div>
                    <div class="value"><?= esc(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?></div>
                    <div class="muted"><?= esc($user['email'] ?? '-') ?></div>
                </div>
            </td>
            <td>
                <div class="card">
                    <div class="label">Objectif</div>
                    <div class="value"><?= esc($sante['objectif'] ?? '-') ?></div>
                    <div class="muted">Statut Gold : <?= ! empty($user['is_gold']) ? 'Oui' : 'Non' ?></div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Programme choisi</div>
    <table class="table">
        <tr>
            <th>Regime</th>
            <td><?= esc($regime['nom'] ?? '-') ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?= esc($regime['description'] ?? '-') ?></td>
        </tr>
        <tr>
            <th>Duree</th>
            <td><?= esc((string) ($duree['duree_jours'] ?? '-')) ?> jours</td>
        </tr>
        <tr>
            <th>Prix paye</th>
            <td><?= esc(number_format((float) ($subscription['prix_paye'] ?? 0), 2, ',', ' ')) ?> Ar</td>
        </tr>
        <tr>
            <th>Date de debut</th>
            <td><?= esc($subscription['date_debut'] ?? '-') ?></td>
        </tr>
        <tr>
            <th>Activite associee</th>
            <td><?= esc($activite['nom'] ?? 'Aucune') ?></td>
        </tr>
    </table>

    <div class="section-title">Bilan sante</div>
    <table class="table">
        <tr>
            <th>Taille</th>
            <td><?= esc((string) ($sante['taille'] ?? '-')) ?> cm</td>
            <th>Poids</th>
            <td><?= esc((string) ($sante['poids'] ?? '-')) ?> kg</td>
        </tr>
        <tr>
            <th>IMC</th>
            <td><?= $imc !== null ? esc(number_format((float) $imc, 1, '.', '')) : '-' ?></td>
            <th>Categorie</th>
            <td><?= esc($categorie ?? '-') ?></td>
        </tr>
        <tr>
            <th>Poids ideal estime</th>
            <td><?= isset($ideal['poids_ideal']) ? esc((string) $ideal['poids_ideal']) . ' kg' : '-' ?></td>
            <th>Fourchette IMC ideale</th>
            <td>
                <?php if (isset($ideal['imc_min'], $ideal['imc_max'])): ?>
                    <?= esc((string) $ideal['imc_min']) ?> - <?= esc((string) $ideal['imc_max']) ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <?php if (! empty($activite)): ?>
        <div class="section-title">Activite recommandee</div>
        <div class="card">
            <div class="value"><?= esc($activite['nom']) ?></div>
            <div class="muted" style="margin:6px 0 10px"><?= esc($activite['description'] ?? '-') ?></div>
            <span class="badge"><?= esc((string) ($activite['duree_min'] ?? 0)) ?> min / jour</span>
            <span class="badge"><?= esc((string) ($activite['calories_h'] ?? 0)) ?> kcal / h</span>
        </div>
    <?php endif; ?>

    <div class="footer-note">Programme genere automatiquement pour usage interne et suivi sportif.</div>
</body>
</html>
