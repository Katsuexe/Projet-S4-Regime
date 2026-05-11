<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="pagetitle">
  <h1>Activités sportives</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Accueil</a></li>
      <li class="breadcrumb-item active">Activités</li>
    </ol>
  </nav>
</div>

<section class="section">
  <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <div class="d-flex justify-content-end mb-3 gap-2 flex-wrap">
    <a href="<?= site_url('admin/activites/export-csv') ?>" class="btn btn-outline-success">
      <i class="bi bi-download me-1"></i> Export CSV
    </a>
    <a href="<?= site_url('admin/activites/creer') ?>" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Nouvelle activité
    </a>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Catalogue des activités</h5>
      <table class="table datatable" id="activiteTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Calories/h</th>
            <th>Durée min.</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($activites as $a): ?>
          <tr>
            <td><?= $a['id'] ?></td>
            <td><strong><?= esc($a['nom']) ?></strong></td>
            <td><span class="badge bg-danger"><?= esc($a['calories_h']) ?> kcal/h</span></td>
            <td><?= esc($a['duree_min']) ?> min</td>
            <td><?= esc($a['description']) ?></td>
            <td>
              <a href="<?= site_url('admin/activites/modifier/'.$a['id']) ?>" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil"></i>
              </a>
              <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalSuppr" data-id="<?= $a['id'] ?>" data-nom="<?= esc($a['nom']) ?>" data-route="admin/activites/supprimer/">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?= $this->endSection() ?>
