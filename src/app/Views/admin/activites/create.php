<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="pagetitle">
  <h1>Créer une activité</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Accueil</a></li>
      <li class="breadcrumb-item"><a href="<?= site_url('admin/activites') ?>">Activités</a></li>
      <li class="breadcrumb-item active">Nouvelle</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Détails de l'activité</h5>

          <form action="<?= site_url('admin/activites/store') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nom <span class="text-danger">*</span></label>
                <input type="text" name="nom" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Calories/h</label>
                <input type="number" name="calories_h" class="form-control" min="0">
              </div>
              <div class="col-md-3">
                <label class="form-label">Durée min (min)</label>
                <input type="number" name="duree_min" class="form-control" min="0">
              </div>
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
              </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
              <a href="<?= site_url('admin/activites') ?>" class="btn btn-light">Annuler</a>
              <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>
