<?php
$role = session('auth_role') ?? 'admin';
$isCoach = $role === 'coach';
$logoutUrl = $isCoach ? site_url('espace-securise/coach/sortie') : site_url('espace-securise/admin/sortie');
$dashboardUrl = $isCoach ? site_url('coach') : site_url('admin');
$currentUri = service('uri')->getPath();
?>
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="<?= esc($dashboardUrl) ?>" class="logo d-flex align-items-center">
            <img src="<?= base_url('niceadmin/assets/img/logo.png') ?>" alt="">
            <span class="d-none d-lg-block"><?= esc($isCoach ? 'Coach' : 'Admin') ?></span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <!-- <img src="<?php // echo base_url('niceadmin/assets/img/profile-img.jpg') ?>" alt="Profile" class="rounded-circle"> -->
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?= esc((session('user_prenom') ?? '') . ' ' . (session('user_nom') ?? '')) ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= esc((session('user_prenom') ?? '') . ' ' . (session('user_nom') ?? '')) ?></h6>
                        <span><?= esc(strtoupper($role)) ?></span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= esc($dashboardUrl) ?>">
                            <i class="bi bi-grid"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="post" action="<?= esc($logoutUrl) ?>">
                            <?= csrf_field() ?>
                            <button type="submit" class="dropdown-item d-flex align-items-center" style="border:0;background:transparent;">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Se deconnecter</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?= ($currentUri === 'admin' || $currentUri === 'coach') ? '' : 'collapsed' ?>" href="<?= esc($dashboardUrl) ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php if (! $isCoach): ?>
            <li class="nav-item">
                <a class="nav-link <?= (strpos($currentUri, 'admin/regimes') === 0) ? '' : 'collapsed' ?>" href="<?= site_url('admin/regimes') ?>">
                    <i class="bi bi-heart-pulse"></i>
                    <span>Regimes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (strpos($currentUri, 'admin/activites') === 0) ? '' : 'collapsed' ?>" href="<?= site_url('admin/activites') ?>">
                    <i class="bi bi-bicycle"></i>
                    <span>Activites</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (strpos($currentUri, 'admin/codes') === 0) ? '' : 'collapsed' ?>" href="<?= site_url('admin/codes') ?>">
                    <i class="bi bi-ticket-perforated"></i>
                    <span>Codes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (strpos($currentUri, 'admin/parametres') === 0) ? '' : 'collapsed' ?>" href="<?= site_url('admin/parametres') ?>">
                    <i class="bi bi-gear"></i>
                    <span>Parametres</span>
                </a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= site_url('coach') ?>">
                    <i class="bi bi-people"></i>
                    <span>Suivi sportifs</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</aside>
