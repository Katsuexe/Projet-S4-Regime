<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="pagetitle">
  <h1>Génération de codes en lot</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Accueil</a></li>
      <li class="breadcrumb-item"><a href="<?= site_url('admin/codes') ?>">Codes</a></li>
      <li class="breadcrumb-item active">Générer</li>
    </ol>
  </nav>
</div>

<section class="section">
  <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Paramètres de génération</h5>

          <form action="<?= site_url('admin/codes/store') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row g-3 align-items-end">
              <div class="col-md-3">
                <label class="form-label">Quantité</label>
                <input type="number" name="quantite" id="inpQte" class="form-control" min="1" max="500" value="10" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Montant (€)</label>
                <input type="number" name="montant" id="inpMontant" class="form-control" step="0.01" value="25.00" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Préfixe</label>
                <input type="text" name="prefixe" id="inpPrefix" class="form-control" value="PROMO" required>
              </div>
              <div class="col-md-3 text-end">
                <button type="submit" class="btn btn-primary w-100">Générer</button>
              </div>
            </div>

            <div class="mt-4 p-3 bg-light rounded border border-secondary border-opacity-25 text-center">
              <span class="text-muted d-block mb-1 small">Aperçu :</span>
              <strong class="fs-5" id="previewText">PROMO-XXXX-XXXX</strong><br>
              <small class="text-muted" id="previewDesc">(10 codes × 25,00 €)</small>
            </div>
            
            <div class="mt-4 border-top pt-3 d-flex justify-content-end">
                <a href="<?= site_url('admin/codes') ?>" class="btn btn-light">Annuler</a>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const qte = document.getElementById('inpQte');
    const montant = document.getElementById('inpMontant');
    const prefix = document.getElementById('inpPrefix');
    const prevText = document.getElementById('previewText');
    const prevDesc = document.getElementById('previewDesc');

    function updatePreview() {
        const q = parseInt(qte.value) || 0;
        const m = parseFloat(montant.value) || 0;
        const p = prefix.value.toUpperCase() || 'PROMO';
        
        prevText.textContent = `${p}-XXXX-XXXX`;
        prevDesc.textContent = `(${q} codes × ${m.toFixed(2)} €)`;
    }

    qte.addEventListener('input', updatePreview);
    montant.addEventListener('input', updatePreview);
    prefix.addEventListener('input', updatePreview);
});
</script>
<?= $this->endSection() ?>
