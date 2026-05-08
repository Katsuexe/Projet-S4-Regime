<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<section class="auth-wrapper">
    <div class="auth-form auth-panel">
        <div class="auth-header">
            <p class="auth-kicker">Bienvenue</p>
            <h1><?= esc(session('user_prenom') ?? 'Sportif') ?></h1>
            <p>Votre compte est actif. La partie suggestions de regime peut maintenant etre branchee sur la logique metier du plan.</p>
        </div>

        <?= view('partials/flash_messages') ?>

        <fieldset>
            <legend>Session</legend>
            <p><strong>Email :</strong> <?= esc(session('user_email') ?? '') ?></p>
            <p><strong>Genre :</strong> <?= esc(session('genre') ?? '') ?></p>
            <?php if (session('poids_ideal')): ?>
                <p><strong>Poids ideal estime :</strong> <?= esc((string) session('poids_ideal')) ?> kg</p>
            <?php endif; ?>
        </fieldset>

        <div class="auth-actions">
            <a class="secondary-link" href="<?= site_url('profil') ?>">Mon profil</a>
            <a class="secondary-link" href="<?= site_url('deconnexion') ?>">Se deconnecter</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
