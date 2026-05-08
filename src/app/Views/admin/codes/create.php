<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="pagetitle"><h1>Generer un code</h1></div>
<section class="section"><div class="card"><div class="card-body"><h5 class="card-title">Nouveau code portefeuille</h5><form class="row g-3"><div class="col-md-6"><label class="form-label">Code</label><input class="form-control"></div><div class="col-md-6"><label class="form-label">Montant</label><input class="form-control" type="number" step="0.01"></div><div class="text-center"><button type="button" class="btn btn-primary">Generer</button></div></form></div></div></section>
<?= $this->endSection() ?>
