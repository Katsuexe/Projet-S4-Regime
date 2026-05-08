<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<?php
$initials = strtoupper(substr((string) ($user['prenom'] ?? ''), 0, 1) . substr((string) ($user['nom'] ?? ''), 0, 1));
$imcPosition = max(0, min(100, ((float) ($imc ?? 0) / 40) * 100));
?>
<div class="page-content">
    <div class="page-header">
        <div class="page-header-text">
            <div class="kicker">Mon espace</div>
            <h1>Mon profil</h1>
            <p>Consultez vos informations de sante, votre IMC et modifiez uniquement ce qui a besoin d'etre mis a jour.</p>
        </div>
    </div>

    <?= view('partials/flash_messages') ?>

    <div class="profil-grid">
        <div style="display:flex;flex-direction:column;gap:16px">
            <div class="card">
                <div class="card-body" style="text-align:center">
                    <div class="profil-avatar"><?= esc($initials !== '' ? $initials : 'U') ?></div>
                    <div class="profil-name"><?= esc(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?></div>
                    <div class="profil-email"><?= esc($user['email'] ?? '') ?></div>
                    <?php if (! empty($user['is_gold'])): ?>
                        <span class="badge-gold" style="justify-content:center">⭐ Membre Gold</span>
                    <?php endif; ?>
                    <div class="profil-stats" style="margin-top:16px">
                        <div class="profil-stat"><div class="val"><?= esc(number_format((float) ($user['solde'] ?? 0), 2, ',', ' ')) ?> Ar</div><div class="lbl">Solde</div></div>
                        <div class="profil-stat"><div class="val"><?= esc($user['genre'] ?? '-') ?></div><div class="lbl">Genre</div></div>
                        <div class="profil-stat"><div class="val"><?= esc((string) ($sante['taille'] ?? '-')) ?> cm</div><div class="lbl">Taille</div></div>
                        <div class="profil-stat"><div class="val"><?= esc($sante['objectif'] ?? '-') ?></div><div class="lbl">Objectif</div></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">Analyse IMC</div>
                <div class="card-body">
                    <div style="display:flex;justify-content:space-between;align-items:baseline">
                        <span style="font-size:2rem;font-weight:700;color:var(--text)"><?= esc(number_format((float) ($imc ?? 0), 1, '.', '')) ?></span>
                        <?php
                        $catClass = 'normal';
                        if (($imc ?? 0) >= 25 && ($imc ?? 0) < 30) {
                            $catClass = 'surpoid';
                        } elseif (($imc ?? 0) < 18.5 || ($imc ?? 0) >= 30) {
                            $catClass = 'obese';
                        }
                        ?>
                        <span id="imc-cat-live" class="imc-cat <?= esc($catClass) ?>"><?= esc($categorie ?? '-') ?></span>
                    </div>
                    <div class="imc-bar-wrap">
                        <div class="imc-marker" style="left:<?= esc(number_format($imcPosition, 2, '.', '')) ?>%"></div>
                    </div>
                    <div class="imc-scale"><span>Maigreur</span><span>Normal</span><span>Surpoids</span><span>Obesite</span></div>
                    <div class="profil-stats" style="margin-top:12px">
                        <div class="profil-stat"><div class="val"><?= esc((string) ($sante['poids'] ?? '-')) ?> kg</div><div class="lbl">Poids</div></div>
                        <div class="profil-stat"><div class="val"><?= esc((string) ($sante['taille'] ?? '-')) ?> cm</div><div class="lbl">Taille</div></div>
                        <div class="profil-stat" style="grid-column:1/-1"><div class="val"><?= esc(isset($ideal['poids_ideal']) ? (string) $ideal['poids_ideal'] : '-') ?> kg</div><div class="lbl">Poids ideal estime</div></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">Modifier mes donnees de sante</div>
            <div class="card-body">
                <form action="<?= site_url('profil') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="taille">Taille (cm)</label>
                            <input type="number" id="taille" name="taille" min="100" max="250" step="0.1" value="<?= esc(old('taille', $sante['taille'] ?? '')) ?>">
                            <span class="form-error"><?= esc($errors['taille'] ?? '') ?></span>
                        </div>
                        <div class="form-group">
                            <label for="poids">Poids (kg)</label>
                            <input type="number" id="poids" name="poids" min="30" max="300" step="0.1" value="<?= esc(old('poids', $sante['poids'] ?? '')) ?>">
                            <span class="form-error"><?= esc($errors['poids'] ?? '') ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="objectif-select">Objectif</label>
                        <select id="objectif-select" name="objectif">
                            <?php $objectif = old('objectif', $sante['objectif'] ?? ''); ?>
                            <option value="augmenter" <?= $objectif === 'augmenter' ? 'selected' : '' ?>>Augmenter ma masse</option>
                            <option value="reduire" <?= $objectif === 'reduire' ? 'selected' : '' ?>>Reduire mon poids</option>
                            <option value="ideal" <?= $objectif === 'ideal' ? 'selected' : '' ?>>Atteindre un IMC ideal</option>
                        </select>
                        <span class="form-error"><?= esc($errors['objectif'] ?? '') ?></span>
                    </div>
                    <div style="background:var(--blue-light);border-radius:var(--radius-md);padding:14px;margin-bottom:20px">
                        <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--blue);margin-bottom:6px">Apercu IMC en direct</div>
                        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
                            <span id="imc-live" style="font-size:1.6rem;font-weight:700;color:var(--blue)"><?= esc(number_format((float) ($imc ?? 0), 1, '.', '')) ?></span>
                            <span class="imc-cat <?= esc($catClass) ?>" id="imc-preview-value"><?= esc($categorie ?? '-') ?></span>
                            <span style="font-size:.8rem;color:var(--text-3);margin-left:auto">Poids ideal : <?= esc(isset($ideal['poids_ideal']) ? (string) $ideal['poids_ideal'] : '-') ?> kg</span>
                        </div>
                    </div>
                    <div class="action-row">
                        <a href="<?= site_url('suggestions') ?>" class="btn-outline">Retour</a>
                        <button type="submit" class="btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('js/imc.js') ?>"></script>
<?= $this->endSection() ?>
