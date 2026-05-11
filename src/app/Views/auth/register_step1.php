<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<section class="auth-wrapper">
    <form action="<?= site_url('inscription/etape1') ?>" method="post" novalidate class="auth-form">
        <?= csrf_field() ?>

        <div class="auth-header">
            <p class="auth-kicker">Sportif</p>
            <h1>Creer votre compte</h1>
            <p>Commencez par vos informations personnelles. Les champs marques d un * sont obligatoires.</p>
        </div>

        <div class="auth-progress" aria-label="Progression inscription">
            <span class="auth-progress-step is-active">1. Identite</span>
            <span class="auth-progress-step">2. Sante</span>
        </div>

        <?= view('partials/flash_messages') ?>

        <fieldset>
            <legend>Identite</legend>

            <label for="nom">Nom *</label>
            <input type="text" id="nom" name="nom" value="<?= esc(old('nom')) ?>" autocomplete="family-name" required>
            <span class="erreur"><?= esc($errors['nom'] ?? '') ?></span>

            <label for="prenom">Prenom *</label>
            <input type="text" id="prenom" name="prenom" value="<?= esc(old('prenom')) ?>" autocomplete="given-name" required>
            <span class="erreur"><?= esc($errors['prenom'] ?? '') ?></span>

            <label for="email">Adresse email *</label>
            <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" autocomplete="email" inputmode="email" required>
            <span class="erreur"><?= esc($errors['email'] ?? '') ?></span>

            <label for="genre">Genre *</label>
            <select id="genre" name="genre" required>
                <option value="">Choisissez une option</option>
                <option value="homme" <?= old('genre') === 'homme' ? 'selected' : '' ?>>Homme</option>
                <option value="femme" <?= old('genre') === 'femme' ? 'selected' : '' ?>>Femme</option>
            </select>
            <span class="erreur"><?= esc($errors['genre'] ?? '') ?></span>
        </fieldset>

        <fieldset>
            <legend>Connexion</legend>

            <label for="password">Mot de passe *</label>
            <div class="champ-password">
                <input type="password" id="password" name="password" autocomplete="new-password" minlength="8" required>
                <button type="button" class="toggle-password" data-target="password" aria-label="Afficher le mot de passe">Voir</button>
            </div>
            <span class="aide">Minimum 8 caracteres.</span>
            <span class="erreur"><?= esc($errors['password'] ?? '') ?></span>

            <label for="password_confirm">Confirmation du mot de passe *</label>
            <div class="champ-password">
                <input type="password" id="password_confirm" name="password_confirm" autocomplete="new-password" minlength="8" required>
                <button type="button" class="toggle-password" data-target="password_confirm" aria-label="Afficher la confirmation">Voir</button>
            </div>
            <span class="erreur"><?= esc($errors['password_confirm'] ?? '') ?></span>
        </fieldset>

        <button type="submit" id="btn-submit">Continuer vers l etape 2</button>

        <p class="auth-footer">Vous avez deja un compte ? <a href="<?= site_url('connexion') ?>">Se connecter</a></p>
    </form>
</section>
<script src="<?= base_url('js/auth.js') ?>"></script>
<?= $this->endSection() ?>
