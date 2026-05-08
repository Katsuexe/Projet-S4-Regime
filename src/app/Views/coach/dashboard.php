<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<section class="auth-wrapper">
    <div class="auth-form auth-panel">
        <div class="auth-header">
            <p class="auth-kicker">Coach</p>
            <h1>Tableau de bord coach</h1>
            <p>Acces restreint pour l accompagnement des sportifs.</p>
        </div>

        <?= view('partials/flash_messages') ?>

        <fieldset>
            <legend>Session</legend>
            <p><strong>Connecte :</strong> <?= esc(session('user_prenom') ?? '') ?> <?= esc(session('user_nom') ?? '') ?></p>
            <p><strong>Email :</strong> <?= esc(session('user_email') ?? '') ?></p>
            <p><strong>Role :</strong> <?= esc(session('auth_role') ?? '') ?></p>
        </fieldset>

        <div class="auth-actions">
            <a class="secondary-link" href="<?= site_url('espace-securise/coach/sortie') ?>">Se deconnecter</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
