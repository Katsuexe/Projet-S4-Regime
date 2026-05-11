<?php
$currentUri = service('uri')->getPath();
$initials = strtoupper(substr((string) session('user_prenom'), 0, 1) . substr((string) session('user_nom'), 0, 1));
?>
<nav class="navbar">
    <a href="<?= site_url('suggestions') ?>" class="navbar-logo">Re<span>gime</span></a>
    <ul class="navbar-links">
        <li><a href="<?= site_url('suggestions') ?>" class="<?= str_contains($currentUri, 'suggestions') ? 'active' : '' ?>">Suggestions</a></li>
        <li><a href="<?= site_url('objectif') ?>" class="<?= str_contains($currentUri, 'objectif') ? 'active' : '' ?>">Objectif</a></li>
        <li><a href="<?= site_url('profil') ?>" class="<?= str_contains($currentUri, 'profil') ? 'active' : '' ?>">Mon profil</a></li>
        <li><a href="<?= site_url('portefeuille') ?>" class="<?= str_contains($currentUri, 'portefeuille') ? 'active' : '' ?>">Portefeuille</a></li>
    </ul>
    <div class="navbar-wallet">
        <div>
            <div class="label">Solde</div>
            <div class="amount"><?= esc(number_format((float) (session('solde') ?? 0), 2, ',', ' ')) ?> Ar</div>
        </div>
        <?php if (session('is_gold')): ?>
            <span class="badge-gold">⭐ Gold</span>
        <?php endif; ?>
    </div>
    <form action="<?= site_url('deconnexion') ?>" method="post" style="margin-left:12px; display:inline">
        <?= csrf_field() ?>
        <button type="submit" class="btn-outline">Deconnexion</button>
    </form>
    <div class="navbar-avatar" title="<?= esc(trim((session('user_prenom') ?? '') . ' ' . (session('user_nom') ?? ''))) ?>">
        <?= esc($initials !== '' ? $initials : 'U') ?>
    </div>
</nav>
