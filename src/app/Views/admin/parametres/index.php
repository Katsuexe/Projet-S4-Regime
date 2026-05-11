<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="pagetitle">
  <h1>Paramètres système</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Accueil</a></li>
      <li class="breadcrumb-item active">Paramètres</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Configuration globale</h5>
      <p class="text-muted">Ces valeurs métier sont utilisées dynamiquement dans l'application.</p>

      <?php foreach ($params as $p): ?>
      <div class="row g-2 align-items-center mb-3 border-bottom pb-3">
        <div class="col-md-4">
          <code><?= esc($p['cle']) ?></code>
          <div class="small text-muted mt-1"><?= esc($descriptions[$p['cle']] ?? '') ?></div>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control param-input"
                 id="param-<?= esc($p['cle']) ?>"
                 value="<?= esc($p['valeur']) ?>"
                 data-cle="<?= esc($p['cle']) ?>">
        </div>
        <div class="col-md-2">
          <button class="btn btn-outline-primary btn-sm save-param w-100" data-cle="<?= esc($p['cle']) ?>">
            <i class="bi bi-save me-1"></i> Enregistrer
          </button>
        </div>
        <div class="col-md-2">
          <span class="save-status text-success d-none fw-bold"><i class="bi bi-check-circle"></i> Sauvé</span>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const getCookieValue = (name) => {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) {
    return parts.pop().split(';').shift();
  }
  return '';
};

const getCsrfToken = () => getCookieValue('csrf_cookie_name');

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.save-param').forEach(btn => {
        btn.addEventListener('click', function() {
            const cle    = this.dataset.cle;
            const valeur = document.getElementById('param-' + cle).value;
            const status = this.closest('.row').querySelector('.save-status');
      const csrfToken = getCsrfToken();
            
            // On ajoute un etat de chargement sur le bouton
            const originalHtml = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            this.disabled = true;
            
            fetch('<?= site_url('admin/parametres/update') ?>', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-Requested-With': 'XMLHttpRequest',
                ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {})
                },
                body: JSON.stringify({ cle: cle, valeur: valeur })
            })
            .then(r => r.json())
            .then(data => {
                this.innerHTML = originalHtml;
                this.disabled = false;
                if (data.success) {
                    status.classList.remove('d-none');
                    setTimeout(() => status.classList.add('d-none'), 2000);
                } else {
                    alert("Erreur lors de la sauvegarde.");
                }
            })
            .catch(error => {
                this.innerHTML = originalHtml;
                this.disabled = false;
                console.error('Error:', error);
                alert("Erreur réseau lors de la sauvegarde.");
            });
        });
    });
});
</script>
<?= $this->endSection() ?>
