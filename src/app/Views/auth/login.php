<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<?php $space = $space ?? 'sportif'; ?>
<?php
$labels = [
    'sportif' => ['kicker' => 'Projet Regime', 'title' => 'Connexion', 'text' => 'Retrouvez votre espace sportif, vos objectifs et vos suggestions personnalisees.'],
    'admin' => ['kicker' => 'Acces reserve', 'title' => 'Connexion administrateur', 'text' => 'Portail interne reserve a l administration.'],
    'coach' => ['kicker' => 'Acces reserve', 'title' => 'Connexion coach', 'text' => 'Portail interne reserve aux coachs.'],
];
$label = $labels[$space] ?? $labels['sportif'];
?>
<section class="auth-wrapper">
    <?php
    $action = match ($space) {
        'admin' => site_url(config(\Config\AuthGroups::class)->hiddenLoginRoutes['admin']),
        'coach' => site_url(config(\Config\AuthGroups::class)->hiddenLoginRoutes['coach']),
        default => site_url('connexion'),
    };
    ?>
    <form action="<?= $action ?>" method="post" novalidate class="auth-form auth-form-login">
        <?= csrf_field() ?>

        <div class="auth-header">
            <p class="auth-kicker"><?= esc($label['kicker']) ?></p>
            <h1><?= esc($label['title']) ?></h1>
            <p><?= esc($label['text']) ?></p>
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

        <?php if ($space === 'sportif'): ?>
            <p class="auth-footer">Pas encore inscrit ? <a href="<?= site_url('inscription/etape1') ?>">Creer un compte</a></p>
        <?php else: ?>
            <p class="auth-footer">Acces strictement reserve au personnel autorise.</p>
        <?php endif; ?>
    </form>
</section>
<script src="<?= base_url('js/auth.js') ?>"></script>
<?= $this->endSection() ?>
