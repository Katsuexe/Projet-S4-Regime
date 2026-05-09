<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="pagetitle">
  <h1>Régimes</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Accueil</a></li>
      <li class="breadcrumb-item active">Régimes</li>
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

  <div class="d-flex justify-content-end mb-3">
    <a href="<?= site_url('admin/regimes/creer') ?>" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Nouveau régime
    </a>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Catalogue des régimes</h5>
      <table class="table datatable" id="regimeTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Composition (V/P/Vol)</th>
            <th>Variation poids</th>
            <th>Durées disponibles</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($regimes as $r): ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td><?= esc($r['nom']) ?></td>
            <td>
              <div class="d-flex gap-1 align-items-center mb-1" style="min-width:120px">
                <div style="width:<?= $r['pct_viande'] ?>%;height:8px;background:#ef4444;border-radius:2px" title="Viande <?= $r['pct_viande'] ?>%"></div>
                <div style="width:<?= $r['pct_poisson'] ?>%;height:8px;background:#3b82f6;border-radius:2px" title="Poisson <?= $r['pct_poisson'] ?>%"></div>
                <div style="width:<?= $r['pct_volaille'] ?>%;height:8px;background:#f59e0b;border-radius:2px" title="Volaille <?= $r['pct_volaille'] ?>%"></div>
              </div>
              <small class="text-muted"><?= $r['pct_viande'] ?>/<?= $r['pct_poisson'] ?>/<?= $r['pct_volaille'] ?></small>
            </td>
            <td>
              <?= $r['delta_poids_min'] ?> → <?= $r['delta_poids_max'] ?> kg
            </td>
            <td>
              <?php foreach ($r['durees'] as $d): ?>
                <span class="badge bg-light text-dark border"><?= $d['duree_jours'] ?>j — <?= number_format($d['prix'],2) ?>€</span>
              <?php endforeach; ?>
            </td>
            <td>
              <a href="<?= site_url('admin/regimes/modifier/'.$r['id']) ?>" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil"></i>
              </a>
              <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalSuppr" data-id="<?= $r['id'] ?>" data-nom="<?= esc($r['nom']) ?>" data-route="admin/regimes/supprimer/">
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
