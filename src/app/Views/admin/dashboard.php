<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="pagetitle">
    <h1>Dashboard administrateur</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Accueil</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Utilisateurs <span>| Vue rapide</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>Comptes actifs</h6>
                                    <span class="text-muted small pt-2 ps-1">Utilisateurs, admins et coach</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Catalogue <span>| Contenu</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-heart-pulse"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>Regimes et activites</h6>
                                    <span class="text-muted small pt-2 ps-1">Structure prete pour la gestion</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Portefeuille <span>| Monnaie virtuelle</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>Codes et recharges</h6>
                                    <span class="text-muted small pt-2 ps-1">Suivi des flux utilisateur</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Priorites du back-office <span>| Quoi mettre</span></h5>
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th>Module</th>
                                        <th>Role de l'ecran</th>
                                        <th>Contenu attendu</th>
                                        <th>Statut UX</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Regimes</td>
                                        <td>Gerer le catalogue</td>
                                        <td>Nom, composition, variation de poids, durees et prix</td>
                                        <td><span class="badge bg-warning">A finaliser</span></td>
                                    </tr>
                                    <tr>
                                        <td>Activites</td>
                                        <td>Completer les suggestions</td>
                                        <td>Nom, description, calories/heure, duree conseillee</td>
                                        <td><span class="badge bg-warning">A finaliser</span></td>
                                    </tr>
                                    <tr>
                                        <td>Codes</td>
                                        <td>Alimenter les portefeuilles</td>
                                        <td>Code, montant, statut, utilisateur</td>
                                        <td><span class="badge bg-primary">Pret pour integration</span></td>
                                    </tr>
                                    <tr>
                                        <td>Parametres</td>
                                        <td>Eviter le hardcode</td>
                                        <td>Prix Gold, seuils IMC, remise Gold</td>
                                        <td><span class="badge bg-secondary">Structurer</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Session en cours</h5>
                    <div class="activity">
                        <div class="activity-item d-flex">
                            <div class="activite-label">Nom</div>
                            <i class="bi bi-circle-fill activity-badge text-primary align-self-start"></i>
                            <div class="activity-content"><?= esc((session('user_prenom') ?? '') . ' ' . (session('user_nom') ?? '')) ?></div>
                        </div>
                        <div class="activity-item d-flex">
                            <div class="activite-label">Email</div>
                            <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
                            <div class="activity-content"><?= esc(session('user_email') ?? '') ?></div>
                        </div>
                        <div class="activity-item d-flex">
                            <div class="activite-label">Role</div>
                            <i class="bi bi-circle-fill activity-badge text-warning align-self-start"></i>
                            <div class="activity-content"><?= esc(strtoupper(session('auth_role') ?? 'admin')) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body pb-0">
                    <h5 class="card-title">Raccourcis utiles</h5>
                    <div class="news">
                        <div class="post-item clearfix">
                            <img src="<?= base_url('niceadmin/assets/img/news-1.jpg') ?>" alt="">
                            <h4><a href="<?= site_url('admin/regimes') ?>">Gerer les regimes</a></h4>
                            <p>Verifier que chaque regime a une composition claire et des prix par duree.</p>
                        </div>
                        <div class="post-item clearfix">
                            <img src="<?= base_url('niceadmin/assets/img/news-2.jpg') ?>" alt="">
                            <h4><a href="<?= site_url('admin/codes') ?>">Consulter les codes</a></h4>
                            <p>Suivre les recharges et l'etat des codes utilises ou disponibles.</p>
                        </div>
                        <div class="post-item clearfix">
                            <img src="<?= base_url('niceadmin/assets/img/news-3.jpg') ?>" alt="">
                            <h4><a href="<?= site_url('admin/parametres') ?>">Ajuster les parametres</a></h4>
                            <p>Centraliser les valeurs metier pour eviter les incoherences dans l'application.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
