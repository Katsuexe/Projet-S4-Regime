<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<section class="auth-wrapper">
    <div class="auth-form auth-panel">
        <div class="auth-header">
            <p class="auth-kicker">Profil</p>
            <h1>Mon profil</h1>
            <p>Cette page est prete pour accueillir la mise a jour complete du profil sportif.</p>
        </div>
        <div class="auth-actions">
            <a class="secondary-link" href="<?= site_url('suggestions') ?>">Retour aux suggestions</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
