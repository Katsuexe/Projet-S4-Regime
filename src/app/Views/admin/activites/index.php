<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="pagetitle"><h1>Activites</h1></div>
<section class="section"><div class="card"><div class="card-body"><h5 class="card-title">Liste des activites</h5><table class="table datatable"><thead><tr><th>Nom</th><th>Calories/h</th><th>Duree</th><th>Actions</th></tr></thead><tbody><tr><td>Marche rapide</td><td>300</td><td>45 min</td><td><span class="badge bg-primary">Editer</span></td></tr></tbody></table></div></div></section>
<?= $this->endSection() ?>
