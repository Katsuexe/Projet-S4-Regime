<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="pagetitle">
  <h1>Codes Portefeuille</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Accueil</a></li>
      <li class="breadcrumb-item active">Codes</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="d-flex justify-content-between mb-3 align-items-center flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
      <label class="form-label mb-0 fw-bold">Filtre :</label>
      <select id="filterStatut" class="form-select form-select-sm" style="width:150px;">
        <option value="tous">Tous</option>
        <option value="0">Libres</option>
        <option value="1">Utilisés</option>
      </select>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= site_url('admin/codes/export-csv') ?>" class="btn btn-outline-success">
        <i class="bi bi-download me-1"></i> Export CSV
      </a>
      <a href="<?= site_url('admin/codes/creer') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Générer en lot
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Liste des codes</h5>
      <table class="table datatable" id="codesTable">
        <thead>
          <tr>
            <th>Code</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Utilisé par</th>
            <th>Date d'utilisation</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($codes as $c): ?>
          <tr data-statut="<?= esc((string) $c['is_used']) ?>">
            <td><code class="fs-6"><?= esc($c['code']) ?></code></td>
            <td><strong><?= esc(number_format((float) $c['montant'], 2, ',', ' ')) ?> Ar</strong></td>
            <td>
              <?php if ($c['is_used']): ?>
                <span class="badge bg-secondary">Utilisé</span>
              <?php else: ?>
                <span class="badge bg-success">Libre</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($c['is_used']): ?>
                <?= esc($c['prenom'] . ' ' . $c['nom']) ?>
              <?php else: ?>
                <em class="text-muted">-</em>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($c['is_used']): ?>
                <?= esc($c['used_at']) ?>
              <?php else: ?>
                <em class="text-muted">-</em>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('filterStatut').addEventListener('change', function() {
        const val = this.value; // 'tous', '0', '1'
        document.querySelectorAll('#codesTable tbody tr').forEach(tr => {
            const statut = tr.dataset.statut;
            tr.style.display = (val === 'tous' || statut === val) ? '' : 'none';
        });
    });
});
</script>
<?= $this->endSection() ?>
