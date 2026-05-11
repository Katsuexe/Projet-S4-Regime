<?php
$currentUri = service('uri')->getPath();
$initials = strtoupper(substr((string) session('user_prenom'), 0, 1) . substr((string) session('user_nom'), 0, 1));
?>
<nav class="navbar">
    <a href="<?= site_url('suggestions') ?>" class="navbar-logo">Re<span>gime</span></a>
    <ul class="navbar-links">
        <li><a href="<?= site_url('suggestions') ?>" class="<?= str_contains($currentUri, 'suggestions') ? 'active' : '' ?>">Suggestions</a></li>
        <!-- <li><a href="<?= site_url('portefeuille') ?>" class="<?= str_contains($currentUri, 'portefeuille') ? 'active' : '' ?>">Portefeuille</a></li> -->
    </ul>
    <div class="navbar-wallet">
        <a href="<?= site_url('portefeuille') ?>" class="<?= str_contains($currentUri, 'portefeuille') ? 'active' : '' ?>">

            <div>
                <div class="label">Solde</div>
                <div class="amount"><?= esc(number_format((float) (session('solde') ?? 0), 2, ',', ' ')) ?> Ar</div>
            </div>
        </a>

        <?php if (session('is_gold')): ?>
            <span class="badge-gold">⭐ Gold</span>
        <?php endif; ?>
    </div>
    <details class="navbar-user">
        <summary class="navbar-avatar" title="<?= esc(trim((session('user_prenom') ?? '') . ' ' . (session('user_nom') ?? ''))) ?>">
            <?= esc($initials !== '' ? $initials : 'U') ?>
        </summary>
        <div class="navbar-user-menu">
            <a href="<?= site_url('profil') ?>" class="<?= str_contains($currentUri, 'profil') ? 'active' : '' ?>">Mon profil</a>
            <form action="<?= site_url('deconnexion') ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit">Deconnexion</button>
            </form>
        </div>
    </details>
</nav>