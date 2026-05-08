<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="pagetitle">
    <h1>Dashboard coach</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('coach') ?>">Accueil</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Mission du coach</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-hearts"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>Accompagner les sportifs</h6>
                                    <span class="text-muted small pt-2 ps-1">Lecture simple des profils et des objectifs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Lecture rapide</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clipboard2-pulse"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>IMC, objectif, activites</h6>
                                    <span class="text-muted small pt-2 ps-1">Priorite au suivi plutot qu'a l'administration</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Informations a afficher pour un coach</h5>
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th>Zone</th>
                                        <th>Pourquoi</th>
                                        <th>Contenu prioritaire</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Fiche sportif</td>
                                        <td>Comprendre rapidement le profil</td>
                                        <td>Nom, genre, taille, poids, objectif, statut Gold</td>
                                    </tr>
                                    <tr>
                                        <td>Analyse IMC</td>
                                        <td>Identifier l'etat de depart</td>
                                        <td>IMC actuel, categorie, poids ideal estime</td>
                                    </tr>
                                    <tr>
                                        <td>Programme choisi</td>
                                        <td>Suivre ce qui a ete souscrit</td>
                                        <td>Regime, duree, activite associee, date de debut</td>
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
                    <h5 class="card-title">Compte connecte</h5>
                    <p><strong>Nom :</strong> <?= esc((session('user_prenom') ?? '') . ' ' . (session('user_nom') ?? '')) ?></p>
                    <p><strong>Email :</strong> <?= esc(session('user_email') ?? '') ?></p>
                    <p><strong>Role :</strong> <?= esc(strtoupper(session('auth_role') ?? 'coach')) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
