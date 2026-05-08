<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="pagetitle"><h1>Creer une activite</h1></div>
<section class="section"><div class="card"><div class="card-body"><h5 class="card-title">Nouvelle activite</h5><form class="row g-3"><div class="col-md-6"><label class="form-label">Nom</label><input class="form-control"></div><div class="col-md-3"><label class="form-label">Calories/h</label><input class="form-control" type="number"></div><div class="col-md-3"><label class="form-label">Duree min</label><input class="form-control" type="number"></div><div class="col-12"><label class="form-label">Description</label><textarea class="form-control" style="height:100px"></textarea></div><div class="text-center"><button type="button" class="btn btn-primary">Enregistrer</button></div></form></div></div></section>
<?= $this->endSection() ?>
