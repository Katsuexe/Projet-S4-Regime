<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="pagetitle">
  <h1>Créer un régime</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Accueil</a></li>
      <li class="breadcrumb-item"><a href="<?= site_url('admin/regimes') ?>">Régimes</a></li>
      <li class="breadcrumb-item active">Nouveau</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Détails du régime</h5>

      <form action="<?= site_url('admin/regimes/store') ?>" method="POST">
        <?= csrf_field() ?>
        <!-- Hidden input for default gold discount -->
        <input type="hidden" id="goldDiscount" value="15">
        
        <div class="row">
          <div class="col-md-8">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">Nom du régime <span class="text-danger">*</span></label>
                <input type="text" name="nom" class="form-control" required>
              </div>

              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label">Delta poids min (kg) <span class="text-danger">*</span></label>
                <input type="number" name="delta_poids_min" class="form-control" step="0.1" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Delta poids max (kg) <span class="text-danger">*</span></label>
                <input type="number" name="delta_poids_max" class="form-control" step="0.1" required>
              </div>

              <div class="col-12 mt-4">
                <h6 class="mb-3">Composition (%) <span class="text-danger">*</span></h6>
                <div class="row g-3">
                  <div class="col-md-4">
                    <label class="form-label text-danger">Viande</label>
                    <input type="number" name="pct_viande" class="form-control pct-input" min="0" max="100" value="0" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label text-primary">Poisson</label>
                    <input type="number" name="pct_poisson" class="form-control pct-input" min="0" max="100" value="0" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label text-warning">Volaille</label>
                    <input type="number" name="pct_volaille" class="form-control pct-input" min="0" max="100" value="0" required>
                  </div>
                </div>
                <div class="mt-2 text-muted small">
                  Total actuel : <strong id="pct-total">0 %</strong>
                  <span id="pct-warning" class="text-danger ms-2"><i class="bi bi-exclamation-triangle"></i> La somme doit être égale à 100%.</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 border-start">
            <h6 class="mb-3">Durées et Prix</h6>
            <table class="table table-sm" id="dureesTable">
              <thead>
                <tr>
                  <th>Durée (j)</th>
                  <th>Prix (€)</th>
                  <th>Gold (-15%)</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="dureesBody">
                <!-- Lignes dynamiques -->
                <tr>
                  <td><input type="number" name="durees[0][jours]" class="form-control form-control-sm" min="1" required></td>
                  <td><input type="number" name="durees[0][prix]" class="form-control form-control-sm prix-normal" step="0.01" min="0" required></td>
                  <td><input type="number" class="form-control form-control-sm prix-gold" step="0.01" readonly></td>
                  <td><button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="bi bi-x"></i></button></td>
                </tr>
              </tbody>
            </table>
            <button type="button" id="addDuree" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus"></i> Ajouter une durée</button>
          </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
          <a href="<?= site_url('admin/regimes') ?>" class="btn btn-light">Annuler</a>
          <button type="submit" class="btn btn-primary" id="btnSubmit" disabled>Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
    let dureeIndex = 1;

    // Validation somme composition = 100
    const pctInputs = document.querySelectorAll('.pct-input');
    const pctWarning = document.getElementById('pct-warning');
    const pctTotal = document.getElementById('pct-total');
    const btnSubmit = document.getElementById('btnSubmit');

    function checkComposition() {
        const sum = [...pctInputs].reduce((acc, el) => acc + (+el.value || 0), 0);
        const isValid = Math.round(sum) === 100;
        pctWarning.classList.toggle('d-none', isValid);
        pctTotal.textContent = sum.toFixed(0) + ' %';
        btnSubmit.disabled = !isValid;
    }

    pctInputs.forEach(input => input.addEventListener('input', checkComposition));

    // Calcul Prix Gold auto
    function initPrixNormal(input) {
        input.addEventListener('input', function() {
            const tr = this.closest('tr');
            const goldInput = tr.querySelector('.prix-gold');
            const discount = parseFloat(document.getElementById('goldDiscount').value) || 15;
            goldInput.value = (this.value * (1 - discount/100)).toFixed(2);
        });
    }

    document.querySelectorAll('.prix-normal').forEach(initPrixNormal);

    // Ajout dynamique de lignes durées
    document.getElementById('addDuree').addEventListener('click', () => {
        const tbody = document.getElementById('dureesBody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="number" name="durees[${dureeIndex}][jours]" class="form-control form-control-sm" min="1" required></td>
            <td><input type="number" name="durees[${dureeIndex}][prix]" class="form-control form-control-sm prix-normal" step="0.01" min="0" required></td>
            <td><input type="number" class="form-control form-control-sm prix-gold" step="0.01" readonly></td>
            <td><button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="bi bi-x"></i></button></td>
        `;
        tbody.appendChild(tr);
        initPrixNormal(tr.querySelector('.prix-normal'));
        tr.querySelector('.remove-row').addEventListener('click', () => tr.remove());
        dureeIndex++;
    });

    // Suppression lignes existantes
    document.querySelectorAll('.remove-row').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('tr').remove();
        });
    });

    // Run check initially
    checkComposition();
});
</script>
<?= $this->endSection() ?>
