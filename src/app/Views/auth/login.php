<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<section class="auth-wrapper">
    <form action="<?= site_url('connexion') ?>" method="post" novalidate class="auth-form auth-form-login">
        <?= csrf_field() ?>

        <div class="auth-header">
            <p class="auth-kicker">Projet Regime</p>
            <h1>Connexion</h1>
            <p>Retrouvez votre espace sportif, vos objectifs et vos suggestions personnalisees.</p>
        </div>

        <?= view('partials/flash_messages') ?>

        <fieldset>
            <legend>Connexion</legend>

            <label for="email">Adresse email *</label>
            <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" autocomplete="email" inputmode="email" required>
            <span class="erreur"><?= esc($errors['email'] ?? '') ?></span>

            <label for="password">Mot de passe *</label>
            <div class="champ-password">
                <input type="password" id="password" name="password" autocomplete="current-password" minlength="8" required>
                <button type="button" class="toggle-password" data-target="password" aria-label="Afficher le mot de passe">Voir</button>
            </div>
            <span class="erreur"><?= esc($errors['password'] ?? '') ?></span>
        </fieldset>

        <button type="submit" id="btn-submit">Se connecter</button>

        <p class="auth-footer">Pas encore inscrit ? <a href="<?= site_url('inscription/etape1') ?>">Creer un compte</a></p>
    </form>
</section>
<script src="<?= base_url('js/auth.js') ?>"></script>
<?= $this->endSection() ?>
