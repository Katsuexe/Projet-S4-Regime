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
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Stat Cards -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Utilisateurs <span>| Sportifs actifs</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= esc((string) $stats['nb_sportifs']) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Comptes Gold <span>| Total</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= esc((string) $stats['nb_gold']) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Solde Moyen <span>| Sportifs</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= esc(number_format((float) $stats['solde_moyen'], 2, ',', ' ')) ?> Ar</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Revenus <span>| Souscriptions</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= esc(number_format((float) $stats['revenus_total'], 2, ',', ' ')) ?> Ar</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Revenus Gold <span>| Remises appliquees</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-stars"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= esc(number_format((float) $stats['revenus_gold'], 2, ',', ' ')) ?> Ar</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card">
                        <div class="card-body">
                            <h5 class="card-title">Codes Libres <span>| Dispos</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= esc((string) $stats['codes_libres']) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card">
                        <div class="card-body">
                            <h5 class="card-title">Codes Utilisés <span>| Historique</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-check2-circle"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= esc((string) $stats['codes_utilises']) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bar Chart -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Souscriptions <span>/ par mois</span></h5>
                            <div id="barChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Tableaux croisés -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Croisement : Régimes & Objectifs</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Régime</th>
                                        <th>Augmenter</th>
                                        <th>Réduire</th>
                                        <th>Idéal</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($tableau_croise_1 as $row): ?>
                                    <tr>
                                        <td><?= esc($row['nom']) ?></td>
                                        <td><?= esc((string) $row['augmenter']) ?></td>
                                        <td><?= esc((string) $row['reduire']) ?></td>
                                        <td><?= esc((string) $row['ideal']) ?></td>
                                        <td><strong><?= esc((string) $row['total']) ?></strong></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Dernières souscriptions -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Dernières souscriptions</h5>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th>Régime</th>
                                        <th>Durée</th>
                                        <th>Prix payé</th>
                                        <th>Gold</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($derniers_achats as $achat): ?>
                                    <tr>
                                        <td><?= esc($achat['prenom'] . ' ' . $achat['nom']) ?></td>
                                        <td><?= esc($achat['regime']) ?></td>
                                        <td><?= esc((string) $achat['duree_jours']) ?> j</td>
                                        <td><?= esc(number_format((float) $achat['prix_paye'], 2, ',', ' ')) ?> Ar</td>
                                        <td>
                                            <?php if($achat['is_gold']): ?>
                                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

            <!-- Donut Chart -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Répartition des Objectifs</h5>
                    <div id="donutChart"></div>
                </div>
            </div>

            <!-- Utilisateurs Gold récents -->
            <div class="card">
                <div class="card-body pb-0">
                    <h5 class="card-title">Utilisateurs Gold récents</h5>
                    <div class="activity">
                        <?php foreach($users_gold_recents as $u): ?>
                        <div class="activity-item d-flex">
                            <div class="activite-label"><?= date('d/m', strtotime($u['created_at'] ?? 'now')) ?></div>
                            <i class="bi bi-circle-fill activity-badge text-warning align-self-start"></i>
                            <div class="activity-content"><?= esc($u['prenom'] . ' ' . $u['nom']) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div><!-- End Right side columns -->

    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Bar Chart
    const barData = <?= $chart_souscriptions ?>;
    const dates = barData.map(item => item.mois);
    const counts = barData.map(item => item.nb);

    new ApexCharts(document.querySelector("#barChart"), {
        series: [{ name: 'Souscriptions', data: counts }],
        chart: { type: 'line', height: 350 },
        stroke: { curve: 'smooth', width: 3 },
        markers: { size: 5 },
        dataLabels: { enabled: false },
        xaxis: { categories: dates },
        colors: ['#8B4513']
    }).render();

    // Donut Chart
    const donutData = <?= $chart_objectifs ?>;
    const labels = donutData.map(item => item.objectif);
    const series = donutData.map(item => parseInt(item.nb));

    new ApexCharts(document.querySelector("#donutChart"), {
        series: series,
        chart: { height: 350, type: 'donut', toolbar: { show: true } },
        labels: labels,
        colors: ['#15803d', '#dc2626', '#d97706'],
    }).render();
});
</script>
<?= $this->endSection() ?>
