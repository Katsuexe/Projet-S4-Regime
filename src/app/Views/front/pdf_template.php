<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Programme regime</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; line-height: 1.5; }
        .header { border-bottom: 2px solid #3a6ef0; padding-bottom: 12px; margin-bottom: 18px; }
        .header h1 { margin: 0 0 4px; font-size: 22px; color: #1e40af; }
        .muted { color: #6b7280; }
        .grid { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .grid td { width: 50%; vertical-align: top; padding: 8px 10px; }
        .card { border: 1px solid #dbe3f1; border-radius: 8px; padding: 12px; margin-bottom: 14px; }
        .label { font-size: 10px; text-transform: uppercase; color: #6b7280; margin-bottom: 4px; }
        .value { font-size: 14px; font-weight: bold; color: #111827; }
        .section-title { font-size: 14px; font-weight: bold; color: #1f2937; margin: 18px 0 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #e5e7eb; padding: 8px 10px; text-align: left; }
        .table th { background: #eff6ff; color: #1d4ed8; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 999px; background: #dbeafe; color: #1d4ed8; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Recapitulatif de votre programme</h1>
        <div class="muted">Genere le <?= esc($generatedAt ?? '-') ?></div>
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
</body>
</html>
