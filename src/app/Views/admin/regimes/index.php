<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="pagetitle">
    <h1>Regimes</h1>
</div>
<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Liste des regimes</h5>
            <p>Cette vue doit afficher le catalogue avec nom, composition, variation de poids et durees disponibles.</p>
            <table class="table datatable">
                <thead>
                    <tr><th>Nom</th><th>Composition</th><th>Variation</th><th>Durees</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <tr><td>Mediterraneen</td><td>20 / 40 / 40</td><td>-0.5 a 0.2 kg</td><td>7, 14, 30, 60 j</td><td><span class="badge bg-primary">Editer</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
