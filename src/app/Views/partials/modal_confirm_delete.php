<!-- partials/modal_confirm_delete.php -->
<div class="modal fade" id="modalSuppr" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Confirmer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>Supprimer <strong id="supprNom"></strong> ?</p>
        <p class="text-muted small">Cette action est irréversible.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <a id="supprLien" href="#" class="btn btn-danger">Supprimer</a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalSuppr = document.getElementById('modalSuppr');
    if (modalSuppr) {
        modalSuppr.addEventListener('show.bs.modal', function(e) {
          const btn   = e.relatedTarget;
          const id    = btn.dataset.id;
          const nom   = btn.dataset.nom;
          const route = btn.dataset.route; // ex: 'admin/regimes/supprimer/'
          document.getElementById('supprNom').textContent = nom;
          document.getElementById('supprLien').href = '<?= site_url() ?>' + route + id;
        });
    }
});
</script>
