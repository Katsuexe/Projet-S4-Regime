<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="pagetitle"><h1>Parametres</h1></div>
<section class="section"><div class="card"><div class="card-body"><h5 class="card-title">Configuration metier</h5><form class="row g-3"><div class="col-md-4"><label class="form-label">Prix Gold</label><input class="form-control" value="29.99"></div><div class="col-md-4"><label class="form-label">IMC ideal min</label><input class="form-control" value="18.5"></div><div class="col-md-4"><label class="form-label">IMC ideal max</label><input class="form-control" value="24.9"></div><div class="col-md-4"><label class="form-label">Remise Gold %</label><input class="form-control" value="15"></div><div class="text-center"><button type="button" class="btn btn-primary">Mettre a jour</button></div></form></div></div></section>
<?= $this->endSection() ?>
