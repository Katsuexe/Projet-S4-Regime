<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<section class="auth-wrapper">
    <form action="<?= site_url('inscription/etape2') ?>" method="post" novalidate class="auth-form">
        <?= csrf_field() ?>

        <div class="auth-header">
            <p class="auth-kicker">Sportif</p>
            <h1>Completer votre profil sante</h1>
            <p>Nous utilisons ces informations pour orienter vos suggestions de regime et d objectif.</p>
        </div>

        <div class="auth-progress" aria-label="Progression inscription">
            <span class="auth-progress-step is-done">1. Identite</span>
            <span class="auth-progress-step is-active">2. Sante</span>
        </div>

        <?= view('partials/flash_messages') ?>

        <fieldset>
            <legend>Donnees physiques</legend>

            <label for="taille">Taille en cm *</label>
            <input type="number" step="0.1" id="taille" name="taille" value="<?= esc(old('taille')) ?>" inputmode="decimal" required>
            <span class="erreur"><?= esc($errors['taille'] ?? '') ?></span>

            <label for="poids">Poids en kg *</label>
            <input type="number" step="0.1" id="poids" name="poids" value="<?= esc(old('poids')) ?>" inputmode="decimal" required>
            <span class="erreur"><?= esc($errors['poids'] ?? '') ?></span>

            <div class="imc-preview">
                <p class="imc-label">Apercu IMC</p>
                <div id="imc-preview-value">Renseignez votre taille et votre poids pour voir une estimation.</div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Objectif sportif</legend>

            <label for="objectif">Votre objectif *</label>
            <select id="objectif" name="objectif" required>
                <option value="">Choisissez une option</option>
                <option value="augmenter" <?= old('objectif') === 'augmenter' ? 'selected' : '' ?>>Augmenter ma masse</option>
                <option value="reduire" <?= old('objectif') === 'reduire' ? 'selected' : '' ?>>Reduire mon poids</option>
                <option value="ideal" <?= old('objectif') === 'ideal' ? 'selected' : '' ?>>Atteindre un IMC ideal</option>
            </select>
            <span class="erreur"><?= esc($errors['objectif'] ?? '') ?></span>
        </fieldset>

        <div class="auth-actions">
            <a class="secondary-link" href="<?= site_url('inscription/etape1') ?>">Retour etape 1</a>
            <button type="submit" id="btn-submit">Terminer l inscription</button>
        </div>
    </form>
</section>
<script src="<?= base_url('js/imc.js') ?>"></script>
<script src="<?= base_url('js/auth.js') ?>"></script>
<?= $this->endSection() ?>
